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
$locations_list = new locations_list();

// Run the page
$locations_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$locations_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$locations->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flocationslist = currentForm = new ew.Form("flocationslist", "list");
flocationslist.formKeyCountName = '<?php echo $locations_list->FormKeyCountName ?>';

// Validate form
flocationslist.validate = function() {
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
		<?php if ($locations_list->locationId->Required) { ?>
			elm = this.getElements("x" + infix + "_locationId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $locations->locationId->caption(), $locations->locationId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($locations_list->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $locations->title->caption(), $locations->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($locations_list->pincode->Required) { ?>
			elm = this.getElements("x" + infix + "_pincode");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $locations->pincode->caption(), $locations->pincode->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_pincode");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($locations->pincode->errorMessage()) ?>");

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
flocationslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "title", false)) return false;
	if (ew.valueChanged(fobj, infix, "pincode", false)) return false;
	return true;
}

// Form_CustomValidate event
flocationslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flocationslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var flocationslistsrch = currentSearchForm = new ew.Form("flocationslistsrch");

// Filters
flocationslistsrch.filterList = <?php echo $locations_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$locations->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($locations_list->TotalRecs > 0 && $locations_list->ExportOptions->visible()) { ?>
<?php $locations_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($locations_list->ImportOptions->visible()) { ?>
<?php $locations_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($locations_list->SearchOptions->visible()) { ?>
<?php $locations_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($locations_list->FilterOptions->visible()) { ?>
<?php $locations_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$locations_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$locations->isExport() && !$locations->CurrentAction) { ?>
<form name="flocationslistsrch" id="flocationslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($locations_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flocationslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="locations">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($locations_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($locations_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $locations_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($locations_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($locations_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($locations_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($locations_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $locations_list->showPageHeader(); ?>
<?php
$locations_list->showMessage();
?>
<?php if ($locations_list->TotalRecs > 0 || $locations->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($locations_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> locations">
<?php if (!$locations->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$locations->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($locations_list->Pager)) $locations_list->Pager = new PrevNextPager($locations_list->StartRec, $locations_list->DisplayRecs, $locations_list->TotalRecs, $locations_list->AutoHidePager) ?>
<?php if ($locations_list->Pager->RecordCount > 0 && $locations_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($locations_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $locations_list->pageUrl() ?>start=<?php echo $locations_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($locations_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $locations_list->pageUrl() ?>start=<?php echo $locations_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $locations_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($locations_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $locations_list->pageUrl() ?>start=<?php echo $locations_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($locations_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $locations_list->pageUrl() ?>start=<?php echo $locations_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $locations_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($locations_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $locations_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $locations_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $locations_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $locations_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flocationslist" id="flocationslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($locations_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $locations_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="locations">
<div id="gmp_locations" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($locations_list->TotalRecs > 0 || $locations->isGridEdit()) { ?>
<table id="tbl_locationslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$locations_list->RowType = ROWTYPE_HEADER;

// Render list options
$locations_list->renderListOptions();

// Render list options (header, left)
$locations_list->ListOptions->render("header", "left");
?>
<?php if ($locations->locationId->Visible) { // locationId ?>
	<?php if ($locations->sortUrl($locations->locationId) == "") { ?>
		<th data-name="locationId" class="<?php echo $locations->locationId->headerCellClass() ?>"><div id="elh_locations_locationId" class="locations_locationId"><div class="ew-table-header-caption"><?php echo $locations->locationId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="locationId" class="<?php echo $locations->locationId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $locations->SortUrl($locations->locationId) ?>',1);"><div id="elh_locations_locationId" class="locations_locationId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $locations->locationId->caption() ?></span><span class="ew-table-header-sort"><?php if ($locations->locationId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($locations->locationId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($locations->title->Visible) { // title ?>
	<?php if ($locations->sortUrl($locations->title) == "") { ?>
		<th data-name="title" class="<?php echo $locations->title->headerCellClass() ?>"><div id="elh_locations_title" class="locations_title"><div class="ew-table-header-caption"><?php echo $locations->title->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $locations->title->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $locations->SortUrl($locations->title) ?>',1);"><div id="elh_locations_title" class="locations_title">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $locations->title->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($locations->title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($locations->title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($locations->pincode->Visible) { // pincode ?>
	<?php if ($locations->sortUrl($locations->pincode) == "") { ?>
		<th data-name="pincode" class="<?php echo $locations->pincode->headerCellClass() ?>"><div id="elh_locations_pincode" class="locations_pincode"><div class="ew-table-header-caption"><?php echo $locations->pincode->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pincode" class="<?php echo $locations->pincode->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $locations->SortUrl($locations->pincode) ?>',1);"><div id="elh_locations_pincode" class="locations_pincode">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $locations->pincode->caption() ?></span><span class="ew-table-header-sort"><?php if ($locations->pincode->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($locations->pincode->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$locations_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($locations->ExportAll && $locations->isExport()) {
	$locations_list->StopRec = $locations_list->TotalRecs;
} else {

	// Set the last record to display
	if ($locations_list->TotalRecs > $locations_list->StartRec + $locations_list->DisplayRecs - 1)
		$locations_list->StopRec = $locations_list->StartRec + $locations_list->DisplayRecs - 1;
	else
		$locations_list->StopRec = $locations_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $locations_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($locations_list->FormKeyCountName) && ($locations->isGridAdd() || $locations->isGridEdit() || $locations->isConfirm())) {
		$locations_list->KeyCount = $CurrentForm->getValue($locations_list->FormKeyCountName);
		$locations_list->StopRec = $locations_list->StartRec + $locations_list->KeyCount - 1;
	}
}
$locations_list->RecCnt = $locations_list->StartRec - 1;
if ($locations_list->Recordset && !$locations_list->Recordset->EOF) {
	$locations_list->Recordset->moveFirst();
	$selectLimit = $locations_list->UseSelectLimit;
	if (!$selectLimit && $locations_list->StartRec > 1)
		$locations_list->Recordset->move($locations_list->StartRec - 1);
} elseif (!$locations->AllowAddDeleteRow && $locations_list->StopRec == 0) {
	$locations_list->StopRec = $locations->GridAddRowCount;
}

// Initialize aggregate
$locations->RowType = ROWTYPE_AGGREGATEINIT;
$locations->resetAttributes();
$locations_list->renderRow();
$locations_list->EditRowCnt = 0;
if ($locations->isEdit())
	$locations_list->RowIndex = 1;
if ($locations->isGridAdd())
	$locations_list->RowIndex = 0;
while ($locations_list->RecCnt < $locations_list->StopRec) {
	$locations_list->RecCnt++;
	if ($locations_list->RecCnt >= $locations_list->StartRec) {
		$locations_list->RowCnt++;
		if ($locations->isGridAdd() || $locations->isGridEdit() || $locations->isConfirm()) {
			$locations_list->RowIndex++;
			$CurrentForm->Index = $locations_list->RowIndex;
			if ($CurrentForm->hasValue($locations_list->FormActionName) && $locations_list->EventCancelled)
				$locations_list->RowAction = strval($CurrentForm->getValue($locations_list->FormActionName));
			elseif ($locations->isGridAdd())
				$locations_list->RowAction = "insert";
			else
				$locations_list->RowAction = "";
		}

		// Set up key count
		$locations_list->KeyCount = $locations_list->RowIndex;

		// Init row class and style
		$locations->resetAttributes();
		$locations->CssClass = "";
		if ($locations->isGridAdd()) {
			$locations_list->loadRowValues(); // Load default values
		} else {
			$locations_list->loadRowValues($locations_list->Recordset); // Load row values
		}
		$locations->RowType = ROWTYPE_VIEW; // Render view
		if ($locations->isGridAdd()) // Grid add
			$locations->RowType = ROWTYPE_ADD; // Render add
		if ($locations->isGridAdd() && $locations->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$locations_list->restoreCurrentRowFormValues($locations_list->RowIndex); // Restore form values
		if ($locations->isEdit()) {
			if ($locations_list->checkInlineEditKey() && $locations_list->EditRowCnt == 0) { // Inline edit
				$locations->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($locations->isEdit() && $locations->RowType == ROWTYPE_EDIT && $locations->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$locations_list->restoreFormValues(); // Restore form values
		}
		if ($locations->RowType == ROWTYPE_EDIT) // Edit row
			$locations_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$locations->RowAttrs = array_merge($locations->RowAttrs, array('data-rowindex'=>$locations_list->RowCnt, 'id'=>'r' . $locations_list->RowCnt . '_locations', 'data-rowtype'=>$locations->RowType));

		// Render row
		$locations_list->renderRow();

		// Render list options
		$locations_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($locations_list->RowAction <> "delete" && $locations_list->RowAction <> "insertdelete" && !($locations_list->RowAction == "insert" && $locations->isConfirm() && $locations_list->emptyRow())) {
?>
	<tr<?php echo $locations->rowAttributes() ?>>
<?php

// Render list options (body, left)
$locations_list->ListOptions->render("body", "left", $locations_list->RowCnt);
?>
	<?php if ($locations->locationId->Visible) { // locationId ?>
		<td data-name="locationId"<?php echo $locations->locationId->cellAttributes() ?>>
<?php if ($locations->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="locations" data-field="x_locationId" name="o<?php echo $locations_list->RowIndex ?>_locationId" id="o<?php echo $locations_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($locations->locationId->OldValue) ?>">
<?php } ?>
<?php if ($locations->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_locationId" class="form-group locations_locationId">
<span<?php echo $locations->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($locations->locationId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="locations" data-field="x_locationId" name="x<?php echo $locations_list->RowIndex ?>_locationId" id="x<?php echo $locations_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($locations->locationId->CurrentValue) ?>">
<?php } ?>
<?php if ($locations->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_locationId" class="locations_locationId">
<span<?php echo $locations->locationId->viewAttributes() ?>>
<?php echo $locations->locationId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($locations->title->Visible) { // title ?>
		<td data-name="title"<?php echo $locations->title->cellAttributes() ?>>
<?php if ($locations->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_title" class="form-group locations_title">
<input type="text" data-table="locations" data-field="x_title" name="x<?php echo $locations_list->RowIndex ?>_title" id="x<?php echo $locations_list->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($locations->title->getPlaceHolder()) ?>" value="<?php echo $locations->title->EditValue ?>"<?php echo $locations->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="locations" data-field="x_title" name="o<?php echo $locations_list->RowIndex ?>_title" id="o<?php echo $locations_list->RowIndex ?>_title" value="<?php echo HtmlEncode($locations->title->OldValue) ?>">
<?php } ?>
<?php if ($locations->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_title" class="form-group locations_title">
<input type="text" data-table="locations" data-field="x_title" name="x<?php echo $locations_list->RowIndex ?>_title" id="x<?php echo $locations_list->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($locations->title->getPlaceHolder()) ?>" value="<?php echo $locations->title->EditValue ?>"<?php echo $locations->title->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($locations->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_title" class="locations_title">
<span<?php echo $locations->title->viewAttributes() ?>>
<?php echo $locations->title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($locations->pincode->Visible) { // pincode ?>
		<td data-name="pincode"<?php echo $locations->pincode->cellAttributes() ?>>
<?php if ($locations->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_pincode" class="form-group locations_pincode">
<input type="text" data-table="locations" data-field="x_pincode" name="x<?php echo $locations_list->RowIndex ?>_pincode" id="x<?php echo $locations_list->RowIndex ?>_pincode" size="30" placeholder="<?php echo HtmlEncode($locations->pincode->getPlaceHolder()) ?>" value="<?php echo $locations->pincode->EditValue ?>"<?php echo $locations->pincode->editAttributes() ?>>
</span>
<input type="hidden" data-table="locations" data-field="x_pincode" name="o<?php echo $locations_list->RowIndex ?>_pincode" id="o<?php echo $locations_list->RowIndex ?>_pincode" value="<?php echo HtmlEncode($locations->pincode->OldValue) ?>">
<?php } ?>
<?php if ($locations->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_pincode" class="form-group locations_pincode">
<input type="text" data-table="locations" data-field="x_pincode" name="x<?php echo $locations_list->RowIndex ?>_pincode" id="x<?php echo $locations_list->RowIndex ?>_pincode" size="30" placeholder="<?php echo HtmlEncode($locations->pincode->getPlaceHolder()) ?>" value="<?php echo $locations->pincode->EditValue ?>"<?php echo $locations->pincode->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($locations->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $locations_list->RowCnt ?>_locations_pincode" class="locations_pincode">
<span<?php echo $locations->pincode->viewAttributes() ?>>
<?php echo $locations->pincode->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$locations_list->ListOptions->render("body", "right", $locations_list->RowCnt);
?>
	</tr>
<?php if ($locations->RowType == ROWTYPE_ADD || $locations->RowType == ROWTYPE_EDIT) { ?>
<script>
flocationslist.updateLists(<?php echo $locations_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$locations->isGridAdd())
		if (!$locations_list->Recordset->EOF)
			$locations_list->Recordset->moveNext();
}
?>
<?php
	if ($locations->isGridAdd() || $locations->isGridEdit()) {
		$locations_list->RowIndex = '$rowindex$';
		$locations_list->loadRowValues();

		// Set row properties
		$locations->resetAttributes();
		$locations->RowAttrs = array_merge($locations->RowAttrs, array('data-rowindex'=>$locations_list->RowIndex, 'id'=>'r0_locations', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($locations->RowAttrs["class"], "ew-template");
		$locations->RowType = ROWTYPE_ADD;

		// Render row
		$locations_list->renderRow();

		// Render list options
		$locations_list->renderListOptions();
		$locations_list->StartRowCnt = 0;
?>
	<tr<?php echo $locations->rowAttributes() ?>>
<?php

// Render list options (body, left)
$locations_list->ListOptions->render("body", "left", $locations_list->RowIndex);
?>
	<?php if ($locations->locationId->Visible) { // locationId ?>
		<td data-name="locationId">
<input type="hidden" data-table="locations" data-field="x_locationId" name="o<?php echo $locations_list->RowIndex ?>_locationId" id="o<?php echo $locations_list->RowIndex ?>_locationId" value="<?php echo HtmlEncode($locations->locationId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($locations->title->Visible) { // title ?>
		<td data-name="title">
<span id="el$rowindex$_locations_title" class="form-group locations_title">
<input type="text" data-table="locations" data-field="x_title" name="x<?php echo $locations_list->RowIndex ?>_title" id="x<?php echo $locations_list->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($locations->title->getPlaceHolder()) ?>" value="<?php echo $locations->title->EditValue ?>"<?php echo $locations->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="locations" data-field="x_title" name="o<?php echo $locations_list->RowIndex ?>_title" id="o<?php echo $locations_list->RowIndex ?>_title" value="<?php echo HtmlEncode($locations->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($locations->pincode->Visible) { // pincode ?>
		<td data-name="pincode">
<span id="el$rowindex$_locations_pincode" class="form-group locations_pincode">
<input type="text" data-table="locations" data-field="x_pincode" name="x<?php echo $locations_list->RowIndex ?>_pincode" id="x<?php echo $locations_list->RowIndex ?>_pincode" size="30" placeholder="<?php echo HtmlEncode($locations->pincode->getPlaceHolder()) ?>" value="<?php echo $locations->pincode->EditValue ?>"<?php echo $locations->pincode->editAttributes() ?>>
</span>
<input type="hidden" data-table="locations" data-field="x_pincode" name="o<?php echo $locations_list->RowIndex ?>_pincode" id="o<?php echo $locations_list->RowIndex ?>_pincode" value="<?php echo HtmlEncode($locations->pincode->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$locations_list->ListOptions->render("body", "right", $locations_list->RowIndex);
?>
<script>
flocationslist.updateLists(<?php echo $locations_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($locations->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $locations_list->FormKeyCountName ?>" id="<?php echo $locations_list->FormKeyCountName ?>" value="<?php echo $locations_list->KeyCount ?>">
<?php echo $locations_list->MultiSelectKey ?>
<?php } ?>
<?php if ($locations->isEdit()) { ?>
<input type="hidden" name="<?php echo $locations_list->FormKeyCountName ?>" id="<?php echo $locations_list->FormKeyCountName ?>" value="<?php echo $locations_list->KeyCount ?>">
<?php } ?>
<?php if (!$locations->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($locations_list->Recordset)
	$locations_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($locations_list->TotalRecs == 0 && !$locations->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $locations_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$locations_list->showPageFooter();
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
$locations_list->terminate();
?>
