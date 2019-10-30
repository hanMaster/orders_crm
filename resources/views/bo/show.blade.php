@extends('layouts.app')

@section('content')
    <h3 class="text-center">{{$bo->name}}</h3>

    <h4>Создатель заявок: <strong> {{isset($bo->starter_id)?$bo->starter->name: 'Не назначен'}}</strong></h4>
    <h4>Согласующий: <strong>{{isset($bo->approve_id)?$bo->approve->name: 'Не назначен'}}</strong></h4>
    <a href="/" class="btn btn-primary">Назад</a>
@endsection

