@extends('layouts.app')

@section('content')

@include('layouts.include.header')

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#items" role="tab" aria-controls="items"
           aria-selected="true">Заявка</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments"
           aria-selected="false">Коментарии</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history"
           aria-selected="false">История изменений</a>
    </li>

    @if(auth()->user()->role_id == 3)

    <li class="nav-item">
        <a class="nav-link" id="reject-tab" data-toggle="tab" href="#reject" role="tab" aria-controls="reject"
           aria-selected="false">Отмена заявки</a>
    </li>
    @endif
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th style="width: 50px;">№</th>
                <th style="width: 250px;">Наименование материала</th>
                <th style="width: 81px;">Ед. изм.</th>
                <th style="width: 75px;">Кол-во</th>
                <th style="width: 130px;">Дата план</th>
                <th style="width: 130px;">Дата исполнения</th>
                <th style="width: 120px;">Статус</th>
                <th style="width: 160px;">Исполнитель</th>
                <th style="width: 200px;">Примечание</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->items as $item)
            <tr @include(
            'layouts.include.itemColors') >
            <td>{{$item->idx}}</td>
            <td>
                <div><strong>{{$item->order_item}}</strong></div>
                <div>@include('layouts.include.attach')</div>
            </td>
            <td>{!!$item->ed->name!!}</td>
            <td>{{$item->quantity}}</td>
            <td>{{$item->date_plan}}</td>
            <td>{{$item->date_fact}}</td>
            <td>{{$item->status->name}}</td>
            <td>{{$item->executor->name ?? 'не назначен'}}</td>
            <td>{{$item->comment}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
        <div class="card">
            <div class="card-header">
                <a href="{{url('order/'. $order->id . '/comments/create')}}">Добавить</a>
            </div>
            <div class="card-body">
                @foreach($order->comments as $comment)
                <div class="comment-box">
                    <strong>{{$comment->user->name}}</strong>
                    {{$comment->comment}}
                    <span>{{$comment->created_at}}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
        <ul class="list-group">
            @foreach($order->logs as $log)
            <li class="list-group-item">{{\Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i')." - "}} {!!
                $log->message !!}
                - {{$log->user->name}}
            </li>
            @endforeach
        </ul>
    </div>

    @if(auth()->user()->role_id == 3)
    <div class="tab-pane fade" id="reject" role="tabpanel" aria-labelledby="reject-tab">

        <h2 class="mt-3">Отмена заявки</h2>
        <a class="btn btn-danger" onclick="reject({{$order->id}})" href="#">Отменить заявку</a>
    </div>
    @endif

</div>


@if (auth()->user()->role_id == \Illuminate\Support\Facades\Config::get('role.starter')
&& ($order->status_id == \Illuminate\Support\Facades\Config::get('status.not_approved') ||
$order->status_id == \Illuminate\Support\Facades\Config::get('status.creating') ||
$order->status_id == \Illuminate\Support\Facades\Config::get('status.new') ||
$order->status_id == \Illuminate\Support\Facades\Config::get('status.editing')
))

<form action="{{url('order/'.$order->id.'/reapprove')}}" method="POST" class="mt-3">
    @method('PUT')
    @csrf
    <a href="{{url('order/'.$order->id.'/starter-edit')}}" class="btn btn-primary">Редактировать заявку</a>
    @if ($order->status_id == Config::get('status.not_approved'))
    <button type="submit" class="btn btn-success">На согласование</button>
    @endif
</form>
@endif

//Гаврилову можно редактировать заявку в статусе approved
@if (auth()->user()->id == 18 && $order->status_id == \Illuminate\Support\Facades\Config::get('status.approved'))
<a href="{{url('order/'.$order->id.'/starter-edit')}}" class="btn btn-primary">Редактировать заявку</a>
@endif


@endsection

@section('js')
<script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous">
</script>
<script>
    $(document).ready(() => {
        let url = location.href.replace(/\/$/, "");

        if (location.hash) {
            const hash = url.split("#");
            $('#myTab a[href="#' + hash[1] + '"]').tab("show");
            url = location.href.replace(/\/#/, "#");
            history.replaceState(null, null, url);
            setTimeout(() => {
                $(window).scrollTop(0);
            }, 400);
        }

        $('a[data-toggle="tab"]').on("click", function () {
            let newUrl;
            const hash = $(this).attr("href");
            if (hash == "#home") {
                newUrl = url.split("#")[0];
            } else {
                newUrl = url.split("#")[0] + hash;
            }
            newUrl += "/";
            history.replaceState(null, null, newUrl);
        });
    });
</script>
<script src="/js/vendor/pdf.min.js"></script>
<script src="/js/main.js"></script>
<script>
    const reject = id => {
        event.preventDefault();
        if (confirm("Вы действительно хотите удалить эту заявку?")) {
            fetch(`https://orders.kfkcom.ru/reject/${id}`, {
                credentials: 'same-origin',
            })
        }
        window.location.assign('https://orders.kfkcom.ru/');
    };
</script>
@endsection
