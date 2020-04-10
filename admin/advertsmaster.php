<?php
namespace PHPMaker2019\tabelo_admin;
?>
<?php if ($adverts->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_advertsmaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($adverts->_userId->Visible) { // userId ?>
		<tr id="r__userId">
			<td class="<?php echo $adverts->TableLeftColumnClass ?>"><?php echo $adverts->_userId->caption() ?></td>
			<td<?php echo $adverts->_userId->cellAttributes() ?>>
<span id="el_adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->getViewValue())) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><?php echo $adverts->_userId->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->_userId->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($adverts->title->Visible) { // title ?>
		<tr id="r_title">
			<td class="<?php echo $adverts->TableLeftColumnClass ?>"><?php echo $adverts->title->caption() ?></td>
			<td<?php echo $adverts->title->cellAttributes() ?>>
<span id="el_adverts_title">
<span<?php echo $adverts->title->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->title->getViewValue())) && $adverts->title->linkAttributes() <> "") { ?>
<a<?php echo $adverts->title->linkAttributes() ?>><?php echo $adverts->title->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->title->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($adverts->description->Visible) { // description ?>
		<tr id="r_description">
			<td class="<?php echo $adverts->TableLeftColumnClass ?>"><?php echo $adverts->description->caption() ?></td>
			<td<?php echo $adverts->description->cellAttributes() ?>>
<span id="el_adverts_description">
<span<?php echo $adverts->description->viewAttributes() ?>>
<?php echo $adverts->description->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($adverts->categoryId->Visible) { // categoryId ?>
		<tr id="r_categoryId">
			<td class="<?php echo $adverts->TableLeftColumnClass ?>"><?php echo $adverts->categoryId->caption() ?></td>
			<td<?php echo $adverts->categoryId->cellAttributes() ?>>
<span id="el_adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<?php echo $adverts->categoryId->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($adverts->locationId->Visible) { // locationId ?>
		<tr id="r_locationId">
			<td class="<?php echo $adverts->TableLeftColumnClass ?>"><?php echo $adverts->locationId->caption() ?></td>
			<td<?php echo $adverts->locationId->cellAttributes() ?>>
<span id="el_adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<?php echo $adverts->locationId->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($adverts->date->Visible) { // date ?>
		<tr id="r_date">
			<td class="<?php echo $adverts->TableLeftColumnClass ?>"><?php echo $adverts->date->caption() ?></td>
			<td<?php echo $adverts->date->cellAttributes() ?>>
<span id="el_adverts_date">
<span<?php echo $adverts->date->viewAttributes() ?>>
<?php echo $adverts->date->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($adverts->cost->Visible) { // cost ?>
		<tr id="r_cost">
			<td class="<?php echo $adverts->TableLeftColumnClass ?>"><?php echo $adverts->cost->caption() ?></td>
			<td<?php echo $adverts->cost->cellAttributes() ?>>
<span id="el_adverts_cost">
<span<?php echo $adverts->cost->viewAttributes() ?>>
<?php echo $adverts->cost->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
