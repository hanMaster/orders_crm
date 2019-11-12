<!-- Button trigger modal -->
<a href="#" data-toggle="modal" data-target="#pass{{$user->id}}" class="btn btn-sm btn-primary">
    Пароль
</a>
<!-- Modal -->
<div class="modal fade" id="pass{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="{{"pass".$user->id."Label"}}"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 500px;">
        <div class="modal-content">
            <form action="{{url('pass/'.$user->id)}}" method="post">
                @method('PATCH')
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="{{"pass".$user->id."Label"}}">Задать пароль</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="{{"pass1".$user->id}}">Введите пароль</label>
                    <input type="password" class="form-control" name="pass1" id="{{"pass1".$user->id}}">
                </div>
                <div class="form-group">
                    <label for="{{"pass2".$user->id}}">Повторите пароль</label>
                    <input type="password" class="form-control" name="pass2" id="{{"pass2".$user->id}}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
            </form>
        </div>
    </div>
</div>


