<form id="modalForm" class="form-horizontal" name="modalForm">
@foreach($column_list as $colKey => $column)
    @if($column != 'id')
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ $column }}</label>
        @if($column == 'categories')
        	<div class="col-sm-5">
        		<select class="form-control" id="create-{{ $menu }}-{{ $column }}">
        			@foreach($categories as $catId => $category)
        				<option value="{{ $catId }}">{{ $category }}</option>
        			@endforeach
        		</select>
        	</div>
        @else
        	<div class="col-sm-10">
            	<input class="form-control" name="{{ $column }}" id="create-{{ $menu }}-{{ $column }}" placeholder="{{ $column }}" />
        	</div>
        @endif
    </div>
    @endif
@endforeach
</form>
<input type="hidden" id="task-id" name="taskId" value="{{ $id }}">