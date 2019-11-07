@extends('layouts.app')

@section('content')

    <div class="header d-flex justify-content-between">
        <h3>Заявка от {{$order->created_at}}</h3>
        <h4><span style="color: #ED5565">Статус: </span>{{$order->status->name}}</h4>
    </div>

    <div class="info d-flex justify-content-between">
        <p>Объект: {{$order->bo->name??''}}</p>
        @if ($order->executor)
            <p style="color: #227dc7;">Исполнитель: {{$order->executor->name}}</p>
        @endif
    </div>


    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px;">№</th>
            <th>Наименование материала</th>
            <th style="width: 100px;">Ед. изм.</th>
            <th style="width: 100px;">Кол-во</th>
            <th style="width: 150px;">Дата поставки</th>
            <th style="width: 100px;">Статус</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($order->execItems as $item)
            <tr>
                <td>{{$item->idx}}</td>

                <td>
                    {{$item->order_item}}
                    @include('layouts.include.attach')
                </td>

                <td>{{$item->ed->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->delivery_date}}</td>
                <td style="padding: 0;text-align: center; vertical-align: middle;">
                    @if($item->done)
                        Исполнено
                    @else
                    <form onsubmit="if(confirm('Подтвердите изменение статуса!')) {return true} else {return false}"
                          action="{{url('/execute/'.$item->id)}}" method="POST">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-outline-success">Исполнено</button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Комментарии <a href="{{url('order/'. $order->id . '/comments/create')}}">Добавить</a>
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

@endsection
