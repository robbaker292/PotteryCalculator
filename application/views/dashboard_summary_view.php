<div class="panel panel-primary">
	<div class="panel-heading"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;Sales Summary</div>
<table class="table table-striped">
		<thead>
			<tr>
				<th>Total Sales</th><th>Total Profit</th><th>Av. Profit</th><th>Av. Rate</th><th>Av. Selling Price</th><th>Av. Margin</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php
					echo "<td class=\"total_profit\">";
					echo $product_data->sales_count;
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
					if($product_data->margin === "N/A") {
						echo $product_data->margin;
					} else {
						echo number_format($product_data->margin,2)."%";
					}
					echo "</td>";

				?>
			</tr>
		</tbody>
	</table>
	</div>