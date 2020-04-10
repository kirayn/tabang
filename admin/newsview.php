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
$news_view = new news_view();

// Run the page
$news_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$news_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$news->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fnewsview = currentForm = new ew.Form("fnewsview", "view");

// Form_CustomValidate event
fnewsview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fnewsview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fnewsview.lists["x_type"] = <?php echo $news_view->type->Lookup->toClientList() ?>;
fnewsview.lists["x_type"].options = <?php echo JsonEncode($news_view->type->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$news->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $news_view->ExportOptions->render("body") ?>
<?php $news_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $news_view->showPageHeader(); ?>
<?php
$news_view->showMessage();
?>
<?php if (!$news_view->IsModal) { ?>
<?php if (!$news->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($news_view->Pager)) $news_view->Pager = new PrevNextPager($news_view->StartRec, $news_view->DisplayRecs, $news_view->TotalRecs, $news_view->AutoHidePager) ?>
<?php if ($news_view->Pager->RecordCount > 0 && $news_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($news_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $news_view->pageUrl() ?>start=<?php echo $news_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($news_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $news_view->pageUrl() ?>start=<?php echo $news_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $news_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($news_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $news_view->pageUrl() ?>start=<?php echo $news_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($news_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $news_view->pageUrl() ?>start=<?php echo $news_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $news_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fnewsview" id="fnewsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($news_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $news_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="news">
<input type="hidden" name="modal" value="<?php echo (int)$news_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($news->newsId->Visible) { // newsId ?>
	<tr id="r_newsId">
		<td class="<?php echo $news_view->TableLeftColumnClass ?>"><span id="elh_news_newsId"><?php echo $news->newsId->caption() ?></span></td>
		<td data-name="newsId"<?php echo $news->newsId->cellAttributes() ?>>
<span id="el_news_newsId">
<span<?php echo $news->newsId->viewAttributes() ?>>
<?php echo $news->newsId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($news->type->Visible) { // type ?>
	<tr id="r_type">
		<td class="<?php echo $news_view->TableLeftColumnClass ?>"><span id="elh_news_type"><?php echo $news->type->caption() ?></span></td>
		<td data-name="type"<?php echo $news->type->cellAttributes() ?>>
<span id="el_news_type">
<span<?php echo $news->type->viewAttributes() ?>>
<?php echo $news->type->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($news->title->Visible) { // title ?>
	<tr id="r_title">
		<td class="<?php echo $news_view->TableLeftColumnClass ?>"><span id="elh_news_title"><?php echo $news->title->caption() ?></span></td>
		<td data-name="title"<?php echo $news->title->cellAttributes() ?>>
<span id="el_news_title">
<span<?php echo $news->title->viewAttributes() ?>>
<?php echo $news->title->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($news->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $news_view->TableLeftColumnClass ?>"><span id="elh_news_description"><?php echo $news->description->caption() ?></span></td>
		<td data-name="description"<?php echo $news->description->cellAttributes() ?>>
<span id="el_news_description">
<span<?php echo $news->description->viewAttributes() ?>>
<?php echo $news->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($news->fimage->Visible) { // fimage ?>
	<tr id="r_fimage">
		<td class="<?php echo $news_view->TableLeftColumnClass ?>"><span id="elh_news_fimage"><?php echo $news->fimage->caption() ?></span></td>
		<td data-name="fimage"<?php echo $news->fimage->cellAttributes() ?>>
<span id="el_news_fimage">
<span>
<?php echo GetFileViewTag($news->fimage, $news->fimage->getViewValue()) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($news->link->Visible) { // link ?>
	<tr id="r_link">
		<td class="<?php echo $news_view->TableLeftColumnClass ?>"><span id="elh_news_link"><?php echo $news->link->caption() ?></span></td>
		<td data-name="link"<?php echo $news->link->cellAttributes() ?>>
<span id="el_news_link">
<span<?php echo $news->link->viewAttributes() ?>>
<?php echo $news->link->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($news->date->Visible) { // date ?>
	<tr id="r_date">
		<td class="<?php echo $news_view->TableLeftColumnClass ?>"><span id="elh_news_date"><?php echo $news->date->caption() ?></span></td>
		<td data-name="date"<?php echo $news->date->cellAttributes() ?>>
<span id="el_news_date">
<span<?php echo $news->date->viewAttributes() ?>>
<?php echo $news->date->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$news_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$news->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$news_view->terminate();
?>
