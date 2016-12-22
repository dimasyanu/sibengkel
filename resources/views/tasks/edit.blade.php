<form id="modalForm" class="form-horizontal" name="modalForm" action="{{ $url }}" method="post">
@foreach($column_list as $colKey => $column)
	@if($column != 'id')
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ $column }}</label>
        <div class="col-sm-10">
            <input class="form-control" id="edit-{{ $menu }}-{{ $column }}" placeholder="{{ $column }}" value="{{ $item[0]['original'][$column] }}"/>
        </div>
    </div>
    @endif
@endforeach
</form>
<input type="hidden" id="taskId" name="taskId" value="{{ $id }}">

<script>
$(document).ready(function() {
	$('#modalForm').submit(function() {
		console.log("Submitting");
	});
})
</script>