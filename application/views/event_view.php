<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<script>
$(document).on("click", ".btn-delete", function(e) {
	bootbox.confirm({ 
		size: "large",
		title: "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Warning!",
		message: "This will delete the current Event.<br>All Sales with this Event will be set to \"No Event\".<br>This CANNOT be undone",
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
				window.location.href = <?php echo "\"".base_url()."event/delete/".$event_data->id."\""; ?>;
			}
		}
	});
});
</script>
<h2><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<?php echo $event_data->name; 
echo "&nbsp;&nbsp;<a href=\"".base_url()."event/edit/".$event_data->id."\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Edit</a>";
?>
	<!-- <a href="<?php echo base_url()."event/delete/".$event_data->id; ?>" class="btn btn-danger btn-md pull-right btn-delete" role="button"> -->
	<a href="#" class="btn btn-danger btn-md pull-right btn-delete" role="button">
		<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Delete Event
	</a>
</h2>

<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;&nbsp;Event Details</h4></div>
		<table class="table table-striped">
		<?php

		if(trim($event_data->name) != "") {
			echo "<tr><th class=\"col-sm-3\">Name</th><td>";
			echo $event_data->name;
			echo "</td></tr>";
		}

		if(trim($event_data->location) != "") {
			echo "<tr><th class=\"col-sm-3\">Location</th><td>";
			echo $event_data->location;
			echo "</td></tr>";
		}

		if(trim($event_data->start) != "" && $event_data->start != "0000-00-00") {
			echo "<tr><th class=\"col-sm-3\">Start Date</th><td>";
			echo $event_data->start;
			echo "</td></tr>";
		}

		if(trim($event_data->end) != "" && $event_data->end != "0000-00-00") {
			echo "<tr><th class=\"col-sm-3\">End Date</th><td>";
			echo $event_data->end;
			echo "</td></tr>";
		}

		if(trim($event_data->cost_upfront) != "" && trim($event_data->cost_upfront) != "0.00" && $event_data->cost_upfront !== null ) {
			echo "<tr><th class=\"col-sm-3\">Upfront Cost</th><td>";
			echo "&pound;".number_format($event_data->cost_upfront,2);
			echo "</td></tr>";
		}

		if(trim($event_data->cost_sales) != "" && trim($event_data->cost_sales) != "0.00" && $event_data->cost_sales !== null ) {
			echo "<tr><th class=\"col-sm-3\">Cost from sales</th><td>";
			echo number_format($event_data->cost_sales*100,2)."%";
			echo "</td></tr>";
		}

		?>
	</table>
</div>
<?php
	if(count($sales_data) > 0) {
?>

<div class="panel panel-primary">
	<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;&nbsp;Event Summary</h4></div>
	<table class="table table-striped">
		<tr>
			<th>Total Sales</th><th>Total Profit</th><th>Av. Profit</th><th>Av. Rate</th><th>Av. Selling Price</th><th>Av. Margin</th><th>Most Profitable Product</th><th>Least Profitable Product</th>
		</tr>
		<tr>
			<?php
				echo "<td class=\"total_profit\">";
				echo count($sales_data);
				echo "</td><td class=\"total_profit";
				if($event_data->profit > 0) {
					echo " inprofit";
				} else {
					echo " outprofit";
				}
				echo "\">";
				echo "&pound;".number_format($event_data->profit,2);
				echo "</td><td class=\"total_profit";
				if($event_data->avg_profit > 0) {
					echo " inprofit";
				} else {
					echo " outprofit";
				}
				echo "\">";
				echo "&pound;".number_format($event_data->avg_profit,2);
				echo "</td><td>";
				echo "&pound;".number_format($event_data->avg_rate,2)."/hr";
				echo "</td><td>";
				echo "&pound;".number_format($event_data->avg_selling_price,2);
				echo "</td><td>";
				if($event_data->margin === "N/A") {
					echo $event_data->margin;
				} else {
					echo number_format($event_data->margin,2)."%";
				}
				echo "</td><td>";
				echo "<a href=\"".base_url()."event/view/".$event_data->max_event_id."\">".$event_data->max_event_name." (&pound;"
					.number_format($event_data->max_event_profit,2).")</a>";
				echo "</td><td>";
				echo "<a href=\"".base_url()."event/view/".$event_data->min_event_id."\">".$event_data->min_event_name." (&pound;"
					.number_format($event_data->min_event_profit,2).")</a>";
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
					<th>&nbsp;</th><th>Date</th><th>Name</th><th>Sale Price</th><th>Method</th><th>Revenue</th><th>Parts Cost</th><th>Profit</th><th>Rate</th><th>Margin</th>
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
				echo "</td><td>";
				echo "<a href=\"".base_url()."product/view/".$sale->product_id."\">".$sale->product_name."</a>";
				echo "</td><td class=\"profit\">";
				echo "&pound;".number_format($sale->sale_price,2);
				echo "</td><td>";
				echo ucfirst($sale->payment_method);
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
