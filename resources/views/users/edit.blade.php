@extends('layouts.app')

@section('content')
    <h3 class="text-center">Изменение данных сотрудника</h3>

    <form action="{{url('/users/'.$user->id)}}" method="post">
        {{ method_field('patch')}}
        @csrf

        <div class="form-group">
            <label for="">Имя</label>
            <input type="text" name="name" class="form-control" value="{{$user->name}}"/>
        </div>
        <div class="form-group">
            <label for="">Роль</label>
            <select name="role_id" class="form-control">
                <option disabled>Выберите роль</option>
                <option value="0" @if($user->role_id == 0) selected='selected' @endif>Роль не назначена</option>
                @foreach($roles as $role)
                <option value="{{$role->id}}" @if($user->role_id == $role->id) selected='selected' @endif>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="actions">
            <input class="btn btn-success" type="submit" value="Сохранить">
            <a href="/" class="btn btn-light">Отмена</a>
        </div>
    </form>

@endsection
