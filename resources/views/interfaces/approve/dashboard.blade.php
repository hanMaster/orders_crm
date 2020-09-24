@extends('layouts.app')

@section('content')
<div class="container">
    <div class="plates">
        @foreach ($bo as $object)
        <a href="{{'object/' . $object->id}}">
            <div class="plate">
                <h5>{{$object->name}}</h5>
                <span class="orders-for-approve">{{$newCounters[$object->id] > 0 ? $newCounters[$object->id] : '' }}</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
