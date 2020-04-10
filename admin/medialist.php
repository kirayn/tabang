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
$media_list = new media_list();

// Run the page
$media_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$media_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$media->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fmedialist = currentForm = new ew.Form("fmedialist", "list");
fmedialist.formKeyCountName = '<?php echo $media_list->FormKeyCountName ?>';

// Validate form
fmedialist.validate = function() {
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
		<?php if ($media_list->mediaId->Required) { ?>
			elm = this.getElements("x" + infix + "_mediaId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $media->mediaId->caption(), $media->mediaId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($media_list->advId->Required) { ?>
			elm = this.getElements("x" + infix + "_advId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $media->advId->caption(), $media->advId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_advId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($media->advId->errorMessage()) ?>");
		<?php if ($media_list->filename->Required) { ?>
			felm = this.getElements("x" + infix + "_filename");
			elm = this.getElements("fn_x" + infix + "_filename");
			if (felm && elm && !ew.hasValue(elm))
				return this.onError(felm, "<?php echo JsEncode(str_replace("%s", $media->filename->caption(), $media->filename->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($media_list->_thumbnail->Required) { ?>
			felm = this.getElements("x" + infix + "__thumbnail");
			elm = this.getElements("fn_x" + infix + "__thumbnail");
			if (felm && elm && !ew.hasValue(elm))
				return this.onError(felm, "<?php echo JsEncode(str_replace("%s", $media->_thumbnail->caption(), $media->_thumbnail->RequiredErrorMessage)) ?>");
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
fmedialist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "advId", false)) return false;
	if (ew.valueChanged(fobj, infix, "filename", false)) return false;
	if (ew.valueChanged(fobj, infix, "_thumbnail", false)) return false;
	return true;
}

// Form_CustomValidate event
fmedialist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fmedialist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmedialist.lists["x_advId"] = <?php echo $media_list->advId->Lookup->toClientList() ?>;
fmedialist.lists["x_advId"].options = <?php echo JsonEncode($media_list->advId->lookupOptions()) ?>;
fmedialist.autoSuggests["x_advId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
var fmedialistsrch = currentSearchForm = new ew.Form("fmedialistsrch");

// Filters
fmedialistsrch.filterList = <?php echo $media_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$media->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($media_list->TotalRecs > 0 && $media_list->ExportOptions->visible()) { ?>
<?php $media_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($media_list->ImportOptions->visible()) { ?>
<?php $media_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($media_list->SearchOptions->visible()) { ?>
<?php $media_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($media_list->FilterOptions->visible()) { ?>
<?php $media_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$media->isExport() || EXPORT_MASTER_RECORD && $media->isExport("print")) { ?>
<?php
if ($media_list->DbMasterFilter <> "" && $media->getCurrentMasterTable() == "adverts") {
	if ($media_list->MasterRecordExists) {
		include_once "advertsmaster.php";
	}
}
?>
<?php } ?>
<?php
$media_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$media->isExport() && !$media->CurrentAction) { ?>
<form name="fmedialistsrch" id="fmedialistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($media_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fmedialistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="media">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($media_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($media_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $media_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($media_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($media_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($media_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($media_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $media_list->showPageHeader(); ?>
<?php
$media_list->showMessage();
?>
<?php if ($media_list->TotalRecs > 0 || $media->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($media_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> media">
<?php if (!$media->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$media->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($media_list->Pager)) $media_list->Pager = new PrevNextPager($media_list->StartRec, $media_list->DisplayRecs, $media_list->TotalRecs, $media_list->AutoHidePager) ?>
<?php if ($media_list->Pager->RecordCount > 0 && $media_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($media_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $media_list->pageUrl() ?>start=<?php echo $media_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($media_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $media_list->pageUrl() ?>start=<?php echo $media_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $media_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($media_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $media_list->pageUrl() ?>start=<?php echo $media_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($media_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $media_list->pageUrl() ?>start=<?php echo $media_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $media_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($media_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $media_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $media_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $media_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $media_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fmedialist" id="fmedialist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($media_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $media_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="media">
<?php if ($media->getCurrentMasterTable() == "adverts" && $media->CurrentAction) { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="adverts">
<input type="hidden" name="fk_advId" value="<?php echo $media->advId->getSessionValue() ?>">
<?php } ?>
<div id="gmp_media" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($media_list->TotalRecs > 0 || $media->isGridEdit()) { ?>
<table id="tbl_medialist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$media_list->RowType = ROWTYPE_HEADER;

// Render list options
$media_list->renderListOptions();

// Render list options (header, left)
$media_list->ListOptions->render("header", "left");
?>
<?php if ($media->mediaId->Visible) { // mediaId ?>
	<?php if ($media->sortUrl($media->mediaId) == "") { ?>
		<th data-name="mediaId" class="<?php echo $media->mediaId->headerCellClass() ?>"><div id="elh_media_mediaId" class="media_mediaId"><div class="ew-table-header-caption"><?php echo $media->mediaId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mediaId" class="<?php echo $media->mediaId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $media->SortUrl($media->mediaId) ?>',1);"><div id="elh_media_mediaId" class="media_mediaId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->mediaId->caption() ?></span><span class="ew-table-header-sort"><?php if ($media->mediaId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->mediaId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($media->advId->Visible) { // advId ?>
	<?php if ($media->sortUrl($media->advId) == "") { ?>
		<th data-name="advId" class="<?php echo $media->advId->headerCellClass() ?>"><div id="elh_media_advId" class="media_advId"><div class="ew-table-header-caption"><?php echo $media->advId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="advId" class="<?php echo $media->advId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $media->SortUrl($media->advId) ?>',1);"><div id="elh_media_advId" class="media_advId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->advId->caption() ?></span><span class="ew-table-header-sort"><?php if ($media->advId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->advId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($media->filename->Visible) { // filename ?>
	<?php if ($media->sortUrl($media->filename) == "") { ?>
		<th data-name="filename" class="<?php echo $media->filename->headerCellClass() ?>"><div id="elh_media_filename" class="media_filename"><div class="ew-table-header-caption"><?php echo $media->filename->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="filename" class="<?php echo $media->filename->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $media->SortUrl($media->filename) ?>',1);"><div id="elh_media_filename" class="media_filename">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->filename->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($media->filename->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->filename->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
	<?php if ($media->sortUrl($media->_thumbnail) == "") { ?>
		<th data-name="_thumbnail" class="<?php echo $media->_thumbnail->headerCellClass() ?>"><div id="elh_media__thumbnail" class="media__thumbnail"><div class="ew-table-header-caption"><?php echo $media->_thumbnail->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_thumbnail" class="<?php echo $media->_thumbnail->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $media->SortUrl($media->_thumbnail) ?>',1);"><div id="elh_media__thumbnail" class="media__thumbnail">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->_thumbnail->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($media->_thumbnail->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->_thumbnail->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$media_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($media->ExportAll && $media->isExport()) {
	$media_list->StopRec = $media_list->TotalRecs;
} else {

	// Set the last record to display
	if ($media_list->TotalRecs > $media_list->StartRec + $media_list->DisplayRecs - 1)
		$media_list->StopRec = $media_list->StartRec + $media_list->DisplayRecs - 1;
	else
		$media_list->StopRec = $media_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $media_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($media_list->FormKeyCountName) && ($media->isGridAdd() || $media->isGridEdit() || $media->isConfirm())) {
		$media_list->KeyCount = $CurrentForm->getValue($media_list->FormKeyCountName);
		$media_list->StopRec = $media_list->StartRec + $media_list->KeyCount - 1;
	}
}
$media_list->RecCnt = $media_list->StartRec - 1;
if ($media_list->Recordset && !$media_list->Recordset->EOF) {
	$media_list->Recordset->moveFirst();
	$selectLimit = $media_list->UseSelectLimit;
	if (!$selectLimit && $media_list->StartRec > 1)
		$media_list->Recordset->move($media_list->StartRec - 1);
} elseif (!$media->AllowAddDeleteRow && $media_list->StopRec == 0) {
	$media_list->StopRec = $media->GridAddRowCount;
}

// Initialize aggregate
$media->RowType = ROWTYPE_AGGREGATEINIT;
$media->resetAttributes();
$media_list->renderRow();
$media_list->EditRowCnt = 0;
if ($media->isEdit())
	$media_list->RowIndex = 1;
if ($media->isGridAdd())
	$media_list->RowIndex = 0;
while ($media_list->RecCnt < $media_list->StopRec) {
	$media_list->RecCnt++;
	if ($media_list->RecCnt >= $media_list->StartRec) {
		$media_list->RowCnt++;
		if ($media->isGridAdd() || $media->isGridEdit() || $media->isConfirm()) {
			$media_list->RowIndex++;
			$CurrentForm->Index = $media_list->RowIndex;
			if ($CurrentForm->hasValue($media_list->FormActionName) && $media_list->EventCancelled)
				$media_list->RowAction = strval($CurrentForm->getValue($media_list->FormActionName));
			elseif ($media->isGridAdd())
				$media_list->RowAction = "insert";
			else
				$media_list->RowAction = "";
		}

		// Set up key count
		$media_list->KeyCount = $media_list->RowIndex;

		// Init row class and style
		$media->resetAttributes();
		$media->CssClass = "";
		if ($media->isGridAdd()) {
			$media_list->loadRowValues(); // Load default values
		} else {
			$media_list->loadRowValues($media_list->Recordset); // Load row values
		}
		$media->RowType = ROWTYPE_VIEW; // Render view
		if ($media->isGridAdd()) // Grid add
			$media->RowType = ROWTYPE_ADD; // Render add
		if ($media->isGridAdd() && $media->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$media_list->restoreCurrentRowFormValues($media_list->RowIndex); // Restore form values
		if ($media->isEdit()) {
			if ($media_list->checkInlineEditKey() && $media_list->EditRowCnt == 0) { // Inline edit
				$media->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($media->isEdit() && $media->RowType == ROWTYPE_EDIT && $media->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$media_list->restoreFormValues(); // Restore form values
		}
		if ($media->RowType == ROWTYPE_EDIT) // Edit row
			$media_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$media->RowAttrs = array_merge($media->RowAttrs, array('data-rowindex'=>$media_list->RowCnt, 'id'=>'r' . $media_list->RowCnt . '_media', 'data-rowtype'=>$media->RowType));

		// Render row
		$media_list->renderRow();

		// Render list options
		$media_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($media_list->RowAction <> "delete" && $media_list->RowAction <> "insertdelete" && !($media_list->RowAction == "insert" && $media->isConfirm() && $media_list->emptyRow())) {
?>
	<tr<?php echo $media->rowAttributes() ?>>
<?php

// Render list options (body, left)
$media_list->ListOptions->render("body", "left", $media_list->RowCnt);
?>
	<?php if ($media->mediaId->Visible) { // mediaId ?>
		<td data-name="mediaId"<?php echo $media->mediaId->cellAttributes() ?>>
<?php if ($media->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="media" data-field="x_mediaId" name="o<?php echo $media_list->RowIndex ?>_mediaId" id="o<?php echo $media_list->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->OldValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_mediaId" class="form-group media_mediaId">
<span<?php echo $media->mediaId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->mediaId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="media" data-field="x_mediaId" name="x<?php echo $media_list->RowIndex ?>_mediaId" id="x<?php echo $media_list->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->CurrentValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_mediaId" class="media_mediaId">
<span<?php echo $media->mediaId->viewAttributes() ?>>
<?php echo $media->mediaId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($media->advId->Visible) { // advId ?>
		<td data-name="advId"<?php echo $media->advId->cellAttributes() ?>>
<?php if ($media->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($media->advId->getSessionValue() <> "") { ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_advId" class="form-group media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $media_list->RowIndex ?>_advId" name="x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_advId" class="form-group media_advId">
<?php
$wrkonchange = "" . trim(@$media->advId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$media->advId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $media_list->RowIndex ?>_advId" class="text-nowrap" style="z-index: <?php echo (9000 - $media_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $media_list->RowIndex ?>_advId" id="sv_x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo RemoveHtml($media->advId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>"<?php echo $media->advId->editAttributes() ?>>
</span>
<input type="hidden" data-table="media" data-field="x_advId" data-value-separator="<?php echo $media->advId->displayValueSeparatorAttribute() ?>" name="x<?php echo $media_list->RowIndex ?>_advId" id="x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fmedialist.createAutoSuggest({"id":"x<?php echo $media_list->RowIndex ?>_advId","forceSelect":true});
</script>
<?php echo $media->advId->Lookup->getParamTag("p_x" . $media_list->RowIndex . "_advId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="media" data-field="x_advId" name="o<?php echo $media_list->RowIndex ?>_advId" id="o<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->OldValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($media->advId->getSessionValue() <> "") { ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_advId" class="form-group media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $media_list->RowIndex ?>_advId" name="x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_advId" class="form-group media_advId">
<?php
$wrkonchange = "" . trim(@$media->advId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$media->advId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $media_list->RowIndex ?>_advId" class="text-nowrap" style="z-index: <?php echo (9000 - $media_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $media_list->RowIndex ?>_advId" id="sv_x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo RemoveHtml($media->advId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>"<?php echo $media->advId->editAttributes() ?>>
</span>
<input type="hidden" data-table="media" data-field="x_advId" data-value-separator="<?php echo $media->advId->displayValueSeparatorAttribute() ?>" name="x<?php echo $media_list->RowIndex ?>_advId" id="x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fmedialist.createAutoSuggest({"id":"x<?php echo $media_list->RowIndex ?>_advId","forceSelect":true});
</script>
<?php echo $media->advId->Lookup->getParamTag("p_x" . $media_list->RowIndex . "_advId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_advId" class="media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<?php echo $media->advId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($media->filename->Visible) { // filename ?>
		<td data-name="filename"<?php echo $media->filename->cellAttributes() ?>>
<?php if ($media->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_filename" class="form-group media_filename">
<div id="fd_x<?php echo $media_list->RowIndex ?>_filename">
<span title="<?php echo $media->filename->title() ? $media->filename->title() : $Language->phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->filename->ReadOnly || $media->filename->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x_filename" name="x<?php echo $media_list->RowIndex ?>_filename" id="x<?php echo $media_list->RowIndex ?>_filename" multiple="multiple"<?php echo $media->filename->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_list->RowIndex ?>_filename" id= "fn_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>_filename" id= "fa_x<?php echo $media_list->RowIndex ?>_filename" value="0">
<input type="hidden" name="fs_x<?php echo $media_list->RowIndex ?>_filename" id= "fs_x<?php echo $media_list->RowIndex ?>_filename" value="255">
<input type="hidden" name="fx_x<?php echo $media_list->RowIndex ?>_filename" id= "fx_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_list->RowIndex ?>_filename" id= "fm_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $media_list->RowIndex ?>_filename" id= "fc_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $media_list->RowIndex ?>_filename" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x_filename" name="o<?php echo $media_list->RowIndex ?>_filename" id="o<?php echo $media_list->RowIndex ?>_filename" value="<?php echo HtmlEncode($media->filename->OldValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_filename" class="form-group media_filename">
<div id="fd_x<?php echo $media_list->RowIndex ?>_filename">
<span title="<?php echo $media->filename->title() ? $media->filename->title() : $Language->phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->filename->ReadOnly || $media->filename->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x_filename" name="x<?php echo $media_list->RowIndex ?>_filename" id="x<?php echo $media_list->RowIndex ?>_filename" multiple="multiple"<?php echo $media->filename->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_list->RowIndex ?>_filename" id= "fn_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->Upload->FileName ?>">
<?php if (Post("fa_x<?php echo $media_list->RowIndex ?>_filename") == "0") { ?>
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>_filename" id= "fa_x<?php echo $media_list->RowIndex ?>_filename" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>_filename" id= "fa_x<?php echo $media_list->RowIndex ?>_filename" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $media_list->RowIndex ?>_filename" id= "fs_x<?php echo $media_list->RowIndex ?>_filename" value="255">
<input type="hidden" name="fx_x<?php echo $media_list->RowIndex ?>_filename" id= "fx_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_list->RowIndex ?>_filename" id= "fm_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $media_list->RowIndex ?>_filename" id= "fc_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $media_list->RowIndex ?>_filename" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media_filename" class="media_filename">
<span>
<?php echo GetFileViewTag($media->filename, $media->filename->getViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail"<?php echo $media->_thumbnail->cellAttributes() ?>>
<?php if ($media->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media__thumbnail" class="form-group media__thumbnail">
<div id="fd_x<?php echo $media_list->RowIndex ?>__thumbnail">
<span title="<?php echo $media->_thumbnail->title() ? $media->_thumbnail->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->_thumbnail->ReadOnly || $media->_thumbnail->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x__thumbnail" name="x<?php echo $media_list->RowIndex ?>__thumbnail" id="x<?php echo $media_list->RowIndex ?>__thumbnail"<?php echo $media->_thumbnail->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fn_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_list->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fs_x<?php echo $media_list->RowIndex ?>__thumbnail" value="255">
<input type="hidden" name="fx_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fx_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fm_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $media_list->RowIndex ?>__thumbnail" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x__thumbnail" name="o<?php echo $media_list->RowIndex ?>__thumbnail" id="o<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo HtmlEncode($media->_thumbnail->OldValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media__thumbnail" class="form-group media__thumbnail">
<div id="fd_x<?php echo $media_list->RowIndex ?>__thumbnail">
<span title="<?php echo $media->_thumbnail->title() ? $media->_thumbnail->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->_thumbnail->ReadOnly || $media->_thumbnail->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x__thumbnail" name="x<?php echo $media_list->RowIndex ?>__thumbnail" id="x<?php echo $media_list->RowIndex ?>__thumbnail"<?php echo $media->_thumbnail->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fn_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->Upload->FileName ?>">
<?php if (Post("fa_x<?php echo $media_list->RowIndex ?>__thumbnail") == "0") { ?>
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_list->RowIndex ?>__thumbnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_list->RowIndex ?>__thumbnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fs_x<?php echo $media_list->RowIndex ?>__thumbnail" value="255">
<input type="hidden" name="fx_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fx_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fm_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $media_list->RowIndex ?>__thumbnail" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_list->RowCnt ?>_media__thumbnail" class="media__thumbnail">
<span>
<?php echo GetFileViewTag($media->_thumbnail, $media->_thumbnail->getViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$media_list->ListOptions->render("body", "right", $media_list->RowCnt);
?>
	</tr>
<?php if ($media->RowType == ROWTYPE_ADD || $media->RowType == ROWTYPE_EDIT) { ?>
<script>
fmedialist.updateLists(<?php echo $media_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$media->isGridAdd())
		if (!$media_list->Recordset->EOF)
			$media_list->Recordset->moveNext();
}
?>
<?php
	if ($media->isGridAdd() || $media->isGridEdit()) {
		$media_list->RowIndex = '$rowindex$';
		$media_list->loadRowValues();

		// Set row properties
		$media->resetAttributes();
		$media->RowAttrs = array_merge($media->RowAttrs, array('data-rowindex'=>$media_list->RowIndex, 'id'=>'r0_media', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($media->RowAttrs["class"], "ew-template");
		$media->RowType = ROWTYPE_ADD;

		// Render row
		$media_list->renderRow();

		// Render list options
		$media_list->renderListOptions();
		$media_list->StartRowCnt = 0;
?>
	<tr<?php echo $media->rowAttributes() ?>>
<?php

// Render list options (body, left)
$media_list->ListOptions->render("body", "left", $media_list->RowIndex);
?>
	<?php if ($media->mediaId->Visible) { // mediaId ?>
		<td data-name="mediaId">
<input type="hidden" data-table="media" data-field="x_mediaId" name="o<?php echo $media_list->RowIndex ?>_mediaId" id="o<?php echo $media_list->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($media->advId->Visible) { // advId ?>
		<td data-name="advId">
<?php if ($media->advId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_media_advId" class="form-group media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $media_list->RowIndex ?>_advId" name="x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_media_advId" class="form-group media_advId">
<?php
$wrkonchange = "" . trim(@$media->advId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$media->advId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $media_list->RowIndex ?>_advId" class="text-nowrap" style="z-index: <?php echo (9000 - $media_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $media_list->RowIndex ?>_advId" id="sv_x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo RemoveHtml($media->advId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>"<?php echo $media->advId->editAttributes() ?>>
</span>
<input type="hidden" data-table="media" data-field="x_advId" data-value-separator="<?php echo $media->advId->displayValueSeparatorAttribute() ?>" name="x<?php echo $media_list->RowIndex ?>_advId" id="x<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fmedialist.createAutoSuggest({"id":"x<?php echo $media_list->RowIndex ?>_advId","forceSelect":true});
</script>
<?php echo $media->advId->Lookup->getParamTag("p_x" . $media_list->RowIndex . "_advId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="media" data-field="x_advId" name="o<?php echo $media_list->RowIndex ?>_advId" id="o<?php echo $media_list->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($media->filename->Visible) { // filename ?>
		<td data-name="filename">
<span id="el$rowindex$_media_filename" class="form-group media_filename">
<div id="fd_x<?php echo $media_list->RowIndex ?>_filename">
<span title="<?php echo $media->filename->title() ? $media->filename->title() : $Language->phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->filename->ReadOnly || $media->filename->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x_filename" name="x<?php echo $media_list->RowIndex ?>_filename" id="x<?php echo $media_list->RowIndex ?>_filename" multiple="multiple"<?php echo $media->filename->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_list->RowIndex ?>_filename" id= "fn_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>_filename" id= "fa_x<?php echo $media_list->RowIndex ?>_filename" value="0">
<input type="hidden" name="fs_x<?php echo $media_list->RowIndex ?>_filename" id= "fs_x<?php echo $media_list->RowIndex ?>_filename" value="255">
<input type="hidden" name="fx_x<?php echo $media_list->RowIndex ?>_filename" id= "fx_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_list->RowIndex ?>_filename" id= "fm_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $media_list->RowIndex ?>_filename" id= "fc_x<?php echo $media_list->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $media_list->RowIndex ?>_filename" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x_filename" name="o<?php echo $media_list->RowIndex ?>_filename" id="o<?php echo $media_list->RowIndex ?>_filename" value="<?php echo HtmlEncode($media->filename->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail">
<span id="el$rowindex$_media__thumbnail" class="form-group media__thumbnail">
<div id="fd_x<?php echo $media_list->RowIndex ?>__thumbnail">
<span title="<?php echo $media->_thumbnail->title() ? $media->_thumbnail->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->_thumbnail->ReadOnly || $media->_thumbnail->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x__thumbnail" name="x<?php echo $media_list->RowIndex ?>__thumbnail" id="x<?php echo $media_list->RowIndex ?>__thumbnail"<?php echo $media->_thumbnail->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fn_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_list->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fs_x<?php echo $media_list->RowIndex ?>__thumbnail" value="255">
<input type="hidden" name="fx_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fx_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_list->RowIndex ?>__thumbnail" id= "fm_x<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $media_list->RowIndex ?>__thumbnail" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x__thumbnail" name="o<?php echo $media_list->RowIndex ?>__thumbnail" id="o<?php echo $media_list->RowIndex ?>__thumbnail" value="<?php echo HtmlEncode($media->_thumbnail->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$media_list->ListOptions->render("body", "right", $media_list->RowIndex);
?>
<script>
fmedialist.updateLists(<?php echo $media_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($media->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $media_list->FormKeyCountName ?>" id="<?php echo $media_list->FormKeyCountName ?>" value="<?php echo $media_list->KeyCount ?>">
<?php echo $media_list->MultiSelectKey ?>
<?php } ?>
<?php if ($media->isEdit()) { ?>
<input type="hidden" name="<?php echo $media_list->FormKeyCountName ?>" id="<?php echo $media_list->FormKeyCountName ?>" value="<?php echo $media_list->KeyCount ?>">
<?php } ?>
<?php if (!$media->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($media_list->Recordset)
	$media_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($media_list->TotalRecs == 0 && !$media->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $media_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$media_list->showPageFooter();
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
$media_list->terminate();
?>
