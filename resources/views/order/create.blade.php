@extends('layouts.app')

@section('content')
    <h3 class="text-center">Создание заявки</h3>

    <div class="d-flex justify-content-between align-items-center">
        <p style="margin: 0;">Объект: <strong>{{$order->bo->name??''}}</strong></p>
        <form action="{{route('order.store')}}" method="POST">
            @method('PUT')
            @csrf
            <input type="hidden" name="order_id" value="{{$order->id}}">
            <button
                type="submit"
                class="btn btn-primary" @if(count($order->items)<1) disabled @endif

            >Закончить редактирование</button>
        </form>
    </div>

    <hr>


    @if(!$order->object_id)
        <form
            action="{{url('order/'.$order->id.'/set-object')}}"
            method="POST"
        >
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
            <div class="col-12">
                <form action="{{route('order.addItemCreate')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="Input_item">Наименование</label>
                        <input
                            type="text"
                            name="item"
                            value="{{old('item')}}"
                            class="form-control"
                            id="Input_item"
                            placeholder="Название материала"
                        >
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="select_ed">Ед.изм.</label>
                                <select class="form-control" name="ed_id" id="select_ed">
                                    @foreach($eds as $ed)
                                        <option value="{{$ed->id}}">{{$ed->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Input_quantity">Кол-во</label>
                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{old('quantity')}}"
                                    class="form-control"
                                    id="Input_quantity"
                                    value='1'
                                >
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Input_date">Дата доставки</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    value="{{date("d.m.Y", mktime(0, 0, 0, date('m'), date('d')+3, date('Y')))}}"
                                    name="delivery_date"
                                    id="Input_date"
                                >
                            </div>
                        </div>

                    </div>
                    <input type="file" name="attached_file" >

                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <button class="btn btn-success btn-block mt-3" type="submit" >Добавить строку</button>
                </form>
                <hr>

                <table class="table table-striped table-bordered mt-4">
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

            </div>

        </div>

    @endif








@endsection
