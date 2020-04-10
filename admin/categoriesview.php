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
$categories_view = new categories_view();

// Run the page
$categories_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$categories_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$categories->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fcategoriesview = currentForm = new ew.Form("fcategoriesview", "view");

// Form_CustomValidate event
fcategoriesview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcategoriesview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcategoriesview.lists["x_parentId"] = <?php echo $categories_view->parentId->Lookup->toClientList() ?>;
fcategoriesview.lists["x_parentId"].options = <?php echo JsonEncode($categories_view->parentId->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$categories->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $categories_view->ExportOptions->render("body") ?>
<?php $categories_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $categories_view->showPageHeader(); ?>
<?php
$categories_view->showMessage();
?>
<?php if (!$categories_view->IsModal) { ?>
<?php if (!$categories->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($categories_view->Pager)) $categories_view->Pager = new PrevNextPager($categories_view->StartRec, $categories_view->DisplayRecs, $categories_view->TotalRecs, $categories_view->AutoHidePager) ?>
<?php if ($categories_view->Pager->RecordCount > 0 && $categories_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($categories_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $categories_view->pageUrl() ?>start=<?php echo $categories_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($categories_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $categories_view->pageUrl() ?>start=<?php echo $categories_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $categories_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($categories_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $categories_view->pageUrl() ?>start=<?php echo $categories_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($categories_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $categories_view->pageUrl() ?>start=<?php echo $categories_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $categories_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fcategoriesview" id="fcategoriesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($categories_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $categories_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="categories">
<input type="hidden" name="modal" value="<?php echo (int)$categories_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($categories->categoryId->Visible) { // categoryId ?>
	<tr id="r_categoryId">
		<td class="<?php echo $categories_view->TableLeftColumnClass ?>"><span id="elh_categories_categoryId"><?php echo $categories->categoryId->caption() ?></span></td>
		<td data-name="categoryId"<?php echo $categories->categoryId->cellAttributes() ?>>
<span id="el_categories_categoryId">
<span<?php echo $categories->categoryId->viewAttributes() ?>>
<?php echo $categories->categoryId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($categories->name->Visible) { // name ?>
	<tr id="r_name">
		<td class="<?php echo $categories_view->TableLeftColumnClass ?>"><span id="elh_categories_name"><?php echo $categories->name->caption() ?></span></td>
		<td data-name="name"<?php echo $categories->name->cellAttributes() ?>>
<span id="el_categories_name">
<span<?php echo $categories->name->viewAttributes() ?>>
<?php echo $categories->name->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($categories->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $categories_view->TableLeftColumnClass ?>"><span id="elh_categories_description"><?php echo $categories->description->caption() ?></span></td>
		<td data-name="description"<?php echo $categories->description->cellAttributes() ?>>
<span id="el_categories_description">
<span<?php echo $categories->description->viewAttributes() ?>>
<?php echo $categories->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($categories->parentId->Visible) { // parentId ?>
	<tr id="r_parentId">
		<td class="<?php echo $categories_view->TableLeftColumnClass ?>"><span id="elh_categories_parentId"><?php echo $categories->parentId->caption() ?></span></td>
		<td data-name="parentId"<?php echo $categories->parentId->cellAttributes() ?>>
<span id="el_categories_parentId">
<span<?php echo $categories->parentId->viewAttributes() ?>>
<?php echo $categories->parentId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($categories->image->Visible) { // image ?>
	<tr id="r_image">
		<td class="<?php echo $categories_view->TableLeftColumnClass ?>"><span id="elh_categories_image"><?php echo $categories->image->caption() ?></span></td>
		<td data-name="image"<?php echo $categories->image->cellAttributes() ?>>
<span id="el_categories_image">
<span>
<?php echo GetFileViewTag($categories->image, $categories->image->getViewValue()) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("adverts", explode(",", $categories->getCurrentDetailTable())) && $adverts->DetailView) {
?>
<?php if ($categories->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("adverts", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "advertsgrid.php" ?>
<?php } ?>
</form>
<?php
$categories_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$categories->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$categories_view->terminate();
?>
