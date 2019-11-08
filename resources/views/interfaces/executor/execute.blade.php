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
                    <th style="width: 130px;">Статус</th>
                    <th style="width: 200px;">Примечание</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->execItems as $item)
                    <tr @include('layouts.include.itemColors') >
                        <td>{{$item->idx}}</td>
                        <td>
                            <div>
                                <a href="{{url('execute/'.$order->id. '/item/'. $item->id)}}"><strong>{{$item->order_item}}</strong></a>
                            </div>
                            <div>@include('layouts.include.attach')</div>
                        </td>

                        <td>{{$item->ed->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->date_plan}}</td>
                        <td>{{$item->date_fact}}</td>
                        <td>{{$item->status->name}}</td>
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
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">history</div>
    </div>






@endsection
