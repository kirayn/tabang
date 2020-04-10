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
$topics_view = new topics_view();

// Run the page
$topics_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$topics_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$topics->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var ftopicsview = currentForm = new ew.Form("ftopicsview", "view");

// Form_CustomValidate event
ftopicsview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
ftopicsview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$topics->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $topics_view->ExportOptions->render("body") ?>
<?php $topics_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $topics_view->showPageHeader(); ?>
<?php
$topics_view->showMessage();
?>
<?php if (!$topics_view->IsModal) { ?>
<?php if (!$topics->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($topics_view->Pager)) $topics_view->Pager = new PrevNextPager($topics_view->StartRec, $topics_view->DisplayRecs, $topics_view->TotalRecs, $topics_view->AutoHidePager) ?>
<?php if ($topics_view->Pager->RecordCount > 0 && $topics_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($topics_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $topics_view->pageUrl() ?>start=<?php echo $topics_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($topics_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $topics_view->pageUrl() ?>start=<?php echo $topics_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $topics_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($topics_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $topics_view->pageUrl() ?>start=<?php echo $topics_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($topics_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $topics_view->pageUrl() ?>start=<?php echo $topics_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $topics_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="ftopicsview" id="ftopicsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($topics_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $topics_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="topics">
<input type="hidden" name="modal" value="<?php echo (int)$topics_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($topics->topicId->Visible) { // topicId ?>
	<tr id="r_topicId">
		<td class="<?php echo $topics_view->TableLeftColumnClass ?>"><span id="elh_topics_topicId"><?php echo $topics->topicId->caption() ?></span></td>
		<td data-name="topicId"<?php echo $topics->topicId->cellAttributes() ?>>
<span id="el_topics_topicId">
<span<?php echo $topics->topicId->viewAttributes() ?>>
<?php echo $topics->topicId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($topics->title->Visible) { // title ?>
	<tr id="r_title">
		<td class="<?php echo $topics_view->TableLeftColumnClass ?>"><span id="elh_topics_title"><?php echo $topics->title->caption() ?></span></td>
		<td data-name="title"<?php echo $topics->title->cellAttributes() ?>>
<span id="el_topics_title">
<span<?php echo $topics->title->viewAttributes() ?>>
<?php echo $topics->title->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($topics->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $topics_view->TableLeftColumnClass ?>"><span id="elh_topics_description"><?php echo $topics->description->caption() ?></span></td>
		<td data-name="description"<?php echo $topics->description->cellAttributes() ?>>
<span id="el_topics_description">
<span<?php echo $topics->description->viewAttributes() ?>>
<?php echo $topics->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($topics->parentId->Visible) { // parentId ?>
	<tr id="r_parentId">
		<td class="<?php echo $topics_view->TableLeftColumnClass ?>"><span id="elh_topics_parentId"><?php echo $topics->parentId->caption() ?></span></td>
		<td data-name="parentId"<?php echo $topics->parentId->cellAttributes() ?>>
<span id="el_topics_parentId">
<span<?php echo $topics->parentId->viewAttributes() ?>>
<?php echo $topics->parentId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$topics_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$topics->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$topics_view->terminate();
?>
