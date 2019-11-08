@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Текущие заявки</div>

                    <div class="card-body">

                        @if (isset($orders))
                            <ol>
                                @foreach($orders as $order)
                                    <li>
                                        <a href="{{url("execute/". $order->id )}}">
                                            {{$order->bo->name}} - {{$order->name}} от {{$order->created_at}} - статус: {{$order->status->name}}
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
