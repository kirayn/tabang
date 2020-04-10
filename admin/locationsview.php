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
$locations_view = new locations_view();

// Run the page
$locations_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$locations_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$locations->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var flocationsview = currentForm = new ew.Form("flocationsview", "view");

// Form_CustomValidate event
flocationsview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flocationsview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$locations->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $locations_view->ExportOptions->render("body") ?>
<?php $locations_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $locations_view->showPageHeader(); ?>
<?php
$locations_view->showMessage();
?>
<?php if (!$locations_view->IsModal) { ?>
<?php if (!$locations->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($locations_view->Pager)) $locations_view->Pager = new PrevNextPager($locations_view->StartRec, $locations_view->DisplayRecs, $locations_view->TotalRecs, $locations_view->AutoHidePager) ?>
<?php if ($locations_view->Pager->RecordCount > 0 && $locations_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($locations_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $locations_view->pageUrl() ?>start=<?php echo $locations_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($locations_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $locations_view->pageUrl() ?>start=<?php echo $locations_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $locations_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($locations_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $locations_view->pageUrl() ?>start=<?php echo $locations_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($locations_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $locations_view->pageUrl() ?>start=<?php echo $locations_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $locations_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="flocationsview" id="flocationsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($locations_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $locations_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="locations">
<input type="hidden" name="modal" value="<?php echo (int)$locations_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($locations->locationId->Visible) { // locationId ?>
	<tr id="r_locationId">
		<td class="<?php echo $locations_view->TableLeftColumnClass ?>"><span id="elh_locations_locationId"><?php echo $locations->locationId->caption() ?></span></td>
		<td data-name="locationId"<?php echo $locations->locationId->cellAttributes() ?>>
<span id="el_locations_locationId">
<span<?php echo $locations->locationId->viewAttributes() ?>>
<?php echo $locations->locationId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($locations->title->Visible) { // title ?>
	<tr id="r_title">
		<td class="<?php echo $locations_view->TableLeftColumnClass ?>"><span id="elh_locations_title"><?php echo $locations->title->caption() ?></span></td>
		<td data-name="title"<?php echo $locations->title->cellAttributes() ?>>
<span id="el_locations_title">
<span<?php echo $locations->title->viewAttributes() ?>>
<?php echo $locations->title->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($locations->pincode->Visible) { // pincode ?>
	<tr id="r_pincode">
		<td class="<?php echo $locations_view->TableLeftColumnClass ?>"><span id="elh_locations_pincode"><?php echo $locations->pincode->caption() ?></span></td>
		<td data-name="pincode"<?php echo $locations->pincode->cellAttributes() ?>>
<span id="el_locations_pincode">
<span<?php echo $locations->pincode->viewAttributes() ?>>
<?php echo $locations->pincode->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("adverts", explode(",", $locations->getCurrentDetailTable())) && $adverts->DetailView) {
?>
<?php if ($locations->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("adverts", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "advertsgrid.php" ?>
<?php } ?>
</form>
<?php
$locations_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$locations->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$locations_view->terminate();
?>
