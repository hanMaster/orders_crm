@extends('layouts.app')

@section('content')
    <h3 class="text-center">Новый объект</h3>

    <form action="{{url('/bo')}}" method="post">
        @csrf

        <div class="form-group">
            <label for="">Название объекта</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}"/>
        </div>
        <div class="form-group">
            <label for="">Создатель заявок</label>
            <select name="starter_id" class="form-control">
                <option value="null" >Создатель не назначен</option>
                @foreach($starters as $starter)
                    <option value="{{$starter->id}}" >{{$starter->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Согласующий</label>
            <select name="approve_id" class="form-control">
                <option value="null" >Согласующий не назначен</option>
                @foreach($approves as $approve)
                    <option value="{{$approve->id}}" >{{$approve->name}}</option>
                @endforeach
            </select>
        </div>



        <div class="actions">
            <input class="btn btn-success" type="submit" value="Сохранить">
            <a href="/" class="btn btn-light">Отмена</a>
        </div>
    </form>

@endsection
