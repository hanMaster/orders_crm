@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Начальник службы снабжения</div>

                    <div class="card-body">
                        @if (isset($orders))
                            <ul>
                                @foreach($orders as $order)
                                    <li>
                                        @if($order->status_id === \Illuminate\Support\Facades\Config::get('status.approved')||$order->status_id === \Illuminate\Support\Facades\Config::get('status.executor'))
                                            <a href="{{url("exec/". $order->id . '/assign')}}"
                                        @else
                                            <a href="{{url("order/". $order->id )}}"
                                        @endif
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
                                                {{$loop->iteration}}. {{$order->bo->name}} - {{$order->name}} от {{$order->created_at}} - статус: {{$order->status->name}}
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
