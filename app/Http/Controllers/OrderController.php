<?php

namespace App\Http\Controllers;

use App\BuildObject;
use App\Ed;
use App\Log;
use App\Order;
use App\OrderComment;
use App\OrderDetail;
use App\Services\DayOffChecker;
use App\Services\NotifSender;
use App\Services\Numerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    public function create()
    {
        $starter_id = auth()->id();
        $order = Order::where(['status_id' => Config::get('status.creating'), 'starter_id' => $starter_id])->first();

        if (!$order) {
            $order = Order::create(['status_id' => Config::get('status.creating'), 'starter_id' => $starter_id, 'name' => '']);
        }

        if (!$order->object_id) {
            $objs = BuildObject::all();
            return view('order.create', compact(['order', 'objs']));
        }

        $eds = Ed::all();

        return view('order.create', compact(['order', 'eds']));
    }

    public function setNameObject(Order $order, Request $request)
    {
        $request->validate([
            'object_id' => 'required|numeric',
            'name' => 'required|min:2'
        ]);
        $order->object_id = $request->object_id;
        $order->name = $request->name;
        $order->save();
        return back();
    }


    public function addItemFromCreate(Request $request)
    {
        $dt = Carbon::now()->add('day', 3)->endOfDay();
        $request->validate([
            'item' => 'required',
            'quantity' => 'required|numeric|gt:0',
            'ed_id' => 'required|numeric|gt:0',
            'attached_file' => 'mimes:pdf,jpg,jpeg,png|max:5120',
            'comment' => 'max:190',
            'date_plan' => 'date|after:'.$dt
        ]);

        $filePath = null;
        if ($request->hasFile('attached_file')) {
            $filePath = $request->attached_file->store('orders', 'public');
        }

        $od = OrderDetail::create([
            'order_item' => $request->item,
            'order_id' => $request->order_id,
            'ed_id' => $request->ed_id,
            'quantity' => $request->quantity,
            'date_plan' => $request->date_plan,
            'dt_plan' => Carbon::parse($request->date_plan)->format('Y.m.d'),
            'attached_file' => $filePath,
            'comment' => $request->comment
        ]);

        Log::create([
            'subject_id' => $od->id,
            'user_id' => Auth::id(),
            'message' => "Создание позиции",
        ]);

        return back();
    }

    public function addItemFromEdit(Request $request, Order $order)
    {
        $dt = Carbon::now()->add('day', 3)->endOfDay();
        $request->validate([
            'item' => 'required',
            'order_id' => 'required|numeric',
            'quantity' => 'required|gt:0',
            'attached_file' => 'mimes:pdf,jpg,jpeg,png|max:5120',
            'comment' => 'max:190',
            'date_plan' => 'date|after:'.$dt
        ]);

        $filePath = null;
        if ($request->hasFile('attached_file')) {
            $filePath = $request->attached_file->store('orders', 'public');
        }

        $od = OrderDetail::create([
            'order_item' => $request->item,
            'order_id' => $order->id,
            'ed_id' => $request->ed_id,
            'quantity' => $request->quantity,
            'date_plan' => $request->date_plan,
            'dt_plan' => Carbon::parse($request->date_plan)->format('Y.m.d'),
            'attached_file' => $filePath,
            'comment' => $request->comment
        ]);

        //Пронумеровали позиции в заявке
        Numerator::numerate($order);

        Log::create([
            'subject_id' => $od->id,
            'user_id' => Auth::id(),
            'message' => "Создание позиции"

        ]);
        return $this->edit($order);
    }

    public function store(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();

        if ($order->status_id == Config::get('status.not_approved')) {
            $order->status_id = Config::get('status.re_approve');
            $message = "Заявка переведена в статус <strong>Для повторного согласования</strong>";
        } else {
            //Заявки от Гаврилова принимаются без согласования
            if (Auth::id() == 18) {
                $order->status_id = Config::get('status.approved');
                $message = "Заявка переведена в статус <strong>Согласована</strong>";
            } else {
                $order->status_id = Config::get('status.new');
                $message = "Заявка переведена в статус <strong>Новая</strong>";
            }
        }
        $order->save();

        $order->created_at = DayOffChecker::getNextWorkDay($order->updated_at);

        $order->save();

        //Пронумеровали позиции в заявке
        Numerator::numerate($order);

        Log::create([
            'subject_id' => $order->id,
            'user_id' => Auth::id(),
            'message' => $message,
            'isLine' => false
        ]);

        return redirect('/');
    }

    public function reApprove(Order $order)
    {
        if ($order) {
            $order->status_id = Config::get('status.re_approve');
            $order->save();
            Log::create([
                'subject_id' => $order->id,
                'user_id' => Auth::id(),
                'message' => "Заявка переведена в статус <strong>Для повторного согласования</strong>",
                'isLine' => false
            ]);

        }

        return redirect('/');
    }

    public function starterEdit(Order $order)
    {
        if ($order->status_id == Config::get('status.new')) {
            $order->status_id = Config::get('status.editing');
        }

        $order->save();
        return $this->edit($order);
    }


    public function edit(Order $order)
    {
        $eds = Ed::all();
        return view('order.edit', compact(['order', 'eds']));
    }

    public function show(Order $order)
    {
        return view('order.show', compact(['order']));
    }

    public function addComment(Order $order)
    {
        return view('order.addComment', compact('order'));
    }

    public function storeComment(Order $order, Request $request)
    {
        $request->validate([
            'comment' => 'required|min:2',
        ]);

        $comment = new OrderComment();
        $comment->order_id = $order->id;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        (new NotifSender())->send($order);


//        $user->notify(new CommentAdded($order, $comment->comment));


        if (Auth::user()->role_id == Config::get('role.executor')) {
            return redirect('/execute/' . $order->id);
        }
        return redirect('/order/' . $order->id);
    }

    public function startApprove(Order $order)
    {
        $order->status_id = Config::get('status.approve_in_process');
        $order->save();
        return view('interfaces.approve.approve', compact('order'));
    }

    public function makeApprove(Order $order, Request $request)
    {
        $request->validate([
            'approved' => 'required',
        ]);
        if ($request->approved == 'on') {
            $order->status_id = Config::get('status.approved');
            $message = "Заявка переведена в статус <strong>Согласована</strong>";
        } else {
            $order->status_id = Config::get('status.not_approved');
            $message = "Заявка переведена в статус <strong>Не согласована</strong>";
        }

        Log::create([
            'subject_id' => $order->id,
            'user_id' => Auth::id(),
            'message' => $message,
            'isLine' => false
        ]);

        $order->save();


        if (isset($request->comment)) {
            $comment = new OrderComment();
            $comment->order_id = $order->id;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->save();
        }
        return redirect('/');
    }

    public function destroyItem(OrderDetail $item, Request $request)
    {
        if ($item->attached_file) {
            Storage::delete("/public/" . $item->attached_file);
        }
        $item->delete();
        return redirect(url('/order/' . $request->order_id . '/edit'));
    }


    public function createItem(Order $order)
    {
        $eds = Ed::all();
        return view('order.createItem', compact(['order', 'eds']));
    }

    public function editItem(Order $order, OrderDetail $item)
    {
        $eds = Ed::all();
        return view('order.editItem', compact(['order', 'item', 'eds']));
    }

    public function updateItem(Order $order, OrderDetail $item, Request $request)
    {
        $dt = Carbon::now()->add('day', 3)->endOfDay();
        $request->validate([
            'item' => 'required',
            'quantity' => 'required|gt:0',
            'attached_file' => 'image|max:1000',
            'comment' => 'max:190',
            'date_plan' => 'date|after:'.$dt
        ]);

        if ($request->hasFile('attached_file')) {
            Storage::delete("/public/" . $item->attached_file);
            $item->attached_file = $request->attached_file->store('orders', 'public');
        }


        $item->order_item = $request->item;
        $item->ed_id = $request->ed_id;
        $item->quantity = $request->quantity;
        $item->date_plan = $request->date_plan;
        $item->dt_plan = Carbon::parse($request->date_plan)->format('Y.m.d');
        $item->comment = $request->comment;
        $item->save();

        Log::create([
            'subject_id' => $item->id,
            'user_id' => Auth::id(),
            'message' => "Изменение позиции"

        ]);

        return $this->edit($order);
    }

    public function print(Order $order)
    {
        return view('interfaces.common.print', compact(['order']));
    }

    public function reject(Order $order)
    {
        try {
            $order->delete();
        } catch (\Exception $e) {
        }
        return redirect('/');
    }
}
