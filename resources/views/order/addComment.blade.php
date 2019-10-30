@extends('layouts.app')

@section('content')

    <form action="{{url('order/'.$order->id.'/comments')}}" method="POST">
        @csrf

        <div class="form-group">
            <label for="comment">Комментарий к заявке</label>
            <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <div class="actions">
            <input class="btn btn-success" type="submit" value="Сохранить">
            <a href="/" class="btn btn-light">Отмена</a>
        </div>
    </form>

@endsection
