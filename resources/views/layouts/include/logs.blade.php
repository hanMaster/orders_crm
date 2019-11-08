<!-- Button trigger modal -->
<a href="#" data-toggle="modal" data-target="{{"#log". $item->id}}">
    История
</a>
<!-- Modal -->
<div class="modal fade" id="{{"log". $item->id}}" tabindex="-1" role="dialog" aria-labelledby="{{"log". $item->id."Label"}}"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{"log". $item->id."Label"}}">{{$item->order_item}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ol>
                    @foreach($item->logs as $log)
                        <li>{{\Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i')." - ". $log->message." - ".$log->user->name}}</li>
                    @endforeach
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

