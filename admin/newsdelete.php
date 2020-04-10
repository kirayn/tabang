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
$news_delete = new news_delete();

// Run the page
$news_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$news_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fnewsdelete = currentForm = new ew.Form("fnewsdelete", "delete");

// Form_CustomValidate event
fnewsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fnewsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fnewsdelete.lists["x_type"] = <?php echo $news_delete->type->Lookup->toClientList() ?>;
fnewsdelete.lists["x_type"].options = <?php echo JsonEncode($news_delete->type->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $news_delete->showPageHeader(); ?>
<?php
$news_delete->showMessage();
?>
<form name="fnewsdelete" id="fnewsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($news_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $news_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="news">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($news_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($news->newsId->Visible) { // newsId ?>
		<th class="<?php echo $news->newsId->headerCellClass() ?>"><span id="elh_news_newsId" class="news_newsId"><?php echo $news->newsId->caption() ?></span></th>
<?php } ?>
<?php if ($news->type->Visible) { // type ?>
		<th class="<?php echo $news->type->headerCellClass() ?>"><span id="elh_news_type" class="news_type"><?php echo $news->type->caption() ?></span></th>
<?php } ?>
<?php if ($news->title->Visible) { // title ?>
		<th class="<?php echo $news->title->headerCellClass() ?>"><span id="elh_news_title" class="news_title"><?php echo $news->title->caption() ?></span></th>
<?php } ?>
<?php if ($news->description->Visible) { // description ?>
		<th class="<?php echo $news->description->headerCellClass() ?>"><span id="elh_news_description" class="news_description"><?php echo $news->description->caption() ?></span></th>
<?php } ?>
<?php if ($news->link->Visible) { // link ?>
		<th class="<?php echo $news->link->headerCellClass() ?>"><span id="elh_news_link" class="news_link"><?php echo $news->link->caption() ?></span></th>
<?php } ?>
<?php if ($news->date->Visible) { // date ?>
		<th class="<?php echo $news->date->headerCellClass() ?>"><span id="elh_news_date" class="news_date"><?php echo $news->date->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$news_delete->RecCnt = 0;
$i = 0;
while (!$news_delete->Recordset->EOF) {
	$news_delete->RecCnt++;
	$news_delete->RowCnt++;

	// Set row properties
	$news->resetAttributes();
	$news->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$news_delete->loadRowValues($news_delete->Recordset);

	// Render row
	$news_delete->renderRow();
?>
	<tr<?php echo $news->rowAttributes() ?>>
<?php if ($news->newsId->Visible) { // newsId ?>
		<td<?php echo $news->newsId->cellAttributes() ?>>
<span id="el<?php echo $news_delete->RowCnt ?>_news_newsId" class="news_newsId">
<span<?php echo $news->newsId->viewAttributes() ?>>
<?php echo $news->newsId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($news->type->Visible) { // type ?>
		<td<?php echo $news->type->cellAttributes() ?>>
<span id="el<?php echo $news_delete->RowCnt ?>_news_type" class="news_type">
<span<?php echo $news->type->viewAttributes() ?>>
<?php echo $news->type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($news->title->Visible) { // title ?>
		<td<?php echo $news->title->cellAttributes() ?>>
<span id="el<?php echo $news_delete->RowCnt ?>_news_title" class="news_title">
<span<?php echo $news->title->viewAttributes() ?>>
<?php echo $news->title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($news->description->Visible) { // description ?>
		<td<?php echo $news->description->cellAttributes() ?>>
<span id="el<?php echo $news_delete->RowCnt ?>_news_description" class="news_description">
<span<?php echo $news->description->viewAttributes() ?>>
<?php echo $news->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($news->link->Visible) { // link ?>
		<td<?php echo $news->link->cellAttributes() ?>>
<span id="el<?php echo $news_delete->RowCnt ?>_news_link" class="news_link">
<span<?php echo $news->link->viewAttributes() ?>>
<?php echo $news->link->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($news->date->Visible) { // date ?>
		<td<?php echo $news->date->cellAttributes() ?>>
<span id="el<?php echo $news_delete->RowCnt ?>_news_date" class="news_date">
<span<?php echo $news->date->viewAttributes() ?>>
<?php echo $news->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$news_delete->Recordset->moveNext();
}
$news_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $news_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$news_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$news_delete->terminate();
?>
