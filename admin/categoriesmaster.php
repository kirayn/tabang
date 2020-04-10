<?php
namespace PHPMaker2019\tabelo_admin;
?>
<?php if ($categories->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_categoriesmaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($categories->categoryId->Visible) { // categoryId ?>
		<tr id="r_categoryId">
			<td class="<?php echo $categories->TableLeftColumnClass ?>"><?php echo $categories->categoryId->caption() ?></td>
			<td<?php echo $categories->categoryId->cellAttributes() ?>>
<span id="el_categories_categoryId">
<span<?php echo $categories->categoryId->viewAttributes() ?>>
<?php echo $categories->categoryId->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($categories->name->Visible) { // name ?>
		<tr id="r_name">
			<td class="<?php echo $categories->TableLeftColumnClass ?>"><?php echo $categories->name->caption() ?></td>
			<td<?php echo $categories->name->cellAttributes() ?>>
<span id="el_categories_name">
<span<?php echo $categories->name->viewAttributes() ?>>
<?php echo $categories->name->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($categories->parentId->Visible) { // parentId ?>
		<tr id="r_parentId">
			<td class="<?php echo $categories->TableLeftColumnClass ?>"><?php echo $categories->parentId->caption() ?></td>
			<td<?php echo $categories->parentId->cellAttributes() ?>>
<span id="el_categories_parentId">
<span<?php echo $categories->parentId->viewAttributes() ?>>
<?php echo $categories->parentId->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
