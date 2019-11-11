<?php

namespace App\Observers;

use App\LineStatus;
use App\Log;
use App\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class OrderDetailObserver
{
    /**
     * Handle the order detail "created" event.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return void
     */
    public function created(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the order detail "updated" event.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return void
     */
    public function updated(OrderDetail $orderDetail)
    {
        $cntPartialDone = $orderDetail->order->items->where('line_status_id',Config::get('lineStatus.not_deliverable'))->count();
        $cntDone = $orderDetail->order->items->whereIn('line_status_id',[Config::get('lineStatus.not_deliverable'),Config::get('lineStatus.done')])->count();
        $cntAll = $orderDetail->order->items->count();
        if ($cntAll == $cntDone){
            $orderDetail->order->status_id = Config::get('status.exec_done');
            $message = "Заявка <strong>Исполнена</strong>";
            if ($cntPartialDone > 0){
                $orderDetail->order->status_id = Config::get('status.partial_done');
                $message = "Заявка <strong>Частично исполнена</strong>";
            }
            $orderDetail->order->save();
            Log::create([
                'subject_id' => $orderDetail->order->id,
                'user_id' => Auth::id(),
                'message' => $message,
                'isLine' => false
            ]);
        }

        if($orderDetail->line_status_id != $orderDetail->getOriginal('line_status_id')){
            $ls = LineStatus::findOrFail($orderDetail->getOriginal('line_status_id'));
            Log::create([
                'subject_id' => $orderDetail->id,
                'user_id' => Auth::id(),
                'message' => "Изменение статуса c <strong>".$ls->name."</strong> на <strong>".$orderDetail->status->name. "</strong>"
            ]);
        };

    }

    /**
     * Handle the order detail "deleted" event.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return void
     */
    public function deleted(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the order detail "restored" event.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return void
     */
    public function restored(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the order detail "force deleted" event.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return void
     */
    public function forceDeleted(OrderDetail $orderDetail)
    {
        //
    }
}
