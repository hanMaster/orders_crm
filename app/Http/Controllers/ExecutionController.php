<?php

namespace App\Http\Controllers;

use App\LineStatus;
use App\Log;
use App\Order;
use App\OrderDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ExecutionController extends Controller
{
    public function assign(Order $order){
        $executors = User::where('role_id', Config::get('role.executor'))->get();
        return view('interfaces.mainExecutor.assign', compact(['order','executors']));

    }

    public function assignStore(Order $order, Request $request){
        foreach ($order->items as $item) {
            $item->executor_id = $request->executor;
            $item->save();
        }
        $order->status_id = Config::get('status.executor');
        $order->save();
        return redirect('exec/'.$order->id.'/assign');
    }

    public function assignSingleStore(Request $request){
        $item = OrderDetail::findOrFail($request->item);
        $item->executor_id = $request->executor;
        $item->save();

        $order = Order::findOrFail($request->order_id);
        $order->status_id = Config::get('status.executor');
        $order->save();

        return back();
    }


    public function execute(Order $order){
        return view('interfaces.executor.execute', compact('order'));
    }

    public function executeItem(OrderDetail $item, Request $request){
        $request->validate([
            'date_fact' => 'date|after:today'
        ]);


        if($item->line_status_id != $request->status){
            $ls = LineStatus::findOrFail($request->status);
            Log::create([
                'order_details_id' => $item->id,
                'user_id' => Auth::id(),
                'message' => "Изменение статуса c <strong>".$item->status->name."</strong> на <strong>".$ls->name. "</strong>"
            ]);
            $item->line_status_id = $request->status;
            $item->save();
        }

        if($request->date_fact != $item->date_fact){
            $item->date_fact = $request->date_fact;
            $item->save();
        }



        return back();
    }

    public function getExecuteItem(Order $order, OrderDetail $item){
        $line_statuses = LineStatus::all();
        return view('interfaces.executor.executeItem', compact(['order','item', 'line_statuses']));
    }
}
