@extends('layouts.app')

@section('content')
    <h3 class="text-center">Создание заявки {{$order->name??''}}</h3>

    <div class="d-flex justify-content-between align-items-center">
        <p style="margin: 0;">Объект: <strong>{{$order->bo->name??'Не выбран'}}</strong></p>
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
            action="{{url('order/'.$order->id.'/set-name-object')}}"
            method="POST"
        >
            @method('PATCH')
            @csrf

            <div class="form-group">
                <label for="name">Название заявки</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Введите название заявки"
                    value="{{$order->name}}"
                    class="form-control"
                >
            </div>

            <div class="form-group">
                <label for="object">Объект</label>
                <select name="object_id" id=""object class="form-control">
                    <option value="null" >Объект не выбран</option>
                    @foreach($objs as $obj)
                        <option value="{{$obj->id}}">{{$obj->name}}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>
    @else
        <div class="row">
            <div class="col-12">
                <form action="{{route('order.addItemCreate')}}" method="POST" enctype="multipart/form-data">
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
                                        <option value="{{$ed->id}}"
                                            @if(old('ed_id') == $ed->id)
                                                    selected="selected"
                                            @endif>{{$ed->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Input_quantity">Кол-во</label>
                                <input
                                    class="form-control"
                                    id="Input_quantity"
                                    name="quantity"
                                    type="number"
                                    value="{{old('quantity')??1}}"
                                >
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="input_date">Желаемая дата поставки</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    value="{{old('date_plan') ?? date("d.m.Y", mktime(0, 0, 0, date('m'), date('d')+3, date('Y')))}}"
                                    name="date_plan"
                                    id="input_date"
                                >
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <input type="file" name="attached_file" >
                    </div>

                    <div class="form-group">
                        <label for="comment">Примечание</label>
                        <input
                            type="text"
                            name="comment"
                            value="{{old('comment')}}"
                            class="form-control"
                            id="comment"
                            placeholder="Добавьте примечание"
                        >
                    </div>
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
                        <th style="width: 200px;">Примечание</th>
                    </tr>
                    </thead>

                    <tbody>
                        @if(isset($order->items))
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        {{$item->order_item}}
                                        @include('layouts.include.attach')
                                    </td>
                                    <td>{{$item->ed->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->date_plan}}</td>
                                    <td>{{$item->comment}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>

        </div>

    @endif

@endsection

@section('js')
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>

    <script>
        $().ready(function(){
            $('#input_date').datepicker({
                format: 'dd.mm.yyyy',
                autoclose: true,
                startDate: '-13Y'
            });

            $('#input_date').datepicker('update', dt);
        });

    </script>
@endsection
