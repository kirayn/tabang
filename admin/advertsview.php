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
$adverts_view = new adverts_view();

// Run the page
$adverts_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$adverts_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$adverts->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fadvertsview = currentForm = new ew.Form("fadvertsview", "view");

// Form_CustomValidate event
fadvertsview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fadvertsview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fadvertsview.lists["x__userId"] = <?php echo $adverts_view->_userId->Lookup->toClientList() ?>;
fadvertsview.lists["x__userId"].options = <?php echo JsonEncode($adverts_view->_userId->lookupOptions()) ?>;
fadvertsview.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fadvertsview.lists["x_categoryId"] = <?php echo $adverts_view->categoryId->Lookup->toClientList() ?>;
fadvertsview.lists["x_categoryId"].options = <?php echo JsonEncode($adverts_view->categoryId->lookupOptions()) ?>;
fadvertsview.lists["x_locationId"] = <?php echo $adverts_view->locationId->Lookup->toClientList() ?>;
fadvertsview.lists["x_locationId"].options = <?php echo JsonEncode($adverts_view->locationId->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$adverts->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $adverts_view->ExportOptions->render("body") ?>
<?php $adverts_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $adverts_view->showPageHeader(); ?>
<?php
$adverts_view->showMessage();
?>
<?php if (!$adverts_view->IsModal) { ?>
<?php if (!$adverts->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($adverts_view->Pager)) $adverts_view->Pager = new PrevNextPager($adverts_view->StartRec, $adverts_view->DisplayRecs, $adverts_view->TotalRecs, $adverts_view->AutoHidePager) ?>
<?php if ($adverts_view->Pager->RecordCount > 0 && $adverts_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($adverts_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $adverts_view->pageUrl() ?>start=<?php echo $adverts_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($adverts_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $adverts_view->pageUrl() ?>start=<?php echo $adverts_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $adverts_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($adverts_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $adverts_view->pageUrl() ?>start=<?php echo $adverts_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($adverts_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $adverts_view->pageUrl() ?>start=<?php echo $adverts_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $adverts_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fadvertsview" id="fadvertsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($adverts_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $adverts_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="adverts">
<input type="hidden" name="modal" value="<?php echo (int)$adverts_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($adverts->advId->Visible) { // advId ?>
	<tr id="r_advId">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_advId"><?php echo $adverts->advId->caption() ?></span></td>
		<td data-name="advId"<?php echo $adverts->advId->cellAttributes() ?>>
<span id="el_adverts_advId">
<span<?php echo $adverts->advId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->advId->getViewValue())) && $adverts->advId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->advId->linkAttributes() ?>><?php echo $adverts->advId->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->advId->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->_userId->Visible) { // userId ?>
	<tr id="r__userId">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts__userId"><?php echo $adverts->_userId->caption() ?></span></td>
		<td data-name="_userId"<?php echo $adverts->_userId->cellAttributes() ?>>
<span id="el_adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->getViewValue())) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><?php echo $adverts->_userId->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->_userId->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->title->Visible) { // title ?>
	<tr id="r_title">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_title"><?php echo $adverts->title->caption() ?></span></td>
		<td data-name="title"<?php echo $adverts->title->cellAttributes() ?>>
<span id="el_adverts_title">
<span<?php echo $adverts->title->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->title->getViewValue())) && $adverts->title->linkAttributes() <> "") { ?>
<a<?php echo $adverts->title->linkAttributes() ?>><?php echo $adverts->title->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->title->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_description"><?php echo $adverts->description->caption() ?></span></td>
		<td data-name="description"<?php echo $adverts->description->cellAttributes() ?>>
<span id="el_adverts_description">
<span<?php echo $adverts->description->viewAttributes() ?>>
<?php echo $adverts->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->categoryId->Visible) { // categoryId ?>
	<tr id="r_categoryId">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_categoryId"><?php echo $adverts->categoryId->caption() ?></span></td>
		<td data-name="categoryId"<?php echo $adverts->categoryId->cellAttributes() ?>>
<span id="el_adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<?php echo $adverts->categoryId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->locationId->Visible) { // locationId ?>
	<tr id="r_locationId">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_locationId"><?php echo $adverts->locationId->caption() ?></span></td>
		<td data-name="locationId"<?php echo $adverts->locationId->cellAttributes() ?>>
<span id="el_adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<?php echo $adverts->locationId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->validity->Visible) { // validity ?>
	<tr id="r_validity">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_validity"><?php echo $adverts->validity->caption() ?></span></td>
		<td data-name="validity"<?php echo $adverts->validity->cellAttributes() ?>>
<span id="el_adverts_validity">
<span<?php echo $adverts->validity->viewAttributes() ?>>
<?php echo $adverts->validity->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->contactPerson->Visible) { // contactPerson ?>
	<tr id="r_contactPerson">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_contactPerson"><?php echo $adverts->contactPerson->caption() ?></span></td>
		<td data-name="contactPerson"<?php echo $adverts->contactPerson->cellAttributes() ?>>
<span id="el_adverts_contactPerson">
<span<?php echo $adverts->contactPerson->viewAttributes() ?>>
<?php echo $adverts->contactPerson->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->contactNumber->Visible) { // contactNumber ?>
	<tr id="r_contactNumber">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_contactNumber"><?php echo $adverts->contactNumber->caption() ?></span></td>
		<td data-name="contactNumber"<?php echo $adverts->contactNumber->cellAttributes() ?>>
<span id="el_adverts_contactNumber">
<span<?php echo $adverts->contactNumber->viewAttributes() ?>>
<?php echo $adverts->contactNumber->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->date->Visible) { // date ?>
	<tr id="r_date">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_date"><?php echo $adverts->date->caption() ?></span></td>
		<td data-name="date"<?php echo $adverts->date->cellAttributes() ?>>
<span id="el_adverts_date">
<span<?php echo $adverts->date->viewAttributes() ?>>
<?php echo $adverts->date->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($adverts->cost->Visible) { // cost ?>
	<tr id="r_cost">
		<td class="<?php echo $adverts_view->TableLeftColumnClass ?>"><span id="elh_adverts_cost"><?php echo $adverts->cost->caption() ?></span></td>
		<td data-name="cost"<?php echo $adverts->cost->cellAttributes() ?>>
<span id="el_adverts_cost">
<span<?php echo $adverts->cost->viewAttributes() ?>>
<?php echo $adverts->cost->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("media", explode(",", $adverts->getCurrentDetailTable())) && $media->DetailView) {
?>
<?php if ($adverts->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("media", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "mediagrid.php" ?>
<?php } ?>
</form>
<?php
$adverts_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$adverts->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$adverts_view->terminate();
?>
