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
$queries_view = new queries_view();

// Run the page
$queries_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$queries_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$queries->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fqueriesview = currentForm = new ew.Form("fqueriesview", "view");

// Form_CustomValidate event
fqueriesview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fqueriesview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fqueriesview.lists["x_topicId"] = <?php echo $queries_view->topicId->Lookup->toClientList() ?>;
fqueriesview.lists["x_topicId"].options = <?php echo JsonEncode($queries_view->topicId->lookupOptions()) ?>;
fqueriesview.lists["x__userId"] = <?php echo $queries_view->_userId->Lookup->toClientList() ?>;
fqueriesview.lists["x__userId"].options = <?php echo JsonEncode($queries_view->_userId->lookupOptions()) ?>;
fqueriesview.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$queries->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $queries_view->ExportOptions->render("body") ?>
<?php $queries_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $queries_view->showPageHeader(); ?>
<?php
$queries_view->showMessage();
?>
<?php if (!$queries_view->IsModal) { ?>
<?php if (!$queries->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($queries_view->Pager)) $queries_view->Pager = new PrevNextPager($queries_view->StartRec, $queries_view->DisplayRecs, $queries_view->TotalRecs, $queries_view->AutoHidePager) ?>
<?php if ($queries_view->Pager->RecordCount > 0 && $queries_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($queries_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $queries_view->pageUrl() ?>start=<?php echo $queries_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($queries_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $queries_view->pageUrl() ?>start=<?php echo $queries_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $queries_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($queries_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $queries_view->pageUrl() ?>start=<?php echo $queries_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($queries_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $queries_view->pageUrl() ?>start=<?php echo $queries_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $queries_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fqueriesview" id="fqueriesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($queries_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $queries_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="queries">
<input type="hidden" name="modal" value="<?php echo (int)$queries_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($queries->queryId->Visible) { // queryId ?>
	<tr id="r_queryId">
		<td class="<?php echo $queries_view->TableLeftColumnClass ?>"><span id="elh_queries_queryId"><?php echo $queries->queryId->caption() ?></span></td>
		<td data-name="queryId"<?php echo $queries->queryId->cellAttributes() ?>>
<span id="el_queries_queryId">
<span<?php echo $queries->queryId->viewAttributes() ?>>
<?php echo $queries->queryId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($queries->topicId->Visible) { // topicId ?>
	<tr id="r_topicId">
		<td class="<?php echo $queries_view->TableLeftColumnClass ?>"><span id="elh_queries_topicId"><?php echo $queries->topicId->caption() ?></span></td>
		<td data-name="topicId"<?php echo $queries->topicId->cellAttributes() ?>>
<span id="el_queries_topicId">
<span<?php echo $queries->topicId->viewAttributes() ?>>
<?php echo $queries->topicId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($queries->_userId->Visible) { // userId ?>
	<tr id="r__userId">
		<td class="<?php echo $queries_view->TableLeftColumnClass ?>"><span id="elh_queries__userId"><?php echo $queries->_userId->caption() ?></span></td>
		<td data-name="_userId"<?php echo $queries->_userId->cellAttributes() ?>>
<span id="el_queries__userId">
<span<?php echo $queries->_userId->viewAttributes() ?>>
<?php echo $queries->_userId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($queries->title->Visible) { // title ?>
	<tr id="r_title">
		<td class="<?php echo $queries_view->TableLeftColumnClass ?>"><span id="elh_queries_title"><?php echo $queries->title->caption() ?></span></td>
		<td data-name="title"<?php echo $queries->title->cellAttributes() ?>>
<span id="el_queries_title">
<span<?php echo $queries->title->viewAttributes() ?>>
<?php echo $queries->title->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($queries->details->Visible) { // details ?>
	<tr id="r_details">
		<td class="<?php echo $queries_view->TableLeftColumnClass ?>"><span id="elh_queries_details"><?php echo $queries->details->caption() ?></span></td>
		<td data-name="details"<?php echo $queries->details->cellAttributes() ?>>
<span id="el_queries_details">
<span<?php echo $queries->details->viewAttributes() ?>>
<?php echo $queries->details->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($queries->date->Visible) { // date ?>
	<tr id="r_date">
		<td class="<?php echo $queries_view->TableLeftColumnClass ?>"><span id="elh_queries_date"><?php echo $queries->date->caption() ?></span></td>
		<td data-name="date"<?php echo $queries->date->cellAttributes() ?>>
<span id="el_queries_date">
<span<?php echo $queries->date->viewAttributes() ?>>
<?php echo $queries->date->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($queries->status->Visible) { // status ?>
	<tr id="r_status">
		<td class="<?php echo $queries_view->TableLeftColumnClass ?>"><span id="elh_queries_status"><?php echo $queries->status->caption() ?></span></td>
		<td data-name="status"<?php echo $queries->status->cellAttributes() ?>>
<span id="el_queries_status">
<span<?php echo $queries->status->viewAttributes() ?>>
<?php echo $queries->status->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$queries_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$queries->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$queries_view->terminate();
?>
