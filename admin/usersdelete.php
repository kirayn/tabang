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
$users_delete = new users_delete();

// Run the page
$users_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fusersdelete = currentForm = new ew.Form("fusersdelete", "delete");

// Form_CustomValidate event
fusersdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusersdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersdelete.lists["x_role"] = <?php echo $users_delete->role->Lookup->toClientList() ?>;
fusersdelete.lists["x_role"].options = <?php echo JsonEncode($users_delete->role->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $users_delete->showPageHeader(); ?>
<?php
$users_delete->showMessage();
?>
<form name="fusersdelete" id="fusersdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($users_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $users_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($users_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($users->ID->Visible) { // ID ?>
		<th class="<?php echo $users->ID->headerCellClass() ?>"><span id="elh_users_ID" class="users_ID"><?php echo $users->ID->caption() ?></span></th>
<?php } ?>
<?php if ($users->mobile->Visible) { // mobile ?>
		<th class="<?php echo $users->mobile->headerCellClass() ?>"><span id="elh_users_mobile" class="users_mobile"><?php echo $users->mobile->caption() ?></span></th>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
		<th class="<?php echo $users->passcode->headerCellClass() ?>"><span id="elh_users_passcode" class="users_passcode"><?php echo $users->passcode->caption() ?></span></th>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
		<th class="<?php echo $users->role->headerCellClass() ?>"><span id="elh_users_role" class="users_role"><?php echo $users->role->caption() ?></span></th>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
		<th class="<?php echo $users->status->headerCellClass() ?>"><span id="elh_users_status" class="users_status"><?php echo $users->status->caption() ?></span></th>
<?php } ?>
<?php if ($users->activation->Visible) { // activation ?>
		<th class="<?php echo $users->activation->headerCellClass() ?>"><span id="elh_users_activation" class="users_activation"><?php echo $users->activation->caption() ?></span></th>
<?php } ?>
<?php if ($users->registered->Visible) { // registered ?>
		<th class="<?php echo $users->registered->headerCellClass() ?>"><span id="elh_users_registered" class="users_registered"><?php echo $users->registered->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$users_delete->RecCnt = 0;
$i = 0;
while (!$users_delete->Recordset->EOF) {
	$users_delete->RecCnt++;
	$users_delete->RowCnt++;

	// Set row properties
	$users->resetAttributes();
	$users->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$users_delete->loadRowValues($users_delete->Recordset);

	// Render row
	$users_delete->renderRow();
?>
	<tr<?php echo $users->rowAttributes() ?>>
<?php if ($users->ID->Visible) { // ID ?>
		<td<?php echo $users->ID->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_ID" class="users_ID">
<span<?php echo $users->ID->viewAttributes() ?>>
<?php echo $users->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->mobile->Visible) { // mobile ?>
		<td<?php echo $users->mobile->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_mobile" class="users_mobile">
<span<?php echo $users->mobile->viewAttributes() ?>>
<?php echo $users->mobile->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
		<td<?php echo $users->passcode->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_passcode" class="users_passcode">
<span<?php echo $users->passcode->viewAttributes() ?>>
<?php echo $users->passcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
		<td<?php echo $users->role->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_role" class="users_role">
<span<?php echo $users->role->viewAttributes() ?>>
<?php echo $users->role->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
		<td<?php echo $users->status->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_status" class="users_status">
<span<?php echo $users->status->viewAttributes() ?>>
<?php echo $users->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->activation->Visible) { // activation ?>
		<td<?php echo $users->activation->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_activation" class="users_activation">
<span<?php echo $users->activation->viewAttributes() ?>>
<?php echo $users->activation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->registered->Visible) { // registered ?>
		<td<?php echo $users->registered->cellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_registered" class="users_registered">
<span<?php echo $users->registered->viewAttributes() ?>>
<?php echo $users->registered->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$users_delete->Recordset->moveNext();
}
$users_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $users_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$users_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_delete->terminate();
?>
