@extends('layouts.app')

@section('content')
    <h3 class="text-center">Изменение строки заявки</h3>
    <form action="{{route('order.updateItemFromEdit', ['order' => $order, 'item' => $item])}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="Input_item">Наименование</label>
            <input
                type="text"
                name="item"
                value="{{$item->order_item}}"
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
                            <option
                                value="{{$ed->id}}"
                                @if($item->ed_id === $ed->id) selected='selected' @endif
                            >{{$ed->name}}</option>
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
                        value="{{$item->quantity}}"
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
                        value="{{$item->delivery_date}}"
                        name="delivery_date"
                        id="Input_date"
                    >
                </div>
            </div>

        </div>
        @include('layouts.include.attach')
        <input type="file" name="attached_file" >

        <input type="hidden" name="order_id" value="{{$order->id}}">
        <button class="btn btn-success btn-block mt-3" type="submit" >Сохранить изменения</button>
    </form>

@endsection

