@extends('layouts.app')

@section('content')

<div class="container">
    <h2>{{$object->name . " - " . $status}}</h2>
    <hr>
    <a href="{{ url()->previous() }}" class="btn btn-lg btn-info">Назад</a>
    <br/>
    <br/>
    <ul class="list-group">
        @foreach ($orders as $order)

        <a href="{{'/' . $operation . '/' . $order->id}}">
            <li class="list-group-item">
                {{ \Carbon\Carbon::parse($order->created_at)->format('Y.m.d H:i')}} &nbsp;&nbsp;
                {{$order->name}}
                --- {{$order->status->name}}
            </li>
        </a>
        @endforeach
    </ul>
</div>

@endsection
