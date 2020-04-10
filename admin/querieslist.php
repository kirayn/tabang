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
$queries_list = new queries_list();

// Run the page
$queries_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$queries_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$queries->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fquerieslist = currentForm = new ew.Form("fquerieslist", "list");
fquerieslist.formKeyCountName = '<?php echo $queries_list->FormKeyCountName ?>';

// Validate form
fquerieslist.validate = function() {
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
		<?php if ($queries_list->queryId->Required) { ?>
			elm = this.getElements("x" + infix + "_queryId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->queryId->caption(), $queries->queryId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($queries_list->topicId->Required) { ?>
			elm = this.getElements("x" + infix + "_topicId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->topicId->caption(), $queries->topicId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($queries_list->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->_userId->caption(), $queries->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($queries->_userId->errorMessage()) ?>");
		<?php if ($queries_list->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->title->caption(), $queries->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($queries_list->details->Required) { ?>
			elm = this.getElements("x" + infix + "_details");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->details->caption(), $queries->details->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($queries_list->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->date->caption(), $queries->date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($queries->date->errorMessage()) ?>");

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
fquerieslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "topicId", false)) return false;
	if (ew.valueChanged(fobj, infix, "_userId", false)) return false;
	if (ew.valueChanged(fobj, infix, "title", false)) return false;
	if (ew.valueChanged(fobj, infix, "details", false)) return false;
	if (ew.valueChanged(fobj, infix, "date", false)) return false;
	return true;
}

// Form_CustomValidate event
fquerieslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fquerieslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fquerieslist.lists["x_topicId"] = <?php echo $queries_list->topicId->Lookup->toClientList() ?>;
fquerieslist.lists["x_topicId"].options = <?php echo JsonEncode($queries_list->topicId->lookupOptions()) ?>;
fquerieslist.lists["x__userId"] = <?php echo $queries_list->_userId->Lookup->toClientList() ?>;
fquerieslist.lists["x__userId"].options = <?php echo JsonEncode($queries_list->_userId->lookupOptions()) ?>;
fquerieslist.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
var fquerieslistsrch = currentSearchForm = new ew.Form("fquerieslistsrch");

// Filters
fquerieslistsrch.filterList = <?php echo $queries_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$queries->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($queries_list->TotalRecs > 0 && $queries_list->ExportOptions->visible()) { ?>
<?php $queries_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($queries_list->ImportOptions->visible()) { ?>
<?php $queries_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($queries_list->SearchOptions->visible()) { ?>
<?php $queries_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($queries_list->FilterOptions->visible()) { ?>
<?php $queries_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$queries_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$queries->isExport() && !$queries->CurrentAction) { ?>
<form name="fquerieslistsrch" id="fquerieslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($queries_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fquerieslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="queries">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($queries_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($queries_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $queries_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($queries_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($queries_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($queries_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($queries_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $queries_list->showPageHeader(); ?>
<?php
$queries_list->showMessage();
?>
<?php if ($queries_list->TotalRecs > 0 || $queries->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($queries_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> queries">
<?php if (!$queries->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$queries->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($queries_list->Pager)) $queries_list->Pager = new PrevNextPager($queries_list->StartRec, $queries_list->DisplayRecs, $queries_list->TotalRecs, $queries_list->AutoHidePager) ?>
<?php if ($queries_list->Pager->RecordCount > 0 && $queries_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($queries_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $queries_list->pageUrl() ?>start=<?php echo $queries_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($queries_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $queries_list->pageUrl() ?>start=<?php echo $queries_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $queries_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($queries_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $queries_list->pageUrl() ?>start=<?php echo $queries_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($queries_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $queries_list->pageUrl() ?>start=<?php echo $queries_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $queries_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($queries_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $queries_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $queries_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $queries_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $queries_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fquerieslist" id="fquerieslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($queries_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $queries_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="queries">
<div id="gmp_queries" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($queries_list->TotalRecs > 0 || $queries->isGridEdit()) { ?>
<table id="tbl_querieslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$queries_list->RowType = ROWTYPE_HEADER;

// Render list options
$queries_list->renderListOptions();

// Render list options (header, left)
$queries_list->ListOptions->render("header", "left");
?>
<?php if ($queries->queryId->Visible) { // queryId ?>
	<?php if ($queries->sortUrl($queries->queryId) == "") { ?>
		<th data-name="queryId" class="<?php echo $queries->queryId->headerCellClass() ?>"><div id="elh_queries_queryId" class="queries_queryId"><div class="ew-table-header-caption"><?php echo $queries->queryId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="queryId" class="<?php echo $queries->queryId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $queries->SortUrl($queries->queryId) ?>',1);"><div id="elh_queries_queryId" class="queries_queryId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $queries->queryId->caption() ?></span><span class="ew-table-header-sort"><?php if ($queries->queryId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($queries->queryId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($queries->topicId->Visible) { // topicId ?>
	<?php if ($queries->sortUrl($queries->topicId) == "") { ?>
		<th data-name="topicId" class="<?php echo $queries->topicId->headerCellClass() ?>"><div id="elh_queries_topicId" class="queries_topicId"><div class="ew-table-header-caption"><?php echo $queries->topicId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="topicId" class="<?php echo $queries->topicId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $queries->SortUrl($queries->topicId) ?>',1);"><div id="elh_queries_topicId" class="queries_topicId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $queries->topicId->caption() ?></span><span class="ew-table-header-sort"><?php if ($queries->topicId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($queries->topicId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($queries->_userId->Visible) { // userId ?>
	<?php if ($queries->sortUrl($queries->_userId) == "") { ?>
		<th data-name="_userId" class="<?php echo $queries->_userId->headerCellClass() ?>"><div id="elh_queries__userId" class="queries__userId"><div class="ew-table-header-caption"><?php echo $queries->_userId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_userId" class="<?php echo $queries->_userId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $queries->SortUrl($queries->_userId) ?>',1);"><div id="elh_queries__userId" class="queries__userId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $queries->_userId->caption() ?></span><span class="ew-table-header-sort"><?php if ($queries->_userId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($queries->_userId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($queries->title->Visible) { // title ?>
	<?php if ($queries->sortUrl($queries->title) == "") { ?>
		<th data-name="title" class="<?php echo $queries->title->headerCellClass() ?>"><div id="elh_queries_title" class="queries_title"><div class="ew-table-header-caption"><?php echo $queries->title->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $queries->title->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $queries->SortUrl($queries->title) ?>',1);"><div id="elh_queries_title" class="queries_title">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $queries->title->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($queries->title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($queries->title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($queries->details->Visible) { // details ?>
	<?php if ($queries->sortUrl($queries->details) == "") { ?>
		<th data-name="details" class="<?php echo $queries->details->headerCellClass() ?>"><div id="elh_queries_details" class="queries_details"><div class="ew-table-header-caption"><?php echo $queries->details->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="details" class="<?php echo $queries->details->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $queries->SortUrl($queries->details) ?>',1);"><div id="elh_queries_details" class="queries_details">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $queries->details->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($queries->details->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($queries->details->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($queries->date->Visible) { // date ?>
	<?php if ($queries->sortUrl($queries->date) == "") { ?>
		<th data-name="date" class="<?php echo $queries->date->headerCellClass() ?>"><div id="elh_queries_date" class="queries_date"><div class="ew-table-header-caption"><?php echo $queries->date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $queries->date->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $queries->SortUrl($queries->date) ?>',1);"><div id="elh_queries_date" class="queries_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $queries->date->caption() ?></span><span class="ew-table-header-sort"><?php if ($queries->date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($queries->date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$queries_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($queries->ExportAll && $queries->isExport()) {
	$queries_list->StopRec = $queries_list->TotalRecs;
} else {

	// Set the last record to display
	if ($queries_list->TotalRecs > $queries_list->StartRec + $queries_list->DisplayRecs - 1)
		$queries_list->StopRec = $queries_list->StartRec + $queries_list->DisplayRecs - 1;
	else
		$queries_list->StopRec = $queries_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $queries_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($queries_list->FormKeyCountName) && ($queries->isGridAdd() || $queries->isGridEdit() || $queries->isConfirm())) {
		$queries_list->KeyCount = $CurrentForm->getValue($queries_list->FormKeyCountName);
		$queries_list->StopRec = $queries_list->StartRec + $queries_list->KeyCount - 1;
	}
}
$queries_list->RecCnt = $queries_list->StartRec - 1;
if ($queries_list->Recordset && !$queries_list->Recordset->EOF) {
	$queries_list->Recordset->moveFirst();
	$selectLimit = $queries_list->UseSelectLimit;
	if (!$selectLimit && $queries_list->StartRec > 1)
		$queries_list->Recordset->move($queries_list->StartRec - 1);
} elseif (!$queries->AllowAddDeleteRow && $queries_list->StopRec == 0) {
	$queries_list->StopRec = $queries->GridAddRowCount;
}

// Initialize aggregate
$queries->RowType = ROWTYPE_AGGREGATEINIT;
$queries->resetAttributes();
$queries_list->renderRow();
$queries_list->EditRowCnt = 0;
if ($queries->isEdit())
	$queries_list->RowIndex = 1;
if ($queries->isGridAdd())
	$queries_list->RowIndex = 0;
while ($queries_list->RecCnt < $queries_list->StopRec) {
	$queries_list->RecCnt++;
	if ($queries_list->RecCnt >= $queries_list->StartRec) {
		$queries_list->RowCnt++;
		if ($queries->isGridAdd() || $queries->isGridEdit() || $queries->isConfirm()) {
			$queries_list->RowIndex++;
			$CurrentForm->Index = $queries_list->RowIndex;
			if ($CurrentForm->hasValue($queries_list->FormActionName) && $queries_list->EventCancelled)
				$queries_list->RowAction = strval($CurrentForm->getValue($queries_list->FormActionName));
			elseif ($queries->isGridAdd())
				$queries_list->RowAction = "insert";
			else
				$queries_list->RowAction = "";
		}

		// Set up key count
		$queries_list->KeyCount = $queries_list->RowIndex;

		// Init row class and style
		$queries->resetAttributes();
		$queries->CssClass = "";
		if ($queries->isGridAdd()) {
			$queries_list->loadRowValues(); // Load default values
		} else {
			$queries_list->loadRowValues($queries_list->Recordset); // Load row values
		}
		$queries->RowType = ROWTYPE_VIEW; // Render view
		if ($queries->isGridAdd()) // Grid add
			$queries->RowType = ROWTYPE_ADD; // Render add
		if ($queries->isGridAdd() && $queries->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$queries_list->restoreCurrentRowFormValues($queries_list->RowIndex); // Restore form values
		if ($queries->isEdit()) {
			if ($queries_list->checkInlineEditKey() && $queries_list->EditRowCnt == 0) { // Inline edit
				$queries->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($queries->isEdit() && $queries->RowType == ROWTYPE_EDIT && $queries->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$queries_list->restoreFormValues(); // Restore form values
		}
		if ($queries->RowType == ROWTYPE_EDIT) // Edit row
			$queries_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$queries->RowAttrs = array_merge($queries->RowAttrs, array('data-rowindex'=>$queries_list->RowCnt, 'id'=>'r' . $queries_list->RowCnt . '_queries', 'data-rowtype'=>$queries->RowType));

		// Render row
		$queries_list->renderRow();

		// Render list options
		$queries_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($queries_list->RowAction <> "delete" && $queries_list->RowAction <> "insertdelete" && !($queries_list->RowAction == "insert" && $queries->isConfirm() && $queries_list->emptyRow())) {
?>
	<tr<?php echo $queries->rowAttributes() ?>>
<?php

// Render list options (body, left)
$queries_list->ListOptions->render("body", "left", $queries_list->RowCnt);
?>
	<?php if ($queries->queryId->Visible) { // queryId ?>
		<td data-name="queryId"<?php echo $queries->queryId->cellAttributes() ?>>
<?php if ($queries->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="queries" data-field="x_queryId" name="o<?php echo $queries_list->RowIndex ?>_queryId" id="o<?php echo $queries_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($queries->queryId->OldValue) ?>">
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_queryId" class="form-group queries_queryId">
<span<?php echo $queries->queryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($queries->queryId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="queries" data-field="x_queryId" name="x<?php echo $queries_list->RowIndex ?>_queryId" id="x<?php echo $queries_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($queries->queryId->CurrentValue) ?>">
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_queryId" class="queries_queryId">
<span<?php echo $queries->queryId->viewAttributes() ?>>
<?php echo $queries->queryId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($queries->topicId->Visible) { // topicId ?>
		<td data-name="topicId"<?php echo $queries->topicId->cellAttributes() ?>>
<?php if ($queries->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_topicId" class="form-group queries_topicId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="queries" data-field="x_topicId" data-value-separator="<?php echo $queries->topicId->displayValueSeparatorAttribute() ?>" id="x<?php echo $queries_list->RowIndex ?>_topicId" name="x<?php echo $queries_list->RowIndex ?>_topicId"<?php echo $queries->topicId->editAttributes() ?>>
		<?php echo $queries->topicId->selectOptionListHtml("x<?php echo $queries_list->RowIndex ?>_topicId") ?>
	</select>
</div>
<?php echo $queries->topicId->Lookup->getParamTag("p_x" . $queries_list->RowIndex . "_topicId") ?>
</span>
<input type="hidden" data-table="queries" data-field="x_topicId" name="o<?php echo $queries_list->RowIndex ?>_topicId" id="o<?php echo $queries_list->RowIndex ?>_topicId" value="<?php echo HtmlEncode($queries->topicId->OldValue) ?>">
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_topicId" class="form-group queries_topicId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="queries" data-field="x_topicId" data-value-separator="<?php echo $queries->topicId->displayValueSeparatorAttribute() ?>" id="x<?php echo $queries_list->RowIndex ?>_topicId" name="x<?php echo $queries_list->RowIndex ?>_topicId"<?php echo $queries->topicId->editAttributes() ?>>
		<?php echo $queries->topicId->selectOptionListHtml("x<?php echo $queries_list->RowIndex ?>_topicId") ?>
	</select>
</div>
<?php echo $queries->topicId->Lookup->getParamTag("p_x" . $queries_list->RowIndex . "_topicId") ?>
</span>
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_topicId" class="queries_topicId">
<span<?php echo $queries->topicId->viewAttributes() ?>>
<?php echo $queries->topicId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($queries->_userId->Visible) { // userId ?>
		<td data-name="_userId"<?php echo $queries->_userId->cellAttributes() ?>>
<?php if ($queries->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries__userId" class="form-group queries__userId">
<?php
$wrkonchange = "" . trim(@$queries->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$queries->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $queries_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $queries_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $queries_list->RowIndex ?>__userId" id="sv_x<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($queries->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>"<?php echo $queries->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="queries" data-field="x__userId" data-value-separator="<?php echo $queries->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $queries_list->RowIndex ?>__userId" id="x<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($queries->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fquerieslist.createAutoSuggest({"id":"x<?php echo $queries_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $queries->_userId->Lookup->getParamTag("p_x" . $queries_list->RowIndex . "__userId") ?>
</span>
<input type="hidden" data-table="queries" data-field="x__userId" name="o<?php echo $queries_list->RowIndex ?>__userId" id="o<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($queries->_userId->OldValue) ?>">
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries__userId" class="form-group queries__userId">
<?php
$wrkonchange = "" . trim(@$queries->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$queries->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $queries_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $queries_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $queries_list->RowIndex ?>__userId" id="sv_x<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($queries->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>"<?php echo $queries->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="queries" data-field="x__userId" data-value-separator="<?php echo $queries->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $queries_list->RowIndex ?>__userId" id="x<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($queries->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fquerieslist.createAutoSuggest({"id":"x<?php echo $queries_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $queries->_userId->Lookup->getParamTag("p_x" . $queries_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries__userId" class="queries__userId">
<span<?php echo $queries->_userId->viewAttributes() ?>>
<?php echo $queries->_userId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($queries->title->Visible) { // title ?>
		<td data-name="title"<?php echo $queries->title->cellAttributes() ?>>
<?php if ($queries->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_title" class="form-group queries_title">
<textarea data-table="queries" data-field="x_title" name="x<?php echo $queries_list->RowIndex ?>_title" id="x<?php echo $queries_list->RowIndex ?>_title" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->title->getPlaceHolder()) ?>"<?php echo $queries->title->editAttributes() ?>><?php echo $queries->title->EditValue ?></textarea>
</span>
<input type="hidden" data-table="queries" data-field="x_title" name="o<?php echo $queries_list->RowIndex ?>_title" id="o<?php echo $queries_list->RowIndex ?>_title" value="<?php echo HtmlEncode($queries->title->OldValue) ?>">
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_title" class="form-group queries_title">
<textarea data-table="queries" data-field="x_title" name="x<?php echo $queries_list->RowIndex ?>_title" id="x<?php echo $queries_list->RowIndex ?>_title" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->title->getPlaceHolder()) ?>"<?php echo $queries->title->editAttributes() ?>><?php echo $queries->title->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_title" class="queries_title">
<span<?php echo $queries->title->viewAttributes() ?>>
<?php echo $queries->title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($queries->details->Visible) { // details ?>
		<td data-name="details"<?php echo $queries->details->cellAttributes() ?>>
<?php if ($queries->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_details" class="form-group queries_details">
<textarea data-table="queries" data-field="x_details" name="x<?php echo $queries_list->RowIndex ?>_details" id="x<?php echo $queries_list->RowIndex ?>_details" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->details->getPlaceHolder()) ?>"<?php echo $queries->details->editAttributes() ?>><?php echo $queries->details->EditValue ?></textarea>
</span>
<input type="hidden" data-table="queries" data-field="x_details" name="o<?php echo $queries_list->RowIndex ?>_details" id="o<?php echo $queries_list->RowIndex ?>_details" value="<?php echo HtmlEncode($queries->details->OldValue) ?>">
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_details" class="form-group queries_details">
<textarea data-table="queries" data-field="x_details" name="x<?php echo $queries_list->RowIndex ?>_details" id="x<?php echo $queries_list->RowIndex ?>_details" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->details->getPlaceHolder()) ?>"<?php echo $queries->details->editAttributes() ?>><?php echo $queries->details->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_details" class="queries_details">
<span<?php echo $queries->details->viewAttributes() ?>>
<?php echo $queries->details->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($queries->date->Visible) { // date ?>
		<td data-name="date"<?php echo $queries->date->cellAttributes() ?>>
<?php if ($queries->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_date" class="form-group queries_date">
<input type="text" data-table="queries" data-field="x_date" name="x<?php echo $queries_list->RowIndex ?>_date" id="x<?php echo $queries_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($queries->date->getPlaceHolder()) ?>" value="<?php echo $queries->date->EditValue ?>"<?php echo $queries->date->editAttributes() ?>>
</span>
<input type="hidden" data-table="queries" data-field="x_date" name="o<?php echo $queries_list->RowIndex ?>_date" id="o<?php echo $queries_list->RowIndex ?>_date" value="<?php echo HtmlEncode($queries->date->OldValue) ?>">
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_date" class="form-group queries_date">
<input type="text" data-table="queries" data-field="x_date" name="x<?php echo $queries_list->RowIndex ?>_date" id="x<?php echo $queries_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($queries->date->getPlaceHolder()) ?>" value="<?php echo $queries->date->EditValue ?>"<?php echo $queries->date->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($queries->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $queries_list->RowCnt ?>_queries_date" class="queries_date">
<span<?php echo $queries->date->viewAttributes() ?>>
<?php echo $queries->date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$queries_list->ListOptions->render("body", "right", $queries_list->RowCnt);
?>
	</tr>
<?php if ($queries->RowType == ROWTYPE_ADD || $queries->RowType == ROWTYPE_EDIT) { ?>
<script>
fquerieslist.updateLists(<?php echo $queries_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$queries->isGridAdd())
		if (!$queries_list->Recordset->EOF)
			$queries_list->Recordset->moveNext();
}
?>
<?php
	if ($queries->isGridAdd() || $queries->isGridEdit()) {
		$queries_list->RowIndex = '$rowindex$';
		$queries_list->loadRowValues();

		// Set row properties
		$queries->resetAttributes();
		$queries->RowAttrs = array_merge($queries->RowAttrs, array('data-rowindex'=>$queries_list->RowIndex, 'id'=>'r0_queries', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($queries->RowAttrs["class"], "ew-template");
		$queries->RowType = ROWTYPE_ADD;

		// Render row
		$queries_list->renderRow();

		// Render list options
		$queries_list->renderListOptions();
		$queries_list->StartRowCnt = 0;
?>
	<tr<?php echo $queries->rowAttributes() ?>>
<?php

// Render list options (body, left)
$queries_list->ListOptions->render("body", "left", $queries_list->RowIndex);
?>
	<?php if ($queries->queryId->Visible) { // queryId ?>
		<td data-name="queryId">
<input type="hidden" data-table="queries" data-field="x_queryId" name="o<?php echo $queries_list->RowIndex ?>_queryId" id="o<?php echo $queries_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($queries->queryId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($queries->topicId->Visible) { // topicId ?>
		<td data-name="topicId">
<span id="el$rowindex$_queries_topicId" class="form-group queries_topicId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="queries" data-field="x_topicId" data-value-separator="<?php echo $queries->topicId->displayValueSeparatorAttribute() ?>" id="x<?php echo $queries_list->RowIndex ?>_topicId" name="x<?php echo $queries_list->RowIndex ?>_topicId"<?php echo $queries->topicId->editAttributes() ?>>
		<?php echo $queries->topicId->selectOptionListHtml("x<?php echo $queries_list->RowIndex ?>_topicId") ?>
	</select>
</div>
<?php echo $queries->topicId->Lookup->getParamTag("p_x" . $queries_list->RowIndex . "_topicId") ?>
</span>
<input type="hidden" data-table="queries" data-field="x_topicId" name="o<?php echo $queries_list->RowIndex ?>_topicId" id="o<?php echo $queries_list->RowIndex ?>_topicId" value="<?php echo HtmlEncode($queries->topicId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($queries->_userId->Visible) { // userId ?>
		<td data-name="_userId">
<span id="el$rowindex$_queries__userId" class="form-group queries__userId">
<?php
$wrkonchange = "" . trim(@$queries->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$queries->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $queries_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $queries_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $queries_list->RowIndex ?>__userId" id="sv_x<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($queries->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>"<?php echo $queries->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="queries" data-field="x__userId" data-value-separator="<?php echo $queries->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $queries_list->RowIndex ?>__userId" id="x<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($queries->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fquerieslist.createAutoSuggest({"id":"x<?php echo $queries_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $queries->_userId->Lookup->getParamTag("p_x" . $queries_list->RowIndex . "__userId") ?>
</span>
<input type="hidden" data-table="queries" data-field="x__userId" name="o<?php echo $queries_list->RowIndex ?>__userId" id="o<?php echo $queries_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($queries->_userId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($queries->title->Visible) { // title ?>
		<td data-name="title">
<span id="el$rowindex$_queries_title" class="form-group queries_title">
<textarea data-table="queries" data-field="x_title" name="x<?php echo $queries_list->RowIndex ?>_title" id="x<?php echo $queries_list->RowIndex ?>_title" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->title->getPlaceHolder()) ?>"<?php echo $queries->title->editAttributes() ?>><?php echo $queries->title->EditValue ?></textarea>
</span>
<input type="hidden" data-table="queries" data-field="x_title" name="o<?php echo $queries_list->RowIndex ?>_title" id="o<?php echo $queries_list->RowIndex ?>_title" value="<?php echo HtmlEncode($queries->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($queries->details->Visible) { // details ?>
		<td data-name="details">
<span id="el$rowindex$_queries_details" class="form-group queries_details">
<textarea data-table="queries" data-field="x_details" name="x<?php echo $queries_list->RowIndex ?>_details" id="x<?php echo $queries_list->RowIndex ?>_details" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->details->getPlaceHolder()) ?>"<?php echo $queries->details->editAttributes() ?>><?php echo $queries->details->EditValue ?></textarea>
</span>
<input type="hidden" data-table="queries" data-field="x_details" name="o<?php echo $queries_list->RowIndex ?>_details" id="o<?php echo $queries_list->RowIndex ?>_details" value="<?php echo HtmlEncode($queries->details->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($queries->date->Visible) { // date ?>
		<td data-name="date">
<span id="el$rowindex$_queries_date" class="form-group queries_date">
<input type="text" data-table="queries" data-field="x_date" name="x<?php echo $queries_list->RowIndex ?>_date" id="x<?php echo $queries_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($queries->date->getPlaceHolder()) ?>" value="<?php echo $queries->date->EditValue ?>"<?php echo $queries->date->editAttributes() ?>>
</span>
<input type="hidden" data-table="queries" data-field="x_date" name="o<?php echo $queries_list->RowIndex ?>_date" id="o<?php echo $queries_list->RowIndex ?>_date" value="<?php echo HtmlEncode($queries->date->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$queries_list->ListOptions->render("body", "right", $queries_list->RowIndex);
?>
<script>
fquerieslist.updateLists(<?php echo $queries_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($queries->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $queries_list->FormKeyCountName ?>" id="<?php echo $queries_list->FormKeyCountName ?>" value="<?php echo $queries_list->KeyCount ?>">
<?php echo $queries_list->MultiSelectKey ?>
<?php } ?>
<?php if ($queries->isEdit()) { ?>
<input type="hidden" name="<?php echo $queries_list->FormKeyCountName ?>" id="<?php echo $queries_list->FormKeyCountName ?>" value="<?php echo $queries_list->KeyCount ?>">
<?php } ?>
<?php if (!$queries->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($queries_list->Recordset)
	$queries_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($queries_list->TotalRecs == 0 && !$queries->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $queries_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$queries_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$queries->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$queries_list->terminate();
?>
