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
                            <a href="{{url(" approve/". $order->id)}}"
                            @if($order->status_id == \Illuminate\Support\Facades\Config::get('status.new'))
                            style="color: #1aa727;"
                            @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.approved'))
                            style="color: #a79721;"
                            @elseif ($order->status_id ==
                            \Illuminate\Support\Facades\Config::get('status.not_approved'))
                            style="color: #a7131d;"
                            @elseif ($order->status_id == \Illuminate\Support\Facades\Config::get('status.executor'))
                            style="color: #2e64a7;"

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
                    @if( Auth::user()->id == 7)
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
                                            <a href="{{url(" order/". $order->id )}}">
                                            {{$loop->iteration}}. {{$order->bo->name}} - {{$order->name}}
                                            от {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}}
                                            - статус: {{$order->status->name}}
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
                    @endif

                    @if( Auth::user()->id != 7)

                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Все заявки
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                             data-parent="#accordionApprove">
                            <div class="card-body">
                                @if (isset($ordersAll))
                                <ul>
                                    @foreach($ordersAll as $order)
                                    <li>
                                        <a href="{{url(" order/". $order->id)}}"
                                        @if($order->status_id == \Illuminate\Support\Facades\Config::get('status.new'))
                                        style="color: #1aa727;"
                                        @elseif ($order->status_id ==
                                        \Illuminate\Support\Facades\Config::get('status.approved'))
                                        style="color: #a79721;"
                                        @elseif ($order->status_id ==
                                        \Illuminate\Support\Facades\Config::get('status.not_approved'))
                                        style="color: #a7131d;"
                                        @elseif ($order->status_id ==
                                        \Illuminate\Support\Facades\Config::get('status.executor'))
                                        style="color: #2e64a7;"
                                        @elseif ($order->status_id ==
                                        \Illuminate\Support\Facades\Config::get('status.rejected'))
                                        style="color: #a76f08;"

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
                    </div>
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
                                        <a href="{{url(" order/". $order->id )}}">
                                        {{$loop->iteration}}. {{$order->bo->name}} - {{$order->name}}
                                        от {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}}
                                        - статус: {{$order->status->name}}
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
