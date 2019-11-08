@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>
                            Панель создания заявок
                        </span>
                         <a href="{{route('order.create')}}">Создать заявку</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (isset($orders))
                            <ol>
                                @foreach($orders as $order)
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

                                    @endif
                                    >
                                    {{$loop->iteration}}. {{$order->bo->name??''}} - {{$order->name}} от {{$order->created_at}} - статус: {{$order->status->name}}
                                    </a>
                                </li>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
