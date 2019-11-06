@if ($item->attached_file)
    <!-- Button trigger modal -->
    <a href="#" data-toggle="modal" data-target="{{"#item". $item->id}}">
        (Изображение)
    </a>
    <!-- Modal -->
    <div class="modal fade" id="{{"item". $item->id}}" tabindex="-1" role="dialog" aria-labelledby="{{"item". $item->id."Label"}}"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{"item". $item->id."Label"}}">{{$item->order_item}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{"/storage/".$item->attached_file}}" alt="file" style="width: 100%;" class="print">
                </div>
                <div class="modal-footer">
                    <a href="{{"/storage/".$item->attached_file}}" download class="btn btn-outline-info">Скачать</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
@endif
