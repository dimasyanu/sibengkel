<form id="modalForm" class="form-horizontal" name="modalForm">
@foreach($columns as $colKey => $column)
    @if($column != 'id')
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ $column }}</label>
    	<div class="col-sm-10">
            @if($menu == 'category' && $column == 'icon')
                <?php
                    $dir = 'images/icons/marker';
                    chdir($dir);
                    foreach (glob('*.png') as $key => $icon):
                ?>
                    <div class="col-sm-1 text-center pick-icon">
                        <img src="{{ URL::asset('images/icons/marker/' . $icon) }}" data-icon="{{ $icon }}" />
                    </div>
                <?php endforeach; ?>
            @else
                <input class="form-control" name="{{ $column }}" id="create-{{ $menu }}-{{ $column }}" placeholder="{{ $column }}" />
            @endif
    	</div>
    </div>
    @endif
@endforeach
</form>
<input type="hidden" id="task-id" name="taskId" value="{{ $id }}">

<script>
    $(document).ready(function() {
        $('.pick-icon').click(function() {
            $('.pick-icon.selected').removeClass('selected');
            $(this).addClass('selected');
        });
    });
</script>