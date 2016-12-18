	<div class="modal fade" id="sib-modal-create" tabindex="-1" role="dialog" aria-labelledby="sib-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sib-modal-label">Modal title</h4>
                </div>
                
                <div class="modal-body">
                    <form id="modalForm" class="form-horizontal" name="modalForm">
					@foreach($column_list as $colKey => $column)
						@if($column != 'id')
					    <div class="form-group">
					        <label for="{{ $menu_lower[$key] }}" class="col-sm-2 control-label">{{ $column }}</label>
					        <div class="col-sm-10">
					            <input class="form-control" id="new-{{ $menu_lower[$key] }}" placeholder="{{ $column }}" />
					        </div>
					    </div>
					    @endif
				    @endforeach
				    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="sib-btn-save" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
