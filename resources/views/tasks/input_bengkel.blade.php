	<div class="container beng-container">
		<input type="hidden" id="cat-action" name="cat-action" value="{{ $action }}" />
		<div id="beng-action-box">
			@if($action == 'create')
				<h1>{{ $action_title }} new bengkel</h1>
			@else
				<h1>{{ $action_title }} {{ $name }}</h1>
			@endif
			<label class="beng-actions" id="beng-btn-save"  data-toggle="tooltip" data-placement="bottom" title="Save">
				<i class="material-icons">check</i>
			</label>
			<label class="beng-actions" id="beng-btn-cancel"  data-toggle="tooltip" data-placement="bottom" title="Cancel {{ $action_title }}">
				<i class="material-icons">clear</i>
			</label>
		</div>

		<div class="col-md-6" id="beng-input-sheet">
			@if($action == 'create')
				<input type="hidden" id="cat-id" value="" />
			@else
				<input type="hidden" id="cat-id" value="{{ $item[0]['original']['cat_id'] }}" />
			@endif
			<form id="bengkel-form" class="form-horizontal" method="post">
				@if($action != 'create')
					<div class="form-group">
						<label for="text-id" class="col-md-3 col-sm-2 control-label">Id</label>
						<div class="col-sm-2">
							<input type="text" class="form-control text-center" disabled id="text-id" placeholder="Id" value="{{ $id }}" />
						</div>
					</div>
				@endif
				<div class="form-group">
					<label for="input-name" class="col-md-3 col-sm-2 control-label">Name</label>
					<div class="col-sm-6">
						@if($action == 'create')
							<input type="text" class="form-control" id="input-name" placeholder="Name" value="" />
						@else
							<input type="text" class="form-control" id="input-name" placeholder="Name" value="{{ $item[0]['original']['name'] }}" />
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="input-category" class="col-md-3 col-sm-2 control-label">Category</label>
					<div class="col-sm-6">
						<select class="form-control" id="input-category" >
						<?php $icons = ''; $ids = ''; $iconDir = URL::asset('images/icons'); ?>
							@foreach ($categories as $catId => $category)
								<option value="{{ $category['original']['id'] }}">{{ $category['original']['name'] }}</option>
								<?php $icons .= ($icons==''?'':',') . $category['original']['icon']; 
									  $ids .= ($ids==''?'':',') . $category['original']['id']; ?>
							@endforeach
						</select>
					</div>
					<div class="col-sm-3">
						@if($action == 'create')
							<img id="cat-icon-preview" src="" />
						@else
							<img id="cat-icon-preview" src="{{ $iconDir.'/'.$cat_icon }}" />
						@endif
					</div>
					<input type="hidden" id="cat-icons-dir" name="cat-icons-dir" value="{{ $iconDir }}" />
					<input type="hidden" id="cat-ids" name="cat-ids" value="{{ $ids }}" />
					<input type="hidden" id="cat-icons" name="cat-icons" value="{{ $icons }}" />
				</div>
				<div class="form-group">
					<label for="input-pictures" class="col-sm-3 control-label">Pictures</label>
					<div class="col-sm-6">
						@if($action == 'create')
							<input type="text" class="form-control" id="input-pictures" placeholder="Pictures" value="">
						@else
							<input type="text" class="form-control" id="input-pictures" placeholder="Pictures" value="{{ $item[0]['original']['pictures'] }}">
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="input-lat" class="col-sm-3 control-label">Lat</label>
					<div class="col-sm-6">
						@if($action == 'create')
							<input type="text" class="form-control" id="input-lat" placeholder="Lat" value="">
						@else
							<input type="text" class="form-control" id="input-lat" placeholder="Lat" value="{{ $item[0]['original']['lat'] }}">
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="input-lng" class="col-sm-3 control-label">Lng</label>
					<div class="col-sm-6">
						@if($action == 'create')
							<input type="text" class="form-control" id="input-lng" placeholder="Lng" value="">
						@else
							<input type="text" class="form-control" id="input-lng" placeholder="Lng" value="{{ $item[0]['original']['lng'] }}">
						@endif
					</div>
				</div>
			</form> 
		</div>
		<div class="col-md-6" id="beng-map-view">
		</div>
		<script>
			var map;
			var marker;
			
			function createMarker(latlng){
				marker = new google.maps.Marker({
					position: latlng,
					map: map
				});
			}

			function initMap() {
				var initLoc = {lat: $('#input-lat').val(), lng: $('#input-lng').val()};
				map = new google.maps.Map(document.getElementById('beng-map-view'), {
					center: initLoc,
					zoom: 12
				});

				marker = new google.maps.Marker({
					position: initLoc,
					map: map
				});

				google.maps.event.addListener(map, 'click', function( event ){
					$('#input-lat').val(event.latLng.lat());
					$('#input-lng').val(event.latLng.lng());
					marker.setPosition(event.latLng);
				});
			};
		</script>
		<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2B1uaimZdVEjVqypYPunSj-ryVXGBcS4&callback=initMap">
		</script>
		<!-- will be used to show any messages -->
		@if (Session::has('message'))
			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
		
	</div>
	<?php 
		$columns = '';
		foreach ($column_list as $key => $column) {
			if($column != 'id') $columns .= (($columns == "" ? '':',') . $column); 
		}
	?>
	<input type="hidden" id="columns" name="columns" value="{{ $columns }}">
<script>
$(document).ready(function() {

	var url = "/sibengkel/public/admin/bengkel";

	$icons = $('#cat-icons').val().split(',');
	$ids = $('#cat-ids').val().split(',');
	$icon_list = [];

	for (var i = 0; i < $icons.length; i++) {
		$icon_list[$ids[i]] = $icons[i];
	}

	$('[data-toggle="tooltip"]').tooltip();

	$('#beng-btn-cancel').click(function() {
		$.ajax({
			type : 'get',
			url: url,
			success: function(data) {
				$('#sib-worksheet').html(data.worksheet);
			},
			error: function(xhr, status, error) {
				console.log('xhr : ' + xhr);
				console.log('status : ' + status);
				console.log('error : ' + error);
			}
		});
	});
	$('#input-category').change(function() {
		$('#cat-icon-preview').attr('src', $('#cat-icons-dir').val() + '/' + $icon_list[$(this).val()]);
	});

	if($('#cat-action').val() == 'create'){
		$('#cat-icon-preview').attr('src', $('#cat-icons-dir').val() + '/' + $icon_list[$('#input-category').val()]);
	}
	else{
		$('#input-category').val($('#cat-id').val());
	}

	$('#beng-btn-save').click(function() {
		if($('#cat-action').val() == 'create')
			var my_url = url + '/create/0';
		else
			var my_url = url + '/edit/' + $('#text-id').val();

		var formData 			= {};
		formData['_token']      = $('meta[name="_token"]').attr('content');
		formData['name']        = $('#input-name').val();
		formData['cat_id']    	= $('#input-category').val();
		formData['pictures']    = $('#input-pictures').val();
		formData['lat']			= $('#input-lat').val();
		formData['lng']			= $('#input-lng').val();

		$.ajax({
			type: 'post',
			url: my_url,
			data: formData,
			dataType: 'json',
			success: function(data) {
				$('#sib-worksheet').html(data.worksheet);
				$('#sib-modal').modal('hide')
			},
			error: function(xhr, status, error) {
				console.log('xhr : ' + xhr);
				console.log('status : ' + status);
				console.log('error : ' + error);
			}
		});
	});
}); 
</script>