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
$comments_delete = new comments_delete();

// Run the page
$comments_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comments_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fcommentsdelete = currentForm = new ew.Form("fcommentsdelete", "delete");

// Form_CustomValidate event
fcommentsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcommentsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcommentsdelete.lists["x_queryId"] = <?php echo $comments_delete->queryId->Lookup->toClientList() ?>;
fcommentsdelete.lists["x_queryId"].options = <?php echo JsonEncode($comments_delete->queryId->lookupOptions()) ?>;
fcommentsdelete.autoSuggests["x_queryId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fcommentsdelete.lists["x__userId"] = <?php echo $comments_delete->_userId->Lookup->toClientList() ?>;
fcommentsdelete.lists["x__userId"].options = <?php echo JsonEncode($comments_delete->_userId->lookupOptions()) ?>;
fcommentsdelete.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $comments_delete->showPageHeader(); ?>
<?php
$comments_delete->showMessage();
?>
<form name="fcommentsdelete" id="fcommentsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($comments_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $comments_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="comments">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($comments_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($comments->commentId->Visible) { // commentId ?>
		<th class="<?php echo $comments->commentId->headerCellClass() ?>"><span id="elh_comments_commentId" class="comments_commentId"><?php echo $comments->commentId->caption() ?></span></th>
<?php } ?>
<?php if ($comments->queryId->Visible) { // queryId ?>
		<th class="<?php echo $comments->queryId->headerCellClass() ?>"><span id="elh_comments_queryId" class="comments_queryId"><?php echo $comments->queryId->caption() ?></span></th>
<?php } ?>
<?php if ($comments->_userId->Visible) { // userId ?>
		<th class="<?php echo $comments->_userId->headerCellClass() ?>"><span id="elh_comments__userId" class="comments__userId"><?php echo $comments->_userId->caption() ?></span></th>
<?php } ?>
<?php if ($comments->date->Visible) { // date ?>
		<th class="<?php echo $comments->date->headerCellClass() ?>"><span id="elh_comments_date" class="comments_date"><?php echo $comments->date->caption() ?></span></th>
<?php } ?>
<?php if ($comments->image->Visible) { // image ?>
		<th class="<?php echo $comments->image->headerCellClass() ?>"><span id="elh_comments_image" class="comments_image"><?php echo $comments->image->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$comments_delete->RecCnt = 0;
$i = 0;
while (!$comments_delete->Recordset->EOF) {
	$comments_delete->RecCnt++;
	$comments_delete->RowCnt++;

	// Set row properties
	$comments->resetAttributes();
	$comments->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$comments_delete->loadRowValues($comments_delete->Recordset);

	// Render row
	$comments_delete->renderRow();
?>
	<tr<?php echo $comments->rowAttributes() ?>>
<?php if ($comments->commentId->Visible) { // commentId ?>
		<td<?php echo $comments->commentId->cellAttributes() ?>>
<span id="el<?php echo $comments_delete->RowCnt ?>_comments_commentId" class="comments_commentId">
<span<?php echo $comments->commentId->viewAttributes() ?>>
<?php echo $comments->commentId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comments->queryId->Visible) { // queryId ?>
		<td<?php echo $comments->queryId->cellAttributes() ?>>
<span id="el<?php echo $comments_delete->RowCnt ?>_comments_queryId" class="comments_queryId">
<span<?php echo $comments->queryId->viewAttributes() ?>>
<?php echo $comments->queryId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comments->_userId->Visible) { // userId ?>
		<td<?php echo $comments->_userId->cellAttributes() ?>>
<span id="el<?php echo $comments_delete->RowCnt ?>_comments__userId" class="comments__userId">
<span<?php echo $comments->_userId->viewAttributes() ?>>
<?php echo $comments->_userId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comments->date->Visible) { // date ?>
		<td<?php echo $comments->date->cellAttributes() ?>>
<span id="el<?php echo $comments_delete->RowCnt ?>_comments_date" class="comments_date">
<span<?php echo $comments->date->viewAttributes() ?>>
<?php echo $comments->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comments->image->Visible) { // image ?>
		<td<?php echo $comments->image->cellAttributes() ?>>
<span id="el<?php echo $comments_delete->RowCnt ?>_comments_image" class="comments_image">
<span<?php echo $comments->image->viewAttributes() ?>>
<?php echo $comments->image->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$comments_delete->Recordset->moveNext();
}
$comments_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $comments_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$comments_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$comments_delete->terminate();
?>
