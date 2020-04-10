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
$locations_delete = new locations_delete();

// Run the page
$locations_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$locations_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flocationsdelete = currentForm = new ew.Form("flocationsdelete", "delete");

// Form_CustomValidate event
flocationsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flocationsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $locations_delete->showPageHeader(); ?>
<?php
$locations_delete->showMessage();
?>
<form name="flocationsdelete" id="flocationsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($locations_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $locations_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="locations">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($locations_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($locations->locationId->Visible) { // locationId ?>
		<th class="<?php echo $locations->locationId->headerCellClass() ?>"><span id="elh_locations_locationId" class="locations_locationId"><?php echo $locations->locationId->caption() ?></span></th>
<?php } ?>
<?php if ($locations->title->Visible) { // title ?>
		<th class="<?php echo $locations->title->headerCellClass() ?>"><span id="elh_locations_title" class="locations_title"><?php echo $locations->title->caption() ?></span></th>
<?php } ?>
<?php if ($locations->pincode->Visible) { // pincode ?>
		<th class="<?php echo $locations->pincode->headerCellClass() ?>"><span id="elh_locations_pincode" class="locations_pincode"><?php echo $locations->pincode->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$locations_delete->RecCnt = 0;
$i = 0;
while (!$locations_delete->Recordset->EOF) {
	$locations_delete->RecCnt++;
	$locations_delete->RowCnt++;

	// Set row properties
	$locations->resetAttributes();
	$locations->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$locations_delete->loadRowValues($locations_delete->Recordset);

	// Render row
	$locations_delete->renderRow();
?>
	<tr<?php echo $locations->rowAttributes() ?>>
<?php if ($locations->locationId->Visible) { // locationId ?>
		<td<?php echo $locations->locationId->cellAttributes() ?>>
<span id="el<?php echo $locations_delete->RowCnt ?>_locations_locationId" class="locations_locationId">
<span<?php echo $locations->locationId->viewAttributes() ?>>
<?php echo $locations->locationId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($locations->title->Visible) { // title ?>
		<td<?php echo $locations->title->cellAttributes() ?>>
<span id="el<?php echo $locations_delete->RowCnt ?>_locations_title" class="locations_title">
<span<?php echo $locations->title->viewAttributes() ?>>
<?php echo $locations->title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($locations->pincode->Visible) { // pincode ?>
		<td<?php echo $locations->pincode->cellAttributes() ?>>
<span id="el<?php echo $locations_delete->RowCnt ?>_locations_pincode" class="locations_pincode">
<span<?php echo $locations->pincode->viewAttributes() ?>>
<?php echo $locations->pincode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$locations_delete->Recordset->moveNext();
}
$locations_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $locations_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$locations_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$locations_delete->terminate();
?>
