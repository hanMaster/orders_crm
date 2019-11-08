@if($item->line_status_id == \Illuminate\Support\Facades\Config::get('lineStatus.done'))
    style="background-color: #2cd45f;"
@elseif ($item->line_status_id == \Illuminate\Support\Facades\Config::get('lineStatus.not_deliverable'))
    style="background-color: #ff7873;"
@endif
