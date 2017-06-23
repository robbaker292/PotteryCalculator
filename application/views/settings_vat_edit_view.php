<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<?php
	if ($new) {
		echo "<h2>New VAT Rate</h2>";
	} else {		
		echo "<h2>Editing VAT Rate";
		echo "&nbsp;&nbsp;<a href=\"".base_url()."settings/listAll\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i>&nbsp;&nbsp;View</a>";
		echo "</h2>";
	}	
	?>


<div id="editing">

	<form id="basicForm">
		<input type="hidden" id="id" name="id" <?php if(!$new) { echo "value=\"".$vat->id."\""; }?>>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="start">Start Date:</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" id="start" placeholder="Enter Start Date" name="start" <?php if(!$new) { echo "value=\"".$vat->start."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="end">End Date:</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" id="end" placeholder="Enter End Date" name="end" <?php if(!$new) { echo "value=\"".$vat->end."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="rate">Rate:</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" id="rate" placeholder="Enter Rate (%)" name="rate" <?php if(!$new) { echo "value=\"".$vat->rate."\""; }?> >
				<div class="help-block">Enter as actual percentage, i.e. 20% = 20.0</div>
			</div>
		</div>

		<div class="form-group">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-primary" id="saveVAT"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Save VAT rate</button>
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