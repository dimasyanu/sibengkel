<form id="modalForm" class="form-horizontal" name="modalForm" action="{{ $url }}" method="post">
@foreach($column_list as $colKey => $column)
	@if($column != 'id')
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ $column }}</label>
        <div class="col-sm-10">
            @if($menu == 'category' && $column == 'icon')
                <?php
                    $dir = 'images/icons';
                    chdir($dir);
                    foreach (glob('*.png') as $key => $icon):
                ?>
                    <div class="col-sm-1 text-center pick-icon">
                        <img src="{{ URL::asset('images/icons/' . $icon) }}" data-icon="{{ $icon }}" />
                    </div>
                <?php endforeach; ?>
            @else
                <input class="form-control" id="edit-{{ $menu }}-{{ $column }}" placeholder="{{ $column }}" value="{{ $item[0]['original'][$column] }}"/>
            @endif
        </div>
    </div>
    @endif
@endforeach
</form>
<input type="hidden" id="cat-icon" value="{{ $item[0]['original']['icon'] }}">
<input type="hidden" id="taskId" value="{{ $id }}">

<script>
$(document).ready(function() {
    $('[data-icon="'+ $('#cat-icon').val() + '"]').parent().addClass('selected');

	$('.pick-icon').click(function() {
        $('.pick-icon.selected').removeClass('selected');
        $(this).addClass('selected');
    });
})
</script>