<form id="modalForm" class="form-horizontal" name="modalForm">
@foreach($column_list as $colKey => $column)
    <div class="form-group">
        <div class="col-sm-2">
           <label class="col-sm-2 control-label">{{ $column }}</label>
        </div>
        <div class="col-sm-10">
            <label id="{{ $column }}-detail" class="control-label">{{ $item[0]['original'][$column] }}</label>
        </div>
    </div>
@endforeach
</form>