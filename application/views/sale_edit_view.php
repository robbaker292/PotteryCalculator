<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
$(document).on("click", ".btn-delete", function(e) {
	bootbox.confirm({ 
		size: "large",
		title: "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Warning!",
		message: "This will delete the current Sale.<br>This CANNOT be undone",
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
				window.location.href = <?php echo "\"".base_url()."sale/delete/".$sale->id."\""; ?>;
			}
		}
	});
});
</script>
	<?php
	if ($new) {
		echo "<h2>New Sale";
	} else {		
		echo "<h2>Editing Sale";
		echo "&nbsp;&nbsp;<a href=\"".base_url()."dashboard\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i>&nbsp;&nbsp;View</a>";
		?>
		<a href="#" class="btn btn-danger btn-md pull-right btn-delete" role="button">
			<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Delete Sale
		</a>
		<?php
	}
	//var_dump($payment_methods);	
	?>

</h2>
<div id="editing">

	<form id="basicForm">
		<input type="hidden" id="id" name="id" <?php if(!$new) { echo "value=\"".$sale->id."\""; }?>>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="date">Date:</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" id="date" placeholder="Enter Date" name="date" <?php if(!$new) { echo "value=\"".$sale->date."\""; }?> >
			</div>
		</div>

		<div class="form-group" id="titleGroup">
			<label class="control-label col-sm-3" for="sale_price">Sale Price (&pound;):</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" id="sale_price" placeholder="Enter Sale Price (&pound;)" name="sale_price" <?php if(!$new) { echo "value=\"".$sale->sale_price."\""; }?> >
				<div class="help-block">If product is unsellable, enter 0 here. Use the button below for suggested sales prices.</div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-3" for="payment_method">Payment Method:</label>
			<div class="col-sm-9">
				<select class="form-control selectpicker" id="payment_method" name="payment_method" data-live-search="true">
					<?php
					foreach($payment_methods as $pm) {
						if($pm->type == $sale->payment_method) {
							echo "<option value=\"".$pm->type."\" selected>".$pm->type." (".(floatval($pm->cut)*100)."%)</option>";
						} else {
							echo "<option value=\"".$pm->type."\">".$pm->type." (".(floatval($pm->cut)*100)."%)</option>";
						}
						
					}
					?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-3" for="product">Product:</label>
			<div class="col-sm-9">
				<select class="form-control selectpicker" id="product" name="product" data-live-search="true">
					<?php
					foreach($products as $pm) {
						if($pm->id == $sale->product) {
							echo "<option value=\"".$pm->id."\" selected>".$pm->name." (".$pm->id.")</option>";
						} else {
							echo "<option value=\"".$pm->id."\">".$pm->name." (".$pm->id.")</option>";
						}
						
					}
					?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-3" for="event">Event:</label>
			<div class="col-sm-9">
				<select class="form-control selectpicker" id="event" name="event" data-live-search="true">
					<option value="null">No Event</option>
					<?php
					foreach($events as $pm) {
						if($pm->id == $sale->event) {
							echo "<option value=\"".$pm->id."\" selected>".$pm->name." (".$pm->location.")</option>";
						} else {
							echo "<option value=\"".$pm->id."\">".$pm->name." (".$pm->location.")</option>";
						}
						
					}
					?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-success" id="saveBasic"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Save sale</button>
				<button type="button" class="btn btn-primary" id="suggestSalePrice"><i class="fa fa-lightbulb-o" aria-hidden="true"></i>&nbsp;&nbsp;Suggest Sale Price</button>
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

<div class="panel panel-primary" id="potentialSaleGraph">
	<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;&nbsp;Potential Profit Chart</h4></div>
	<div class="panel-body" id="drawingArea">
	</div>
</div>

<div id="potentialSale"></div>