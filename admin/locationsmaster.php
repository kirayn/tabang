<?php
namespace PHPMaker2019\tabelo_admin;
?>
<?php if ($locations->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_locationsmaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($locations->locationId->Visible) { // locationId ?>
		<tr id="r_locationId">
			<td class="<?php echo $locations->TableLeftColumnClass ?>"><?php echo $locations->locationId->caption() ?></td>
			<td<?php echo $locations->locationId->cellAttributes() ?>>
<span id="el_locations_locationId">
<span<?php echo $locations->locationId->viewAttributes() ?>>
<?php echo $locations->locationId->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($locations->title->Visible) { // title ?>
		<tr id="r_title">
			<td class="<?php echo $locations->TableLeftColumnClass ?>"><?php echo $locations->title->caption() ?></td>
			<td<?php echo $locations->title->cellAttributes() ?>>
<span id="el_locations_title">
<span<?php echo $locations->title->viewAttributes() ?>>
<?php echo $locations->title->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($locations->pincode->Visible) { // pincode ?>
		<tr id="r_pincode">
			<td class="<?php echo $locations->TableLeftColumnClass ?>"><?php echo $locations->pincode->caption() ?></td>
			<td<?php echo $locations->pincode->cellAttributes() ?>>
<span id="el_locations_pincode">
<span<?php echo $locations->pincode->viewAttributes() ?>>
<?php echo $locations->pincode->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
