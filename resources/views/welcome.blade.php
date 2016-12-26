<!DOCTYPE HTML>
<html>
	<head></head>
	<body>
		<?php 
			
			foreach ($service_list as $key => $service) {
				// serviceIco[$service['original']['id']] = $service['original']['icon'];
				echo '<pre>';
				var_dump($service['icon']);
				echo '</pre>';
			}
			// foreach ($bengkels as $key => $bengkel) {
			// 	echo '<pre>';
			// 	// var_dump($bengkel['services']);
			// 	foreach ($bengkel['services'] as $serviceKey => $serviceId) {
			// 		// var_dump($serviceId);
			// 		echo $serviceId->service_id;
			// 	}
			// 	echo '</pre>';
			// }
		?>
	</body>
</html>