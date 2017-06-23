<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//var_dump($start_date);
?>

<h2><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Dashboard</h2>

<div class="panel panel-primary">
	<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;&nbsp;Profit Chart</h4></div>
	<div class="panel-body" id="drawingArea">
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title">
			<i class="fa fa-filter" aria-hidden="true"></i>&nbsp;&nbsp;<a data-toggle="collapse" href="#collapse1">Filter Profit Chart <i class="fa fa-arrow-down" aria-hidden="true"></i></a>
		</h4>
	</div>
	<div id="collapse1" class="panel-collapse collapse">
		<div class="panel-body text-center" id="filterChart">
			<form class="form-inline">
				<div class="form-group col-md-6">
					<label for="start_date" class="col-md-3">Start Date:</label>
					<input type="date" class="form-control col-md-3" id="start_date" value="<?php echo $start_date; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="end_date" class="col-md-3">End Date:</label>
					<input type="date" class="form-control col-md-3" id="end_date" value="<?php echo $end_date; ?>">
				</div>
			<!-- </form>
			<form class="form-inline text-center"> -->
				<br><br>
				<span class="col-md-2"><b>Group by:</b></span>
				<label class="radio-inline col-md-3">
					<input type="radio" name="groupby" value="day" checked="checked">Daily
				</label>
				<label class="radio-inline col-md-3">
					<input type="radio" name="groupby" value="week">Weekly
				</label>
				<label class="radio-inline col-md-3">
					<input type="radio" name="groupby" value="month">Monthly
				</label>
				<br><br>		
				<button type="button" class="btn btn-primary" id="updateGraph">Update</button>
			</form>
		</div>
	</div>
</div>

<div id="eventsDrilldownOuter"></div>