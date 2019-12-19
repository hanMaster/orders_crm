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

            <form action="{{url('print/'. $order->id)}}" method="POST">
                @csrf

                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th style="width: 60px;">№</th>
                        <th style="width: 250px;">Наименование материала</th>
                        <th style="width: 81px;">Ед. изм.</th>
                        <th style="width: 75px;">Кол-во</th>
                        <th style="width: 130px;">Дата план</th>
                        <th style="width: 130px;">Дата исполнения</th>
                        <th style="width: 130px;">
                            <div class="dropdown">
                                <a class="dropdown-toggle"
                                   href="#" role="button"
                                   id="dropdownMenuLink"
                                   data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false"
                                   style="color: white;"
                                >
                                    Статус
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach($statuses as $status)
                                        <a class="dropdown-item" href="#"
                                           onclick="dropClick({{$status->id}})"
                                        >{{$status->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </th>
                        <th style="width: 200px;">Примечание</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->execItems as $item)
                        <tr @include('layouts.include.itemColors') >
                            <td>
                                {{$item->idx}}
                                <input type="checkbox" class="checkbox" name="items[{{$item->idx}}]"/>
                            </td>
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
                <input type="submit" class="btn btn-primary" value="Печать заявки">
            </form>

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


    <form
        id="mass-assign-form"
        action="{{url('items-status-change/'. $order->id)}}"
        method="POST"
        style="display: none;"
    >
        @method('PATCH')
        @csrf
        <input type="hidden" name="status_id" id="status_id" value="">
    </form>
@endsection

@section('js')
    <script>
        const dropClick = id => {
            event.preventDefault();
            document.querySelector('#status_id').value = id;
            if (confirm('Изменить статус всех позиций заявки?')) {
                document.getElementById('mass-assign-form').submit();
            }
        }
        const dropSingleClick = (item_id, exec_id) => {
            console.log('item: ', item_id);
            console.log("exec: ", exec_id);
            event.preventDefault();
            document.querySelector('#single_exec_input').value = exec_id;
            document.querySelector('#item_id').value = item_id;
            document.getElementById('single-assign-form').submit();
        }

    </script>
@endsection
