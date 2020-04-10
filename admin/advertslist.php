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
$adverts_list = new adverts_list();

// Run the page
$adverts_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$adverts_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$adverts->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fadvertslist = currentForm = new ew.Form("fadvertslist", "list");
fadvertslist.formKeyCountName = '<?php echo $adverts_list->FormKeyCountName ?>';

// Validate form
fadvertslist.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
	if ($fobj.find("#confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.emptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
		<?php if ($adverts_list->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->_userId->caption(), $adverts->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($adverts->_userId->errorMessage()) ?>");
		<?php if ($adverts_list->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->title->caption(), $adverts->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_list->description->Required) { ?>
			elm = this.getElements("x" + infix + "_description");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->description->caption(), $adverts->description->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_list->categoryId->Required) { ?>
			elm = this.getElements("x" + infix + "_categoryId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->categoryId->caption(), $adverts->categoryId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_list->locationId->Required) { ?>
			elm = this.getElements("x" + infix + "_locationId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->locationId->caption(), $adverts->locationId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_list->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->date->caption(), $adverts->date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($adverts->date->errorMessage()) ?>");
		<?php if ($adverts_list->cost->Required) { ?>
			elm = this.getElements("x" + infix + "_cost");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->cost->caption(), $adverts->cost->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew.alert(ew.language.phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fadvertslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "_userId", false)) return false;
	if (ew.valueChanged(fobj, infix, "title", false)) return false;
	if (ew.valueChanged(fobj, infix, "description", false)) return false;
	if (ew.valueChanged(fobj, infix, "categoryId", false)) return false;
	if (ew.valueChanged(fobj, infix, "locationId", false)) return false;
	if (ew.valueChanged(fobj, infix, "date", false)) return false;
	if (ew.valueChanged(fobj, infix, "cost", false)) return false;
	return true;
}

// Form_CustomValidate event
fadvertslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fadvertslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fadvertslist.lists["x__userId"] = <?php echo $adverts_list->_userId->Lookup->toClientList() ?>;
fadvertslist.lists["x__userId"].options = <?php echo JsonEncode($adverts_list->_userId->lookupOptions()) ?>;
fadvertslist.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fadvertslist.lists["x_categoryId"] = <?php echo $adverts_list->categoryId->Lookup->toClientList() ?>;
fadvertslist.lists["x_categoryId"].options = <?php echo JsonEncode($adverts_list->categoryId->lookupOptions()) ?>;
fadvertslist.lists["x_locationId"] = <?php echo $adverts_list->locationId->Lookup->toClientList() ?>;
fadvertslist.lists["x_locationId"].options = <?php echo JsonEncode($adverts_list->locationId->lookupOptions()) ?>;

// Form object for search
var fadvertslistsrch = currentSearchForm = new ew.Form("fadvertslistsrch");

// Filters
fadvertslistsrch.filterList = <?php echo $adverts_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$adverts->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($adverts_list->TotalRecs > 0 && $adverts_list->ExportOptions->visible()) { ?>
<?php $adverts_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($adverts_list->ImportOptions->visible()) { ?>
<?php $adverts_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($adverts_list->SearchOptions->visible()) { ?>
<?php $adverts_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($adverts_list->FilterOptions->visible()) { ?>
<?php $adverts_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$adverts->isExport() || EXPORT_MASTER_RECORD && $adverts->isExport("print")) { ?>
<?php
if ($adverts_list->DbMasterFilter <> "" && $adverts->getCurrentMasterTable() == "categories") {
	if ($adverts_list->MasterRecordExists) {
		include_once "categoriesmaster.php";
	}
}
?>
<?php
if ($adverts_list->DbMasterFilter <> "" && $adverts->getCurrentMasterTable() == "locations") {
	if ($adverts_list->MasterRecordExists) {
		include_once "locationsmaster.php";
	}
}
?>
<?php
if ($adverts_list->DbMasterFilter <> "" && $adverts->getCurrentMasterTable() == "users") {
	if ($adverts_list->MasterRecordExists) {
		include_once "usersmaster.php";
	}
}
?>
<?php } ?>
<?php
$adverts_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$adverts->isExport() && !$adverts->CurrentAction) { ?>
<form name="fadvertslistsrch" id="fadvertslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($adverts_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fadvertslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="adverts">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($adverts_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($adverts_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $adverts_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($adverts_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($adverts_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($adverts_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($adverts_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $adverts_list->showPageHeader(); ?>
<?php
$adverts_list->showMessage();
?>
<?php if ($adverts_list->TotalRecs > 0 || $adverts->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($adverts_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> adverts">
<?php if (!$adverts->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$adverts->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($adverts_list->Pager)) $adverts_list->Pager = new PrevNextPager($adverts_list->StartRec, $adverts_list->DisplayRecs, $adverts_list->TotalRecs, $adverts_list->AutoHidePager) ?>
<?php if ($adverts_list->Pager->RecordCount > 0 && $adverts_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($adverts_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $adverts_list->pageUrl() ?>start=<?php echo $adverts_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($adverts_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $adverts_list->pageUrl() ?>start=<?php echo $adverts_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $adverts_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($adverts_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $adverts_list->pageUrl() ?>start=<?php echo $adverts_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($adverts_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $adverts_list->pageUrl() ?>start=<?php echo $adverts_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $adverts_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($adverts_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $adverts_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $adverts_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $adverts_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $adverts_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fadvertslist" id="fadvertslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($adverts_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $adverts_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="adverts">
<?php if ($adverts->getCurrentMasterTable() == "categories" && $adverts->CurrentAction) { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="categories">
<input type="hidden" name="fk_categoryId" value="<?php echo $adverts->categoryId->getSessionValue() ?>">
<?php } ?>
<?php if ($adverts->getCurrentMasterTable() == "locations" && $adverts->CurrentAction) { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="locations">
<input type="hidden" name="fk_locationId" value="<?php echo $adverts->locationId->getSessionValue() ?>">
<?php } ?>
<?php if ($adverts->getCurrentMasterTable() == "users" && $adverts->CurrentAction) { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="users">
<input type="hidden" name="fk_ID" value="<?php echo $adverts->_userId->getSessionValue() ?>">
<?php } ?>
<div id="gmp_adverts" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($adverts_list->TotalRecs > 0 || $adverts->isGridEdit()) { ?>
<table id="tbl_advertslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$adverts_list->RowType = ROWTYPE_HEADER;

// Render list options
$adverts_list->renderListOptions();

// Render list options (header, left)
$adverts_list->ListOptions->render("header", "left");
?>
<?php if ($adverts->_userId->Visible) { // userId ?>
	<?php if ($adverts->sortUrl($adverts->_userId) == "") { ?>
		<th data-name="_userId" class="<?php echo $adverts->_userId->headerCellClass() ?>"><div id="elh_adverts__userId" class="adverts__userId"><div class="ew-table-header-caption"><?php echo $adverts->_userId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_userId" class="<?php echo $adverts->_userId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $adverts->SortUrl($adverts->_userId) ?>',1);"><div id="elh_adverts__userId" class="adverts__userId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->_userId->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->_userId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->_userId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->title->Visible) { // title ?>
	<?php if ($adverts->sortUrl($adverts->title) == "") { ?>
		<th data-name="title" class="<?php echo $adverts->title->headerCellClass() ?>"><div id="elh_adverts_title" class="adverts_title"><div class="ew-table-header-caption"><?php echo $adverts->title->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $adverts->title->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $adverts->SortUrl($adverts->title) ?>',1);"><div id="elh_adverts_title" class="adverts_title">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->title->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($adverts->title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->description->Visible) { // description ?>
	<?php if ($adverts->sortUrl($adverts->description) == "") { ?>
		<th data-name="description" class="<?php echo $adverts->description->headerCellClass() ?>"><div id="elh_adverts_description" class="adverts_description"><div class="ew-table-header-caption"><?php echo $adverts->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $adverts->description->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $adverts->SortUrl($adverts->description) ?>',1);"><div id="elh_adverts_description" class="adverts_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->description->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($adverts->description->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->description->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->categoryId->Visible) { // categoryId ?>
	<?php if ($adverts->sortUrl($adverts->categoryId) == "") { ?>
		<th data-name="categoryId" class="<?php echo $adverts->categoryId->headerCellClass() ?>"><div id="elh_adverts_categoryId" class="adverts_categoryId"><div class="ew-table-header-caption"><?php echo $adverts->categoryId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="categoryId" class="<?php echo $adverts->categoryId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $adverts->SortUrl($adverts->categoryId) ?>',1);"><div id="elh_adverts_categoryId" class="adverts_categoryId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->categoryId->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->categoryId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->categoryId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->locationId->Visible) { // locationId ?>
	<?php if ($adverts->sortUrl($adverts->locationId) == "") { ?>
		<th data-name="locationId" class="<?php echo $adverts->locationId->headerCellClass() ?>"><div id="elh_adverts_locationId" class="adverts_locationId"><div class="ew-table-header-caption"><?php echo $adverts->locationId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="locationId" class="<?php echo $adverts->locationId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $adverts->SortUrl($adverts->locationId) ?>',1);"><div id="elh_adverts_locationId" class="adverts_locationId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->locationId->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->locationId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->locationId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->date->Visible) { // date ?>
	<?php if ($adverts->sortUrl($adverts->date) == "") { ?>
		<th data-name="date" class="<?php echo $adverts->date->headerCellClass() ?>"><div id="elh_adverts_date" class="adverts_date"><div class="ew-table-header-caption"><?php echo $adverts->date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $adverts->date->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $adverts->SortUrl($adverts->date) ?>',1);"><div id="elh_adverts_date" class="adverts_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->date->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->cost->Visible) { // cost ?>
	<?php if ($adverts->sortUrl($adverts->cost) == "") { ?>
		<th data-name="cost" class="<?php echo $adverts->cost->headerCellClass() ?>"><div id="elh_adverts_cost" class="adverts_cost"><div class="ew-table-header-caption"><?php echo $adverts->cost->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cost" class="<?php echo $adverts->cost->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $adverts->SortUrl($adverts->cost) ?>',1);"><div id="elh_adverts_cost" class="adverts_cost">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->cost->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($adverts->cost->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->cost->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$adverts_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($adverts->ExportAll && $adverts->isExport()) {
	$adverts_list->StopRec = $adverts_list->TotalRecs;
} else {

	// Set the last record to display
	if ($adverts_list->TotalRecs > $adverts_list->StartRec + $adverts_list->DisplayRecs - 1)
		$adverts_list->StopRec = $adverts_list->StartRec + $adverts_list->DisplayRecs - 1;
	else
		$adverts_list->StopRec = $adverts_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $adverts_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($adverts_list->FormKeyCountName) && ($adverts->isGridAdd() || $adverts->isGridEdit() || $adverts->isConfirm())) {
		$adverts_list->KeyCount = $CurrentForm->getValue($adverts_list->FormKeyCountName);
		$adverts_list->StopRec = $adverts_list->StartRec + $adverts_list->KeyCount - 1;
	}
}
$adverts_list->RecCnt = $adverts_list->StartRec - 1;
if ($adverts_list->Recordset && !$adverts_list->Recordset->EOF) {
	$adverts_list->Recordset->moveFirst();
	$selectLimit = $adverts_list->UseSelectLimit;
	if (!$selectLimit && $adverts_list->StartRec > 1)
		$adverts_list->Recordset->move($adverts_list->StartRec - 1);
} elseif (!$adverts->AllowAddDeleteRow && $adverts_list->StopRec == 0) {
	$adverts_list->StopRec = $adverts->GridAddRowCount;
}

// Initialize aggregate
$adverts->RowType = ROWTYPE_AGGREGATEINIT;
$adverts->resetAttributes();
$adverts_list->renderRow();
$adverts_list->EditRowCnt = 0;
if ($adverts->isEdit())
	$adverts_list->RowIndex = 1;
if ($adverts->isGridAdd())
	$adverts_list->RowIndex = 0;
while ($adverts_list->RecCnt < $adverts_list->StopRec) {
	$adverts_list->RecCnt++;
	if ($adverts_list->RecCnt >= $adverts_list->StartRec) {
		$adverts_list->RowCnt++;
		if ($adverts->isGridAdd() || $adverts->isGridEdit() || $adverts->isConfirm()) {
			$adverts_list->RowIndex++;
			$CurrentForm->Index = $adverts_list->RowIndex;
			if ($CurrentForm->hasValue($adverts_list->FormActionName) && $adverts_list->EventCancelled)
				$adverts_list->RowAction = strval($CurrentForm->getValue($adverts_list->FormActionName));
			elseif ($adverts->isGridAdd())
				$adverts_list->RowAction = "insert";
			else
				$adverts_list->RowAction = "";
		}

		// Set up key count
		$adverts_list->KeyCount = $adverts_list->RowIndex;

		// Init row class and style
		$adverts->resetAttributes();
		$adverts->CssClass = "";
		if ($adverts->isGridAdd()) {
			$adverts_list->loadRowValues(); // Load default values
		} else {
			$adverts_list->loadRowValues($adverts_list->Recordset); // Load row values
		}
		$adverts->RowType = ROWTYPE_VIEW; // Render view
		if ($adverts->isGridAdd()) // Grid add
			$adverts->RowType = ROWTYPE_ADD; // Render add
		if ($adverts->isGridAdd() && $adverts->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$adverts_list->restoreCurrentRowFormValues($adverts_list->RowIndex); // Restore form values
		if ($adverts->isEdit()) {
			if ($adverts_list->checkInlineEditKey() && $adverts_list->EditRowCnt == 0) { // Inline edit
				$adverts->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($adverts->isEdit() && $adverts->RowType == ROWTYPE_EDIT && $adverts->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$adverts_list->restoreFormValues(); // Restore form values
		}
		if ($adverts->RowType == ROWTYPE_EDIT) // Edit row
			$adverts_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$adverts->RowAttrs = array_merge($adverts->RowAttrs, array('data-rowindex'=>$adverts_list->RowCnt, 'id'=>'r' . $adverts_list->RowCnt . '_adverts', 'data-rowtype'=>$adverts->RowType));

		// Render row
		$adverts_list->renderRow();

		// Render list options
		$adverts_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($adverts_list->RowAction <> "delete" && $adverts_list->RowAction <> "insertdelete" && !($adverts_list->RowAction == "insert" && $adverts->isConfirm() && $adverts_list->emptyRow())) {
?>
	<tr<?php echo $adverts->rowAttributes() ?>>
<?php

// Render list options (body, left)
$adverts_list->ListOptions->render("body", "left", $adverts_list->RowCnt);
?>
	<?php if ($adverts->_userId->Visible) { // userId ?>
		<td data-name="_userId"<?php echo $adverts->_userId->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($adverts->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->ViewValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>__userId" name="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$adverts->userIDAllow($adverts->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->EditValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_list->RowIndex ?>__userId" id="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<?php
$wrkonchange = "" . trim(@$adverts->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$adverts->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $adverts_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $adverts_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $adverts_list->RowIndex ?>__userId" id="sv_x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>"<?php echo $adverts->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" data-value-separator="<?php echo $adverts->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_list->RowIndex ?>__userId" id="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fadvertslist.createAutoSuggest({"id":"x<?php echo $adverts_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $adverts->_userId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x__userId" name="o<?php echo $adverts_list->RowIndex ?>__userId" id="o<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($adverts->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->ViewValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>__userId" name="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$adverts->userIDAllow($adverts->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->EditValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_list->RowIndex ?>__userId" id="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<?php
$wrkonchange = "" . trim(@$adverts->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$adverts->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $adverts_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $adverts_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $adverts_list->RowIndex ?>__userId" id="sv_x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>"<?php echo $adverts->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" data-value-separator="<?php echo $adverts->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_list->RowIndex ?>__userId" id="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fadvertslist.createAutoSuggest({"id":"x<?php echo $adverts_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $adverts->_userId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts__userId" class="adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->getViewValue())) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><?php echo $adverts->_userId->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->_userId->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="adverts" data-field="x_advId" name="x<?php echo $adverts_list->RowIndex ?>_advId" id="x<?php echo $adverts_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($adverts->advId->CurrentValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_advId" name="o<?php echo $adverts_list->RowIndex ?>_advId" id="o<?php echo $adverts_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($adverts->advId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT || $adverts->CurrentMode == "edit") { ?>
<input type="hidden" data-table="adverts" data-field="x_advId" name="x<?php echo $adverts_list->RowIndex ?>_advId" id="x<?php echo $adverts_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($adverts->advId->CurrentValue) ?>">
<?php } ?>
	<?php if ($adverts->title->Visible) { // title ?>
		<td data-name="title"<?php echo $adverts->title->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_title" class="form-group adverts_title">
<input type="text" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_list->RowIndex ?>_title" id="x<?php echo $adverts_list->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($adverts->title->getPlaceHolder()) ?>" value="<?php echo $adverts->title->EditValue ?>"<?php echo $adverts->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_title" name="o<?php echo $adverts_list->RowIndex ?>_title" id="o<?php echo $adverts_list->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_title" class="form-group adverts_title">
<input type="text" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_list->RowIndex ?>_title" id="x<?php echo $adverts_list->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($adverts->title->getPlaceHolder()) ?>" value="<?php echo $adverts->title->EditValue ?>"<?php echo $adverts->title->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_title" class="adverts_title">
<span<?php echo $adverts->title->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->title->getViewValue())) && $adverts->title->linkAttributes() <> "") { ?>
<a<?php echo $adverts->title->linkAttributes() ?>><?php echo $adverts->title->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->title->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->description->Visible) { // description ?>
		<td data-name="description"<?php echo $adverts->description->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_description" class="form-group adverts_description">
<textarea data-table="adverts" data-field="x_description" name="x<?php echo $adverts_list->RowIndex ?>_description" id="x<?php echo $adverts_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($adverts->description->getPlaceHolder()) ?>"<?php echo $adverts->description->editAttributes() ?>><?php echo $adverts->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="adverts" data-field="x_description" name="o<?php echo $adverts_list->RowIndex ?>_description" id="o<?php echo $adverts_list->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_description" class="form-group adverts_description">
<textarea data-table="adverts" data-field="x_description" name="x<?php echo $adverts_list->RowIndex ?>_description" id="x<?php echo $adverts_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($adverts->description->getPlaceHolder()) ?>"<?php echo $adverts->description->editAttributes() ?>><?php echo $adverts->description->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_description" class="adverts_description">
<span<?php echo $adverts->description->viewAttributes() ?>>
<?php echo $adverts->description->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->categoryId->Visible) { // categoryId ?>
		<td data-name="categoryId"<?php echo $adverts->categoryId->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($adverts->categoryId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>_categoryId" name="x<?php echo $adverts_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="adverts" data-field="x_categoryId" data-value-separator="<?php echo $adverts->categoryId->displayValueSeparatorAttribute() ?>" id="x<?php echo $adverts_list->RowIndex ?>_categoryId" name="x<?php echo $adverts_list->RowIndex ?>_categoryId"<?php echo $adverts->categoryId->editAttributes() ?>>
		<?php echo $adverts->categoryId->selectOptionListHtml("x<?php echo $adverts_list->RowIndex ?>_categoryId") ?>
	</select>
</div>
<?php echo $adverts->categoryId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "_categoryId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="o<?php echo $adverts_list->RowIndex ?>_categoryId" id="o<?php echo $adverts_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($adverts->categoryId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>_categoryId" name="x<?php echo $adverts_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="adverts" data-field="x_categoryId" data-value-separator="<?php echo $adverts->categoryId->displayValueSeparatorAttribute() ?>" id="x<?php echo $adverts_list->RowIndex ?>_categoryId" name="x<?php echo $adverts_list->RowIndex ?>_categoryId"<?php echo $adverts->categoryId->editAttributes() ?>>
		<?php echo $adverts->categoryId->selectOptionListHtml("x<?php echo $adverts_list->RowIndex ?>_categoryId") ?>
	</select>
</div>
<?php echo $adverts->categoryId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "_categoryId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_categoryId" class="adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<?php echo $adverts->categoryId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->locationId->Visible) { // locationId ?>
		<td data-name="locationId"<?php echo $adverts->locationId->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($adverts->locationId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>_locationId" name="x<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $adverts_list->RowIndex ?>_locationId"><?php echo strval($adverts->locationId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $adverts->locationId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($adverts->locationId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($adverts->locationId->ReadOnly || $adverts->locationId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $adverts_list->RowIndex ?>_locationId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $adverts->locationId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "_locationId") ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $adverts->locationId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_list->RowIndex ?>_locationId" id="x<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo $adverts->locationId->CurrentValue ?>"<?php echo $adverts->locationId->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" name="o<?php echo $adverts_list->RowIndex ?>_locationId" id="o<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($adverts->locationId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>_locationId" name="x<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $adverts_list->RowIndex ?>_locationId"><?php echo strval($adverts->locationId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $adverts->locationId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($adverts->locationId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($adverts->locationId->ReadOnly || $adverts->locationId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $adverts_list->RowIndex ?>_locationId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $adverts->locationId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "_locationId") ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $adverts->locationId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_list->RowIndex ?>_locationId" id="x<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo $adverts->locationId->CurrentValue ?>"<?php echo $adverts->locationId->editAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_locationId" class="adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<?php echo $adverts->locationId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->date->Visible) { // date ?>
		<td data-name="date"<?php echo $adverts->date->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_date" class="form-group adverts_date">
<input type="text" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_list->RowIndex ?>_date" id="x<?php echo $adverts_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($adverts->date->getPlaceHolder()) ?>" value="<?php echo $adverts->date->EditValue ?>"<?php echo $adverts->date->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_date" name="o<?php echo $adverts_list->RowIndex ?>_date" id="o<?php echo $adverts_list->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_date" class="form-group adverts_date">
<input type="text" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_list->RowIndex ?>_date" id="x<?php echo $adverts_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($adverts->date->getPlaceHolder()) ?>" value="<?php echo $adverts->date->EditValue ?>"<?php echo $adverts->date->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_date" class="adverts_date">
<span<?php echo $adverts->date->viewAttributes() ?>>
<?php echo $adverts->date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->cost->Visible) { // cost ?>
		<td data-name="cost"<?php echo $adverts->cost->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_cost" class="form-group adverts_cost">
<input type="text" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_list->RowIndex ?>_cost" id="x<?php echo $adverts_list->RowIndex ?>_cost" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($adverts->cost->getPlaceHolder()) ?>" value="<?php echo $adverts->cost->EditValue ?>"<?php echo $adverts->cost->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_cost" name="o<?php echo $adverts_list->RowIndex ?>_cost" id="o<?php echo $adverts_list->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_cost" class="form-group adverts_cost">
<input type="text" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_list->RowIndex ?>_cost" id="x<?php echo $adverts_list->RowIndex ?>_cost" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($adverts->cost->getPlaceHolder()) ?>" value="<?php echo $adverts->cost->EditValue ?>"<?php echo $adverts->cost->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_list->RowCnt ?>_adverts_cost" class="adverts_cost">
<span<?php echo $adverts->cost->viewAttributes() ?>>
<?php echo $adverts->cost->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$adverts_list->ListOptions->render("body", "right", $adverts_list->RowCnt);
?>
	</tr>
<?php if ($adverts->RowType == ROWTYPE_ADD || $adverts->RowType == ROWTYPE_EDIT) { ?>
<script>
fadvertslist.updateLists(<?php echo $adverts_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$adverts->isGridAdd())
		if (!$adverts_list->Recordset->EOF)
			$adverts_list->Recordset->moveNext();
}
?>
<?php
	if ($adverts->isGridAdd() || $adverts->isGridEdit()) {
		$adverts_list->RowIndex = '$rowindex$';
		$adverts_list->loadRowValues();

		// Set row properties
		$adverts->resetAttributes();
		$adverts->RowAttrs = array_merge($adverts->RowAttrs, array('data-rowindex'=>$adverts_list->RowIndex, 'id'=>'r0_adverts', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($adverts->RowAttrs["class"], "ew-template");
		$adverts->RowType = ROWTYPE_ADD;

		// Render row
		$adverts_list->renderRow();

		// Render list options
		$adverts_list->renderListOptions();
		$adverts_list->StartRowCnt = 0;
?>
	<tr<?php echo $adverts->rowAttributes() ?>>
<?php

// Render list options (body, left)
$adverts_list->ListOptions->render("body", "left", $adverts_list->RowIndex);
?>
	<?php if ($adverts->_userId->Visible) { // userId ?>
		<td data-name="_userId">
<?php if ($adverts->_userId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->ViewValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>__userId" name="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$adverts->userIDAllow($adverts->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->EditValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_list->RowIndex ?>__userId" id="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_adverts__userId" class="form-group adverts__userId">
<?php
$wrkonchange = "" . trim(@$adverts->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$adverts->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $adverts_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $adverts_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $adverts_list->RowIndex ?>__userId" id="sv_x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>"<?php echo $adverts->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" data-value-separator="<?php echo $adverts->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_list->RowIndex ?>__userId" id="x<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fadvertslist.createAutoSuggest({"id":"x<?php echo $adverts_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $adverts->_userId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x__userId" name="o<?php echo $adverts_list->RowIndex ?>__userId" id="o<?php echo $adverts_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->title->Visible) { // title ?>
		<td data-name="title">
<span id="el$rowindex$_adverts_title" class="form-group adverts_title">
<input type="text" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_list->RowIndex ?>_title" id="x<?php echo $adverts_list->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($adverts->title->getPlaceHolder()) ?>" value="<?php echo $adverts->title->EditValue ?>"<?php echo $adverts->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_title" name="o<?php echo $adverts_list->RowIndex ?>_title" id="o<?php echo $adverts_list->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->description->Visible) { // description ?>
		<td data-name="description">
<span id="el$rowindex$_adverts_description" class="form-group adverts_description">
<textarea data-table="adverts" data-field="x_description" name="x<?php echo $adverts_list->RowIndex ?>_description" id="x<?php echo $adverts_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($adverts->description->getPlaceHolder()) ?>"<?php echo $adverts->description->editAttributes() ?>><?php echo $adverts->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="adverts" data-field="x_description" name="o<?php echo $adverts_list->RowIndex ?>_description" id="o<?php echo $adverts_list->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->categoryId->Visible) { // categoryId ?>
		<td data-name="categoryId">
<?php if ($adverts->categoryId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_adverts_categoryId" class="form-group adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>_categoryId" name="x<?php echo $adverts_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_adverts_categoryId" class="form-group adverts_categoryId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="adverts" data-field="x_categoryId" data-value-separator="<?php echo $adverts->categoryId->displayValueSeparatorAttribute() ?>" id="x<?php echo $adverts_list->RowIndex ?>_categoryId" name="x<?php echo $adverts_list->RowIndex ?>_categoryId"<?php echo $adverts->categoryId->editAttributes() ?>>
		<?php echo $adverts->categoryId->selectOptionListHtml("x<?php echo $adverts_list->RowIndex ?>_categoryId") ?>
	</select>
</div>
<?php echo $adverts->categoryId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "_categoryId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="o<?php echo $adverts_list->RowIndex ?>_categoryId" id="o<?php echo $adverts_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->locationId->Visible) { // locationId ?>
		<td data-name="locationId">
<?php if ($adverts->locationId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_adverts_locationId" class="form-group adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_list->RowIndex ?>_locationId" name="x<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_adverts_locationId" class="form-group adverts_locationId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $adverts_list->RowIndex ?>_locationId"><?php echo strval($adverts->locationId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $adverts->locationId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($adverts->locationId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($adverts->locationId->ReadOnly || $adverts->locationId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $adverts_list->RowIndex ?>_locationId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $adverts->locationId->Lookup->getParamTag("p_x" . $adverts_list->RowIndex . "_locationId") ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $adverts->locationId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_list->RowIndex ?>_locationId" id="x<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo $adverts->locationId->CurrentValue ?>"<?php echo $adverts->locationId->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" name="o<?php echo $adverts_list->RowIndex ?>_locationId" id="o<?php echo $adverts_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->date->Visible) { // date ?>
		<td data-name="date">
<span id="el$rowindex$_adverts_date" class="form-group adverts_date">
<input type="text" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_list->RowIndex ?>_date" id="x<?php echo $adverts_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($adverts->date->getPlaceHolder()) ?>" value="<?php echo $adverts->date->EditValue ?>"<?php echo $adverts->date->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_date" name="o<?php echo $adverts_list->RowIndex ?>_date" id="o<?php echo $adverts_list->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->cost->Visible) { // cost ?>
		<td data-name="cost">
<span id="el$rowindex$_adverts_cost" class="form-group adverts_cost">
<input type="text" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_list->RowIndex ?>_cost" id="x<?php echo $adverts_list->RowIndex ?>_cost" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($adverts->cost->getPlaceHolder()) ?>" value="<?php echo $adverts->cost->EditValue ?>"<?php echo $adverts->cost->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_cost" name="o<?php echo $adverts_list->RowIndex ?>_cost" id="o<?php echo $adverts_list->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$adverts_list->ListOptions->render("body", "right", $adverts_list->RowIndex);
?>
<script>
fadvertslist.updateLists(<?php echo $adverts_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($adverts->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $adverts_list->FormKeyCountName ?>" id="<?php echo $adverts_list->FormKeyCountName ?>" value="<?php echo $adverts_list->KeyCount ?>">
<?php echo $adverts_list->MultiSelectKey ?>
<?php } ?>
<?php if ($adverts->isEdit()) { ?>
<input type="hidden" name="<?php echo $adverts_list->FormKeyCountName ?>" id="<?php echo $adverts_list->FormKeyCountName ?>" value="<?php echo $adverts_list->KeyCount ?>">
<?php } ?>
<?php if (!$adverts->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($adverts_list->Recordset)
	$adverts_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($adverts_list->TotalRecs == 0 && !$adverts->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $adverts_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$adverts_list->showPageFooter();
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
$adverts_list->terminate();
?>
