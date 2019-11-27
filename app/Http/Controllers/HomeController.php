<?php

namespace App\Http\Controllers;

use App\BuildObject;
use App\Order;
use App\OrderDetail;
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
                $orders = Order::where('starter_id', auth()->id())
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

                $ordersToApprove = Order::whereIn('object_id', BuildObject::select('id')->where('approve_id', auth()->id()))
                    ->whereIn('status_id', [Config::get('status.new'), Config::get('status.re_approve'), Config::get('status.approve_in_process')])
                    ->orderBy('updated_at', 'desc')->get();

                $ordersAll = Order::whereIn('object_id', BuildObject::select('id')->where('approve_id', auth()->id()))
                    ->orderBy('updated_at', 'desc')->get();

                return view('interfaces.approve.index', compact(['ordersToApprove', 'ordersAll']));
//Main executor
            case Config::get('role.main_executor'):

                $orders = Order::whereNotIn('status_id', [
                    Config::get('status.editing'),
                    Config::get('status.creating'),
                    Config::get('status.exec_done'),
                    Config::get('status.partial_done'),
                    Config::get('status.rejected')])
                    ->orderBy('updated_at', 'desc')->get();

                $ordersDone = Order::whereIn('status_id', [
                    Config::get('status.exec_done'),
                    Config::get('status.partial_done'),
                    Config::get('status.rejected')])
                    ->orderBy('updated_at', 'desc')->get();

                return view('interfaces.mainExecutor.index', compact(['orders', 'ordersDone']));
//Executor
            case Config::get('role.executor'):

                $orders = Order::whereIn('id', OrderDetail::select('order_id')->where('executor_id', auth()->id()))
                    ->whereNotIn('status_id', [Config::get('status.exec_done'), Config::get('status.partial_done'), Config::get('status.rejected')])
                    ->orderBy('updated_at', 'desc')->get();

                $ordersDone = Order::whereIn('id', OrderDetail::select('order_id')->where('executor_id', auth()->id()))
                    ->whereIn('status_id', [Config::get('status.exec_done'), Config::get('status.partial_done'), Config::get('status.rejected')])
                    ->orderBy('updated_at', 'desc')->get();

                return view('interfaces.executor.index', compact(['orders', 'ordersDone']));
//Admin
            case Config::get('role.admin'):
                $users = User::all();
                $buildObjects = BuildObject::all();
                return view('interfaces.admin.index', compact(['users', 'buildObjects']));

        }
    }
}
