<form id="modalForm" class="form-horizontal" name="modalForm">
@foreach($column_list as $colKey => $column)
	@if($column != 'id')
    <div class="form-group">
        <label for="{{ $menu_lower[$colKey] }}" class="col-sm-2 control-label">{{ $column }}</label>
        <div class="col-sm-10">
            <input class="form-control" id="edit-{{ $menu_lower[$colKey] }}" placeholder="{{ $column }}" value="{{ $items[0]['original'][$column] }}"/>
        </div>
    </div>
    @endif
@endforeach
</form>