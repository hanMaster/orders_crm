@extends('layouts.app')

@section('content')

    <div class="header d-flex justify-content-between">
        <h3>{{$order->name}} от {{$order->created_at}}</h3>
        <h4><span style="color: #ED5565">Статус: </span>{{$order->status->name}}</h4>
    </div>

    <p>Объект: {{$order->bo->name??''}}</p>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px;">№</th>
            <th style="width: 250px;">Наименование материала</th>
            <th style="width: 81px;">Ед. изм.</th>
            <th style="width: 75px;">Кол-во</th>
            <th style="width: 130px;">Дата план</th>
            <th style="width: 130px;">Дата исполнения</th>
            <th style="width: 130px;">Статус</th>
        </tr>
        </thead>
        <tbody>
        <tr>
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
        </tr>
        </tbody>
    </table>
    <form action="{{url('/execute/'.$item->id)}}" method="POST">
        @method('patch')
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="date_fact">Дата исполнения</label>
                    <input
                        type="text"
                        class="form-control"
                        id="date_fact"
                        name="date_fact"
                        value="{{old('date_fact') ?? \Carbon\Carbon::now()->format('d.m.Y')}}"

                    >
                </div>

            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="status">Изменить статус</label>
                    <select name="status" id="status" class="form-control">
                        @foreach($line_statuses as $status)
                            <option value="{{$status->id}}"
                                    @if($status->id == $item->line_status_id) selected='selected' @endif
                            >{{$status->name}}</option>

                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="date_fact">Примечание</label>
                    <input
                        type="text"
                        class="form-control"
                        id="comment"
                        name="comment"
                        value="{{$item->comment}}"
                    >
                </div>



            </div>
        </div>


        <button type="submit" class="btn btn-outline-primary">Сохранить изменения</button>
        <a href="{{url('execute/'.$order->id)}}" class="btn btn-outline-secondary">Назад к списку</a>
    </form>

    <hr>
    <div class="card mt-5">
        <div class="card-header">
            История позиции заявки
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($item->logs as $log)
                    <li class="list-group-item">{{\Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i')." - "}} {!! $log->message !!}
                        - {{$log->user->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection

@section('js')
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>

    <script>
        $().ready(function(){
            $('#date_fact').datepicker({
                autoclose: true,
                startDate: '-1Y',
                language: "ru",
            });
        });
    </script>
@endsection
