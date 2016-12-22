<form id="modalForm" class="form-horizontal" name="modalForm">
@foreach($column_list as $colKey => $column)
    @if($column != 'id')
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ $column }}</label>
    	<div class="col-sm-10">
            @if($menu == 'category' && $column == 'icon')
        	   <input type="file" />
            @else
                <input class="form-control" name="{{ $column }}" id="create-{{ $menu }}-{{ $column }}" placeholder="{{ $column }}" />
            @endif
    	</div>
    </div>
    @endif
@endforeach
</form>
<input type="hidden" id="task-id" name="taskId" value="{{ $id }}">