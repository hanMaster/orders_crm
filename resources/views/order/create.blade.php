@extends('layouts.app')

@section('content')
    <h3 class="text-center">Создание заявки</h3>

    <p>Объект: <strong>{{$order->bo->name??''}}</strong></p>


    @if(!$order->object_id)
        <form action="{{url('order/'.$order->id.'/set-object')}}" method="POST">
            @method('PATCH')
            @csrf
            <select name="object_id" class="form-control">
                <option value="null" >Объект не выбран</option>
                @foreach($objs as $obj)
                    <option value="{{$obj->id}}">{{$obj->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>
    @else
        <div class="row">
            <div class="col-9">
                <form action="{{route('order.addItemCreate')}}" method="POST">
                    @csrf
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th style="width: 50px;">№</th>
                            <th>Наименование</th>
                            <th style="width: 100px;">Ед. изм.</th>
                            <th style="width: 100px;">Кол-во</th>
                            <th style="width: 140px;">Дата поставки</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td style="padding: 0;"></td>
                            <td style="padding: 0;">
                                <input class="form-control" type="text" name="item" value="{{old('item')}}">
                            </td>
                            <td style="padding: 0;">
                                <select class="form-control" name="ed_id" >
                                    @foreach($eds as $ed)
                                    <option value="{{$ed->id}}">{{$ed->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="padding: 0;">
                                <input class="form-control" type="number" value="1" name="quantity">
                            </td>
                            <td style="padding: 0;">
                                <input
                                    class="form-control"
                                    type="text"
                                    value="{{date("d.m.Y", mktime(0, 0, 0, date('m'), date('d')+3, date('Y')))}}"
                                    name="delivery_date"
                                >
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
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <button class="btn btn-outline-secondary" type="submit" >Добавить строку</button>
                </form>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">Действия</div>
                    <div class="card-body">
                        <form action="{{route('order.store')}}" method="POST" class="mt-3">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <button
                                type="submit"
                                class="btn btn-primary" @if(count($order->items)<1) disabled @endif

                            >Закончить редактирование</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    @endif








@endsection
