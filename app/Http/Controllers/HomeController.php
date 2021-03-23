<?php

namespace App\Http\Controllers;

use App\BuildObject;
use App\Order;
use App\OrderDetail;
use App\Services\ActiveBuildObjects;
use App\Services\PatchDates;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (Auth::user()->role_id) {
//Starter
            case Config::get('role.starter'):
                $objectId = BuildObject::select('id')->where('starter_id', auth()->id())->first();
                if (isset($objectId)) {
                    $selectedId = $objectId->id;
                } else {
                    $selectedId = 0;
                }

                $orders = Order::where('object_id', $selectedId)
                    ->whereNotIn('status_id', [
                        Config::get('status.exec_done'),
                        Config::get('status.partial_done'),
                        Config::get('status.rejected')])
                    ->orderBy('created_at', 'desc')->get();

                $ordersDone = Order::where('starter_id', auth()->id())
                    ->whereIn('status_id', [
                        Config::get('status.exec_done'),
                        Config::get('status.partial_done'),
                        Config::get('status.rejected')])
                    ->orderBy('created_at', 'desc')->get();

                return view('interfaces.orderStart.index', compact(['orders', 'ordersDone']));

//Approver
            case Config::get('role.approve'):
                return $this->approveDashboard();

//Main executor
            case Config::get('role.main_executor'):
                $preOrders = Order::whereIn('status_id', [
                    Config::get('status.creating'),
                    Config::get('status.editing'),
                    Config::get('status.new'),
                    Config::get('status.approve_in_process'),
                    Config::get('status.re_approve'),
                    Config::get('status.not_approved'),
                ])
                    ->orderBy('updated_at', 'desc')->get();

                $startOrders = Order::whereIn('status_id', [
                    Config::get('status.approved'),
                    Config::get('status.main_executor')])
                    ->orderBy('updated_at', 'desc')->get();

                $workOrders = Order::where('status_id',
                    Config::get('status.executor'))
                    ->orderBy('updated_at', 'desc')->get();

                $doneOrders = Order::whereIn('status_id', [
                    Config::get('status.exec_done'),
                    Config::get('status.partial_done'),
                    Config::get('status.rejected')])
                    ->orderBy('updated_at', 'desc')->get();

                return view('interfaces.mainExecutor.index', compact(['preOrders', 'startOrders', 'workOrders', 'doneOrders']));
//Executor
            case Config::get('role.executor'):

                $orders = Order::whereIn('id', OrderDetail::select('order_id')->where('executor_id', auth()->id()))
                    ->whereNotIn('status_id', [
                        Config::get('status.exec_done'),
                        Config::get('status.partial_done'),
                        Config::get('status.rejected')
                    ])
                    ->orderBy('updated_at', 'desc')->get();

                $ordersDone = Order::whereIn('id', OrderDetail::select('order_id')->where('executor_id', auth()->id()))
                    ->whereIn('status_id', [
                        Config::get('status.exec_done'),
                        Config::get('status.partial_done'),
                        Config::get('status.rejected')
                    ])
                    ->orderBy('updated_at', 'desc')->get();

                return view('interfaces.executor.index', compact(['orders', 'ordersDone']));
//Observer
            case Config::get('role.observer'):
                $orders = Order::whereIn('status_id', [
                    Config::get('status.approved'),
                    Config::get('status.executor'),
                    Config::get('status.exec_done'),
                    Config::get('status.partial_done'),
                    Config::get('status.rejected'),
                    Config::get('status.main_executor')])
                    ->orderBy('updated_at', 'desc')->get();

                $bo = BuildObject::select('id', 'name')->get();


                return view('interfaces.observer.index', compact(['orders', 'bo']));
//Admin
            case Config::get('role.admin'):
                $users = User::all();
                $buildObjects = BuildObject::all();
                return view('interfaces.admin.index', compact(['users', 'buildObjects']));

        }
    }

    public function patchDates()
    {
        PatchDates::patch();
    }

    public function approveDashboard()
    {
        if (Auth::user()->role_id == Config::get('role.approve')) {
            $bo = ActiveBuildObjects::getActiveObjects();

            foreach ($bo as $object) {
                $count = Order::where('object_id', $object->id)
                    ->whereIn('status_id', [
                        Config::get('status.new'),
                        Config::get('status.re_approve'),
                        Config::get('status.approve_in_process')
                    ])
                    ->count();
                $newCounters[$object->id] = $count;
            }
            return view('interfaces.approve.dashboard', compact(['bo', 'newCounters']));
        } else {
            return redirect('/');
        }
    }

    public function objectList(BuildObject $object)
    {
        $new = Order::where('object_id', $object->id)
            ->whereIn('status_id', [
                Config::get('status.new'),
                Config::get('status.re_approve'),
                Config::get('status.approve_in_process')
            ])
            ->count();
        $exec = Order::where('object_id', $object->id)
            ->whereIn('status_id', [
                Config::get('status.approved'),
                Config::get('status.executor'),
                Config::get('status.main_executor')
            ])
            ->count();
        $done = Order::where('object_id', $object->id)
            ->whereIn('status_id', [
                Config::get('status.exec_done'),
                Config::get('status.partial_done'),
                Config::get('status.rejected')
            ])
            ->count();
        return view('interfaces.common.object', compact(['object', 'new', 'exec', 'done']));
    }

    public function objectListNew(BuildObject $object)
    {
        $operation = 'approve';
        $status = 'новые';
        $orders = Order::where('object_id', $object->id)
            ->whereIn('status_id', [
                Config::get('status.new'),
                Config::get('status.re_approve'),
                Config::get('status.approve_in_process')
            ])
            ->orderBy('updated_at', 'desc')->get();
        return view('interfaces.common.objectList', compact(['object', 'orders', 'operation', 'status']));
    }

    public function objectListWork(BuildObject $object)
    {
        $operation = 'order';
        $status = 'на исполнении';
        $orders = Order::where('object_id', $object->id)
            ->whereIn('status_id', [
                Config::get('status.approved'),
                Config::get('status.executor'),
                Config::get('status.main_executor')
            ])
            ->orderBy('updated_at', 'desc')->get();
        return view('interfaces.common.objectList', compact(['object', 'orders', 'operation', 'status']));
    }

    public function objectListDone(BuildObject $object)
    {
        $operation = 'order';
        $status = 'исполненные';
        $orders = Order::where('object_id', $object->id)
            ->whereIn('status_id', [
                Config::get('status.exec_done'),
                Config::get('status.partial_done'),
                Config::get('status.rejected')
            ])
            ->orderBy('updated_at', 'desc')->get();
        return view('interfaces.common.objectList', compact(['object', 'orders', 'operation', 'status']));
    }
}
