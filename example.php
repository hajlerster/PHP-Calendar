<style type="text/css">
	.weekendday {
		color: red;
	}
	
	.current {
		background: orange;
	}
	
	.weekdays {
		background: yellow;
	}
	
	.weekdays td {
		color: blue;
		padding: 10px;
		text-align: center;
	}
	
	.month {
		color: green;
	}
	
	.year {
		color: magenta;
	}
	
	.days {
		text-align: center;
	}
	
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php

	require_once("calendar.class.php");
	
	$calendar = new Calendar();
	
	$settings['year'] = 2010;
	$settings['month'] = '11';
	
	$links[date('Y-m-d')] = 'http://google.com';
	$calendar->setLinks($links);
	
	$cal = $calendar->render();
	
	print $cal;

?>