@extends('layouts.app')

@section('content')

    <div class="header d-flex justify-content-between">
        <h3>Заявка от {{$order->created_at}}</h3>
        <h4><span style="color: #ED5565">Статус: </span>{{$order->status->name}}</h4>
    </div>

    <p>Объект: {{$order->bo->name}}</p>
    <form action="{{url('exec/'. $order->id)}}" method="POST">
        @method('PATCH')
        @csrf
    <div class="row">
        <div class="col-9">


            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th style="width: 60px;">№</th>
                    <th>Наименование материала</th>
                    <th style="width: 90px;">Ед. изм.</th>
                    <th style="width: 80px;">Кол-во</th>
                    <th style="width: 130px;">Дата поставки</th>
                    <th style="width: 220px;">Исполнитель</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{$item->idx}} <input type="checkbox" name="{{'items['.$item->id.']'}}"></td>
                        <td>
                            {{$item->order_item}}
                            @include('layouts.include.attach')
                            @include('layouts.include.logs')

                        </td>
                        <td>{{$item->ed->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->delivery_date}}</td>
                        <td>{{$item->executor->name?? 'Не назначен'}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="card mt-5">
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
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    Назначить исполнителя
                </div>
                <div class="card-body">

                        <select name="executor"  class="form-control">
                            <option value="0">Не назначен</option>
                            @foreach($executors as $exec)
                                <option value="{{$exec->id}}">{{$exec->name}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Назначить</button>

                </div>
            </div>
        </div>
    </div>
    </form>

@endsection


