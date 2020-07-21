<?php

namespace App\Http\Controllers;

use App\LineStatus;
use App\Log;
use App\Order;
use App\OrderDetail;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ExecutionController extends Controller
{
    public function assign(Order $order)
    {
        $executors = User::where('role_id', Config::get('role.executor'))->get();
        return view('interfaces.mainExecutor.assign', compact(['order', 'executors']));

    }

    public function assignStore(Order $order, Request $request)
    {
        foreach ($order->items as $item) {
            $item->executor_id = $request->executor;
            $item->save();
        }
        $order->status_id = Config::get('status.executor');
        $order->save();
        return redirect('exec/' . $order->id . '/assign');
    }

    public function assignSingleStore(Request $request)
    {
        $item = OrderDetail::findOrFail($request->item);
        $item->executor_id = $request->executor;
        $item->save();

        Log::create([
            'subject_id' => $item->id,
            'user_id' => Auth::id(),
            'message' => "Назначен исполнитель: " . $item->executor->name
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->status_id = Config::get('status.executor');
        $order->save();

        return back();
    }


    public function execute(Order $order)
    {
        $statuses = LineStatus::all();
        return view('interfaces.executor.execute', compact(['order', 'statuses']));
    }

    public function executeItem(OrderDetail $item, Request $request)
    {
        $request->validate([
            'date_fact' => 'date'
        ]);

        if ($item->line_status_id != $request->status) {
            $item->line_status_id = $request->status;
            $item->save();
        }

        if ($item->comment != $request->comment) {
            $item->comment = $request->comment;
            $item->save();
        }


        if ($item->line_status_id == Config::get('lineStatus.done') ||
            $item->line_status_id == Config::get('lineStatus.not_deliverable')) {
            $item->date_fact = $request->date_fact;
            $item->save();
        }

        return back();
    }

    public function getExecuteItem(Order $order, OrderDetail $item)
    {
        $line_statuses = LineStatus::all();
        return view('interfaces.executor.executeItem', compact(['order', 'item', 'line_statuses']));
    }

    public function itemsStatusChange(Order $order, Request $request)
    {
        if (isset($request->items)) {
            $items = $order->execItems->whereIn('idx', array_keys($request->items));
        } else {
            $items = $order->execItems;
        }
        foreach ($items as $item) {
            $item->line_status_id = $request->status_id;
            $item->save();
        }
        return back();
    }

    public function print(Order $order, Request $request)
    {
        if (isset($request->items)) {
            $items = $order->execItems->whereIn('idx', array_keys($request->items));
        } else {
            $items = $order->execItems;
        }
        return view('interfaces.common.print', compact(['order', 'items']));
    }
}
