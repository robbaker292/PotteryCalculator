<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2><i class="fa fa-pencil" aria-hidden="true"></i>
	<?php
	if ($new) {
		echo "New Resource</h2>";
	} else {		
		echo "Editing Resource";
		echo "&nbsp;&nbsp;<a href=\"".base_url()."resource/view/".$resource->id."\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i>&nbsp;&nbsp;View</a>";
		echo "</h2>";
	}	
	?>


<div id="editing">

	<form id="basicForm">
		<input type="hidden" id="id" name="id" <?php if(!$new) { echo "value=\"".$resource->id."\""; }?>>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="name">Name:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" <?php if(!$new) { echo "value=\"".$resource->name."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="description">Description:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="description" placeholder="Enter Description" name="description" <?php if(!$new) { echo "value=\"".$resource->description."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="date_bought">Date Bought:</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" id="date_bought" placeholder="Enter Date Bought" name="date_bought" <?php if(!$new) { echo "value=\"".$resource->date_bought."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="size">Size:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="size" placeholder="Enter Size" name="size" <?php if(!$new) { echo "value=\"".$resource->size."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="unit_type">Unit Type:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="unit_type" placeholder="Enter Unit Type" name="unit_type" <?php if(!$new) { echo "value=\"".$resource->unit_type."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="price_paid">Price Paid (&pound;):</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" id="price_paid" placeholder="Enter Price Paid" name="price_paid" <?php if(!$new) { echo "value=\"".$resource->price_paid."\""; }?> >
			</div>
		</div>

		<div class="form-group">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary" id="saveBasic">Save resource</button>
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