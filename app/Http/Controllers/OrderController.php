<?php

namespace App\Http\Controllers;

use App\BuildObject;
use App\Ed;
use App\Order;
use App\OrderComment;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Services\Numerator;

class OrderController extends Controller
{

    public function create(){
        $starter_id = auth()->id();
        $order = Order::where(['status_id' => Config::get('status.edit'), 'starter_id'=>$starter_id])->first();

        if (!$order){
            $order = Order::create(['status_id' => Config::get('status.edit'), 'starter_id'=>$starter_id]);
        }

        if(!$order->object_id){
            $objs = BuildObject::all();
            return view('order.create', compact(['order','objs']));
        }

        $eds = Ed::all();

        return view('order.create', compact(['order', 'eds']));
    }

    public function setObject(Order $order, Request $request){
        $request->validate(['object_id' => 'required|numeric']);
        $order->object_id = $request->object_id;
        $order->save();
        return $this->create();
    }


    public function addItemFromCreate(Request $request){
//        return $request;
        $request->validate([
            'item' => 'required',
            'quantity' => 'required|numeric|gt:0',
            'ed_id' => 'required|numeric|gt:0'
        ]);

        OrderDetail::create([
            'order_item'=>$request->item,
            'order_id'=>$request->order_id,
            'ed_id' => $request->ed_id,
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date
        ]);

        return $this->create();
    }

    public function addItemFromEdit(Request $request, Order $order){
//return $request;
        $request->validate([
            'item' => 'required',
            'order_id' => 'required|numeric',
            'quantity' => 'required|gt:0',
        ]);

        OrderDetail::create([
            'order_item'=>$request->item,
            'order_id'=>$order->id,
            'ed_id' => $request->ed_id,
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date
        ]);
        return $this->edit($order);
    }

    public function store(Request $request){
        $order = Order::where('id',$request->order_id)->first();
        if($order->object_id == null) {
            return back()->with('error', 'Вы ничего не добавили в заявку');
        }

        if ($order->status_id == \Illuminate\Support\Facades\Config::get('status.not_approved')){
            $order->status_id = Config::get('status.re_approve');
        }else{
            $order->status_id = Config::get('status.new');
        }
        $order->save();
        //Пронумеровали позиции в заявке
        Numerator::numerate($order);

        return redirect('/');
    }

    public function reApprove(Order $order){
        if($order){
            $order->status_id = Config::get('status.re_approve');
            $order->save();
        }

        return redirect('/');
    }

    public function edit(Order $order){
        $objs = BuildObject::all();
        $eds = Ed::all();
        return view('order.edit', compact(['order', 'objs', 'eds']));
    }

    public function show(Order $order){
        return view('order.show', compact(['order']));
    }

    public function addComment(Order $order){
        return view('order.addComment', compact('order'));
    }

    public function storeComment(Order $order, Request $request){
        $request->validate([
            'comment' => 'required|min:2',
        ]);

        $comment = new OrderComment();
        $comment->order_id = $order->id;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->save();
        return redirect('/order/'. $order->id);
    }

    public function startApprove(Order $order){
        $order->status_id = Config::get('status.approve_in_process');
        $order->save();
        return view('interfaces.approve.start', compact('order'));
    }

    public function makeApprove(Order $order, Request $request){
        $request->validate([
            'approved' => 'required',
        ]);
        if ($request->approved == 'on'){
            $order->status_id = Config::get('status.approved');
        }else{
            $order->status_id = Config::get('status.not_approved');
        }
        $order->save();


        if (isset($request->comment)){
            $comment = new OrderComment();
            $comment->order_id = $order->id;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->save();
        }
        return redirect('/');
    }

    public function destroyItem(OrderDetail $item, Request $request){
        $item->delete();
        return redirect(url('/order/'.$request->order_id.'/edit'));
    }

}
