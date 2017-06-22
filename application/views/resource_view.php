<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//var_dump($resource_data);
//var_dump($product_data);
?>

<h2><?php echo $resource_data->name; 
echo "&nbsp;&nbsp;<a href=\"".base_url()."resource/edit/".$resource_data->id."\" class=\"btn btn-primary btn-md\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Edit</a>";
?></h2>

<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-cubes" aria-hidden="true"></i>&nbsp;&nbsp;Resource Details</h4></div>
		<table class="table table-striped">
		<?php

		if(trim($resource_data->name) != "") {
			echo "<tr><th class=\"col-sm-3\">Name</th><td>";
			echo $resource_data->name;
			echo "</td></tr>";
		}

		if(trim($resource_data->description) != "") {
			echo "<tr><th class=\"col-sm-3\">Description</th><td>";
			echo $resource_data->description;
			echo "</td></tr>";
		}

		if(trim($resource_data->date_bought) != "") {
			echo "<tr><th class=\"col-sm-3\">Date Bought</th><td>";
			echo $resource_data->date_bought;
			echo "</td></tr>";
		}

		if(trim($resource_data->size) != "") {
			echo "<tr><th class=\"col-sm-3\">Size</th><td>";
			echo $resource_data->size." ".$resource_data->unit_type;
			echo "</td></tr>";
		}

		if(trim($resource_data->price_paid) != "") {
			echo "<tr><th class=\"col-sm-3\">Price Paid</th><td>";
			echo "&pound;".number_format($resource_data->price_paid,2);
			echo "</td></tr>";
		}

		?>
	</table>
</div>

<?php
if(count($product_data) > 0) {
?>
<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-cubes" aria-hidden="true"></i>&nbsp;&nbsp;Products using this Resource</h4></div>
		<table class="table table-striped dataTable table-condensed">
			<thead>
				<tr><th>&nbsp;</th><th>Name</th><th>Amount Used</th><th>Cost</th></tr>
			</thead>
			<tbody>
			<?php
				foreach ($product_data as $product) {
					echo "<tr><td>";
					echo "<a href=\"".base_url()."product/edit/".$product->id."\" class=\"btn btn-primary btn-xs\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>";
					echo "</td><td>";
					echo "<a href=\"".base_url()."product/view/".$product->id."\" >".$product->name."</a>";
					echo "</td><td>";
					echo $product->amount." ".$resource_data->unit_type;
					echo "</td><td>";
					echo "&pound;".number_format($product->cost,2);
					echo "</td></tr>";
				}
			?>

			</tbody>
		</table>
<?php
}
