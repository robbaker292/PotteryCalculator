<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<?php
	if ($new) {
		echo "<h2>New Payment Method</h2>";
	} else {		
		echo "<h2>Editing Payment Method";
		echo "&nbsp;&nbsp;<a href=\"".base_url()."settings/listAll\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i>&nbsp;&nbsp;View</a>";
		echo "</h2>";
	}	
	?>


<div id="editing">

	<form id="basicForm">
		<input type="hidden" id="id" name="id" <?php if(!$new) { echo "value=\"".$pm->type."\""; }?>>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="type">Type:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="type" placeholder="Enter Type" name="type" <?php if(!$new) { echo "value=\"".$pm->type."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="cut">Cut:</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" id="cut" placeholder="Enter cut" name="cut" <?php if(!$new) { echo "value=\"".$pm->cut."\""; }?> >
				<div class="help-block">Enter as decimal, i.e. 2% = 0.02, 1.5% = 0.015</div>
			</div>
		</div>

		<div class="form-group">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary" id="savePM"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Save Payment Method</button>
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