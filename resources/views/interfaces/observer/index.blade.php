@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mt-5">
                <div class="accordion" id="accordionApprove">
                    @if (isset($bo))
                    @foreach($bo as $object)

                    @php ($hasRows = 0)
                    @foreach($orders as $order)
                    @if ($order->object_id == $object->id)
                    @php ($hasRows = 1)
                    @endif
                    @endforeach

                    @if ($hasRows == 1)
                    <div class="card">
                        <div class="card-header" id="heading{{$object->id}}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapse{{$object->id}}"
                                        aria-expanded="false"
                                        aria-controls="collapse{{$object->id}}">
                                    {{$object->name}}
                                </button>
                            </h2>
                        </div>
                        <div id="collapse{{$object->id}}" class="collapse" aria-labelledby="heading{{$object->id}}"
                             data-parent="#accordionApprove">
                            <div class="card-body">
                                @if (isset($orders))
                                <ul>
                                    @foreach($orders as $order)
                                    @if ($order->object_id == $object->id)
                                    <li>
                                        <a href="{{url('order/'. $order->id )}}">
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('Y.m.d H:i')}} &nbsp;&nbsp;
                                        {{$order->name}}
                                        --- {{$order->status->name}}
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
