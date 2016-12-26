<div class="modal-content">
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="sib-modal-title" class="modal-title" id="sib-modal-label">{{ $item[0]['name'] }} Details</h4>
    </div>
    
    <div id="sib-modal-body" class="modal-body">
		<table class="table">
			<tbody>
				@foreach($columns as $key => $column)
				<tr>
					<th>{{ $column }}</th>
					@if($column == 'services')
						<td>
							<ul>
								@foreach($services as $key => $service)
									<li>{{ $service['name'] }}</li>
								@endforeach
							</ul>
						</td>
					@else
						<td>{{ $item[0]['original'][$column] }}</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
    </div>

    <div id="sib-modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
