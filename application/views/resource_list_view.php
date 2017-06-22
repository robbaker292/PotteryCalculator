<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//var_dump($resource_total_data);
//var_dump($product_data);
?>

<h2>Resources<?php 
echo "&nbsp;&nbsp;<a href=\"".base_url()."resource/edit/-1\" class=\"btn btn-success btn-md\" role=\"button\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Add</a>";
?></h2>

<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;List of All Resources</h4></div>
		<table class="table dataTable">
			<thead>
			<tr>
					<th>&nbsp;</th><th>Name</th><th>Date Bought</th><th>Price Paid</th><th>Size</th><th>Used in Products</th>
				</tr>
			</thead><tbody>
		<?php

			foreach($resource_total_data as $resource_data) {
				//var_dump($product_data);
				?>
					<?php
						echo "<tr><td>";
						echo "<a href=\"".base_url()."resource/edit/".$resource_data->id."\" class=\"btn btn-primary btn-xs\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>";
						echo "</td><td>";
						echo "<a href=\"".base_url()."resource/view/".$resource_data->id."\" >".$resource_data->name."</a>";
						echo "</td><td>";
						echo $resource_data->date_bought;
						echo "</td><td>";
						echo "&pound;".number_format($resource_data->price_paid,2);
						echo "</td><td>";
						echo $resource_data->size." ".$resource_data->unit_type;
						echo "</td><td>";
						echo $resource_data->product_count;						
						echo "</td></tr>";
					?>
				</tr>

				<?php
			}

		?>
	</tbody>
	</table>
</div>