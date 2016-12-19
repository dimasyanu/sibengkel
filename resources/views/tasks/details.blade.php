<form id="modalForm" class="form-horizontal" name="modalForm">
@foreach($column_list as $colKey => $column)
    <div class="form-group">
        <div class="col-sm-2">
           <label for="{{ $menu_lower[$colKey] }}" class="col-sm-2 control-label">{{ $column }}</label>
        </div>
        <div class="col-sm-10">
            @if(sizeof($items))
                <label id="{{ $menu_lower[$colKey] }}-details" class="control-label">{{ $items[0]['original'][$column] }}</label>
                
            @endif
        </div>
    </div>
@endforeach
</form>