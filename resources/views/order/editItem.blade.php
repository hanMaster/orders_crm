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
                                @if($item->ed_id == $ed->id) selected='selected' @endif
                            >
                                {!!$ed->name!!}
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
                        step="0.1"
                        value="{{$item->quantity}}"
                    >
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="input_date">Дата доставки</label>
                    <input
                        class="form-control"
                        id="input_date"
                        name="date_plan"
                        type="text"
                        value="{{$item->date_plan}}"
                    >
                </div>
            </div>

        </div>


        <div class="form-group">
            @include('layouts.include.attach')
            <input type="file" name="attached_file" >
        </div>

        <div class="form-group">
            <label for="comment">Примечание</label>
            <input
                type="text"
                name="comment"
                value="{{$item->comment}}"
                class="form-control"
                id="comment"
                placeholder="Добавьте примечание"
            >
        </div>

        <input type="hidden" name="order_id" value="{{$order->id}}">
        <button class="btn btn-success btn-block mt-3" type="submit" >Сохранить изменения</button>
    </form>

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
                autoclose: true,
                startDate: '-1Y',
                language: "ru",
            });
        });
    </script>
@endsection
