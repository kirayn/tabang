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
$comments_view = new comments_view();

// Run the page
$comments_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comments_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$comments->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fcommentsview = currentForm = new ew.Form("fcommentsview", "view");

// Form_CustomValidate event
fcommentsview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcommentsview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcommentsview.lists["x_queryId"] = <?php echo $comments_view->queryId->Lookup->toClientList() ?>;
fcommentsview.lists["x_queryId"].options = <?php echo JsonEncode($comments_view->queryId->lookupOptions()) ?>;
fcommentsview.autoSuggests["x_queryId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fcommentsview.lists["x__userId"] = <?php echo $comments_view->_userId->Lookup->toClientList() ?>;
fcommentsview.lists["x__userId"].options = <?php echo JsonEncode($comments_view->_userId->lookupOptions()) ?>;
fcommentsview.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$comments->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $comments_view->ExportOptions->render("body") ?>
<?php $comments_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $comments_view->showPageHeader(); ?>
<?php
$comments_view->showMessage();
?>
<?php if (!$comments_view->IsModal) { ?>
<?php if (!$comments->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($comments_view->Pager)) $comments_view->Pager = new PrevNextPager($comments_view->StartRec, $comments_view->DisplayRecs, $comments_view->TotalRecs, $comments_view->AutoHidePager) ?>
<?php if ($comments_view->Pager->RecordCount > 0 && $comments_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($comments_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $comments_view->pageUrl() ?>start=<?php echo $comments_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($comments_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $comments_view->pageUrl() ?>start=<?php echo $comments_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $comments_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($comments_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $comments_view->pageUrl() ?>start=<?php echo $comments_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($comments_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $comments_view->pageUrl() ?>start=<?php echo $comments_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $comments_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fcommentsview" id="fcommentsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($comments_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $comments_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="comments">
<input type="hidden" name="modal" value="<?php echo (int)$comments_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($comments->commentId->Visible) { // commentId ?>
	<tr id="r_commentId">
		<td class="<?php echo $comments_view->TableLeftColumnClass ?>"><span id="elh_comments_commentId"><?php echo $comments->commentId->caption() ?></span></td>
		<td data-name="commentId"<?php echo $comments->commentId->cellAttributes() ?>>
<span id="el_comments_commentId">
<span<?php echo $comments->commentId->viewAttributes() ?>>
<?php echo $comments->commentId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comments->queryId->Visible) { // queryId ?>
	<tr id="r_queryId">
		<td class="<?php echo $comments_view->TableLeftColumnClass ?>"><span id="elh_comments_queryId"><?php echo $comments->queryId->caption() ?></span></td>
		<td data-name="queryId"<?php echo $comments->queryId->cellAttributes() ?>>
<span id="el_comments_queryId">
<span<?php echo $comments->queryId->viewAttributes() ?>>
<?php echo $comments->queryId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comments->_userId->Visible) { // userId ?>
	<tr id="r__userId">
		<td class="<?php echo $comments_view->TableLeftColumnClass ?>"><span id="elh_comments__userId"><?php echo $comments->_userId->caption() ?></span></td>
		<td data-name="_userId"<?php echo $comments->_userId->cellAttributes() ?>>
<span id="el_comments__userId">
<span<?php echo $comments->_userId->viewAttributes() ?>>
<?php echo $comments->_userId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comments->details->Visible) { // details ?>
	<tr id="r_details">
		<td class="<?php echo $comments_view->TableLeftColumnClass ?>"><span id="elh_comments_details"><?php echo $comments->details->caption() ?></span></td>
		<td data-name="details"<?php echo $comments->details->cellAttributes() ?>>
<span id="el_comments_details">
<span<?php echo $comments->details->viewAttributes() ?>>
<?php echo $comments->details->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comments->date->Visible) { // date ?>
	<tr id="r_date">
		<td class="<?php echo $comments_view->TableLeftColumnClass ?>"><span id="elh_comments_date"><?php echo $comments->date->caption() ?></span></td>
		<td data-name="date"<?php echo $comments->date->cellAttributes() ?>>
<span id="el_comments_date">
<span<?php echo $comments->date->viewAttributes() ?>>
<?php echo $comments->date->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($comments->image->Visible) { // image ?>
	<tr id="r_image">
		<td class="<?php echo $comments_view->TableLeftColumnClass ?>"><span id="elh_comments_image"><?php echo $comments->image->caption() ?></span></td>
		<td data-name="image"<?php echo $comments->image->cellAttributes() ?>>
<span id="el_comments_image">
<span<?php echo $comments->image->viewAttributes() ?>>
<?php echo $comments->image->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$comments_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$comments->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$comments_view->terminate();
?>
