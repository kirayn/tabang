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
$userprofiles_delete = new userprofiles_delete();

// Run the page
$userprofiles_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userprofiles_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fuserprofilesdelete = currentForm = new ew.Form("fuserprofilesdelete", "delete");

// Form_CustomValidate event
fuserprofilesdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fuserprofilesdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserprofilesdelete.lists["x__userId"] = <?php echo $userprofiles_delete->_userId->Lookup->toClientList() ?>;
fuserprofilesdelete.lists["x__userId"].options = <?php echo JsonEncode($userprofiles_delete->_userId->lookupOptions()) ?>;
fuserprofilesdelete.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $userprofiles_delete->showPageHeader(); ?>
<?php
$userprofiles_delete->showMessage();
?>
<form name="fuserprofilesdelete" id="fuserprofilesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($userprofiles_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $userprofiles_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userprofiles">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($userprofiles_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($userprofiles->_userId->Visible) { // userId ?>
		<th class="<?php echo $userprofiles->_userId->headerCellClass() ?>"><span id="elh_userprofiles__userId" class="userprofiles__userId"><?php echo $userprofiles->_userId->caption() ?></span></th>
<?php } ?>
<?php if ($userprofiles->firstName->Visible) { // firstName ?>
		<th class="<?php echo $userprofiles->firstName->headerCellClass() ?>"><span id="elh_userprofiles_firstName" class="userprofiles_firstName"><?php echo $userprofiles->firstName->caption() ?></span></th>
<?php } ?>
<?php if ($userprofiles->lastName->Visible) { // lastName ?>
		<th class="<?php echo $userprofiles->lastName->headerCellClass() ?>"><span id="elh_userprofiles_lastName" class="userprofiles_lastName"><?php echo $userprofiles->lastName->caption() ?></span></th>
<?php } ?>
<?php if ($userprofiles->address->Visible) { // address ?>
		<th class="<?php echo $userprofiles->address->headerCellClass() ?>"><span id="elh_userprofiles_address" class="userprofiles_address"><?php echo $userprofiles->address->caption() ?></span></th>
<?php } ?>
<?php if ($userprofiles->village->Visible) { // village ?>
		<th class="<?php echo $userprofiles->village->headerCellClass() ?>"><span id="elh_userprofiles_village" class="userprofiles_village"><?php echo $userprofiles->village->caption() ?></span></th>
<?php } ?>
<?php if ($userprofiles->city->Visible) { // city ?>
		<th class="<?php echo $userprofiles->city->headerCellClass() ?>"><span id="elh_userprofiles_city" class="userprofiles_city"><?php echo $userprofiles->city->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$userprofiles_delete->RecCnt = 0;
$i = 0;
while (!$userprofiles_delete->Recordset->EOF) {
	$userprofiles_delete->RecCnt++;
	$userprofiles_delete->RowCnt++;

	// Set row properties
	$userprofiles->resetAttributes();
	$userprofiles->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$userprofiles_delete->loadRowValues($userprofiles_delete->Recordset);

	// Render row
	$userprofiles_delete->renderRow();
?>
	<tr<?php echo $userprofiles->rowAttributes() ?>>
<?php if ($userprofiles->_userId->Visible) { // userId ?>
		<td<?php echo $userprofiles->_userId->cellAttributes() ?>>
<span id="el<?php echo $userprofiles_delete->RowCnt ?>_userprofiles__userId" class="userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<?php echo $userprofiles->_userId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userprofiles->firstName->Visible) { // firstName ?>
		<td<?php echo $userprofiles->firstName->cellAttributes() ?>>
<span id="el<?php echo $userprofiles_delete->RowCnt ?>_userprofiles_firstName" class="userprofiles_firstName">
<span<?php echo $userprofiles->firstName->viewAttributes() ?>>
<?php echo $userprofiles->firstName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userprofiles->lastName->Visible) { // lastName ?>
		<td<?php echo $userprofiles->lastName->cellAttributes() ?>>
<span id="el<?php echo $userprofiles_delete->RowCnt ?>_userprofiles_lastName" class="userprofiles_lastName">
<span<?php echo $userprofiles->lastName->viewAttributes() ?>>
<?php echo $userprofiles->lastName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userprofiles->address->Visible) { // address ?>
		<td<?php echo $userprofiles->address->cellAttributes() ?>>
<span id="el<?php echo $userprofiles_delete->RowCnt ?>_userprofiles_address" class="userprofiles_address">
<span<?php echo $userprofiles->address->viewAttributes() ?>>
<?php echo $userprofiles->address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userprofiles->village->Visible) { // village ?>
		<td<?php echo $userprofiles->village->cellAttributes() ?>>
<span id="el<?php echo $userprofiles_delete->RowCnt ?>_userprofiles_village" class="userprofiles_village">
<span<?php echo $userprofiles->village->viewAttributes() ?>>
<?php echo $userprofiles->village->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userprofiles->city->Visible) { // city ?>
		<td<?php echo $userprofiles->city->cellAttributes() ?>>
<span id="el<?php echo $userprofiles_delete->RowCnt ?>_userprofiles_city" class="userprofiles_city">
<span<?php echo $userprofiles->city->viewAttributes() ?>>
<?php echo $userprofiles->city->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$userprofiles_delete->Recordset->moveNext();
}
$userprofiles_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userprofiles_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$userprofiles_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$userprofiles_delete->terminate();
?>
