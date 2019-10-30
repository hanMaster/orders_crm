@extends('layouts.app')

@section('content')
    <h3 class="text-center">Изменить объект</h3>

    <form action="{{url('/bo/'.$bo['id'])}}" method="post">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="">Название объекта</label>
            <input type="text" name="name" class="form-control" value="{{$bo->name}}"/>
        </div>
        <div class="form-group">
            <label for="">Создатель заявок</label>
            <select name="starter_id" class="form-control">
                <option value="null" @if($bo->starter_id === null) selected='selected' @endif>Создатель не назначен</option>
                @foreach($starters as $starter)
                    <option
                        value="{{$starter->id}}"
                        @if($bo->starter_id === $starter->id)
                            selected='selected'
                        @endif
                    >{{$starter->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Согласующий</label>
            <select name="approve_id" class="form-control">
                <option value="null" @if($bo->approve_id === null) selected='selected' @endif>Согласующий не назначен</option>
                @foreach($approves as $approve)
                    <option
                        value="{{$approve->id}}"
                        @if($bo->approve_id === $approve->id)
                            selected='selected'
                        @endif
                    >{{$approve->name}}</option>
                @endforeach
            </select>
        </div>



        <div class="actions">
            <input class="btn btn-success" type="submit" value="Сохранить">
            <a href="/" class="btn btn-light">Отмена</a>
        </div>
    </form>

@endsection

