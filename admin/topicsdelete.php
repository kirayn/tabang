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
$topics_delete = new topics_delete();

// Run the page
$topics_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$topics_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var ftopicsdelete = currentForm = new ew.Form("ftopicsdelete", "delete");

// Form_CustomValidate event
ftopicsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
ftopicsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $topics_delete->showPageHeader(); ?>
<?php
$topics_delete->showMessage();
?>
<form name="ftopicsdelete" id="ftopicsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($topics_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $topics_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="topics">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($topics_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($topics->topicId->Visible) { // topicId ?>
		<th class="<?php echo $topics->topicId->headerCellClass() ?>"><span id="elh_topics_topicId" class="topics_topicId"><?php echo $topics->topicId->caption() ?></span></th>
<?php } ?>
<?php if ($topics->title->Visible) { // title ?>
		<th class="<?php echo $topics->title->headerCellClass() ?>"><span id="elh_topics_title" class="topics_title"><?php echo $topics->title->caption() ?></span></th>
<?php } ?>
<?php if ($topics->parentId->Visible) { // parentId ?>
		<th class="<?php echo $topics->parentId->headerCellClass() ?>"><span id="elh_topics_parentId" class="topics_parentId"><?php echo $topics->parentId->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$topics_delete->RecCnt = 0;
$i = 0;
while (!$topics_delete->Recordset->EOF) {
	$topics_delete->RecCnt++;
	$topics_delete->RowCnt++;

	// Set row properties
	$topics->resetAttributes();
	$topics->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$topics_delete->loadRowValues($topics_delete->Recordset);

	// Render row
	$topics_delete->renderRow();
?>
	<tr<?php echo $topics->rowAttributes() ?>>
<?php if ($topics->topicId->Visible) { // topicId ?>
		<td<?php echo $topics->topicId->cellAttributes() ?>>
<span id="el<?php echo $topics_delete->RowCnt ?>_topics_topicId" class="topics_topicId">
<span<?php echo $topics->topicId->viewAttributes() ?>>
<?php echo $topics->topicId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($topics->title->Visible) { // title ?>
		<td<?php echo $topics->title->cellAttributes() ?>>
<span id="el<?php echo $topics_delete->RowCnt ?>_topics_title" class="topics_title">
<span<?php echo $topics->title->viewAttributes() ?>>
<?php echo $topics->title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($topics->parentId->Visible) { // parentId ?>
		<td<?php echo $topics->parentId->cellAttributes() ?>>
<span id="el<?php echo $topics_delete->RowCnt ?>_topics_parentId" class="topics_parentId">
<span<?php echo $topics->parentId->viewAttributes() ?>>
<?php echo $topics->parentId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$topics_delete->Recordset->moveNext();
}
$topics_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $topics_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$topics_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$topics_delete->terminate();
?>
