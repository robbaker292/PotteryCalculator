<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<?php
	if ($new) {
		echo "<h2>New Product</h2>";
	} else {		
		echo "<h2>Editing Product";
		echo "&nbsp;&nbsp;<a href=\"".base_url()."product/view/".$product->id."\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i>&nbsp;&nbsp;View</a>";
		echo "</h2>";
	}	
	?>


<div id="editing">

	<form id="basicForm">
		<input type="hidden" id="id" name="id" <?php if(!$new) { echo "value=\"".$product->id."\""; }?>>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="name">Name:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" <?php if(!$new) { echo "value=\"".$product->name."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="description">Description:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="description" placeholder="Enter Description" name="description" <?php if(!$new) { echo "value=\"".$product->description."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="time">Time to create (hours):</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" id="time" placeholder="Enter Time to create (hours)" name="time" <?php if(!$new) { echo "value=\"".$product->time."\""; }?> >
			</div>
		</div>
	</form>
	<hr>
	<h3>Resource Data:</h3>
	<form id="resourceForm">
		<div id="resourceChoosers">
		<?php foreach($resources as $resource) {?>
			<div class="resourceOptions">
				<div class="form-group">
					<label class="control-label col-sm-3" for="resources">Current Resources:</label>
					<div class="col-sm-4">
						<select class="form-control selectpicker" name="resources[]" data-live-search="true" multiple data-max-options="1">
							<?php
							foreach($all_resources as $rL) {
								echo "<option value=\"".$rL->id."\" data-subtext=\"Bought ".$rL->date_bought."\"";
								if($resource->id == $rL->id) {
									echo "selected";
								}
								echo ">(".$rL->id.") ".$rL->name." (".$rL->unit_type.")</option>";
							}
							?>
						</select>
					</div>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="name" placeholder="Enter Amount" name="amount[]" <?php if(!$new) { echo "value=\"".$resource->amount."\""; }?> >
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</form>
<br><br>
	<div class="form-group">
		<div class="btn-group" role="group" aria-label="...">
			<button type="button" class="btn btn-success" id="resourceAdder"><i class="fa fa-cubes" aria-hidden="true"></i>&nbsp;&nbsp;Add another resource</button>
			<button type="button" class="btn btn-primary" id="saveProduct"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Save product</button>
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
		
</div>