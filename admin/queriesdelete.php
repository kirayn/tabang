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
$queries_delete = new queries_delete();

// Run the page
$queries_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$queries_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fqueriesdelete = currentForm = new ew.Form("fqueriesdelete", "delete");

// Form_CustomValidate event
fqueriesdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fqueriesdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fqueriesdelete.lists["x_topicId"] = <?php echo $queries_delete->topicId->Lookup->toClientList() ?>;
fqueriesdelete.lists["x_topicId"].options = <?php echo JsonEncode($queries_delete->topicId->lookupOptions()) ?>;
fqueriesdelete.lists["x__userId"] = <?php echo $queries_delete->_userId->Lookup->toClientList() ?>;
fqueriesdelete.lists["x__userId"].options = <?php echo JsonEncode($queries_delete->_userId->lookupOptions()) ?>;
fqueriesdelete.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $queries_delete->showPageHeader(); ?>
<?php
$queries_delete->showMessage();
?>
<form name="fqueriesdelete" id="fqueriesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($queries_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $queries_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="queries">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($queries_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($queries->queryId->Visible) { // queryId ?>
		<th class="<?php echo $queries->queryId->headerCellClass() ?>"><span id="elh_queries_queryId" class="queries_queryId"><?php echo $queries->queryId->caption() ?></span></th>
<?php } ?>
<?php if ($queries->topicId->Visible) { // topicId ?>
		<th class="<?php echo $queries->topicId->headerCellClass() ?>"><span id="elh_queries_topicId" class="queries_topicId"><?php echo $queries->topicId->caption() ?></span></th>
<?php } ?>
<?php if ($queries->_userId->Visible) { // userId ?>
		<th class="<?php echo $queries->_userId->headerCellClass() ?>"><span id="elh_queries__userId" class="queries__userId"><?php echo $queries->_userId->caption() ?></span></th>
<?php } ?>
<?php if ($queries->title->Visible) { // title ?>
		<th class="<?php echo $queries->title->headerCellClass() ?>"><span id="elh_queries_title" class="queries_title"><?php echo $queries->title->caption() ?></span></th>
<?php } ?>
<?php if ($queries->details->Visible) { // details ?>
		<th class="<?php echo $queries->details->headerCellClass() ?>"><span id="elh_queries_details" class="queries_details"><?php echo $queries->details->caption() ?></span></th>
<?php } ?>
<?php if ($queries->date->Visible) { // date ?>
		<th class="<?php echo $queries->date->headerCellClass() ?>"><span id="elh_queries_date" class="queries_date"><?php echo $queries->date->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$queries_delete->RecCnt = 0;
$i = 0;
while (!$queries_delete->Recordset->EOF) {
	$queries_delete->RecCnt++;
	$queries_delete->RowCnt++;

	// Set row properties
	$queries->resetAttributes();
	$queries->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$queries_delete->loadRowValues($queries_delete->Recordset);

	// Render row
	$queries_delete->renderRow();
?>
	<tr<?php echo $queries->rowAttributes() ?>>
<?php if ($queries->queryId->Visible) { // queryId ?>
		<td<?php echo $queries->queryId->cellAttributes() ?>>
<span id="el<?php echo $queries_delete->RowCnt ?>_queries_queryId" class="queries_queryId">
<span<?php echo $queries->queryId->viewAttributes() ?>>
<?php echo $queries->queryId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($queries->topicId->Visible) { // topicId ?>
		<td<?php echo $queries->topicId->cellAttributes() ?>>
<span id="el<?php echo $queries_delete->RowCnt ?>_queries_topicId" class="queries_topicId">
<span<?php echo $queries->topicId->viewAttributes() ?>>
<?php echo $queries->topicId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($queries->_userId->Visible) { // userId ?>
		<td<?php echo $queries->_userId->cellAttributes() ?>>
<span id="el<?php echo $queries_delete->RowCnt ?>_queries__userId" class="queries__userId">
<span<?php echo $queries->_userId->viewAttributes() ?>>
<?php echo $queries->_userId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($queries->title->Visible) { // title ?>
		<td<?php echo $queries->title->cellAttributes() ?>>
<span id="el<?php echo $queries_delete->RowCnt ?>_queries_title" class="queries_title">
<span<?php echo $queries->title->viewAttributes() ?>>
<?php echo $queries->title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($queries->details->Visible) { // details ?>
		<td<?php echo $queries->details->cellAttributes() ?>>
<span id="el<?php echo $queries_delete->RowCnt ?>_queries_details" class="queries_details">
<span<?php echo $queries->details->viewAttributes() ?>>
<?php echo $queries->details->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($queries->date->Visible) { // date ?>
		<td<?php echo $queries->date->cellAttributes() ?>>
<span id="el<?php echo $queries_delete->RowCnt ?>_queries_date" class="queries_date">
<span<?php echo $queries->date->viewAttributes() ?>>
<?php echo $queries->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$queries_delete->Recordset->moveNext();
}
$queries_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $queries_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$queries_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$queries_delete->terminate();
?>
