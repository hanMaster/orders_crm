@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Панель согласования</div>

                    <div class="card-body">
                        @if (isset($orders))
                            <ol>
                                @foreach($orders as $order)
                                    <li>
                                        <a href="{{url("approve/". $order->id)}}">
                                            {{$order->bo->name}} - заявка от {{$order->created_at}} - статус: {{$order->status->name}}
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
