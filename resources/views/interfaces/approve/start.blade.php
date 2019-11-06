@extends('layouts.app')

@section('content')

    <div class="header d-flex justify-content-between">
        <h3>Заявка от {{$order->created_at}}</h3>
        <h4><span style="color: #ED5565">Статус: </span>{{$order->status->name}}</h4>
    </div>

    <p>Объект: {{$order->bo->name}}</p>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px;">№</th>
            <th>Наименование материала</th>
            <th style="width: 100px;">Ед. изм.</th>
            <th style="width: 100px;">Кол-во</th>
            <th style="width: 150px;">Дата поставки</th>
            <th style="width: 220px;">Исполнитель</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{$item->idx}}</td>
                <td>
                    {{$item->order_item}}
                    @include('layouts.include.attach')
                </td>
                <td>{{$item->ed->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->delivery_date}}</td>
                <td>{{$item->executor ?? 'не назначен'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="card mt-5">
        <div class="card-header d-flex justify-content-between">
            Комментарии
        </div>
        <div class="card-body">
            @foreach($order->comments as $comment)
                <div class="comment-box">
                    <strong>{{$comment->user->name}}</strong>
                    {{$comment->comment}}
                    <span>{{$comment->created_at}}</span>
                </div>
            @endforeach

        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">Согласование</div>
        <div class="card-body">
            <form action="{{url('approve/'. $order->id)}}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="approved" value="off">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="approved">
                    <label class="custom-control-label" for="customSwitch1">Согласовано</label>
                </div>
                <textarea name="comment" cols="30" rows="5" class="form-control mt-4 mb-4"></textarea>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </div>

@endsection

