@extends('layouts.app')

@section('content')

<div class="container">
    <h2>{{$object->name}}</h2>
    <hr>
    <a href="/" class="btn btn-lg btn-info">Назад</a>
    <br/>
    <br/>
    <ul class="list-group">
        <a href="{{'/object/' . $object->id . '/new'}}">
            <li class="list-group-item">Новые<span style="float: right">{{$new}}</span></li>
        </a>
        <a href="{{'/object/' . $object->id . '/executing'}}">
            <li class="list-group-item">На исполнении<span style="float: right">{{$exec}}</span></li>
        </a>
        <a href="{{'/object/' . $object->id . '/done'}}">
            <li class="list-group-item">Исполненные<span style="float: right">{{$done}}</span></li>
        </a>
    </ul>
</div>

@endsection
