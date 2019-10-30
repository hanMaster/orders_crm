<?php

namespace App\Http\Controllers;

use App\BuildObject;
use App\Order;
use Illuminate\Http\Request;
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
        switch (Auth::user()->role_id){

            case Config::get('role.starter'):
                $orders = Order::where('starter_id', \auth()->id())->orderBy('updated_at', 'desc')->get();
                return view('interfaces.orderStart.index', compact('orders'));

            case Config::get('role.approve'):

                $orders = Order::whereIn('object_id', BuildObject::select('id')->where('approve_id', \auth()->id()))
                    ->whereIn('status_id', [Config::get('status.new'),Config::get('status.re_approve')])
                    ->orderBy('updated_at', 'desc')->get();

                return view('interfaces.approve.index', compact('orders'));

            case Config::get('role.main_executor'):
                $orders = Order::whereIn('status_id', [Config::get('status.approved'),Config::get('status.executor')])
                    ->orderBy('updated_at', 'desc')->get();
                return view('interfaces.mainExecutor.index', compact('orders'));

            case Config::get('role.executor'):
                return view('interfaces.executor.index');

            case Config::get('role.admin'):
                $users = User::all();
                $buildObjects = BuildObject::all();
                return view('interfaces.admin.index', compact(['users','buildObjects']));

        }
    }
}
