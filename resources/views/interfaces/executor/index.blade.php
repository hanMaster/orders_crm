@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Текущие заявки</div>

                    <div class="card-body">

                        @if (isset($orders))
                            <ul>
                                @foreach($orders as $order)
                                    <li>
                                        <a href="{{url("execute/". $order->id )}}">
                                            {{$loop->iteration}}. {{$order->bo->name}} - {{$order->name}}
                                            от {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}} - статус: {{$order->status->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>

                @include('layouts.include.ordersDone')


            </div>
        </div>
    </div>
@endsection
