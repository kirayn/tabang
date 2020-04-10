<?php
namespace PHPMaker2019\tabelo_admin;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start(); 

// Autoload
include_once "autoload.php";
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$adverts_delete = new adverts_delete();

// Run the page
$adverts_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$adverts_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fadvertsdelete = currentForm = new ew.Form("fadvertsdelete", "delete");

// Form_CustomValidate event
fadvertsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fadvertsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fadvertsdelete.lists["x__userId"] = <?php echo $adverts_delete->_userId->Lookup->toClientList() ?>;
fadvertsdelete.lists["x__userId"].options = <?php echo JsonEncode($adverts_delete->_userId->lookupOptions()) ?>;
fadvertsdelete.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fadvertsdelete.lists["x_categoryId"] = <?php echo $adverts_delete->categoryId->Lookup->toClientList() ?>;
fadvertsdelete.lists["x_categoryId"].options = <?php echo JsonEncode($adverts_delete->categoryId->lookupOptions()) ?>;
fadvertsdelete.lists["x_locationId"] = <?php echo $adverts_delete->locationId->Lookup->toClientList() ?>;
fadvertsdelete.lists["x_locationId"].options = <?php echo JsonEncode($adverts_delete->locationId->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $adverts_delete->showPageHeader(); ?>
<?php
$adverts_delete->showMessage();
?>
<form name="fadvertsdelete" id="fadvertsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($adverts_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $adverts_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="adverts">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($adverts_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($adverts->_userId->Visible) { // userId ?>
		<th class="<?php echo $adverts->_userId->headerCellClass() ?>"><span id="elh_adverts__userId" class="adverts__userId"><?php echo $adverts->_userId->caption() ?></span></th>
<?php } ?>
<?php if ($adverts->title->Visible) { // title ?>
		<th class="<?php echo $adverts->title->headerCellClass() ?>"><span id="elh_adverts_title" class="adverts_title"><?php echo $adverts->title->caption() ?></span></th>
<?php } ?>
<?php if ($adverts->description->Visible) { // description ?>
		<th class="<?php echo $adverts->description->headerCellClass() ?>"><span id="elh_adverts_description" class="adverts_description"><?php echo $adverts->description->caption() ?></span></th>
<?php } ?>
<?php if ($adverts->categoryId->Visible) { // categoryId ?>
		<th class="<?php echo $adverts->categoryId->headerCellClass() ?>"><span id="elh_adverts_categoryId" class="adverts_categoryId"><?php echo $adverts->categoryId->caption() ?></span></th>
<?php } ?>
<?php if ($adverts->locationId->Visible) { // locationId ?>
		<th class="<?php echo $adverts->locationId->headerCellClass() ?>"><span id="elh_adverts_locationId" class="adverts_locationId"><?php echo $adverts->locationId->caption() ?></span></th>
<?php } ?>
<?php if ($adverts->date->Visible) { // date ?>
		<th class="<?php echo $adverts->date->headerCellClass() ?>"><span id="elh_adverts_date" class="adverts_date"><?php echo $adverts->date->caption() ?></span></th>
<?php } ?>
<?php if ($adverts->cost->Visible) { // cost ?>
		<th class="<?php echo $adverts->cost->headerCellClass() ?>"><span id="elh_adverts_cost" class="adverts_cost"><?php echo $adverts->cost->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$adverts_delete->RecCnt = 0;
$i = 0;
while (!$adverts_delete->Recordset->EOF) {
	$adverts_delete->RecCnt++;
	$adverts_delete->RowCnt++;

	// Set row properties
	$adverts->resetAttributes();
	$adverts->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$adverts_delete->loadRowValues($adverts_delete->Recordset);

	// Render row
	$adverts_delete->renderRow();
?>
	<tr<?php echo $adverts->rowAttributes() ?>>
<?php if ($adverts->_userId->Visible) { // userId ?>
		<td<?php echo $adverts->_userId->cellAttributes() ?>>
<span id="el<?php echo $adverts_delete->RowCnt ?>_adverts__userId" class="adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->getViewValue())) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><?php echo $adverts->_userId->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->_userId->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($adverts->title->Visible) { // title ?>
		<td<?php echo $adverts->title->cellAttributes() ?>>
<span id="el<?php echo $adverts_delete->RowCnt ?>_adverts_title" class="adverts_title">
<span<?php echo $adverts->title->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->title->getViewValue())) && $adverts->title->linkAttributes() <> "") { ?>
<a<?php echo $adverts->title->linkAttributes() ?>><?php echo $adverts->title->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->title->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($adverts->description->Visible) { // description ?>
		<td<?php echo $adverts->description->cellAttributes() ?>>
<span id="el<?php echo $adverts_delete->RowCnt ?>_adverts_description" class="adverts_description">
<span<?php echo $adverts->description->viewAttributes() ?>>
<?php echo $adverts->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($adverts->categoryId->Visible) { // categoryId ?>
		<td<?php echo $adverts->categoryId->cellAttributes() ?>>
<span id="el<?php echo $adverts_delete->RowCnt ?>_adverts_categoryId" class="adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<?php echo $adverts->categoryId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($adverts->locationId->Visible) { // locationId ?>
		<td<?php echo $adverts->locationId->cellAttributes() ?>>
<span id="el<?php echo $adverts_delete->RowCnt ?>_adverts_locationId" class="adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<?php echo $adverts->locationId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($adverts->date->Visible) { // date ?>
		<td<?php echo $adverts->date->cellAttributes() ?>>
<span id="el<?php echo $adverts_delete->RowCnt ?>_adverts_date" class="adverts_date">
<span<?php echo $adverts->date->viewAttributes() ?>>
<?php echo $adverts->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($adverts->cost->Visible) { // cost ?>
		<td<?php echo $adverts->cost->cellAttributes() ?>>
<span id="el<?php echo $adverts_delete->RowCnt ?>_adverts_cost" class="adverts_cost">
<span<?php echo $adverts->cost->viewAttributes() ?>>
<?php echo $adverts->cost->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$adverts_delete->Recordset->moveNext();
}
$adverts_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $adverts_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$adverts_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$adverts_delete->terminate();
?>
