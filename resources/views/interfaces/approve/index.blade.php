@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Панель согласования</div>

                    <div class="card-body">
                        @if (isset($ordersToApprove))
                            <ul>
                                @foreach($ordersToApprove as $order)
                                    <li>
                                        <a href="{{url("approve/". $order->id)}}"
                                           @if($order->status_id == \Illuminate\Support\Facades\Config::get('status.new'))
                                           style="color: #1aa727;"
                                           @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.approved'))
                                           style="color: #a79721;"
                                           @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.not_approved'))
                                           style="color: #a7131d;"
                                           @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.executor'))
                                           style="color: #2e64a7;"

                                            @endif
                                        >
                                            {{$loop->iteration}}. {{$order->bo->name}} - {{$order->name}} от {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}} - статус: {{$order->status->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header">Все заявки</div>

                    <div class="card-body">
                        @if (isset($ordersAll))
                            <ul>
                                @foreach($ordersAll as $order)
                                    <li>
                                        <a href="{{url("order/". $order->id)}}"
                                           @if($order->status_id == \Illuminate\Support\Facades\Config::get('status.new'))
                                           style="color: #1aa727;"
                                           @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.approved'))
                                           style="color: #a79721;"
                                           @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.not_approved'))
                                           style="color: #a7131d;"
                                           @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.executor'))
                                           style="color: #2e64a7;"
                                           @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.rejected'))
                                           style="color: #a76f08;"

                                            @endif
                                        >
                                            {{$loop->iteration}}. {{$order->bo->name}} - {{$order->name}} от {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}} - статус: {{$order->status->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
