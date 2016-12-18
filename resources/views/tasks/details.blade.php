<div class="modal fade" id="sib-modal-details" tabindex="-1" role="dialog" aria-labelledby="sib-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sib-modal-label">Modal title</h4>
                </div>
                
                <div class="modal-body">
                    <form id="modalForm" class="form-horizontal" name="modalForm">
					@foreach($column_list as $colKey => $column)
					    <div class="form-group">
                            <div class="col-sm-2">
					           <label for="{{ $menu_lower[$key] }}" class="col-sm-2 control-label">{{ $column }}</label>
                            </div>
					        <div class="col-sm-10">
                                @if(sizeof($items))
                                    <label id="{{ $menu_lower[$key] }}-details" class="control-label">{{ $items[0]['original'][$column] }}</label>
                                @endif
					        </div>
					    </div>
				    @endforeach
				    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>