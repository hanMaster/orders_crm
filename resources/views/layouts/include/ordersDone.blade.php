<div class="card mt-5">
    <div class="card-header">
        Исполненные заявки
    </div>
    <div class="card-body">
        @if (isset($ordersDone))
            <ul>
                @foreach($ordersDone as $order)
                    <li>
                        <a href="{{url("order/". $order->id )}}">
                            {{$loop->iteration}}.
                            {{$order->bo->name}} - {{$order->name}} от
                            {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}} -
                            статус: {{$order->status->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
