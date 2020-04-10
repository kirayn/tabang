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
$topics_list = new topics_list();

// Run the page
$topics_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$topics_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$topics->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var ftopicslist = currentForm = new ew.Form("ftopicslist", "list");
ftopicslist.formKeyCountName = '<?php echo $topics_list->FormKeyCountName ?>';

// Validate form
ftopicslist.validate = function() {
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
		<?php if ($topics_list->topicId->Required) { ?>
			elm = this.getElements("x" + infix + "_topicId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $topics->topicId->caption(), $topics->topicId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($topics_list->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $topics->title->caption(), $topics->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($topics_list->parentId->Required) { ?>
			elm = this.getElements("x" + infix + "_parentId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $topics->parentId->caption(), $topics->parentId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_parentId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($topics->parentId->errorMessage()) ?>");

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
ftopicslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "title", false)) return false;
	if (ew.valueChanged(fobj, infix, "parentId", false)) return false;
	return true;
}

// Form_CustomValidate event
ftopicslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
ftopicslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var ftopicslistsrch = currentSearchForm = new ew.Form("ftopicslistsrch");

// Filters
ftopicslistsrch.filterList = <?php echo $topics_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$topics->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($topics_list->TotalRecs > 0 && $topics_list->ExportOptions->visible()) { ?>
<?php $topics_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($topics_list->ImportOptions->visible()) { ?>
<?php $topics_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($topics_list->SearchOptions->visible()) { ?>
<?php $topics_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($topics_list->FilterOptions->visible()) { ?>
<?php $topics_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$topics_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$topics->isExport() && !$topics->CurrentAction) { ?>
<form name="ftopicslistsrch" id="ftopicslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($topics_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="ftopicslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="topics">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($topics_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($topics_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $topics_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($topics_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($topics_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($topics_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($topics_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $topics_list->showPageHeader(); ?>
<?php
$topics_list->showMessage();
?>
<?php if ($topics_list->TotalRecs > 0 || $topics->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($topics_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> topics">
<?php if (!$topics->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$topics->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($topics_list->Pager)) $topics_list->Pager = new PrevNextPager($topics_list->StartRec, $topics_list->DisplayRecs, $topics_list->TotalRecs, $topics_list->AutoHidePager) ?>
<?php if ($topics_list->Pager->RecordCount > 0 && $topics_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($topics_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $topics_list->pageUrl() ?>start=<?php echo $topics_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($topics_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $topics_list->pageUrl() ?>start=<?php echo $topics_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $topics_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($topics_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $topics_list->pageUrl() ?>start=<?php echo $topics_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($topics_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $topics_list->pageUrl() ?>start=<?php echo $topics_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $topics_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($topics_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $topics_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $topics_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $topics_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $topics_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ftopicslist" id="ftopicslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($topics_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $topics_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="topics">
<div id="gmp_topics" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($topics_list->TotalRecs > 0 || $topics->isGridEdit()) { ?>
<table id="tbl_topicslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$topics_list->RowType = ROWTYPE_HEADER;

// Render list options
$topics_list->renderListOptions();

// Render list options (header, left)
$topics_list->ListOptions->render("header", "left");
?>
<?php if ($topics->topicId->Visible) { // topicId ?>
	<?php if ($topics->sortUrl($topics->topicId) == "") { ?>
		<th data-name="topicId" class="<?php echo $topics->topicId->headerCellClass() ?>"><div id="elh_topics_topicId" class="topics_topicId"><div class="ew-table-header-caption"><?php echo $topics->topicId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="topicId" class="<?php echo $topics->topicId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $topics->SortUrl($topics->topicId) ?>',1);"><div id="elh_topics_topicId" class="topics_topicId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $topics->topicId->caption() ?></span><span class="ew-table-header-sort"><?php if ($topics->topicId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($topics->topicId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($topics->title->Visible) { // title ?>
	<?php if ($topics->sortUrl($topics->title) == "") { ?>
		<th data-name="title" class="<?php echo $topics->title->headerCellClass() ?>"><div id="elh_topics_title" class="topics_title"><div class="ew-table-header-caption"><?php echo $topics->title->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $topics->title->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $topics->SortUrl($topics->title) ?>',1);"><div id="elh_topics_title" class="topics_title">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $topics->title->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($topics->title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($topics->title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($topics->parentId->Visible) { // parentId ?>
	<?php if ($topics->sortUrl($topics->parentId) == "") { ?>
		<th data-name="parentId" class="<?php echo $topics->parentId->headerCellClass() ?>"><div id="elh_topics_parentId" class="topics_parentId"><div class="ew-table-header-caption"><?php echo $topics->parentId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="parentId" class="<?php echo $topics->parentId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $topics->SortUrl($topics->parentId) ?>',1);"><div id="elh_topics_parentId" class="topics_parentId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $topics->parentId->caption() ?></span><span class="ew-table-header-sort"><?php if ($topics->parentId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($topics->parentId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$topics_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($topics->ExportAll && $topics->isExport()) {
	$topics_list->StopRec = $topics_list->TotalRecs;
} else {

	// Set the last record to display
	if ($topics_list->TotalRecs > $topics_list->StartRec + $topics_list->DisplayRecs - 1)
		$topics_list->StopRec = $topics_list->StartRec + $topics_list->DisplayRecs - 1;
	else
		$topics_list->StopRec = $topics_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $topics_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($topics_list->FormKeyCountName) && ($topics->isGridAdd() || $topics->isGridEdit() || $topics->isConfirm())) {
		$topics_list->KeyCount = $CurrentForm->getValue($topics_list->FormKeyCountName);
		$topics_list->StopRec = $topics_list->StartRec + $topics_list->KeyCount - 1;
	}
}
$topics_list->RecCnt = $topics_list->StartRec - 1;
if ($topics_list->Recordset && !$topics_list->Recordset->EOF) {
	$topics_list->Recordset->moveFirst();
	$selectLimit = $topics_list->UseSelectLimit;
	if (!$selectLimit && $topics_list->StartRec > 1)
		$topics_list->Recordset->move($topics_list->StartRec - 1);
} elseif (!$topics->AllowAddDeleteRow && $topics_list->StopRec == 0) {
	$topics_list->StopRec = $topics->GridAddRowCount;
}

// Initialize aggregate
$topics->RowType = ROWTYPE_AGGREGATEINIT;
$topics->resetAttributes();
$topics_list->renderRow();
$topics_list->EditRowCnt = 0;
if ($topics->isEdit())
	$topics_list->RowIndex = 1;
if ($topics->isGridAdd())
	$topics_list->RowIndex = 0;
while ($topics_list->RecCnt < $topics_list->StopRec) {
	$topics_list->RecCnt++;
	if ($topics_list->RecCnt >= $topics_list->StartRec) {
		$topics_list->RowCnt++;
		if ($topics->isGridAdd() || $topics->isGridEdit() || $topics->isConfirm()) {
			$topics_list->RowIndex++;
			$CurrentForm->Index = $topics_list->RowIndex;
			if ($CurrentForm->hasValue($topics_list->FormActionName) && $topics_list->EventCancelled)
				$topics_list->RowAction = strval($CurrentForm->getValue($topics_list->FormActionName));
			elseif ($topics->isGridAdd())
				$topics_list->RowAction = "insert";
			else
				$topics_list->RowAction = "";
		}

		// Set up key count
		$topics_list->KeyCount = $topics_list->RowIndex;

		// Init row class and style
		$topics->resetAttributes();
		$topics->CssClass = "";
		if ($topics->isGridAdd()) {
			$topics_list->loadRowValues(); // Load default values
		} else {
			$topics_list->loadRowValues($topics_list->Recordset); // Load row values
		}
		$topics->RowType = ROWTYPE_VIEW; // Render view
		if ($topics->isGridAdd()) // Grid add
			$topics->RowType = ROWTYPE_ADD; // Render add
		if ($topics->isGridAdd() && $topics->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$topics_list->restoreCurrentRowFormValues($topics_list->RowIndex); // Restore form values
		if ($topics->isEdit()) {
			if ($topics_list->checkInlineEditKey() && $topics_list->EditRowCnt == 0) { // Inline edit
				$topics->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($topics->isEdit() && $topics->RowType == ROWTYPE_EDIT && $topics->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$topics_list->restoreFormValues(); // Restore form values
		}
		if ($topics->RowType == ROWTYPE_EDIT) // Edit row
			$topics_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$topics->RowAttrs = array_merge($topics->RowAttrs, array('data-rowindex'=>$topics_list->RowCnt, 'id'=>'r' . $topics_list->RowCnt . '_topics', 'data-rowtype'=>$topics->RowType));

		// Render row
		$topics_list->renderRow();

		// Render list options
		$topics_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($topics_list->RowAction <> "delete" && $topics_list->RowAction <> "insertdelete" && !($topics_list->RowAction == "insert" && $topics->isConfirm() && $topics_list->emptyRow())) {
?>
	<tr<?php echo $topics->rowAttributes() ?>>
<?php

// Render list options (body, left)
$topics_list->ListOptions->render("body", "left", $topics_list->RowCnt);
?>
	<?php if ($topics->topicId->Visible) { // topicId ?>
		<td data-name="topicId"<?php echo $topics->topicId->cellAttributes() ?>>
<?php if ($topics->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="topics" data-field="x_topicId" name="o<?php echo $topics_list->RowIndex ?>_topicId" id="o<?php echo $topics_list->RowIndex ?>_topicId" value="<?php echo HtmlEncode($topics->topicId->OldValue) ?>">
<?php } ?>
<?php if ($topics->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_topicId" class="form-group topics_topicId">
<span<?php echo $topics->topicId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($topics->topicId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="topics" data-field="x_topicId" name="x<?php echo $topics_list->RowIndex ?>_topicId" id="x<?php echo $topics_list->RowIndex ?>_topicId" value="<?php echo HtmlEncode($topics->topicId->CurrentValue) ?>">
<?php } ?>
<?php if ($topics->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_topicId" class="topics_topicId">
<span<?php echo $topics->topicId->viewAttributes() ?>>
<?php echo $topics->topicId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($topics->title->Visible) { // title ?>
		<td data-name="title"<?php echo $topics->title->cellAttributes() ?>>
<?php if ($topics->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_title" class="form-group topics_title">
<input type="text" data-table="topics" data-field="x_title" name="x<?php echo $topics_list->RowIndex ?>_title" id="x<?php echo $topics_list->RowIndex ?>_title" size="30" maxlength="200" placeholder="<?php echo HtmlEncode($topics->title->getPlaceHolder()) ?>" value="<?php echo $topics->title->EditValue ?>"<?php echo $topics->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="topics" data-field="x_title" name="o<?php echo $topics_list->RowIndex ?>_title" id="o<?php echo $topics_list->RowIndex ?>_title" value="<?php echo HtmlEncode($topics->title->OldValue) ?>">
<?php } ?>
<?php if ($topics->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_title" class="form-group topics_title">
<input type="text" data-table="topics" data-field="x_title" name="x<?php echo $topics_list->RowIndex ?>_title" id="x<?php echo $topics_list->RowIndex ?>_title" size="30" maxlength="200" placeholder="<?php echo HtmlEncode($topics->title->getPlaceHolder()) ?>" value="<?php echo $topics->title->EditValue ?>"<?php echo $topics->title->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($topics->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_title" class="topics_title">
<span<?php echo $topics->title->viewAttributes() ?>>
<?php echo $topics->title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($topics->parentId->Visible) { // parentId ?>
		<td data-name="parentId"<?php echo $topics->parentId->cellAttributes() ?>>
<?php if ($topics->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_parentId" class="form-group topics_parentId">
<input type="text" data-table="topics" data-field="x_parentId" name="x<?php echo $topics_list->RowIndex ?>_parentId" id="x<?php echo $topics_list->RowIndex ?>_parentId" size="30" placeholder="<?php echo HtmlEncode($topics->parentId->getPlaceHolder()) ?>" value="<?php echo $topics->parentId->EditValue ?>"<?php echo $topics->parentId->editAttributes() ?>>
</span>
<input type="hidden" data-table="topics" data-field="x_parentId" name="o<?php echo $topics_list->RowIndex ?>_parentId" id="o<?php echo $topics_list->RowIndex ?>_parentId" value="<?php echo HtmlEncode($topics->parentId->OldValue) ?>">
<?php } ?>
<?php if ($topics->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_parentId" class="form-group topics_parentId">
<input type="text" data-table="topics" data-field="x_parentId" name="x<?php echo $topics_list->RowIndex ?>_parentId" id="x<?php echo $topics_list->RowIndex ?>_parentId" size="30" placeholder="<?php echo HtmlEncode($topics->parentId->getPlaceHolder()) ?>" value="<?php echo $topics->parentId->EditValue ?>"<?php echo $topics->parentId->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($topics->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $topics_list->RowCnt ?>_topics_parentId" class="topics_parentId">
<span<?php echo $topics->parentId->viewAttributes() ?>>
<?php echo $topics->parentId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$topics_list->ListOptions->render("body", "right", $topics_list->RowCnt);
?>
	</tr>
<?php if ($topics->RowType == ROWTYPE_ADD || $topics->RowType == ROWTYPE_EDIT) { ?>
<script>
ftopicslist.updateLists(<?php echo $topics_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$topics->isGridAdd())
		if (!$topics_list->Recordset->EOF)
			$topics_list->Recordset->moveNext();
}
?>
<?php
	if ($topics->isGridAdd() || $topics->isGridEdit()) {
		$topics_list->RowIndex = '$rowindex$';
		$topics_list->loadRowValues();

		// Set row properties
		$topics->resetAttributes();
		$topics->RowAttrs = array_merge($topics->RowAttrs, array('data-rowindex'=>$topics_list->RowIndex, 'id'=>'r0_topics', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($topics->RowAttrs["class"], "ew-template");
		$topics->RowType = ROWTYPE_ADD;

		// Render row
		$topics_list->renderRow();

		// Render list options
		$topics_list->renderListOptions();
		$topics_list->StartRowCnt = 0;
?>
	<tr<?php echo $topics->rowAttributes() ?>>
<?php

// Render list options (body, left)
$topics_list->ListOptions->render("body", "left", $topics_list->RowIndex);
?>
	<?php if ($topics->topicId->Visible) { // topicId ?>
		<td data-name="topicId">
<input type="hidden" data-table="topics" data-field="x_topicId" name="o<?php echo $topics_list->RowIndex ?>_topicId" id="o<?php echo $topics_list->RowIndex ?>_topicId" value="<?php echo HtmlEncode($topics->topicId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($topics->title->Visible) { // title ?>
		<td data-name="title">
<span id="el$rowindex$_topics_title" class="form-group topics_title">
<input type="text" data-table="topics" data-field="x_title" name="x<?php echo $topics_list->RowIndex ?>_title" id="x<?php echo $topics_list->RowIndex ?>_title" size="30" maxlength="200" placeholder="<?php echo HtmlEncode($topics->title->getPlaceHolder()) ?>" value="<?php echo $topics->title->EditValue ?>"<?php echo $topics->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="topics" data-field="x_title" name="o<?php echo $topics_list->RowIndex ?>_title" id="o<?php echo $topics_list->RowIndex ?>_title" value="<?php echo HtmlEncode($topics->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($topics->parentId->Visible) { // parentId ?>
		<td data-name="parentId">
<span id="el$rowindex$_topics_parentId" class="form-group topics_parentId">
<input type="text" data-table="topics" data-field="x_parentId" name="x<?php echo $topics_list->RowIndex ?>_parentId" id="x<?php echo $topics_list->RowIndex ?>_parentId" size="30" placeholder="<?php echo HtmlEncode($topics->parentId->getPlaceHolder()) ?>" value="<?php echo $topics->parentId->EditValue ?>"<?php echo $topics->parentId->editAttributes() ?>>
</span>
<input type="hidden" data-table="topics" data-field="x_parentId" name="o<?php echo $topics_list->RowIndex ?>_parentId" id="o<?php echo $topics_list->RowIndex ?>_parentId" value="<?php echo HtmlEncode($topics->parentId->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$topics_list->ListOptions->render("body", "right", $topics_list->RowIndex);
?>
<script>
ftopicslist.updateLists(<?php echo $topics_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($topics->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $topics_list->FormKeyCountName ?>" id="<?php echo $topics_list->FormKeyCountName ?>" value="<?php echo $topics_list->KeyCount ?>">
<?php echo $topics_list->MultiSelectKey ?>
<?php } ?>
<?php if ($topics->isEdit()) { ?>
<input type="hidden" name="<?php echo $topics_list->FormKeyCountName ?>" id="<?php echo $topics_list->FormKeyCountName ?>" value="<?php echo $topics_list->KeyCount ?>">
<?php } ?>
<?php if (!$topics->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($topics_list->Recordset)
	$topics_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($topics_list->TotalRecs == 0 && !$topics->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $topics_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$topics_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$topics->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$topics_list->terminate();
?>
