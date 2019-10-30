@extends('layouts.app')

@section('content')
    <h3 class="text-center mb-3">Редактирование заявки</h3>
    <p>Объект: <strong>{{$order->bo->name??''}}</strong></p>



    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px;">№</th>
            <th>Наименование</th>
            <th style="width: 100px;">Ед. изм.</th>
            <th style="width: 100px;">Кол-во</th>
            <th style="width: 140px;">Дата поставки</th>
            <th style="width: 100px;">Действие</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td colspan="6" style="padding: 0;">
                <form action="{{url('order/'.$order->id. '/edit')}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                <table class="table table-striped table-bordered">
                    <tbody>
                    <tr>
                        <td style="width: 50px; padding: 0;"></td>
                        <td style="padding: 0; width: 100%;">
                            <input class="form-control" type="text" name="item" value="{{old('item')}}">
                        </td>
                        <td style="padding: 0; width: 100px;">
                            <select class="form-control" name="ed_id" >
                                @foreach($eds as $ed)
                                    <option value="{{$ed->id}}">{{$ed->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="padding: 0; width: 100px;">
                            <input class="form-control" type="number" value="1" name="quantity">
                        </td>
                        <td style="padding: 0; width: 140px;">
                            <input
                                class="form-control"
                                type="text"
                                value="{{date("d.m.Y", mktime(0, 0, 0, date('m'), date('d')+3, date('Y')))}}"
                                name="delivery_date"
                            >
                        </td>
                        <td style="padding: 0; vertical-align: middle; text-align: center;  width: 100px;">
                            <button class="btn btn-outline-primary" type="submit">Добавить</button>

                        </td>
                    </tr>
                    </tbody>
                </table>
                </form>
            </td>




        </tr>

        @if(isset($order->items))
            @foreach($order->items as $i)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$i->order_item}}</td>
                    <td>{{$i->ed->name}}</td>
                    <td>{{$i->quantity}}</td>
                    <td>{{$i->delivery_date}}</td>
                    <td style="padding: 0; vertical-align: middle; text-align: center; ">
                        <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}"
                              action="{{url('/order/items/'.$i->id)}}" method="POST">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <button type="submit" class="btn btn-outline-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>


    <form action="{{route('order.store')}}" method="POST" class="mt-3">
        @method('PUT')
        @csrf
        <input type="hidden" name="order_id" value="{{$order->id}}">
        <button type="submit" class="btn btn-primary">Закончить редактирование</button>
    </form>


@endsection
