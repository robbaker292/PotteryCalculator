<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-money" aria-hidden="true"></i>
			&nbsp;&nbsp;<a data-toggle="collapse" href="#collapse1">Potential Sale Prices <i class="fa fa-arrow-down" aria-hidden="true"></i></a>
		</h4>
	</div>
	<div id="collapse1" class="panel-collapse collapse">
		<table class="table table-striped dataTable">
			<caption>Revenue is the sale price minus VAT and any payment processing fee. Profit is revenue minus parts costs and any event costs.<br>
				Events Costs assume that this is the next product to be sold at that event, so may be displayed higher if actual sales are high.
			</caption>
			<thead>
			<tr>
				<th>Sale Price</th><th>Revenue</th><th>Parts Cost</th><th>Event Cost</th><th>Profit</th><th>Hourly Rate</th><th>Margin</th>
			</tr>
		</thead>
		<tbody>
	<?php

		foreach ($sales_data as $sale) {
			
			if($sale["profit"] > 0) {
				echo "<tr class=\"success\">";
			} elseif($sale["sale_price"] == 0) {
				echo "<tr class=\"warning\">";
			} else {
				echo "<tr class=\"danger\">";
			}
			echo "<td class=\"profit\">";
			echo "&pound;".number_format($sale["sale_price"],2);
			echo "</td><td>";
			echo "&pound;".number_format($sale["revenue"],2);
			echo "</td><td>";
			echo "&pound;".number_format($sale["parts_cost"],2);
			echo "</td><td>";
			echo "&pound;".number_format($sale["event_cost"],2);
			echo "</td><td class=\"profit";
			if($sale["profit"] > 0) {
				echo " inprofit";
			} else {
				echo " outprofit";
			}
			echo "\">";
			echo "&pound;".number_format($sale["profit"],2);
			echo "</td><td>";
			echo "&pound;".number_format($sale["hourly_rate"],2)."/hr";
			echo "</td><td>";
			if($sale["margin"] === "N/A") {
				echo $sale["margin"];
			} else {
				echo number_format($sale["margin"],2)."%";
			}
			echo "</td></tr>";
		}
	?>
			</tbody>
		</table>
	</div>
</div>
