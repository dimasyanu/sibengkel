<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>SiBengkel</title>
		
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

		<!-- Styles -->
		<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />

		<!-- Scripts -->
		<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

	</head>
	<body>
		<div id="sib-header-bar" class="col-md-12 col-sm-12 col-xs-12">
			<a id="sib-sidebar-toggle" class="btn">
				<span class="sib-sidebar-toggle-line"></span>
				<span class="sib-sidebar-toggle-line"></span>
				<span class="sib-sidebar-toggle-line"></span>
			</a>
			<img class="sib-header-brand" src="{{ URL::asset('images/bengkelke.png') }}" />
			<!-- Authentication Links -->
			@if (Auth::guest())
				<a href="{{ url('/login') }}">Login</a>
				<a href="{{ url('/register') }}">Register</a>
			@else
				<div class="dropdown pull-right">
					<a href="#" class="btn dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						{{ Auth::user()->name }} <span class="caret"></span>
					</a>

					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="{{ url('/logout') }}"
								onclick="event.preventDefault();
										 document.getElementById('logout-form').submit();">
								Logout
							</a>

							<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</div>
			@endif
		</div>
		<div id="sib-map-container" class="col-md-12 col-sm-12 col-xs-12">
			<div id="sib-map"></div>
			<script>
			function initMap() {
				var myLoc = {lat: -7.7884403, lng: 110.3681616};
				var yourLoc = {lat: -7.8884403, lng: 110.3681616};
				map = new google.maps.Map(document.getElementById('sib-map'), {
					center: myLoc,
					zoom: 12
				});
				var icons = {
					<?php 
						$images = '';
						foreach ($categories as $catId => $category) {
							$alias = $category['original']['alias'];
							$icon = $category['original']['icon'];
							$images .= (($images==''?'':',') . $alias . ': ' . '\'' . URL::asset('images/icons/' . $icon) . '\'');
						}
						echo $images;
					?>
				}
				var markers = new Array(<?php echo sizeof($bengkels); ?>);
				function addMarker(data) {
					markers[data.id] = new google.maps.Marker({
						position: data.location,
						icon: data.icon,
						map: map
					});
				}

				function markerClick(marker) {
					map.panTo(marker.getPosition());
					// console.log(marker);
				}

				<?php
					foreach ($bengkels as $bengkelId => $bengkel) {
						echo 'var marker' . $bengkelId . " = {\n" . 
							'id: ' . $bengkelId . ',' . "\n" . 
							'location: {lat: ' . $bengkel['lat'] . ', lng: ' . $bengkel['lng'] . "},\n" . 
							'icon: icons.' . $bengkel['alias'] . "\n" . 
						'};' . "\n";
					}

					foreach ($bengkels as $bengkelId => $bengkel) {
						echo 'addMarker(marker' . $bengkelId . ');' . "\n";

						echo 'markers[' . $bengkelId . '].addListener(\'click\', function() {markerClick(markers[' . $bengkelId . '])});' . "\n";
					}	
				?>
				google.maps.event.addListener(map, 'click', function( event ){
					console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); 
				});
			}
			</script>
			<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2B1uaimZdVEjVqypYPunSj-ryVXGBcS4&callback=initMap">
			</script>
		</div>
		<div id="sib-sidebar" class="col-md-3 col-sm-4 col-xs-10"></div>

		<script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
	</body>
</html>