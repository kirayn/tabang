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
$userprofiles_list = new userprofiles_list();

// Run the page
$userprofiles_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userprofiles_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$userprofiles->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fuserprofileslist = currentForm = new ew.Form("fuserprofileslist", "list");
fuserprofileslist.formKeyCountName = '<?php echo $userprofiles_list->FormKeyCountName ?>';

// Validate form
fuserprofileslist.validate = function() {
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
		<?php if ($userprofiles_list->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->_userId->caption(), $userprofiles->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($userprofiles->_userId->errorMessage()) ?>");
		<?php if ($userprofiles_list->firstName->Required) { ?>
			elm = this.getElements("x" + infix + "_firstName");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->firstName->caption(), $userprofiles->firstName->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_list->lastName->Required) { ?>
			elm = this.getElements("x" + infix + "_lastName");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->lastName->caption(), $userprofiles->lastName->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_list->address->Required) { ?>
			elm = this.getElements("x" + infix + "_address");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->address->caption(), $userprofiles->address->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_list->village->Required) { ?>
			elm = this.getElements("x" + infix + "_village");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->village->caption(), $userprofiles->village->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_list->city->Required) { ?>
			elm = this.getElements("x" + infix + "_city");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->city->caption(), $userprofiles->city->RequiredErrorMessage)) ?>");
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
fuserprofileslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "_userId", false)) return false;
	if (ew.valueChanged(fobj, infix, "firstName", false)) return false;
	if (ew.valueChanged(fobj, infix, "lastName", false)) return false;
	if (ew.valueChanged(fobj, infix, "address", false)) return false;
	if (ew.valueChanged(fobj, infix, "village", false)) return false;
	if (ew.valueChanged(fobj, infix, "city", false)) return false;
	return true;
}

// Form_CustomValidate event
fuserprofileslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fuserprofileslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserprofileslist.lists["x__userId"] = <?php echo $userprofiles_list->_userId->Lookup->toClientList() ?>;
fuserprofileslist.lists["x__userId"].options = <?php echo JsonEncode($userprofiles_list->_userId->lookupOptions()) ?>;
fuserprofileslist.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
var fuserprofileslistsrch = currentSearchForm = new ew.Form("fuserprofileslistsrch");

// Filters
fuserprofileslistsrch.filterList = <?php echo $userprofiles_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$userprofiles->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($userprofiles_list->TotalRecs > 0 && $userprofiles_list->ExportOptions->visible()) { ?>
<?php $userprofiles_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($userprofiles_list->ImportOptions->visible()) { ?>
<?php $userprofiles_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($userprofiles_list->SearchOptions->visible()) { ?>
<?php $userprofiles_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($userprofiles_list->FilterOptions->visible()) { ?>
<?php $userprofiles_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$userprofiles->isExport() || EXPORT_MASTER_RECORD && $userprofiles->isExport("print")) { ?>
<?php
if ($userprofiles_list->DbMasterFilter <> "" && $userprofiles->getCurrentMasterTable() == "users") {
	if ($userprofiles_list->MasterRecordExists) {
		include_once "usersmaster.php";
	}
}
?>
<?php } ?>
<?php
$userprofiles_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$userprofiles->isExport() && !$userprofiles->CurrentAction) { ?>
<form name="fuserprofileslistsrch" id="fuserprofileslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($userprofiles_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fuserprofileslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="userprofiles">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($userprofiles_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($userprofiles_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $userprofiles_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($userprofiles_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($userprofiles_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($userprofiles_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($userprofiles_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $userprofiles_list->showPageHeader(); ?>
<?php
$userprofiles_list->showMessage();
?>
<?php if ($userprofiles_list->TotalRecs > 0 || $userprofiles->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($userprofiles_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> userprofiles">
<?php if (!$userprofiles->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$userprofiles->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($userprofiles_list->Pager)) $userprofiles_list->Pager = new PrevNextPager($userprofiles_list->StartRec, $userprofiles_list->DisplayRecs, $userprofiles_list->TotalRecs, $userprofiles_list->AutoHidePager) ?>
<?php if ($userprofiles_list->Pager->RecordCount > 0 && $userprofiles_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($userprofiles_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $userprofiles_list->pageUrl() ?>start=<?php echo $userprofiles_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($userprofiles_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $userprofiles_list->pageUrl() ?>start=<?php echo $userprofiles_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $userprofiles_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($userprofiles_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $userprofiles_list->pageUrl() ?>start=<?php echo $userprofiles_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($userprofiles_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $userprofiles_list->pageUrl() ?>start=<?php echo $userprofiles_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $userprofiles_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($userprofiles_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $userprofiles_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $userprofiles_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $userprofiles_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $userprofiles_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fuserprofileslist" id="fuserprofileslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($userprofiles_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $userprofiles_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userprofiles">
<?php if ($userprofiles->getCurrentMasterTable() == "users" && $userprofiles->CurrentAction) { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="users">
<input type="hidden" name="fk_ID" value="<?php echo $userprofiles->_userId->getSessionValue() ?>">
<?php } ?>
<div id="gmp_userprofiles" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($userprofiles_list->TotalRecs > 0 || $userprofiles->isGridEdit()) { ?>
<table id="tbl_userprofileslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$userprofiles_list->RowType = ROWTYPE_HEADER;

// Render list options
$userprofiles_list->renderListOptions();

// Render list options (header, left)
$userprofiles_list->ListOptions->render("header", "left");
?>
<?php if ($userprofiles->_userId->Visible) { // userId ?>
	<?php if ($userprofiles->sortUrl($userprofiles->_userId) == "") { ?>
		<th data-name="_userId" class="<?php echo $userprofiles->_userId->headerCellClass() ?>"><div id="elh_userprofiles__userId" class="userprofiles__userId"><div class="ew-table-header-caption"><?php echo $userprofiles->_userId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_userId" class="<?php echo $userprofiles->_userId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $userprofiles->SortUrl($userprofiles->_userId) ?>',1);"><div id="elh_userprofiles__userId" class="userprofiles__userId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->_userId->caption() ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->_userId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->_userId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->firstName->Visible) { // firstName ?>
	<?php if ($userprofiles->sortUrl($userprofiles->firstName) == "") { ?>
		<th data-name="firstName" class="<?php echo $userprofiles->firstName->headerCellClass() ?>"><div id="elh_userprofiles_firstName" class="userprofiles_firstName"><div class="ew-table-header-caption"><?php echo $userprofiles->firstName->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="firstName" class="<?php echo $userprofiles->firstName->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $userprofiles->SortUrl($userprofiles->firstName) ?>',1);"><div id="elh_userprofiles_firstName" class="userprofiles_firstName">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->firstName->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->firstName->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->firstName->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->lastName->Visible) { // lastName ?>
	<?php if ($userprofiles->sortUrl($userprofiles->lastName) == "") { ?>
		<th data-name="lastName" class="<?php echo $userprofiles->lastName->headerCellClass() ?>"><div id="elh_userprofiles_lastName" class="userprofiles_lastName"><div class="ew-table-header-caption"><?php echo $userprofiles->lastName->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lastName" class="<?php echo $userprofiles->lastName->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $userprofiles->SortUrl($userprofiles->lastName) ?>',1);"><div id="elh_userprofiles_lastName" class="userprofiles_lastName">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->lastName->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->lastName->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->lastName->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->address->Visible) { // address ?>
	<?php if ($userprofiles->sortUrl($userprofiles->address) == "") { ?>
		<th data-name="address" class="<?php echo $userprofiles->address->headerCellClass() ?>"><div id="elh_userprofiles_address" class="userprofiles_address"><div class="ew-table-header-caption"><?php echo $userprofiles->address->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="address" class="<?php echo $userprofiles->address->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $userprofiles->SortUrl($userprofiles->address) ?>',1);"><div id="elh_userprofiles_address" class="userprofiles_address">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->address->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->address->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->address->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->village->Visible) { // village ?>
	<?php if ($userprofiles->sortUrl($userprofiles->village) == "") { ?>
		<th data-name="village" class="<?php echo $userprofiles->village->headerCellClass() ?>"><div id="elh_userprofiles_village" class="userprofiles_village"><div class="ew-table-header-caption"><?php echo $userprofiles->village->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="village" class="<?php echo $userprofiles->village->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $userprofiles->SortUrl($userprofiles->village) ?>',1);"><div id="elh_userprofiles_village" class="userprofiles_village">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->village->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->village->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->village->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->city->Visible) { // city ?>
	<?php if ($userprofiles->sortUrl($userprofiles->city) == "") { ?>
		<th data-name="city" class="<?php echo $userprofiles->city->headerCellClass() ?>"><div id="elh_userprofiles_city" class="userprofiles_city"><div class="ew-table-header-caption"><?php echo $userprofiles->city->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="city" class="<?php echo $userprofiles->city->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $userprofiles->SortUrl($userprofiles->city) ?>',1);"><div id="elh_userprofiles_city" class="userprofiles_city">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->city->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->city->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->city->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$userprofiles_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($userprofiles->ExportAll && $userprofiles->isExport()) {
	$userprofiles_list->StopRec = $userprofiles_list->TotalRecs;
} else {

	// Set the last record to display
	if ($userprofiles_list->TotalRecs > $userprofiles_list->StartRec + $userprofiles_list->DisplayRecs - 1)
		$userprofiles_list->StopRec = $userprofiles_list->StartRec + $userprofiles_list->DisplayRecs - 1;
	else
		$userprofiles_list->StopRec = $userprofiles_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $userprofiles_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($userprofiles_list->FormKeyCountName) && ($userprofiles->isGridAdd() || $userprofiles->isGridEdit() || $userprofiles->isConfirm())) {
		$userprofiles_list->KeyCount = $CurrentForm->getValue($userprofiles_list->FormKeyCountName);
		$userprofiles_list->StopRec = $userprofiles_list->StartRec + $userprofiles_list->KeyCount - 1;
	}
}
$userprofiles_list->RecCnt = $userprofiles_list->StartRec - 1;
if ($userprofiles_list->Recordset && !$userprofiles_list->Recordset->EOF) {
	$userprofiles_list->Recordset->moveFirst();
	$selectLimit = $userprofiles_list->UseSelectLimit;
	if (!$selectLimit && $userprofiles_list->StartRec > 1)
		$userprofiles_list->Recordset->move($userprofiles_list->StartRec - 1);
} elseif (!$userprofiles->AllowAddDeleteRow && $userprofiles_list->StopRec == 0) {
	$userprofiles_list->StopRec = $userprofiles->GridAddRowCount;
}

// Initialize aggregate
$userprofiles->RowType = ROWTYPE_AGGREGATEINIT;
$userprofiles->resetAttributes();
$userprofiles_list->renderRow();
$userprofiles_list->EditRowCnt = 0;
if ($userprofiles->isEdit())
	$userprofiles_list->RowIndex = 1;
if ($userprofiles->isGridAdd())
	$userprofiles_list->RowIndex = 0;
while ($userprofiles_list->RecCnt < $userprofiles_list->StopRec) {
	$userprofiles_list->RecCnt++;
	if ($userprofiles_list->RecCnt >= $userprofiles_list->StartRec) {
		$userprofiles_list->RowCnt++;
		if ($userprofiles->isGridAdd() || $userprofiles->isGridEdit() || $userprofiles->isConfirm()) {
			$userprofiles_list->RowIndex++;
			$CurrentForm->Index = $userprofiles_list->RowIndex;
			if ($CurrentForm->hasValue($userprofiles_list->FormActionName) && $userprofiles_list->EventCancelled)
				$userprofiles_list->RowAction = strval($CurrentForm->getValue($userprofiles_list->FormActionName));
			elseif ($userprofiles->isGridAdd())
				$userprofiles_list->RowAction = "insert";
			else
				$userprofiles_list->RowAction = "";
		}

		// Set up key count
		$userprofiles_list->KeyCount = $userprofiles_list->RowIndex;

		// Init row class and style
		$userprofiles->resetAttributes();
		$userprofiles->CssClass = "";
		if ($userprofiles->isGridAdd()) {
			$userprofiles_list->loadRowValues(); // Load default values
		} else {
			$userprofiles_list->loadRowValues($userprofiles_list->Recordset); // Load row values
		}
		$userprofiles->RowType = ROWTYPE_VIEW; // Render view
		if ($userprofiles->isGridAdd()) // Grid add
			$userprofiles->RowType = ROWTYPE_ADD; // Render add
		if ($userprofiles->isGridAdd() && $userprofiles->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$userprofiles_list->restoreCurrentRowFormValues($userprofiles_list->RowIndex); // Restore form values
		if ($userprofiles->isEdit()) {
			if ($userprofiles_list->checkInlineEditKey() && $userprofiles_list->EditRowCnt == 0) { // Inline edit
				$userprofiles->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($userprofiles->isEdit() && $userprofiles->RowType == ROWTYPE_EDIT && $userprofiles->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$userprofiles_list->restoreFormValues(); // Restore form values
		}
		if ($userprofiles->RowType == ROWTYPE_EDIT) // Edit row
			$userprofiles_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$userprofiles->RowAttrs = array_merge($userprofiles->RowAttrs, array('data-rowindex'=>$userprofiles_list->RowCnt, 'id'=>'r' . $userprofiles_list->RowCnt . '_userprofiles', 'data-rowtype'=>$userprofiles->RowType));

		// Render row
		$userprofiles_list->renderRow();

		// Render list options
		$userprofiles_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($userprofiles_list->RowAction <> "delete" && $userprofiles_list->RowAction <> "insertdelete" && !($userprofiles_list->RowAction == "insert" && $userprofiles->isConfirm() && $userprofiles_list->emptyRow())) {
?>
	<tr<?php echo $userprofiles->rowAttributes() ?>>
<?php

// Render list options (body, left)
$userprofiles_list->ListOptions->render("body", "left", $userprofiles_list->RowCnt);
?>
	<?php if ($userprofiles->_userId->Visible) { // userId ?>
		<td data-name="_userId"<?php echo $userprofiles->_userId->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($userprofiles->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$userprofiles->userIDAllow($userprofiles->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<?php
$wrkonchange = "" . trim(@$userprofiles->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$userprofiles->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $userprofiles_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $userprofiles_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $userprofiles_list->RowIndex ?>__userId" id="sv_x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>"<?php echo $userprofiles->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" data-value-separator="<?php echo $userprofiles->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fuserprofileslist.createAutoSuggest({"id":"x<?php echo $userprofiles_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $userprofiles->_userId->Lookup->getParamTag("p_x" . $userprofiles_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="o<?php echo $userprofiles_list->RowIndex ?>__userId" id="o<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($userprofiles->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$userprofiles->userIDAllow($userprofiles->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<?php
$wrkonchange = "" . trim(@$userprofiles->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$userprofiles->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $userprofiles_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $userprofiles_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $userprofiles_list->RowIndex ?>__userId" id="sv_x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>"<?php echo $userprofiles->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" data-value-separator="<?php echo $userprofiles->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fuserprofileslist.createAutoSuggest({"id":"x<?php echo $userprofiles_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $userprofiles->_userId->Lookup->getParamTag("p_x" . $userprofiles_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles__userId" class="userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<?php echo $userprofiles->_userId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="userprofiles" data-field="x_profileId" name="x<?php echo $userprofiles_list->RowIndex ?>_profileId" id="x<?php echo $userprofiles_list->RowIndex ?>_profileId" value="<?php echo HtmlEncode($userprofiles->profileId->CurrentValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_profileId" name="o<?php echo $userprofiles_list->RowIndex ?>_profileId" id="o<?php echo $userprofiles_list->RowIndex ?>_profileId" value="<?php echo HtmlEncode($userprofiles->profileId->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT || $userprofiles->CurrentMode == "edit") { ?>
<input type="hidden" data-table="userprofiles" data-field="x_profileId" name="x<?php echo $userprofiles_list->RowIndex ?>_profileId" id="x<?php echo $userprofiles_list->RowIndex ?>_profileId" value="<?php echo HtmlEncode($userprofiles->profileId->CurrentValue) ?>">
<?php } ?>
	<?php if ($userprofiles->firstName->Visible) { // firstName ?>
		<td data-name="firstName"<?php echo $userprofiles->firstName->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_firstName" class="form-group userprofiles_firstName">
<input type="text" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_list->RowIndex ?>_firstName" id="x<?php echo $userprofiles_list->RowIndex ?>_firstName" placeholder="<?php echo HtmlEncode($userprofiles->firstName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->firstName->EditValue ?>"<?php echo $userprofiles->firstName->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="o<?php echo $userprofiles_list->RowIndex ?>_firstName" id="o<?php echo $userprofiles_list->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_firstName" class="form-group userprofiles_firstName">
<input type="text" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_list->RowIndex ?>_firstName" id="x<?php echo $userprofiles_list->RowIndex ?>_firstName" placeholder="<?php echo HtmlEncode($userprofiles->firstName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->firstName->EditValue ?>"<?php echo $userprofiles->firstName->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_firstName" class="userprofiles_firstName">
<span<?php echo $userprofiles->firstName->viewAttributes() ?>>
<?php echo $userprofiles->firstName->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->lastName->Visible) { // lastName ?>
		<td data-name="lastName"<?php echo $userprofiles->lastName->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_lastName" class="form-group userprofiles_lastName">
<input type="text" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_list->RowIndex ?>_lastName" id="x<?php echo $userprofiles_list->RowIndex ?>_lastName" placeholder="<?php echo HtmlEncode($userprofiles->lastName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->lastName->EditValue ?>"<?php echo $userprofiles->lastName->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="o<?php echo $userprofiles_list->RowIndex ?>_lastName" id="o<?php echo $userprofiles_list->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_lastName" class="form-group userprofiles_lastName">
<input type="text" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_list->RowIndex ?>_lastName" id="x<?php echo $userprofiles_list->RowIndex ?>_lastName" placeholder="<?php echo HtmlEncode($userprofiles->lastName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->lastName->EditValue ?>"<?php echo $userprofiles->lastName->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_lastName" class="userprofiles_lastName">
<span<?php echo $userprofiles->lastName->viewAttributes() ?>>
<?php echo $userprofiles->lastName->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->address->Visible) { // address ?>
		<td data-name="address"<?php echo $userprofiles->address->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_address" class="form-group userprofiles_address">
<textarea data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_list->RowIndex ?>_address" id="x<?php echo $userprofiles_list->RowIndex ?>_address" cols="35" rows="4" placeholder="<?php echo HtmlEncode($userprofiles->address->getPlaceHolder()) ?>"<?php echo $userprofiles->address->editAttributes() ?>><?php echo $userprofiles->address->EditValue ?></textarea>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_address" name="o<?php echo $userprofiles_list->RowIndex ?>_address" id="o<?php echo $userprofiles_list->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_address" class="form-group userprofiles_address">
<textarea data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_list->RowIndex ?>_address" id="x<?php echo $userprofiles_list->RowIndex ?>_address" cols="35" rows="4" placeholder="<?php echo HtmlEncode($userprofiles->address->getPlaceHolder()) ?>"<?php echo $userprofiles->address->editAttributes() ?>><?php echo $userprofiles->address->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_address" class="userprofiles_address">
<span<?php echo $userprofiles->address->viewAttributes() ?>>
<?php echo $userprofiles->address->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->village->Visible) { // village ?>
		<td data-name="village"<?php echo $userprofiles->village->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_village" class="form-group userprofiles_village">
<input type="text" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_list->RowIndex ?>_village" id="x<?php echo $userprofiles_list->RowIndex ?>_village" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($userprofiles->village->getPlaceHolder()) ?>" value="<?php echo $userprofiles->village->EditValue ?>"<?php echo $userprofiles->village->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_village" name="o<?php echo $userprofiles_list->RowIndex ?>_village" id="o<?php echo $userprofiles_list->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_village" class="form-group userprofiles_village">
<input type="text" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_list->RowIndex ?>_village" id="x<?php echo $userprofiles_list->RowIndex ?>_village" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($userprofiles->village->getPlaceHolder()) ?>" value="<?php echo $userprofiles->village->EditValue ?>"<?php echo $userprofiles->village->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_village" class="userprofiles_village">
<span<?php echo $userprofiles->village->viewAttributes() ?>>
<?php echo $userprofiles->village->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->city->Visible) { // city ?>
		<td data-name="city"<?php echo $userprofiles->city->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_city" class="form-group userprofiles_city">
<input type="text" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_list->RowIndex ?>_city" id="x<?php echo $userprofiles_list->RowIndex ?>_city" placeholder="<?php echo HtmlEncode($userprofiles->city->getPlaceHolder()) ?>" value="<?php echo $userprofiles->city->EditValue ?>"<?php echo $userprofiles->city->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_city" name="o<?php echo $userprofiles_list->RowIndex ?>_city" id="o<?php echo $userprofiles_list->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_city" class="form-group userprofiles_city">
<input type="text" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_list->RowIndex ?>_city" id="x<?php echo $userprofiles_list->RowIndex ?>_city" placeholder="<?php echo HtmlEncode($userprofiles->city->getPlaceHolder()) ?>" value="<?php echo $userprofiles->city->EditValue ?>"<?php echo $userprofiles->city->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_list->RowCnt ?>_userprofiles_city" class="userprofiles_city">
<span<?php echo $userprofiles->city->viewAttributes() ?>>
<?php echo $userprofiles->city->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$userprofiles_list->ListOptions->render("body", "right", $userprofiles_list->RowCnt);
?>
	</tr>
<?php if ($userprofiles->RowType == ROWTYPE_ADD || $userprofiles->RowType == ROWTYPE_EDIT) { ?>
<script>
fuserprofileslist.updateLists(<?php echo $userprofiles_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$userprofiles->isGridAdd())
		if (!$userprofiles_list->Recordset->EOF)
			$userprofiles_list->Recordset->moveNext();
}
?>
<?php
	if ($userprofiles->isGridAdd() || $userprofiles->isGridEdit()) {
		$userprofiles_list->RowIndex = '$rowindex$';
		$userprofiles_list->loadRowValues();

		// Set row properties
		$userprofiles->resetAttributes();
		$userprofiles->RowAttrs = array_merge($userprofiles->RowAttrs, array('data-rowindex'=>$userprofiles_list->RowIndex, 'id'=>'r0_userprofiles', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($userprofiles->RowAttrs["class"], "ew-template");
		$userprofiles->RowType = ROWTYPE_ADD;

		// Render row
		$userprofiles_list->renderRow();

		// Render list options
		$userprofiles_list->renderListOptions();
		$userprofiles_list->StartRowCnt = 0;
?>
	<tr<?php echo $userprofiles->rowAttributes() ?>>
<?php

// Render list options (body, left)
$userprofiles_list->ListOptions->render("body", "left", $userprofiles_list->RowIndex);
?>
	<?php if ($userprofiles->_userId->Visible) { // userId ?>
		<td data-name="_userId">
<?php if ($userprofiles->_userId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$userprofiles->userIDAllow($userprofiles->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_userprofiles__userId" class="form-group userprofiles__userId">
<?php
$wrkonchange = "" . trim(@$userprofiles->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$userprofiles->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $userprofiles_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $userprofiles_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $userprofiles_list->RowIndex ?>__userId" id="sv_x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>"<?php echo $userprofiles->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" data-value-separator="<?php echo $userprofiles->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $userprofiles_list->RowIndex ?>__userId" id="x<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fuserprofileslist.createAutoSuggest({"id":"x<?php echo $userprofiles_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $userprofiles->_userId->Lookup->getParamTag("p_x" . $userprofiles_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="o<?php echo $userprofiles_list->RowIndex ?>__userId" id="o<?php echo $userprofiles_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->firstName->Visible) { // firstName ?>
		<td data-name="firstName">
<span id="el$rowindex$_userprofiles_firstName" class="form-group userprofiles_firstName">
<input type="text" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_list->RowIndex ?>_firstName" id="x<?php echo $userprofiles_list->RowIndex ?>_firstName" placeholder="<?php echo HtmlEncode($userprofiles->firstName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->firstName->EditValue ?>"<?php echo $userprofiles->firstName->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="o<?php echo $userprofiles_list->RowIndex ?>_firstName" id="o<?php echo $userprofiles_list->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->lastName->Visible) { // lastName ?>
		<td data-name="lastName">
<span id="el$rowindex$_userprofiles_lastName" class="form-group userprofiles_lastName">
<input type="text" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_list->RowIndex ?>_lastName" id="x<?php echo $userprofiles_list->RowIndex ?>_lastName" placeholder="<?php echo HtmlEncode($userprofiles->lastName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->lastName->EditValue ?>"<?php echo $userprofiles->lastName->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="o<?php echo $userprofiles_list->RowIndex ?>_lastName" id="o<?php echo $userprofiles_list->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->address->Visible) { // address ?>
		<td data-name="address">
<span id="el$rowindex$_userprofiles_address" class="form-group userprofiles_address">
<textarea data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_list->RowIndex ?>_address" id="x<?php echo $userprofiles_list->RowIndex ?>_address" cols="35" rows="4" placeholder="<?php echo HtmlEncode($userprofiles->address->getPlaceHolder()) ?>"<?php echo $userprofiles->address->editAttributes() ?>><?php echo $userprofiles->address->EditValue ?></textarea>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_address" name="o<?php echo $userprofiles_list->RowIndex ?>_address" id="o<?php echo $userprofiles_list->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->village->Visible) { // village ?>
		<td data-name="village">
<span id="el$rowindex$_userprofiles_village" class="form-group userprofiles_village">
<input type="text" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_list->RowIndex ?>_village" id="x<?php echo $userprofiles_list->RowIndex ?>_village" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($userprofiles->village->getPlaceHolder()) ?>" value="<?php echo $userprofiles->village->EditValue ?>"<?php echo $userprofiles->village->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_village" name="o<?php echo $userprofiles_list->RowIndex ?>_village" id="o<?php echo $userprofiles_list->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->city->Visible) { // city ?>
		<td data-name="city">
<span id="el$rowindex$_userprofiles_city" class="form-group userprofiles_city">
<input type="text" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_list->RowIndex ?>_city" id="x<?php echo $userprofiles_list->RowIndex ?>_city" placeholder="<?php echo HtmlEncode($userprofiles->city->getPlaceHolder()) ?>" value="<?php echo $userprofiles->city->EditValue ?>"<?php echo $userprofiles->city->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_city" name="o<?php echo $userprofiles_list->RowIndex ?>_city" id="o<?php echo $userprofiles_list->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$userprofiles_list->ListOptions->render("body", "right", $userprofiles_list->RowIndex);
?>
<script>
fuserprofileslist.updateLists(<?php echo $userprofiles_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($userprofiles->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $userprofiles_list->FormKeyCountName ?>" id="<?php echo $userprofiles_list->FormKeyCountName ?>" value="<?php echo $userprofiles_list->KeyCount ?>">
<?php echo $userprofiles_list->MultiSelectKey ?>
<?php } ?>
<?php if ($userprofiles->isEdit()) { ?>
<input type="hidden" name="<?php echo $userprofiles_list->FormKeyCountName ?>" id="<?php echo $userprofiles_list->FormKeyCountName ?>" value="<?php echo $userprofiles_list->KeyCount ?>">
<?php } ?>
<?php if (!$userprofiles->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($userprofiles_list->Recordset)
	$userprofiles_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($userprofiles_list->TotalRecs == 0 && !$userprofiles->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $userprofiles_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$userprofiles_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$userprofiles->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$userprofiles_list->terminate();
?>
