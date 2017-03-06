<?php

	if($type == 'business') {
		$business = array();
	
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		
		foreach($business_list as $business) {
			$items[$business['name']] = $business['name'];
		}
		
		foreach ($items as $key=>$value) {
			if (strpos(strtolower($key), $q) !== false) {
				echo "$key|$value\n";
			}
		}		
	}
	
	if($type == 'city') {
		$city = array();
	
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		
		foreach($city_list as $city) {
			$items[$city['city']] = $city['city'];
		}
		
		foreach ($items as $key=>$value) {
			if (strpos(strtolower($key), $q) !== false) {
				echo "$key|$value\n";
			}
		}		
	}	

?>