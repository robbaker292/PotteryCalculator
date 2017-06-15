<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//var_dump($sales_data);
?>

<h2>Dashboard</h2>

<div class="panel panel-primary">
	<div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;&nbsp;Profit Chart</div>
	<div class="panel-body" id="drawingArea">
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;&nbsp;Filter Profit Chart</div>
	<div class="panel-body" id="filterChart">
		TODO Specify dates. Or choose particular product, or event.
	</div>
</div>

<div id="eventsDrilldownOuter"></div>