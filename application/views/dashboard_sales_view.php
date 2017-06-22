<?php
	if(count($sales_data) > 0) {
		?>
		<div class="panel panel-primary">
			<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;Sales Drilldown</h4></div>
			<table class="table table-striped dataTable">
				<caption>Revenue is the sale price minus VAT and any payment processing fee. Profit is revenue minus parts costs and any event costs (not shown).</caption>
				<thead>
				<tr>
					<th>&nbsp;</th><th>Product Name</th><th>Sale Price</th><th>Event</th><th>Method</th><th>Revenue</th><th>Parts Cost</th><th>Profit</th><th>Rate</th><th>Margin</th>
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
				echo "<a href=\"".base_url()."product/view/".$sale->product_id."\">".$sale->product_name."</a>";
				echo "</td><td class=\"profit\">";
				echo "&pound;".number_format($sale->sale_price,2);
				echo "</td><td>";
				if($sale->event_name !== null) {
					echo "<a href=\"".base_url()."event/view/".$sale->event_id."\">".$sale->event_name." <small>(".$sale->event_location.")</small></a>";
				} else {
					echo "No Event";
				}
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