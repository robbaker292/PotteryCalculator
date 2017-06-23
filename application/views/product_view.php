<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//var_dump($sales_data);
?>
<script>
$(document).on("click", ".btn-delete", function(e) {
	bootbox.confirm({ 
		size: "large",
		title: "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Warning!",
		message: "This will delete the current Product.<br>All Sales with this Product will be deleted.<br>This CANNOT be undone",
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
				window.location.href = <?php echo "\"".base_url()."product/delete/".$product_data->id."\""; ?>;
			}
		}
	});
});
</script>

<h2><?php echo $product_data->name; 
echo "&nbsp;&nbsp;<a href=\"".base_url()."product/edit/".$product_data->id."\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Edit</a>";
?>
	<a href="#" class="btn btn-danger btn-md pull-right btn-delete" role="button">
		<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Delete Product
	</a>
</h2>

<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;&nbsp;Product Details</h4></div>
		<table class="table table-striped">
		<?php

		if(trim($product_data->name) != "") {
			echo "<tr><th class=\"col-sm-3\">Name</th><td>";
			echo $product_data->name;
			echo "</td></tr>";
		}

		if(trim($product_data->description) != "") {
			echo "<tr><th class=\"col-sm-3\">Description</th><td>";
			echo $product_data->description;
			echo "</td></tr>";
		}

		if(trim($product_data->time) != "") {
			echo "<tr><th class=\"col-sm-3\">Creation Time (Hours)</th><td>";
			echo $product_data->time;
			echo "</td></tr>";
		}
		?>
	</table>
</div>

<?php
	if(count($sales_data) > 0) {
	?>
<div class="panel panel-primary">
	<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;&nbsp;Product Summary</h4></div>
	<table class="table table-striped">
		<tr>
			<th>Total Sales</th><th>Total Profit</th><th>Av. Profit</th><th>Av. Rate</th><th>Av. Selling Price</th><th>Av. Margin</th><th>Most Profitable Event</th><th>Least Profitable Event</th>
		</tr>
		<tr>
			<?php
				echo "<td class=\"total_profit\">";
				echo count($sales_data);
				echo "</td><td class=\"total_profit";
				if($product_data->profit > 0) {
					echo " inprofit";
				} else {
					echo " outprofit";
				}
				echo "\">";
				echo "&pound;".number_format($product_data->profit,2);
				echo "</td><td class=\"total_profit";
				if($product_data->avg_profit > 0) {
					echo " inprofit";
				} else {
					echo " outprofit";
				}
				echo "\">";
				echo "&pound;".number_format($product_data->avg_profit,2);
				echo "</td><td>";
				echo "&pound;".number_format($product_data->avg_rate,2)."/hr";
				echo "</td><td>";
				echo "&pound;".number_format($product_data->avg_selling_price,2);
				echo "</td><td>";
				echo number_format($product_data->margin,2)."%";
				echo "</td><td>";
				if(isset($product_data->max_event)) {
					echo "<a href=\"".base_url()."event/view/".$product_data->max_event."\">".$product_data->max_event_name." (".$product_data->max_event_location.") (&pound;"
						.number_format($product_data->max_event_profit,2).")</a>";
				} else {
					echo "N/A";
				}
				echo "</td><td>";
				if(isset($product_data->min_event)) {
					echo "<a href=\"".base_url()."event/view/".$product_data->min_event."\">".$product_data->min_event_name." (".$product_data->min_event_location.") (&pound;"
						.number_format($product_data->min_event_profit,2).")</a>";
				} else {
					echo "N/A";
				}
				echo "</td>";

			?>
		</tr>
	</table>
</div>

<?php
	}

	if(count($sales_data) > 0) {
		?>
		<div class="panel panel-primary">
			<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;&nbsp;Sales</h4></div>
			<table class="table table-striped dataTable">
				<caption>Revenue is the sale price minus VAT and any payment processing fee. Profit is revenue minus parts costs and any event costs (not shown).</caption>
				<thead>
				<tr>
					<th>&nbsp;</th><th>Date</th><th>Sale Price</th><th>Method</th><th>Event</th><th>Revenue</th><th>Parts Cost</th><th>Profit</th><th>Rate</th><th>Margin</th>
				</tr>
			</thead>
			<tbody>
		<?php
			foreach ($sales_data as $sale) {
				if($sale->profit > 0) {
					echo "<tr class=\"success\">";
				} elseif($sale->sale_price == 0) {
					echo "<tr class=\"warning\">";
				} else {
					echo "<tr class=\"danger\">";
				}
				echo "<td>";
				echo "<a href=\"".base_url()."sale/edit/".$sale->sale_id."\" class=\"btn btn-primary btn-xs\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>";
				echo "</td><td>";
				echo $sale->date;
				echo "</td><td class=\"profit\">";
				echo "&pound;".number_format($sale->sale_price,2);
				echo "</td><td>";
				echo ucfirst($sale->payment_method);
				echo "</td><td>";
				if($sale->event_name !== null) {
					echo "<a href=\"".base_url()."event/view/".$sale->event_id."\">".$sale->event_name." (".$sale->event_location.")</a>";
				} else {
					echo "No Event";
				}
				echo "</td><td>";
				echo "&pound;".number_format($sale->revenue,2);
				echo "</td><td>";
				echo "&pound;".number_format($sale->parts_cost,2);
				echo "</td><td class=\"profit";
				if($sale->profit > 0) {
					echo " inprofit";
				} else {
					echo " outprofit";
				}
				echo "\">";
				echo "&pound;".number_format($sale->profit,2);
				echo "</td><td>";
				echo "&pound;".number_format($sale->hourly_rate,2)."/hr";
				echo "</td><td>";
				if($sale->margin === "N/A") {
					echo $sale->margin;
				} else {
					echo number_format($sale->margin,2)."%";
				}
				echo "</td></tr>";
			}
		?>
	</tbody>
		</table>
	</div>

		<?php
	}

?>

<?php
	if(count($resources_data) > 0) {
	?>
	<div class="panel panel-primary">
			<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-cubes" aria-hidden="true"></i>&nbsp;&nbsp;Resources</h4></div>
			<table class="table table-striped dataTable table-condensed">
				<thead>
				<tr>
					<th>&nbsp;</th><th>Name</th><th>Description</th><th>Date Bought</th><th>Amount Used</th><th>Cost</th>
				</tr>
			</thead>
			<tbody>
		<?php
			foreach ($resources_data as $resource) {
				echo "<tr><td>";
				echo "<a href=\"".base_url()."product/edit/".$product_data->id."\" class=\"btn btn-primary btn-xs\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>";
				echo "</td><td>";
				echo "<a href=\"".base_url()."resource/view/".$resource->id."\" >".$resource->name."</a>";
				echo "</td><td>";
				echo $resource->description;
				echo "</td><td>";
				echo $resource->date_bought;
				echo "</td><td>";
				echo number_format($resource->amount,2)." ".$resource->unit_type;
				echo "</td><td>";
				echo "&pound;".number_format($resource->cost,2);
				echo "</td></tr>";
			}
		?>
	</tbody>
		</table>
		</div>
		<?php
	}

?>
