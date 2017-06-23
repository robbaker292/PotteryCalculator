<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
$(document).on("click", ".btn-delete", function(e) {
	bootbox.confirm({ 
		size: "large",
		title: "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Warning!",
		message: "This will delete the current Payment Method.<br>This can only be done when all Sales with this method have been deleted or updated.<br>This CANNOT be undone",
		buttons: {
			confirm: {
				label: '<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Delete',
				className: 'btn-danger'
			},
			cancel: {
				label: '<i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;Cancel',
				className: 'btn-primary'
			}
		}, 
		callback: function(result){ 
			if(result) {
				window.location.href = <?php echo "\"".base_url()."settings/deletePM/".$pm->type."\""; ?>;
			}
		}
	});
});
</script>
	<?php
	if ($new) {
		echo "<h2>New Payment Method";
	} else {		
		echo "<h2>Editing Payment Method";
		echo "&nbsp;&nbsp;<a href=\"".base_url()."settings/listAll\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i>&nbsp;&nbsp;View</a>";
		?>
		<a href="#" class="btn btn-danger btn-md pull-right btn-delete" role="button">
			<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Delete Payment Method
		</a>
		<?php
	}	
	?>
</h2>

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