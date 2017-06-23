<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h2><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;Settings</h2>

<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;List of VAT Rates
			&nbsp;&nbsp;
			<?php echo "<a href=\"".base_url()."settings/editVat/-1\" class=\"btn btn-success btn-xs\" role=\"button\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Add</a>";
			?>
		</h4></div>
		<table class="table table-striped dataTable">
			<thead>
			<tr>
					<th>&nbsp;</th><th>Start Date</th><th>End Date</th><th>Rate (%)</th>
				</tr>
			</thead><tbody>
		<?php

			foreach($vat_list as $vat) {
								?>
				<tr>
					<?php
						echo "<td>";
						echo "<a href=\"".base_url()."settings/editVat/".$vat->id."\" class=\"btn btn-primary btn-xs\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>";
						echo "</td><td>";
						if($vat->start == "0000-00-00" || $vat->start ==null) {
							echo "&nbsp;";
						} else {
							echo $vat->start;
						}
						echo "</td><td>";
						if($vat->end == "0000-00-00" || $vat->end ==null) {
							echo "&nbsp;";
						} else {
							echo $vat->end;
						}
						echo "</td><td>";
						echo $vat->rate;
						echo "</td>";

					?>
				</tr>

				<?php
			}

		?>
	</tbody>
	</table>

</div>

<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;List of Payment Methods
			&nbsp;&nbsp;
			<?php echo "<a href=\"".base_url()."settings/editPM/-1\" class=\"btn btn-success btn-xs\" role=\"button\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Add</a>";
			?>
		</h4></div>
		<table class="table table-striped dataTable">
			<thead>
			<tr>
					<th>&nbsp;</th><th>Type</th><th>Cut (%)</th>
				</tr>
			</thead><tbody>
		<?php

			foreach($pm_list as $pm) {
								?>
				<tr>
					<?php
						echo "<td>";
						echo "<a href=\"".base_url()."settings/editPM/".urlencode($pm->type)."\" class=\"btn btn-primary btn-xs\" role=\"button\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>";
						echo "</td><td>";
						echo $pm->type;
						echo "</td><td>";
						echo $pm->cut;
						echo "</td>";

					?>
				</tr>

				<?php
			}

		?>
	</tbody>
	</table>

</div>