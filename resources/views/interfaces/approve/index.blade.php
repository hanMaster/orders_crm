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
                            <a href="{{url('approve/'. $order->id)}}"
                            @if($order->status_id == \Illuminate\Support\Facades\Config::get('status.new'))
                            style="color: #1aa727;"
                            @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.re_approve'))
                            style="color: #a79721;"
                            @elseif ($order->status_id ==
                            \Illuminate\Support\Facades\Config::get('status.approve_in_process'))
                            style="color: #a7131d;"
                            @endif
                            >
                            {{$loop->iteration}}. {{$order->bo->name??''}} - {{$order->name??''}} от {{
                            \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}} - статус:
                            {{$order->status->name}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">Панель совместного согласования</div>

                <div class="card-body">
                    @if (isset($coApproveOrders))
                    <ul>
                        @foreach($coApproveOrders as $order)
                        <li>
                            <a href="{{url('order/'. $order->id)}}"
                            @if($order->status_id == \Illuminate\Support\Facades\Config::get('status.new'))
                            style="color: #1aa727;"
                            @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.re_approve'))
                            style="color: #a79721;"
                            @elseif ($order->status_id ==
                            \Illuminate\Support\Facades\Config::get('status.approve_in_process'))
                            style="color: #a7131d;"
                            @endif
                            >
                            {{$loop->iteration}}. {{$order->bo->name??''}} - {{$order->name??''}} от {{
                            \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}} - статус:
                            {{$order->status->name}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <div class="card mt-5">
                <div class="accordion" id="accordionApprove">
                    @if (isset($bo))
                    @foreach($bo as $object)

                    @php ($hasRows = 0)
                    @foreach($workOrders as $order)
                    @if ($order->object_id == $object->id)
                    @php ($hasRows = 1)
                    @endif
                    @endforeach

                    @if ($hasRows == 1)
                    <div class="card">
                        <div class="card-header" id="heading{{$object->id}}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse{{$object->id}}"
                                        aria-expanded="false"
                                        aria-controls="collapse{{$object->id}}">
                                    {{$object->name}}
                                </button>
                            </h2>
                        </div>
                        <div id="collapse{{$object->id}}" class="collapse" aria-labelledby="heading{{$object->id}}"
                             data-parent="#accordionApprove">
                            <div class="card-body">
                                @if (isset($workOrders))
                                <ul>
                                    @foreach($workOrders as $order)
                                    @if ($order->object_id == $object->id)
                                    <li>
                                        <a href="{{url('order/'. $order->id )}}">
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('Y.m.d H:i')}} &nbsp;&nbsp;
                                        {{$order->name}}
                                        --- {{$order->status->name}}
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @endforeach
                    @endif
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                    Завершенные {{$doneOrders->count() > 0 ? $doneOrders->count() : ''}}
                                </button>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                             data-parent="#accordionApprove">
                            <div class="card-body">
                                @if (isset($doneOrders))
                                <ul>
                                    @foreach($doneOrders as $order)
                                    <li>
                                        <a href="{{url('order/'. $order->id )}}">

                                        {{ \Carbon\Carbon::parse($order->created_at)->format('Y.m.d H:i')}} &nbsp;&nbsp;
                                        {{$order->bo->name}} --- {{$order->name}}
                                        --- {{$order->status->name}}

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

        </div>
    </div>
</div>
@endsection
