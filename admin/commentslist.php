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
$comments_list = new comments_list();

// Run the page
$comments_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comments_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$comments->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fcommentslist = currentForm = new ew.Form("fcommentslist", "list");
fcommentslist.formKeyCountName = '<?php echo $comments_list->FormKeyCountName ?>';

// Validate form
fcommentslist.validate = function() {
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
		<?php if ($comments_list->commentId->Required) { ?>
			elm = this.getElements("x" + infix + "_commentId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->commentId->caption(), $comments->commentId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($comments_list->queryId->Required) { ?>
			elm = this.getElements("x" + infix + "_queryId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->queryId->caption(), $comments->queryId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_queryId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($comments->queryId->errorMessage()) ?>");
		<?php if ($comments_list->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->_userId->caption(), $comments->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($comments->_userId->errorMessage()) ?>");
		<?php if ($comments_list->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->date->caption(), $comments->date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($comments->date->errorMessage()) ?>");
		<?php if ($comments_list->image->Required) { ?>
			elm = this.getElements("x" + infix + "_image");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->image->caption(), $comments->image->RequiredErrorMessage)) ?>");
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
fcommentslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "queryId", false)) return false;
	if (ew.valueChanged(fobj, infix, "_userId", false)) return false;
	if (ew.valueChanged(fobj, infix, "date", false)) return false;
	if (ew.valueChanged(fobj, infix, "image", false)) return false;
	return true;
}

// Form_CustomValidate event
fcommentslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcommentslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcommentslist.lists["x_queryId"] = <?php echo $comments_list->queryId->Lookup->toClientList() ?>;
fcommentslist.lists["x_queryId"].options = <?php echo JsonEncode($comments_list->queryId->lookupOptions()) ?>;
fcommentslist.autoSuggests["x_queryId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fcommentslist.lists["x__userId"] = <?php echo $comments_list->_userId->Lookup->toClientList() ?>;
fcommentslist.lists["x__userId"].options = <?php echo JsonEncode($comments_list->_userId->lookupOptions()) ?>;
fcommentslist.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
var fcommentslistsrch = currentSearchForm = new ew.Form("fcommentslistsrch");

// Filters
fcommentslistsrch.filterList = <?php echo $comments_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$comments->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($comments_list->TotalRecs > 0 && $comments_list->ExportOptions->visible()) { ?>
<?php $comments_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($comments_list->ImportOptions->visible()) { ?>
<?php $comments_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($comments_list->SearchOptions->visible()) { ?>
<?php $comments_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($comments_list->FilterOptions->visible()) { ?>
<?php $comments_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$comments_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$comments->isExport() && !$comments->CurrentAction) { ?>
<form name="fcommentslistsrch" id="fcommentslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($comments_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fcommentslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="comments">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($comments_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($comments_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $comments_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($comments_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($comments_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($comments_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($comments_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $comments_list->showPageHeader(); ?>
<?php
$comments_list->showMessage();
?>
<?php if ($comments_list->TotalRecs > 0 || $comments->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($comments_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> comments">
<?php if (!$comments->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$comments->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($comments_list->Pager)) $comments_list->Pager = new PrevNextPager($comments_list->StartRec, $comments_list->DisplayRecs, $comments_list->TotalRecs, $comments_list->AutoHidePager) ?>
<?php if ($comments_list->Pager->RecordCount > 0 && $comments_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($comments_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $comments_list->pageUrl() ?>start=<?php echo $comments_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($comments_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $comments_list->pageUrl() ?>start=<?php echo $comments_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $comments_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($comments_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $comments_list->pageUrl() ?>start=<?php echo $comments_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($comments_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $comments_list->pageUrl() ?>start=<?php echo $comments_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $comments_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($comments_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $comments_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $comments_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $comments_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $comments_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fcommentslist" id="fcommentslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($comments_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $comments_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="comments">
<div id="gmp_comments" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($comments_list->TotalRecs > 0 || $comments->isGridEdit()) { ?>
<table id="tbl_commentslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$comments_list->RowType = ROWTYPE_HEADER;

// Render list options
$comments_list->renderListOptions();

// Render list options (header, left)
$comments_list->ListOptions->render("header", "left");
?>
<?php if ($comments->commentId->Visible) { // commentId ?>
	<?php if ($comments->sortUrl($comments->commentId) == "") { ?>
		<th data-name="commentId" class="<?php echo $comments->commentId->headerCellClass() ?>"><div id="elh_comments_commentId" class="comments_commentId"><div class="ew-table-header-caption"><?php echo $comments->commentId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="commentId" class="<?php echo $comments->commentId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $comments->SortUrl($comments->commentId) ?>',1);"><div id="elh_comments_commentId" class="comments_commentId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $comments->commentId->caption() ?></span><span class="ew-table-header-sort"><?php if ($comments->commentId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($comments->commentId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($comments->queryId->Visible) { // queryId ?>
	<?php if ($comments->sortUrl($comments->queryId) == "") { ?>
		<th data-name="queryId" class="<?php echo $comments->queryId->headerCellClass() ?>"><div id="elh_comments_queryId" class="comments_queryId"><div class="ew-table-header-caption"><?php echo $comments->queryId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="queryId" class="<?php echo $comments->queryId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $comments->SortUrl($comments->queryId) ?>',1);"><div id="elh_comments_queryId" class="comments_queryId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $comments->queryId->caption() ?></span><span class="ew-table-header-sort"><?php if ($comments->queryId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($comments->queryId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($comments->_userId->Visible) { // userId ?>
	<?php if ($comments->sortUrl($comments->_userId) == "") { ?>
		<th data-name="_userId" class="<?php echo $comments->_userId->headerCellClass() ?>"><div id="elh_comments__userId" class="comments__userId"><div class="ew-table-header-caption"><?php echo $comments->_userId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_userId" class="<?php echo $comments->_userId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $comments->SortUrl($comments->_userId) ?>',1);"><div id="elh_comments__userId" class="comments__userId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $comments->_userId->caption() ?></span><span class="ew-table-header-sort"><?php if ($comments->_userId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($comments->_userId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($comments->date->Visible) { // date ?>
	<?php if ($comments->sortUrl($comments->date) == "") { ?>
		<th data-name="date" class="<?php echo $comments->date->headerCellClass() ?>"><div id="elh_comments_date" class="comments_date"><div class="ew-table-header-caption"><?php echo $comments->date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $comments->date->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $comments->SortUrl($comments->date) ?>',1);"><div id="elh_comments_date" class="comments_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $comments->date->caption() ?></span><span class="ew-table-header-sort"><?php if ($comments->date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($comments->date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($comments->image->Visible) { // image ?>
	<?php if ($comments->sortUrl($comments->image) == "") { ?>
		<th data-name="image" class="<?php echo $comments->image->headerCellClass() ?>"><div id="elh_comments_image" class="comments_image"><div class="ew-table-header-caption"><?php echo $comments->image->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $comments->image->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $comments->SortUrl($comments->image) ?>',1);"><div id="elh_comments_image" class="comments_image">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $comments->image->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($comments->image->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($comments->image->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$comments_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($comments->ExportAll && $comments->isExport()) {
	$comments_list->StopRec = $comments_list->TotalRecs;
} else {

	// Set the last record to display
	if ($comments_list->TotalRecs > $comments_list->StartRec + $comments_list->DisplayRecs - 1)
		$comments_list->StopRec = $comments_list->StartRec + $comments_list->DisplayRecs - 1;
	else
		$comments_list->StopRec = $comments_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $comments_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($comments_list->FormKeyCountName) && ($comments->isGridAdd() || $comments->isGridEdit() || $comments->isConfirm())) {
		$comments_list->KeyCount = $CurrentForm->getValue($comments_list->FormKeyCountName);
		$comments_list->StopRec = $comments_list->StartRec + $comments_list->KeyCount - 1;
	}
}
$comments_list->RecCnt = $comments_list->StartRec - 1;
if ($comments_list->Recordset && !$comments_list->Recordset->EOF) {
	$comments_list->Recordset->moveFirst();
	$selectLimit = $comments_list->UseSelectLimit;
	if (!$selectLimit && $comments_list->StartRec > 1)
		$comments_list->Recordset->move($comments_list->StartRec - 1);
} elseif (!$comments->AllowAddDeleteRow && $comments_list->StopRec == 0) {
	$comments_list->StopRec = $comments->GridAddRowCount;
}

// Initialize aggregate
$comments->RowType = ROWTYPE_AGGREGATEINIT;
$comments->resetAttributes();
$comments_list->renderRow();
$comments_list->EditRowCnt = 0;
if ($comments->isEdit())
	$comments_list->RowIndex = 1;
if ($comments->isGridAdd())
	$comments_list->RowIndex = 0;
while ($comments_list->RecCnt < $comments_list->StopRec) {
	$comments_list->RecCnt++;
	if ($comments_list->RecCnt >= $comments_list->StartRec) {
		$comments_list->RowCnt++;
		if ($comments->isGridAdd() || $comments->isGridEdit() || $comments->isConfirm()) {
			$comments_list->RowIndex++;
			$CurrentForm->Index = $comments_list->RowIndex;
			if ($CurrentForm->hasValue($comments_list->FormActionName) && $comments_list->EventCancelled)
				$comments_list->RowAction = strval($CurrentForm->getValue($comments_list->FormActionName));
			elseif ($comments->isGridAdd())
				$comments_list->RowAction = "insert";
			else
				$comments_list->RowAction = "";
		}

		// Set up key count
		$comments_list->KeyCount = $comments_list->RowIndex;

		// Init row class and style
		$comments->resetAttributes();
		$comments->CssClass = "";
		if ($comments->isGridAdd()) {
			$comments_list->loadRowValues(); // Load default values
		} else {
			$comments_list->loadRowValues($comments_list->Recordset); // Load row values
		}
		$comments->RowType = ROWTYPE_VIEW; // Render view
		if ($comments->isGridAdd()) // Grid add
			$comments->RowType = ROWTYPE_ADD; // Render add
		if ($comments->isGridAdd() && $comments->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$comments_list->restoreCurrentRowFormValues($comments_list->RowIndex); // Restore form values
		if ($comments->isEdit()) {
			if ($comments_list->checkInlineEditKey() && $comments_list->EditRowCnt == 0) { // Inline edit
				$comments->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($comments->isEdit() && $comments->RowType == ROWTYPE_EDIT && $comments->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$comments_list->restoreFormValues(); // Restore form values
		}
		if ($comments->RowType == ROWTYPE_EDIT) // Edit row
			$comments_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$comments->RowAttrs = array_merge($comments->RowAttrs, array('data-rowindex'=>$comments_list->RowCnt, 'id'=>'r' . $comments_list->RowCnt . '_comments', 'data-rowtype'=>$comments->RowType));

		// Render row
		$comments_list->renderRow();

		// Render list options
		$comments_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($comments_list->RowAction <> "delete" && $comments_list->RowAction <> "insertdelete" && !($comments_list->RowAction == "insert" && $comments->isConfirm() && $comments_list->emptyRow())) {
?>
	<tr<?php echo $comments->rowAttributes() ?>>
<?php

// Render list options (body, left)
$comments_list->ListOptions->render("body", "left", $comments_list->RowCnt);
?>
	<?php if ($comments->commentId->Visible) { // commentId ?>
		<td data-name="commentId"<?php echo $comments->commentId->cellAttributes() ?>>
<?php if ($comments->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="comments" data-field="x_commentId" name="o<?php echo $comments_list->RowIndex ?>_commentId" id="o<?php echo $comments_list->RowIndex ?>_commentId" value="<?php echo HtmlEncode($comments->commentId->OldValue) ?>">
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_commentId" class="form-group comments_commentId">
<span<?php echo $comments->commentId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($comments->commentId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="comments" data-field="x_commentId" name="x<?php echo $comments_list->RowIndex ?>_commentId" id="x<?php echo $comments_list->RowIndex ?>_commentId" value="<?php echo HtmlEncode($comments->commentId->CurrentValue) ?>">
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_commentId" class="comments_commentId">
<span<?php echo $comments->commentId->viewAttributes() ?>>
<?php echo $comments->commentId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($comments->queryId->Visible) { // queryId ?>
		<td data-name="queryId"<?php echo $comments->queryId->cellAttributes() ?>>
<?php if ($comments->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_queryId" class="form-group comments_queryId">
<?php
$wrkonchange = "" . trim(@$comments->queryId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->queryId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $comments_list->RowIndex ?>_queryId" class="text-nowrap" style="z-index: <?php echo (9000 - $comments_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $comments_list->RowIndex ?>_queryId" id="sv_x<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo RemoveHtml($comments->queryId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>"<?php echo $comments->queryId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_queryId" data-value-separator="<?php echo $comments->queryId->displayValueSeparatorAttribute() ?>" name="x<?php echo $comments_list->RowIndex ?>_queryId" id="x<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($comments->queryId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentslist.createAutoSuggest({"id":"x<?php echo $comments_list->RowIndex ?>_queryId","forceSelect":false});
</script>
<?php echo $comments->queryId->Lookup->getParamTag("p_x" . $comments_list->RowIndex . "_queryId") ?>
</span>
<input type="hidden" data-table="comments" data-field="x_queryId" name="o<?php echo $comments_list->RowIndex ?>_queryId" id="o<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($comments->queryId->OldValue) ?>">
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_queryId" class="form-group comments_queryId">
<?php
$wrkonchange = "" . trim(@$comments->queryId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->queryId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $comments_list->RowIndex ?>_queryId" class="text-nowrap" style="z-index: <?php echo (9000 - $comments_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $comments_list->RowIndex ?>_queryId" id="sv_x<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo RemoveHtml($comments->queryId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>"<?php echo $comments->queryId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_queryId" data-value-separator="<?php echo $comments->queryId->displayValueSeparatorAttribute() ?>" name="x<?php echo $comments_list->RowIndex ?>_queryId" id="x<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($comments->queryId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentslist.createAutoSuggest({"id":"x<?php echo $comments_list->RowIndex ?>_queryId","forceSelect":false});
</script>
<?php echo $comments->queryId->Lookup->getParamTag("p_x" . $comments_list->RowIndex . "_queryId") ?>
</span>
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_queryId" class="comments_queryId">
<span<?php echo $comments->queryId->viewAttributes() ?>>
<?php echo $comments->queryId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($comments->_userId->Visible) { // userId ?>
		<td data-name="_userId"<?php echo $comments->_userId->cellAttributes() ?>>
<?php if ($comments->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments__userId" class="form-group comments__userId">
<?php
$wrkonchange = "" . trim(@$comments->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $comments_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $comments_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $comments_list->RowIndex ?>__userId" id="sv_x<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($comments->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>"<?php echo $comments->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x__userId" data-value-separator="<?php echo $comments->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $comments_list->RowIndex ?>__userId" id="x<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($comments->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentslist.createAutoSuggest({"id":"x<?php echo $comments_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $comments->_userId->Lookup->getParamTag("p_x" . $comments_list->RowIndex . "__userId") ?>
</span>
<input type="hidden" data-table="comments" data-field="x__userId" name="o<?php echo $comments_list->RowIndex ?>__userId" id="o<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($comments->_userId->OldValue) ?>">
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments__userId" class="form-group comments__userId">
<?php
$wrkonchange = "" . trim(@$comments->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $comments_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $comments_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $comments_list->RowIndex ?>__userId" id="sv_x<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($comments->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>"<?php echo $comments->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x__userId" data-value-separator="<?php echo $comments->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $comments_list->RowIndex ?>__userId" id="x<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($comments->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentslist.createAutoSuggest({"id":"x<?php echo $comments_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $comments->_userId->Lookup->getParamTag("p_x" . $comments_list->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments__userId" class="comments__userId">
<span<?php echo $comments->_userId->viewAttributes() ?>>
<?php echo $comments->_userId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($comments->date->Visible) { // date ?>
		<td data-name="date"<?php echo $comments->date->cellAttributes() ?>>
<?php if ($comments->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_date" class="form-group comments_date">
<input type="text" data-table="comments" data-field="x_date" name="x<?php echo $comments_list->RowIndex ?>_date" id="x<?php echo $comments_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($comments->date->getPlaceHolder()) ?>" value="<?php echo $comments->date->EditValue ?>"<?php echo $comments->date->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_date" name="o<?php echo $comments_list->RowIndex ?>_date" id="o<?php echo $comments_list->RowIndex ?>_date" value="<?php echo HtmlEncode($comments->date->OldValue) ?>">
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_date" class="form-group comments_date">
<input type="text" data-table="comments" data-field="x_date" name="x<?php echo $comments_list->RowIndex ?>_date" id="x<?php echo $comments_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($comments->date->getPlaceHolder()) ?>" value="<?php echo $comments->date->EditValue ?>"<?php echo $comments->date->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_date" class="comments_date">
<span<?php echo $comments->date->viewAttributes() ?>>
<?php echo $comments->date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($comments->image->Visible) { // image ?>
		<td data-name="image"<?php echo $comments->image->cellAttributes() ?>>
<?php if ($comments->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_image" class="form-group comments_image">
<input type="text" data-table="comments" data-field="x_image" name="x<?php echo $comments_list->RowIndex ?>_image" id="x<?php echo $comments_list->RowIndex ?>_image" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($comments->image->getPlaceHolder()) ?>" value="<?php echo $comments->image->EditValue ?>"<?php echo $comments->image->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_image" name="o<?php echo $comments_list->RowIndex ?>_image" id="o<?php echo $comments_list->RowIndex ?>_image" value="<?php echo HtmlEncode($comments->image->OldValue) ?>">
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_image" class="form-group comments_image">
<input type="text" data-table="comments" data-field="x_image" name="x<?php echo $comments_list->RowIndex ?>_image" id="x<?php echo $comments_list->RowIndex ?>_image" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($comments->image->getPlaceHolder()) ?>" value="<?php echo $comments->image->EditValue ?>"<?php echo $comments->image->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($comments->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $comments_list->RowCnt ?>_comments_image" class="comments_image">
<span<?php echo $comments->image->viewAttributes() ?>>
<?php echo $comments->image->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$comments_list->ListOptions->render("body", "right", $comments_list->RowCnt);
?>
	</tr>
<?php if ($comments->RowType == ROWTYPE_ADD || $comments->RowType == ROWTYPE_EDIT) { ?>
<script>
fcommentslist.updateLists(<?php echo $comments_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$comments->isGridAdd())
		if (!$comments_list->Recordset->EOF)
			$comments_list->Recordset->moveNext();
}
?>
<?php
	if ($comments->isGridAdd() || $comments->isGridEdit()) {
		$comments_list->RowIndex = '$rowindex$';
		$comments_list->loadRowValues();

		// Set row properties
		$comments->resetAttributes();
		$comments->RowAttrs = array_merge($comments->RowAttrs, array('data-rowindex'=>$comments_list->RowIndex, 'id'=>'r0_comments', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($comments->RowAttrs["class"], "ew-template");
		$comments->RowType = ROWTYPE_ADD;

		// Render row
		$comments_list->renderRow();

		// Render list options
		$comments_list->renderListOptions();
		$comments_list->StartRowCnt = 0;
?>
	<tr<?php echo $comments->rowAttributes() ?>>
<?php

// Render list options (body, left)
$comments_list->ListOptions->render("body", "left", $comments_list->RowIndex);
?>
	<?php if ($comments->commentId->Visible) { // commentId ?>
		<td data-name="commentId">
<input type="hidden" data-table="comments" data-field="x_commentId" name="o<?php echo $comments_list->RowIndex ?>_commentId" id="o<?php echo $comments_list->RowIndex ?>_commentId" value="<?php echo HtmlEncode($comments->commentId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($comments->queryId->Visible) { // queryId ?>
		<td data-name="queryId">
<span id="el$rowindex$_comments_queryId" class="form-group comments_queryId">
<?php
$wrkonchange = "" . trim(@$comments->queryId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->queryId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $comments_list->RowIndex ?>_queryId" class="text-nowrap" style="z-index: <?php echo (9000 - $comments_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $comments_list->RowIndex ?>_queryId" id="sv_x<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo RemoveHtml($comments->queryId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>"<?php echo $comments->queryId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_queryId" data-value-separator="<?php echo $comments->queryId->displayValueSeparatorAttribute() ?>" name="x<?php echo $comments_list->RowIndex ?>_queryId" id="x<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($comments->queryId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentslist.createAutoSuggest({"id":"x<?php echo $comments_list->RowIndex ?>_queryId","forceSelect":false});
</script>
<?php echo $comments->queryId->Lookup->getParamTag("p_x" . $comments_list->RowIndex . "_queryId") ?>
</span>
<input type="hidden" data-table="comments" data-field="x_queryId" name="o<?php echo $comments_list->RowIndex ?>_queryId" id="o<?php echo $comments_list->RowIndex ?>_queryId" value="<?php echo HtmlEncode($comments->queryId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($comments->_userId->Visible) { // userId ?>
		<td data-name="_userId">
<span id="el$rowindex$_comments__userId" class="form-group comments__userId">
<?php
$wrkonchange = "" . trim(@$comments->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $comments_list->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $comments_list->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $comments_list->RowIndex ?>__userId" id="sv_x<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo RemoveHtml($comments->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>"<?php echo $comments->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x__userId" data-value-separator="<?php echo $comments->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $comments_list->RowIndex ?>__userId" id="x<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($comments->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentslist.createAutoSuggest({"id":"x<?php echo $comments_list->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $comments->_userId->Lookup->getParamTag("p_x" . $comments_list->RowIndex . "__userId") ?>
</span>
<input type="hidden" data-table="comments" data-field="x__userId" name="o<?php echo $comments_list->RowIndex ?>__userId" id="o<?php echo $comments_list->RowIndex ?>__userId" value="<?php echo HtmlEncode($comments->_userId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($comments->date->Visible) { // date ?>
		<td data-name="date">
<span id="el$rowindex$_comments_date" class="form-group comments_date">
<input type="text" data-table="comments" data-field="x_date" name="x<?php echo $comments_list->RowIndex ?>_date" id="x<?php echo $comments_list->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($comments->date->getPlaceHolder()) ?>" value="<?php echo $comments->date->EditValue ?>"<?php echo $comments->date->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_date" name="o<?php echo $comments_list->RowIndex ?>_date" id="o<?php echo $comments_list->RowIndex ?>_date" value="<?php echo HtmlEncode($comments->date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($comments->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_comments_image" class="form-group comments_image">
<input type="text" data-table="comments" data-field="x_image" name="x<?php echo $comments_list->RowIndex ?>_image" id="x<?php echo $comments_list->RowIndex ?>_image" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($comments->image->getPlaceHolder()) ?>" value="<?php echo $comments->image->EditValue ?>"<?php echo $comments->image->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_image" name="o<?php echo $comments_list->RowIndex ?>_image" id="o<?php echo $comments_list->RowIndex ?>_image" value="<?php echo HtmlEncode($comments->image->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$comments_list->ListOptions->render("body", "right", $comments_list->RowIndex);
?>
<script>
fcommentslist.updateLists(<?php echo $comments_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($comments->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $comments_list->FormKeyCountName ?>" id="<?php echo $comments_list->FormKeyCountName ?>" value="<?php echo $comments_list->KeyCount ?>">
<?php echo $comments_list->MultiSelectKey ?>
<?php } ?>
<?php if ($comments->isEdit()) { ?>
<input type="hidden" name="<?php echo $comments_list->FormKeyCountName ?>" id="<?php echo $comments_list->FormKeyCountName ?>" value="<?php echo $comments_list->KeyCount ?>">
<?php } ?>
<?php if (!$comments->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($comments_list->Recordset)
	$comments_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($comments_list->TotalRecs == 0 && !$comments->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $comments_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$comments_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$comments->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$comments_list->terminate();
?>
