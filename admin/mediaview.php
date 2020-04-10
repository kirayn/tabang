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
$media_view = new media_view();

// Run the page
$media_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$media_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$media->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fmediaview = currentForm = new ew.Form("fmediaview", "view");

// Form_CustomValidate event
fmediaview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fmediaview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmediaview.lists["x_advId"] = <?php echo $media_view->advId->Lookup->toClientList() ?>;
fmediaview.lists["x_advId"].options = <?php echo JsonEncode($media_view->advId->lookupOptions()) ?>;
fmediaview.autoSuggests["x_advId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$media->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $media_view->ExportOptions->render("body") ?>
<?php $media_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $media_view->showPageHeader(); ?>
<?php
$media_view->showMessage();
?>
<?php if (!$media_view->IsModal) { ?>
<?php if (!$media->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($media_view->Pager)) $media_view->Pager = new PrevNextPager($media_view->StartRec, $media_view->DisplayRecs, $media_view->TotalRecs, $media_view->AutoHidePager) ?>
<?php if ($media_view->Pager->RecordCount > 0 && $media_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($media_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $media_view->pageUrl() ?>start=<?php echo $media_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($media_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $media_view->pageUrl() ?>start=<?php echo $media_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $media_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($media_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $media_view->pageUrl() ?>start=<?php echo $media_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($media_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $media_view->pageUrl() ?>start=<?php echo $media_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $media_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fmediaview" id="fmediaview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($media_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $media_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="media">
<input type="hidden" name="modal" value="<?php echo (int)$media_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($media->mediaId->Visible) { // mediaId ?>
	<tr id="r_mediaId">
		<td class="<?php echo $media_view->TableLeftColumnClass ?>"><span id="elh_media_mediaId"><?php echo $media->mediaId->caption() ?></span></td>
		<td data-name="mediaId"<?php echo $media->mediaId->cellAttributes() ?>>
<span id="el_media_mediaId">
<span<?php echo $media->mediaId->viewAttributes() ?>>
<?php echo $media->mediaId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($media->advId->Visible) { // advId ?>
	<tr id="r_advId">
		<td class="<?php echo $media_view->TableLeftColumnClass ?>"><span id="elh_media_advId"><?php echo $media->advId->caption() ?></span></td>
		<td data-name="advId"<?php echo $media->advId->cellAttributes() ?>>
<span id="el_media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<?php echo $media->advId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($media->filename->Visible) { // filename ?>
	<tr id="r_filename">
		<td class="<?php echo $media_view->TableLeftColumnClass ?>"><span id="elh_media_filename"><?php echo $media->filename->caption() ?></span></td>
		<td data-name="filename"<?php echo $media->filename->cellAttributes() ?>>
<span id="el_media_filename">
<span>
<?php echo GetFileViewTag($media->filename, $media->filename->getViewValue()) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
	<tr id="r__thumbnail">
		<td class="<?php echo $media_view->TableLeftColumnClass ?>"><span id="elh_media__thumbnail"><?php echo $media->_thumbnail->caption() ?></span></td>
		<td data-name="_thumbnail"<?php echo $media->_thumbnail->cellAttributes() ?>>
<span id="el_media__thumbnail">
<span>
<?php echo GetFileViewTag($media->_thumbnail, $media->_thumbnail->getViewValue()) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$media_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$media->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$media_view->terminate();
?>
