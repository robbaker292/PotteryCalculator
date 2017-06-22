<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<?php
	if ($new) {
		echo "<h2>New Event</h2>";
	} else {		
		echo "<h2>Editing Event";
		echo "&nbsp;&nbsp;<a href=\"".base_url()."event/view/".$event->id."\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i>&nbsp;&nbsp;View</a>";
		echo "</h2>";
	}	
	?>


<div id="editing">

	<form id="basicForm">
		<input type="hidden" id="id" name="id" <?php if(!$new) { echo "value=\"".$event->id."\""; }?>>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="name">Name:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" <?php if(!$new) { echo "value=\"".$event->name."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="location">Location:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="location" placeholder="Enter Location" name="location" <?php if(!$new) { echo "value=\"".$event->location."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="start">Start Date:</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" id="start" placeholder="Enter Start Date" name="start" <?php if(!$new) { echo "value=\"".$event->start."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="end">End Date:</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" id="end" placeholder="Enter End Date" name="end" <?php if(!$new) { echo "value=\"".$event->end."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="cost_upfront">Upfront Cost (&pound;, if any):</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" id="cost_upfront" placeholder="Enter Upfront Cost (if any)" name="cost_upfront" <?php if(!$new) { echo "value=\"".$event->cost_upfront."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="cost_sales">Cut of Sales (%, if any):</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" id="cost_sales" placeholder="Enter Cut of Sales (if any)" name="cost_sales" <?php if(!$new) { echo "value=\"".$event->cost_sales."\""; }?> >
			</div>
		</div>

		<div class="form-group">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary" id="saveBasic">Save event</button>
			</div>
			<div id="saveResult">
				<?php
					if($this->session->flashdata('area') == "main") {
						$type = $this->session->flashdata('type');
						$message = $this->session->flashdata('message');
						if($type == "success") {
							?>
							<div class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i><strong>Success</strong>&nbsp;<?php echo $message;?></div>
							<?php
						}
					}
				?>
			</div>			
		</div>

	</form>
</div>