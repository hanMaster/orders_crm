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
            <th style="width: 220px;">Исполнитель</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($order->items as $item)
            <tr
                @if($item->done)
                style="text-decoration: line-through;"
                @endif
            >
                <td>{{$item->idx}}</td>

                <td>
                    {{$item->order_item}}
                    @include('layouts.include.attach')
                </td>

                <td>{{$item->ed->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->delivery_date}}</td>
                <td>{{$item->executor->name ?? 'не назначен'}}</td>
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



    @if (auth()->user()->role_id == \Illuminate\Support\Facades\Config::get('role.starter')
            && ($order->status_id == \Illuminate\Support\Facades\Config::get('status.not_approved') ||
            $order->status_id == \Illuminate\Support\Facades\Config::get('status.new')))

        <form action="{{url('order/'.$order->id.'/reapprove')}}" method="POST" class="mt-3">
            @method('PUT')
            @csrf
            <a href="{{url('order/'.$order->id.'/edit')}}" class="btn btn-primary">Редактировать заявку</a>
            @if ($order->status_id == Config::get('status.not_approved'))
                <button type="submit" class="btn btn-success">На согласование</button>
            @endif

        </form>
    @endif

@endsection
