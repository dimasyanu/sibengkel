	<div class="modal fade" id="sib-modal-edit" tabindex="-1" role="dialog" aria-labelledby="sib-modal-label">
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
					        	@if(sizeof($items))
					            	<input class="form-control" id="edit-{{ $menu_lower[$key] }}" placeholder="{{ $column }}" value="{{ $items[0]['original'][$column] }}"/>
					            @endif
					        </div>
					    </div>
					    @endif
				    @endforeach
				    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
