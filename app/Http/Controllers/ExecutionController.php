<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ExecutionController extends Controller
{
    public function assign(Order $order){
        $executors = User::where('role_id', Config::get('role.executor'))->get();
        return view('interfaces.mainExecutor.assign', compact(['order','executors']));

    }

    public function assignStore(Order $order, Request $request){

        $items = $request->items;
        if (isset($items)){
            foreach ($items as $index => $item) {
                $item = OrderDetail::where('id', $index)->first();
                if ($item){
                    $item->executor_id = $request->executor;
                    $item->save();
                }
            }
            $order->status_id = Config::get('status.executor');
            $order->save();
            return redirect('exec/'.$order->id.'/assign');
        }
        return redirect('exec/'.$order->id.'/assign')->with("error", "Не выбран ни один пункт заявки");

    }

    public function execute(Order $order){
        return view('interfaces.executor.execute', compact('order'));
    }
}
