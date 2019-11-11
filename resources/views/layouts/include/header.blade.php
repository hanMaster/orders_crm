<div class="header d-flex justify-content-between">
    <h3 class="print">{{$order->name}} от {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i')}}</h3>
    <h4><span style="color: #ED5565">Статус: </span>{{$order->status->name}}</h4>
</div>

<div class="header d-flex justify-content-between print">
    <p>Объект: {{$order->bo->name??''}}</p>
    <p>Создатель: {{$order->starter->name}}</p>
</div>
