<?php
namespace PHPMaker2019\tabelo_admin;
?>
<?php if ($users->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_usersmaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($users->ID->Visible) { // ID ?>
		<tr id="r_ID">
			<td class="<?php echo $users->TableLeftColumnClass ?>"><?php echo $users->ID->caption() ?></td>
			<td<?php echo $users->ID->cellAttributes() ?>>
<span id="el_users_ID">
<span<?php echo $users->ID->viewAttributes() ?>>
<?php echo $users->ID->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->mobile->Visible) { // mobile ?>
		<tr id="r_mobile">
			<td class="<?php echo $users->TableLeftColumnClass ?>"><?php echo $users->mobile->caption() ?></td>
			<td<?php echo $users->mobile->cellAttributes() ?>>
<span id="el_users_mobile">
<span<?php echo $users->mobile->viewAttributes() ?>>
<?php echo $users->mobile->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
		<tr id="r_passcode">
			<td class="<?php echo $users->TableLeftColumnClass ?>"><?php echo $users->passcode->caption() ?></td>
			<td<?php echo $users->passcode->cellAttributes() ?>>
<span id="el_users_passcode">
<span<?php echo $users->passcode->viewAttributes() ?>>
<?php echo $users->passcode->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
		<tr id="r_role">
			<td class="<?php echo $users->TableLeftColumnClass ?>"><?php echo $users->role->caption() ?></td>
			<td<?php echo $users->role->cellAttributes() ?>>
<span id="el_users_role">
<span<?php echo $users->role->viewAttributes() ?>>
<?php echo $users->role->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
		<tr id="r_status">
			<td class="<?php echo $users->TableLeftColumnClass ?>"><?php echo $users->status->caption() ?></td>
			<td<?php echo $users->status->cellAttributes() ?>>
<span id="el_users_status">
<span<?php echo $users->status->viewAttributes() ?>>
<?php echo $users->status->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->activation->Visible) { // activation ?>
		<tr id="r_activation">
			<td class="<?php echo $users->TableLeftColumnClass ?>"><?php echo $users->activation->caption() ?></td>
			<td<?php echo $users->activation->cellAttributes() ?>>
<span id="el_users_activation">
<span<?php echo $users->activation->viewAttributes() ?>>
<?php echo $users->activation->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->registered->Visible) { // registered ?>
		<tr id="r_registered">
			<td class="<?php echo $users->TableLeftColumnClass ?>"><?php echo $users->registered->caption() ?></td>
			<td<?php echo $users->registered->cellAttributes() ?>>
<span id="el_users_registered">
<span<?php echo $users->registered->viewAttributes() ?>>
<?php echo $users->registered->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
