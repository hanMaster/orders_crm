@extends('layouts.app')

@section('content')

    @include('layouts.include.header')

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#items" role="tab" aria-controls="items"
               aria-selected="true">Заявка</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments"
               aria-selected="false">Коментарии</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history"
               aria-selected="false">История изменений</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">

            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th style="width: 50px;">№</th>
                    <th>Наименование материала</th>
                    <th style="width: 81px;">Ед. изм.</th>
                    <th style="width: 75px;">Кол-во</th>
                    <th style="width: 130px;">Дата план</th>
                    <th style="width: 130px;">Дата факт</th>
                    <th style="width: 100px;">Статус</th>
                    <th style="width: 160px;">Исполнитель</th>
                    <th style="width: 200px;">Примечание</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->items as $item)
                    <tr @include('layouts.include.itemColors') >
                        <td>{{$item->idx}}</td>
                        <td>
                            <div><strong>{{$item->order_item}}</strong></div>
                            <div>@include('layouts.include.attach')</div>
                        </td>
                        <td>{{$item->ed->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->date_plan}}</td>
                        <td>{{$item->date_fact}}</td>
                        <td>{{$item->status->name}}</td>
                        <td>{{$item->executor->name ?? 'не назначен'}}</td>
                        <td>{{$item->comment}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
            <div class="card">
                <div class="card-header">
                    <a href="{{url('order/'. $order->id . '/comments/create')}}">Добавить</a>
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
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            <ul class="list-group">
                @foreach($order->logs as $log)
                    <li class="list-group-item">{{\Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i')." - "}} {!! $log->message !!}
                        - {{$log->user->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>


    @if (auth()->user()->role_id == \Illuminate\Support\Facades\Config::get('role.starter')
            && ($order->status_id == \Illuminate\Support\Facades\Config::get('status.not_approved') ||
            $order->status_id == \Illuminate\Support\Facades\Config::get('status.new') ||
            $order->status_id == \Illuminate\Support\Facades\Config::get('status.editing')
            ))

        <form action="{{url('order/'.$order->id.'/reapprove')}}" method="POST" class="mt-3">
            @method('PUT')
            @csrf
            <a href="{{url('order/'.$order->id.'/starter-edit')}}" class="btn btn-primary">Редактировать заявку</a>
            @if ($order->status_id == Config::get('status.not_approved'))
                <button type="submit" class="btn btn-success">На согласование</button>
            @endif

        </form>
    @endif

@endsection
