@extends('layouts.app')

@section('content')
    <h3 class="text-center mb-3">Редактирование заявки {{$order->name}}</h3>
    <p>Объект: <strong>{{$order->bo->name??''}}</strong></p>



    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px;">№</th>
            <th>Наименование</th>
            <th style="width: 100px;">Ед. изм.</th>
            <th style="width: 100px;">Кол-во</th>
            <th style="width: 140px;">Дата поставки</th>
            <th style="width: 220px;">Действие</th>
        </tr>
        </thead>

        <tbody>

        @if(isset($order->items))
            @foreach($order->items as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <div>
                            <strong>{{$item->order_item}}</strong>
                        </div>
                        <div>
                            @include('layouts.include.attach')
                        </div>
                        <div>
                            {{$item->comment}}
                        </div>
                    </td>
                    <td>{{$item->ed->name}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->date_plan}}</td>
                    <td style="padding: 0; vertical-align: middle; text-align: center; ">
                        <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}"
                              action="{{url('/order/items/'.$item->id)}}" method="POST">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <a class="btn btn-outline-secondary"
                               href="{{route('order.editItemFromEdit',['order' => $order, 'item' => $item])}}">Редактировать</a>
                            <button type="submit" class="btn btn-outline-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <a href="{{route('order.addItemFromEdit', ['order'=>$order->id])}}" class="btn btn-success">Добавить строку</a>
        <form action="{{route('order.store')}}" method="POST">
            @method('PUT')
            @csrf
            <input type="hidden" name="order_id" value="{{$order->id}}">
            <button type="submit" class="btn btn-primary">Закончить редактирование</button>
        </form>
    </div>

@endsection

@section('js')
    <script src="/js/vendor/pdf.min.js"></script>
    <script src="/js/main.js"></script>
@endsection
