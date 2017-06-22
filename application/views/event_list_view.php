<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//var_dump($event_total_data);
?>

<h2>Events<?php 
echo "&nbsp;&nbsp;<a href=\"".base_url()."event/edit/-1\" class=\"btn btn-success btn-md\" role=\"button\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i>&nbsp;&nbsp;New</a>";
?></h2>

<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;List of All Events</h4></div>
		<table class="table dataTable">
			<thead>
			<tr>
					<th>&nbsp;</th><th>Name</th><th>Total Sales</th><th>Total Profit</th><th>Av. Profit</th><th>Av. Rate</th><th>Av. Selling Price</th><th>Av. Margin</th>
				</tr>
			</thead><tbody>
		<?php

			foreach($event_total_data as $event_data) {

				//var_dump($event_data);
				?>
				
				
					<?php
						if(isset($event_data->avg_profit)) {
							if($event_data->avg_profit > 0) {
								echo "<tr class=\"success\">";
							} else {
								echo "<tr class=\"danger\">";
							} 
						} else {
							echo "<tr class=\"warning\">";
						}


						echo "<td>";
						echo "<a href=\"".base_url()."event/edit/".$event_data->id."\" class=\"btn btn-primary btn-xs\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>";
						echo "</td><td>";
						echo "<a href=\"".base_url()."event/view/".$event_data->id."\" >".$event_data->name." <small>(".$event_data->location.")</small></a>";
						echo "</td><td class=\"profit\">";
						echo $event_data->sales_count;
						echo "</td><td class=\"profit";
						if($event_data->profit > 0) {
							echo " inprofit";
						} else if($event_data->profit < 0) {
							echo " outprofit";
						}
						echo "\">";
						echo "&pound;".number_format($event_data->profit,2);
						echo "</td><td class=\"profit";
							if(isset($event_data->avg_profit)) {
								if($event_data->avg_profit > 0) {
									echo " inprofit";
								} else if($event_data->avg_profit < 0){
									echo " outprofit";
								}
								echo "\">";
								echo "&pound;".number_format($event_data->avg_profit,2);
							} else {
								echo "\">";
								echo"N/A";
							}

						echo "</td><td>";
						if(isset($event_data->avg_profit)) {
							echo "&pound;".number_format($event_data->avg_rate,2)."/hr";
						} else {
							echo"N/A";
						}
						echo "</td><td>";
						if(isset($event_data->avg_profit)) {
							echo "&pound;".number_format($event_data->avg_selling_price,2);
						} else {
							echo"N/A";
						}
						echo "</td><td>";
						if(isset($event_data->avg_profit)) {
							echo number_format($event_data->margin,2)."%";
						} else {
							echo"N/A";
						}
						echo "</td>";

					?>
				</tr>

				<?php
			}

		?>
	</tbody>
	</table>

</div>