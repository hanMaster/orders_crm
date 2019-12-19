@extends('layouts.app')

@section('content')

    <div class="header d-flex justify-content-between">
        <h3>{{$order->name}} от {{$order->created_at}}</h3>
        <h4><span style="color: #ED5565">Статус: </span>{{$order->status->name}}</h4>
    </div>

    <div class="header d-flex justify-content-between">
        <div>
            <p>Объект: {{$order->bo->name}}</p>
            <p>Создатель: {{$order->starter->name}}</p>
        </div>

        <a href="{{url("order/".$order->id."/edit")}}">Редактировать заявку</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px;">№</th>
            <th style="width: 250px;">Наименование материала</th>
            <th style="width: 100px;">Ед. изм.</th>
            <th style="width: 100px;">Кол-во</th>
            <th style="width: 150px;">Дата поставки</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{$item->idx}}</td>
                <td>
                    <div><strong>{{$item->order_item}}</strong></div>
                    <div>@include('layouts.include.attach')</div>
                    <div class="d-block" style="color: #343a40; font-size: 12px;">
                        {{$item->comment}}
                    </div>
                </td>
                <td>{{$item->ed->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->date_plan}}</td>
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

