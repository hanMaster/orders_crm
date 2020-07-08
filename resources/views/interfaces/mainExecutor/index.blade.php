@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion" id="accordionMainExecutor">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    В процессе создания
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                             data-parent="#accordionMainExecutor">
                            <div class="card-body">
                                @if (isset($preOrders))
                                    <ul>
                                        @foreach($preOrders as $order)
                                            <li>
                                                <a href="{{url("order/". $order->id )}}">
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
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                    Требуют назначения
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                             data-parent="#accordionMainExecutor">
                            <div class="card-body">
                                @if (isset($startOrders))
                                    <ul>
                                        @foreach($startOrders as $order)
                                            <li>
                                                <a href="{{url("exec/". $order->id . '/assign')}}">
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
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    В процессе исполнения
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                             data-parent="#accordionMainExecutor">
                            <div class="card-body">
                                @if (isset($workOrders))
                                    <ul>
                                        @foreach($workOrders as $order)
                                            <li>
                                                <a href="{{url("exec/". $order->id . '/assign')}}">
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
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                    Завершенные
                                </button>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                             data-parent="#accordionMainExecutor">
                            <div class="card-body">
                                @if (isset($doneOrders))
                                    <ul>
                                        @foreach($doneOrders as $order)
                                            <li>
                                                <a href="{{url("order/". $order->id )}}">
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
@endsection
