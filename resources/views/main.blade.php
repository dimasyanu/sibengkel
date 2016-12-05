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
		<script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>

	</head>
	<body>
		<div id="sib-header-bar" class="col-md-12 col-sm-12 col-xs-12">
			<a id="sib-sidebar-toggle" class="btn">
				<span class="sib-sidebar-toggle-line"></span>
				<span class="sib-sidebar-toggle-line"></span>
				<span class="sib-sidebar-toggle-line"></span>
			</a>
		</div>
		<div id="sib-map-container" class="col-md-12 col-sm-12 col-xs-12">
			<div id="sib-map">{!! Mapper::render () !!}</div>
		</div>
		<div id="sib-sidebar" class="col-md-3 col-sm-4 col-xs-10"></div>
	</body>
</html>