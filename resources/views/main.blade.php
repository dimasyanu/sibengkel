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
		<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2B1uaimZdVEjVqypYPunSj-ryVXGBcS4&callback=initMap">
		</script>
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
					foreach ($categories as $catId => $category): ?>
						<?php
						$alias = $category['original']['alias'];
						$icon = $category['original']['icon']; 
						echo $alias; ?>: {
							url 	: '<?php echo URL::asset('images/icons/marker/' . $icon) ?>',
							size 	: new google.maps.Size(32, 48),
							origin 	: new google.maps.Point(0, 0),
							anchor 	: new google.maps.Point(16, 48)
						},
					<?php endforeach; ?>
					closed: {
						url 	: '<?php echo URL::asset('images/icons/marker/closed.png') ?>',
						size 	: new google.maps.Size(32, 48),
						origin 	: new google.maps.Point(0, 0),
						anchor 	: new google.maps.Point(16, 48)
					}
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
				}

				var serviceIco = [];
				<?php foreach ($service_list as $key => $service) : ?>
					serviceIco[<?php echo $service['id']; ?>] = '<?php echo $service['icon']; ?>';
				<?php endforeach; ?>

				var markerPopup = [];
				var marker = [];

				<?php foreach ($bengkels as $bengkelId => $bengkel): ?>
					markerdata = {
						id: <?php echo $bengkelId ?>,
						location: {lat: <?php echo $bengkel['lat']?>, lng: <?php echo $bengkel['lng'] ?>},
						icon: icons.<?php 
							$start_hour = new DateTime($bengkel['start_hour']);
							$end_hour = new DateTime($bengkel['end_hour']);
							if ($start_hour->diff(new DateTime)->format('%R') == '-' || $end_hour->diff(new DateTime)->format('%R') == '+') {
								echo 'closed';
							}
							else echo $bengkel['alias'];
						?>
					};

					var serviceIcoUrl = '<?php echo URL::asset("images/icons"); ?>';
					var servicesHtml = '';
					<?php foreach ($bengkel['services'] as $key => $service): ?>
						servicesHtml += (servicesHtml==''?'':'<br>') + '<img src="' + serviceIcoUrl + '/' + serviceIco[<?php echo $service->service_id; ?>] + '">';
					<?php endforeach; ?>

					var popupContent = '<div id="content">'+
						'<div class="col-sm-12 text-center"><h3 id="firstHeading">'+ 	
							<?php echo '\'' . $bengkel['name'] . '\''; ?> + 
							'</h3>' +
							'<h4>(' +
								'<?php echo $bengkel['catName']; ?>' +
							')</h4>' +
						'</div>'+
						'<div class="col-sm-6">' +
							'<p>' + '<?php echo $bengkel['description']; ?>' + '</p>' +
							'<br><p>Buka <br>' + '<?php echo $bengkel['start_hour'] . ' - ' . $bengkel['end_hour']; ?>' + '</p>' +
						'</div>' +
						'<div class="col-sm-6 text-right">' +
							servicesHtml +
						'</div>' +
					'</div>';

					markerPopup[<?php echo $bengkelId; ?>] = new google.maps.InfoWindow({
						content: popupContent
					});

					addMarker(markerdata);

					markers[<?php echo $bengkelId; ?>].addListener('click', function() {
						markerPopup[<?php echo $bengkelId; ?>].open(map, this);
						markerClick(markers[<?php echo $bengkelId; ?>]);
					});

					markers[<?php echo $bengkelId; ?>].addListener('mouseover', function() {
						markerPopup[<?php echo $bengkelId; ?>].open(map, this);
					});

					markers[<?php echo $bengkelId; ?>].addListener('mouseout', function() {
						markerPopup[<?php echo $bengkelId; ?>].close();
					});
				<?php endforeach; ?>
				
				// google.maps.event.addListener(map, 'click', function( event ){
				// 	console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); 
				// });
			}
			</script>
		</div>
		<div id="sib-sidebar" class="col-md-3 col-sm-4 col-xs-10"></div>

		<script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
	</body>
</html>