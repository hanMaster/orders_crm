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
                    <th style="width: 45px;">№</th>
                    <th>Наименование материала</th>
                    <th style="width: 81px;">Ед. изм.</th>
                    <th style="width: 75px;">Кол-во</th>
                    <th style="width: 130px;">Дата план</th>
                    <th style="width: 130px;">Дата факт</th>
                    <th style="width: 170px;">
                        <div class="dropdown">
                            <a class="dropdown-toggle"
                               href="#" role="button"
                               id="dropdownMenuLink"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false"
                               style="color: white;"
                            >
                                Исполнитель
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                @foreach($executors as $exec)
                                    <a class="dropdown-item" href="#"
                                       onclick="dropClick({{$exec->id}})"
                                    >{{$exec->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </th>
                    <th style="width: 130px;">Статус</th>
                    <th style="width: 200px;">Примечание</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->items as $item)
                    <tr @include('layouts.include.itemColors')>
                        <td>{{$item->idx}}</td>
                        <td>
                            <div class="d-block">
                                <strong>{{$item->order_item}}</strong>
                            </div>
                            <div class="d-block">
                                @include('layouts.include.attach')
                            </div>
                            <div class="d-block">
                                @include('layouts.include.logs')
                            </div>
                        </td>
                        <td>{{$item->ed->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->date_plan}}</td>
                        <td>{{$item->date_fact}}</td>
                        <td>

                            <div class="dropdown">
                                <a href="#" role="button"
                                   id="dropdownMenuLink{{$item->id}}"
                                   data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false"
                                >
                                    {{$item->executor->name?? 'Не назначен'}}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{$item->id}}">
                                    @foreach($executors as $exec)
                                        <a class="dropdown-item" href="#"
                                           onclick="dropSingleClick({{$item->id}},{{$exec->id}})"
                                        >{{$exec->name}}</a>
                                    @endforeach
                                </div>
                            </div>

                        </td>
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
        action="{{url('exec/'. $order->id)}}"
        method="POST"
        style="display: none;"
    >
        @method('PATCH')
        @csrf
        <input type="hidden" name="executor" id="exec_input" value="">
    </form>
    <form
        id="single-assign-form"
        action="{{url('exec-single')}}"
        method="POST"
        style="display: none;"
    >
        @method('PATCH')
        @csrf
        <input type="hidden" name="order_id" value="{{$order->id}}">
        <input type="hidden" name="executor" id="single_exec_input" value="">
        <input type="hidden" name="item" id="item_id" value="">

    </form>

@endsection

@section('js')
    <script>
        const dropClick = id => {
            event.preventDefault();
            document.querySelector('#exec_input').value = id;
            if (confirm('Назначить исполнителя на всю заявку?')) {
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
