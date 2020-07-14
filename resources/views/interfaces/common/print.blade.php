@extends('layouts.app')

@section('content')

    @include('layouts.include.header')
    <button class="btn btn-info mb-3" onclick="window.print()">Печать</button>
    <table class="table table-striped table-bordered print">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px;">№</th>
            <th style="width: 200px;">Наименование материала</th>
            <th style="width: 81px;">Ед. изм.</th>
            <th style="width: 75px;">Кол-во</th>
            <th style="width: 75px;">Дата поставки</th>
            <th style="width: 200px;">Примечание</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $items??$order->items as $item)
            <tr @include('layouts.include.itemColors') >
                <td>{{$item->idx}}</td>
                <td>{{$item->order_item}}</td>
                <td>{!!$item->ed->name!!}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->date_plan}}</td>
                <td>{{$item->comment}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


