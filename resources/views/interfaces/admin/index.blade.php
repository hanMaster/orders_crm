@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{route('push')}}" class="btn btn-outline-primary btn-block">Make a Push Notification!</a>
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between p-1">
                <h4 style="display:inline-block;">Пользователи</h4>
                <a href="{{url('register')}}">Создать пользователя</a>
            </div>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th class="text-right">Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role['name']}}</td>
                        <td class="text-right">
                            @include("layouts.include.password")
                            <a href="{{url('/users/'.$user->id.'/edit')}}" class="btn btn-sm btn-success">Изменить</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>


        <div class="col-md-4">
            <div class="d-flex justify-content-between p-1">
                <h4 style="display:inline-block;">Объекты</h4>
                <a href="{{url('/bo/create')}}">Новый объект</a>
            </div>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>Название объекта</th>
                    <th class="text-right">Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($buildObjects as $bo)
                    <tr>
                        <td><a href="/bo/{{$bo->id}}">{{$bo->name}}</a></td>
                        <td class="text-right">
                            <a href="{{url('/bo/'.$bo->id.'/edit')}}" class="btn btn-sm btn-success">Изменить</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>
</div>
@endsection
