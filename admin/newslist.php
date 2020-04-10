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
$news_list = new news_list();

// Run the page
$news_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$news_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$news->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fnewslist = currentForm = new ew.Form("fnewslist", "list");
fnewslist.formKeyCountName = '<?php echo $news_list->FormKeyCountName ?>';

// Validate form
fnewslist.validate = function() {
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
		<?php if ($news_list->newsId->Required) { ?>
			elm = this.getElements("x" + infix + "_newsId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->newsId->caption(), $news->newsId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_list->type->Required) { ?>
			elm = this.getElements("x" + infix + "_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->type->caption(), $news->type->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_list->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->title->caption(), $news->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_list->description->Required) { ?>
			elm = this.getElements("x" + infix + "_description");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->description->caption(), $news->description->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_list->link->Required) { ?>
			elm = this.getElements("x" + infix + "_link");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->link->caption(), $news->link->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_list->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->date->caption(), $news->date->RequiredErrorMessage)) ?>");
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
fnewslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "type", false)) return false;
	if (ew.valueChanged(fobj, infix, "title", false)) return false;
	if (ew.valueChanged(fobj, infix, "description", false)) return false;
	if (ew.valueChanged(fobj, infix, "link", false)) return false;
	return true;
}

// Form_CustomValidate event
fnewslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fnewslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fnewslist.lists["x_type"] = <?php echo $news_list->type->Lookup->toClientList() ?>;
fnewslist.lists["x_type"].options = <?php echo JsonEncode($news_list->type->options(FALSE, TRUE)) ?>;

// Form object for search
var fnewslistsrch = currentSearchForm = new ew.Form("fnewslistsrch");

// Filters
fnewslistsrch.filterList = <?php echo $news_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$news->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($news_list->TotalRecs > 0 && $news_list->ExportOptions->visible()) { ?>
<?php $news_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($news_list->ImportOptions->visible()) { ?>
<?php $news_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($news_list->SearchOptions->visible()) { ?>
<?php $news_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($news_list->FilterOptions->visible()) { ?>
<?php $news_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$news_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$news->isExport() && !$news->CurrentAction) { ?>
<form name="fnewslistsrch" id="fnewslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($news_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fnewslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="news">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($news_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($news_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $news_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($news_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($news_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($news_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($news_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $news_list->showPageHeader(); ?>
<?php
$news_list->showMessage();
?>
<?php if ($news_list->TotalRecs > 0 || $news->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($news_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> news">
<?php if (!$news->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$news->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($news_list->Pager)) $news_list->Pager = new PrevNextPager($news_list->StartRec, $news_list->DisplayRecs, $news_list->TotalRecs, $news_list->AutoHidePager) ?>
<?php if ($news_list->Pager->RecordCount > 0 && $news_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($news_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $news_list->pageUrl() ?>start=<?php echo $news_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($news_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $news_list->pageUrl() ?>start=<?php echo $news_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $news_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($news_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $news_list->pageUrl() ?>start=<?php echo $news_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($news_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $news_list->pageUrl() ?>start=<?php echo $news_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $news_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($news_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $news_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $news_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $news_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $news_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fnewslist" id="fnewslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($news_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $news_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="news">
<div id="gmp_news" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($news_list->TotalRecs > 0 || $news->isGridEdit()) { ?>
<table id="tbl_newslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$news_list->RowType = ROWTYPE_HEADER;

// Render list options
$news_list->renderListOptions();

// Render list options (header, left)
$news_list->ListOptions->render("header", "left");
?>
<?php if ($news->newsId->Visible) { // newsId ?>
	<?php if ($news->sortUrl($news->newsId) == "") { ?>
		<th data-name="newsId" class="<?php echo $news->newsId->headerCellClass() ?>"><div id="elh_news_newsId" class="news_newsId"><div class="ew-table-header-caption"><?php echo $news->newsId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="newsId" class="<?php echo $news->newsId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $news->SortUrl($news->newsId) ?>',1);"><div id="elh_news_newsId" class="news_newsId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $news->newsId->caption() ?></span><span class="ew-table-header-sort"><?php if ($news->newsId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($news->newsId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news->type->Visible) { // type ?>
	<?php if ($news->sortUrl($news->type) == "") { ?>
		<th data-name="type" class="<?php echo $news->type->headerCellClass() ?>"><div id="elh_news_type" class="news_type"><div class="ew-table-header-caption"><?php echo $news->type->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="type" class="<?php echo $news->type->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $news->SortUrl($news->type) ?>',1);"><div id="elh_news_type" class="news_type">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $news->type->caption() ?></span><span class="ew-table-header-sort"><?php if ($news->type->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($news->type->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news->title->Visible) { // title ?>
	<?php if ($news->sortUrl($news->title) == "") { ?>
		<th data-name="title" class="<?php echo $news->title->headerCellClass() ?>"><div id="elh_news_title" class="news_title"><div class="ew-table-header-caption"><?php echo $news->title->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $news->title->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $news->SortUrl($news->title) ?>',1);"><div id="elh_news_title" class="news_title">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $news->title->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($news->title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($news->title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news->description->Visible) { // description ?>
	<?php if ($news->sortUrl($news->description) == "") { ?>
		<th data-name="description" class="<?php echo $news->description->headerCellClass() ?>"><div id="elh_news_description" class="news_description"><div class="ew-table-header-caption"><?php echo $news->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $news->description->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $news->SortUrl($news->description) ?>',1);"><div id="elh_news_description" class="news_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $news->description->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($news->description->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($news->description->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news->link->Visible) { // link ?>
	<?php if ($news->sortUrl($news->link) == "") { ?>
		<th data-name="link" class="<?php echo $news->link->headerCellClass() ?>"><div id="elh_news_link" class="news_link"><div class="ew-table-header-caption"><?php echo $news->link->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="link" class="<?php echo $news->link->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $news->SortUrl($news->link) ?>',1);"><div id="elh_news_link" class="news_link">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $news->link->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($news->link->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($news->link->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news->date->Visible) { // date ?>
	<?php if ($news->sortUrl($news->date) == "") { ?>
		<th data-name="date" class="<?php echo $news->date->headerCellClass() ?>"><div id="elh_news_date" class="news_date"><div class="ew-table-header-caption"><?php echo $news->date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $news->date->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $news->SortUrl($news->date) ?>',1);"><div id="elh_news_date" class="news_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $news->date->caption() ?></span><span class="ew-table-header-sort"><?php if ($news->date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($news->date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$news_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($news->ExportAll && $news->isExport()) {
	$news_list->StopRec = $news_list->TotalRecs;
} else {

	// Set the last record to display
	if ($news_list->TotalRecs > $news_list->StartRec + $news_list->DisplayRecs - 1)
		$news_list->StopRec = $news_list->StartRec + $news_list->DisplayRecs - 1;
	else
		$news_list->StopRec = $news_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $news_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($news_list->FormKeyCountName) && ($news->isGridAdd() || $news->isGridEdit() || $news->isConfirm())) {
		$news_list->KeyCount = $CurrentForm->getValue($news_list->FormKeyCountName);
		$news_list->StopRec = $news_list->StartRec + $news_list->KeyCount - 1;
	}
}
$news_list->RecCnt = $news_list->StartRec - 1;
if ($news_list->Recordset && !$news_list->Recordset->EOF) {
	$news_list->Recordset->moveFirst();
	$selectLimit = $news_list->UseSelectLimit;
	if (!$selectLimit && $news_list->StartRec > 1)
		$news_list->Recordset->move($news_list->StartRec - 1);
} elseif (!$news->AllowAddDeleteRow && $news_list->StopRec == 0) {
	$news_list->StopRec = $news->GridAddRowCount;
}

// Initialize aggregate
$news->RowType = ROWTYPE_AGGREGATEINIT;
$news->resetAttributes();
$news_list->renderRow();
$news_list->EditRowCnt = 0;
if ($news->isEdit())
	$news_list->RowIndex = 1;
if ($news->isGridAdd())
	$news_list->RowIndex = 0;
while ($news_list->RecCnt < $news_list->StopRec) {
	$news_list->RecCnt++;
	if ($news_list->RecCnt >= $news_list->StartRec) {
		$news_list->RowCnt++;
		if ($news->isGridAdd() || $news->isGridEdit() || $news->isConfirm()) {
			$news_list->RowIndex++;
			$CurrentForm->Index = $news_list->RowIndex;
			if ($CurrentForm->hasValue($news_list->FormActionName) && $news_list->EventCancelled)
				$news_list->RowAction = strval($CurrentForm->getValue($news_list->FormActionName));
			elseif ($news->isGridAdd())
				$news_list->RowAction = "insert";
			else
				$news_list->RowAction = "";
		}

		// Set up key count
		$news_list->KeyCount = $news_list->RowIndex;

		// Init row class and style
		$news->resetAttributes();
		$news->CssClass = "";
		if ($news->isGridAdd()) {
			$news_list->loadRowValues(); // Load default values
		} else {
			$news_list->loadRowValues($news_list->Recordset); // Load row values
		}
		$news->RowType = ROWTYPE_VIEW; // Render view
		if ($news->isGridAdd()) // Grid add
			$news->RowType = ROWTYPE_ADD; // Render add
		if ($news->isGridAdd() && $news->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$news_list->restoreCurrentRowFormValues($news_list->RowIndex); // Restore form values
		if ($news->isEdit()) {
			if ($news_list->checkInlineEditKey() && $news_list->EditRowCnt == 0) { // Inline edit
				$news->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($news->isEdit() && $news->RowType == ROWTYPE_EDIT && $news->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$news_list->restoreFormValues(); // Restore form values
		}
		if ($news->RowType == ROWTYPE_EDIT) // Edit row
			$news_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$news->RowAttrs = array_merge($news->RowAttrs, array('data-rowindex'=>$news_list->RowCnt, 'id'=>'r' . $news_list->RowCnt . '_news', 'data-rowtype'=>$news->RowType));

		// Render row
		$news_list->renderRow();

		// Render list options
		$news_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($news_list->RowAction <> "delete" && $news_list->RowAction <> "insertdelete" && !($news_list->RowAction == "insert" && $news->isConfirm() && $news_list->emptyRow())) {
?>
	<tr<?php echo $news->rowAttributes() ?>>
<?php

// Render list options (body, left)
$news_list->ListOptions->render("body", "left", $news_list->RowCnt);
?>
	<?php if ($news->newsId->Visible) { // newsId ?>
		<td data-name="newsId"<?php echo $news->newsId->cellAttributes() ?>>
<?php if ($news->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="news" data-field="x_newsId" name="o<?php echo $news_list->RowIndex ?>_newsId" id="o<?php echo $news_list->RowIndex ?>_newsId" value="<?php echo HtmlEncode($news->newsId->OldValue) ?>">
<?php } ?>
<?php if ($news->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_newsId" class="form-group news_newsId">
<span<?php echo $news->newsId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($news->newsId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="news" data-field="x_newsId" name="x<?php echo $news_list->RowIndex ?>_newsId" id="x<?php echo $news_list->RowIndex ?>_newsId" value="<?php echo HtmlEncode($news->newsId->CurrentValue) ?>">
<?php } ?>
<?php if ($news->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_newsId" class="news_newsId">
<span<?php echo $news->newsId->viewAttributes() ?>>
<?php echo $news->newsId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news->type->Visible) { // type ?>
		<td data-name="type"<?php echo $news->type->cellAttributes() ?>>
<?php if ($news->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_type" class="form-group news_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="news" data-field="x_type" data-value-separator="<?php echo $news->type->displayValueSeparatorAttribute() ?>" id="x<?php echo $news_list->RowIndex ?>_type" name="x<?php echo $news_list->RowIndex ?>_type"<?php echo $news->type->editAttributes() ?>>
		<?php echo $news->type->selectOptionListHtml("x<?php echo $news_list->RowIndex ?>_type") ?>
	</select>
</div>
</span>
<input type="hidden" data-table="news" data-field="x_type" name="o<?php echo $news_list->RowIndex ?>_type" id="o<?php echo $news_list->RowIndex ?>_type" value="<?php echo HtmlEncode($news->type->OldValue) ?>">
<?php } ?>
<?php if ($news->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_type" class="form-group news_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="news" data-field="x_type" data-value-separator="<?php echo $news->type->displayValueSeparatorAttribute() ?>" id="x<?php echo $news_list->RowIndex ?>_type" name="x<?php echo $news_list->RowIndex ?>_type"<?php echo $news->type->editAttributes() ?>>
		<?php echo $news->type->selectOptionListHtml("x<?php echo $news_list->RowIndex ?>_type") ?>
	</select>
</div>
</span>
<?php } ?>
<?php if ($news->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_type" class="news_type">
<span<?php echo $news->type->viewAttributes() ?>>
<?php echo $news->type->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news->title->Visible) { // title ?>
		<td data-name="title"<?php echo $news->title->cellAttributes() ?>>
<?php if ($news->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_title" class="form-group news_title">
<input type="text" data-table="news" data-field="x_title" name="x<?php echo $news_list->RowIndex ?>_title" id="x<?php echo $news_list->RowIndex ?>_title" placeholder="<?php echo HtmlEncode($news->title->getPlaceHolder()) ?>" value="<?php echo $news->title->EditValue ?>"<?php echo $news->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="news" data-field="x_title" name="o<?php echo $news_list->RowIndex ?>_title" id="o<?php echo $news_list->RowIndex ?>_title" value="<?php echo HtmlEncode($news->title->OldValue) ?>">
<?php } ?>
<?php if ($news->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_title" class="form-group news_title">
<input type="text" data-table="news" data-field="x_title" name="x<?php echo $news_list->RowIndex ?>_title" id="x<?php echo $news_list->RowIndex ?>_title" placeholder="<?php echo HtmlEncode($news->title->getPlaceHolder()) ?>" value="<?php echo $news->title->EditValue ?>"<?php echo $news->title->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($news->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_title" class="news_title">
<span<?php echo $news->title->viewAttributes() ?>>
<?php echo $news->title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news->description->Visible) { // description ?>
		<td data-name="description"<?php echo $news->description->cellAttributes() ?>>
<?php if ($news->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_description" class="form-group news_description">
<?php AppendClass($news->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="news" data-field="x_description" name="x<?php echo $news_list->RowIndex ?>_description" id="x<?php echo $news_list->RowIndex ?>_description" cols="50" rows="6" placeholder="<?php echo HtmlEncode($news->description->getPlaceHolder()) ?>"<?php echo $news->description->editAttributes() ?>><?php echo $news->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="news" data-field="x_description" name="o<?php echo $news_list->RowIndex ?>_description" id="o<?php echo $news_list->RowIndex ?>_description" value="<?php echo HtmlEncode($news->description->OldValue) ?>">
<?php } ?>
<?php if ($news->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_description" class="form-group news_description">
<?php AppendClass($news->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="news" data-field="x_description" name="x<?php echo $news_list->RowIndex ?>_description" id="x<?php echo $news_list->RowIndex ?>_description" cols="50" rows="6" placeholder="<?php echo HtmlEncode($news->description->getPlaceHolder()) ?>"<?php echo $news->description->editAttributes() ?>><?php echo $news->description->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($news->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_description" class="news_description">
<span<?php echo $news->description->viewAttributes() ?>>
<?php echo $news->description->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news->link->Visible) { // link ?>
		<td data-name="link"<?php echo $news->link->cellAttributes() ?>>
<?php if ($news->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_link" class="form-group news_link">
<textarea data-table="news" data-field="x_link" name="x<?php echo $news_list->RowIndex ?>_link" id="x<?php echo $news_list->RowIndex ?>_link" cols="35" rows="4" placeholder="<?php echo HtmlEncode($news->link->getPlaceHolder()) ?>"<?php echo $news->link->editAttributes() ?>><?php echo $news->link->EditValue ?></textarea>
</span>
<input type="hidden" data-table="news" data-field="x_link" name="o<?php echo $news_list->RowIndex ?>_link" id="o<?php echo $news_list->RowIndex ?>_link" value="<?php echo HtmlEncode($news->link->OldValue) ?>">
<?php } ?>
<?php if ($news->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_link" class="form-group news_link">
<textarea data-table="news" data-field="x_link" name="x<?php echo $news_list->RowIndex ?>_link" id="x<?php echo $news_list->RowIndex ?>_link" cols="35" rows="4" placeholder="<?php echo HtmlEncode($news->link->getPlaceHolder()) ?>"<?php echo $news->link->editAttributes() ?>><?php echo $news->link->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($news->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_link" class="news_link">
<span<?php echo $news->link->viewAttributes() ?>>
<?php echo $news->link->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news->date->Visible) { // date ?>
		<td data-name="date"<?php echo $news->date->cellAttributes() ?>>
<?php if ($news->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="news" data-field="x_date" name="o<?php echo $news_list->RowIndex ?>_date" id="o<?php echo $news_list->RowIndex ?>_date" value="<?php echo HtmlEncode($news->date->OldValue) ?>">
<?php } ?>
<?php if ($news->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($news->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_list->RowCnt ?>_news_date" class="news_date">
<span<?php echo $news->date->viewAttributes() ?>>
<?php echo $news->date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$news_list->ListOptions->render("body", "right", $news_list->RowCnt);
?>
	</tr>
<?php if ($news->RowType == ROWTYPE_ADD || $news->RowType == ROWTYPE_EDIT) { ?>
<script>
fnewslist.updateLists(<?php echo $news_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$news->isGridAdd())
		if (!$news_list->Recordset->EOF)
			$news_list->Recordset->moveNext();
}
?>
<?php
	if ($news->isGridAdd() || $news->isGridEdit()) {
		$news_list->RowIndex = '$rowindex$';
		$news_list->loadRowValues();

		// Set row properties
		$news->resetAttributes();
		$news->RowAttrs = array_merge($news->RowAttrs, array('data-rowindex'=>$news_list->RowIndex, 'id'=>'r0_news', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($news->RowAttrs["class"], "ew-template");
		$news->RowType = ROWTYPE_ADD;

		// Render row
		$news_list->renderRow();

		// Render list options
		$news_list->renderListOptions();
		$news_list->StartRowCnt = 0;
?>
	<tr<?php echo $news->rowAttributes() ?>>
<?php

// Render list options (body, left)
$news_list->ListOptions->render("body", "left", $news_list->RowIndex);
?>
	<?php if ($news->newsId->Visible) { // newsId ?>
		<td data-name="newsId">
<input type="hidden" data-table="news" data-field="x_newsId" name="o<?php echo $news_list->RowIndex ?>_newsId" id="o<?php echo $news_list->RowIndex ?>_newsId" value="<?php echo HtmlEncode($news->newsId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news->type->Visible) { // type ?>
		<td data-name="type">
<span id="el$rowindex$_news_type" class="form-group news_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="news" data-field="x_type" data-value-separator="<?php echo $news->type->displayValueSeparatorAttribute() ?>" id="x<?php echo $news_list->RowIndex ?>_type" name="x<?php echo $news_list->RowIndex ?>_type"<?php echo $news->type->editAttributes() ?>>
		<?php echo $news->type->selectOptionListHtml("x<?php echo $news_list->RowIndex ?>_type") ?>
	</select>
</div>
</span>
<input type="hidden" data-table="news" data-field="x_type" name="o<?php echo $news_list->RowIndex ?>_type" id="o<?php echo $news_list->RowIndex ?>_type" value="<?php echo HtmlEncode($news->type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news->title->Visible) { // title ?>
		<td data-name="title">
<span id="el$rowindex$_news_title" class="form-group news_title">
<input type="text" data-table="news" data-field="x_title" name="x<?php echo $news_list->RowIndex ?>_title" id="x<?php echo $news_list->RowIndex ?>_title" placeholder="<?php echo HtmlEncode($news->title->getPlaceHolder()) ?>" value="<?php echo $news->title->EditValue ?>"<?php echo $news->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="news" data-field="x_title" name="o<?php echo $news_list->RowIndex ?>_title" id="o<?php echo $news_list->RowIndex ?>_title" value="<?php echo HtmlEncode($news->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news->description->Visible) { // description ?>
		<td data-name="description">
<span id="el$rowindex$_news_description" class="form-group news_description">
<?php AppendClass($news->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="news" data-field="x_description" name="x<?php echo $news_list->RowIndex ?>_description" id="x<?php echo $news_list->RowIndex ?>_description" cols="50" rows="6" placeholder="<?php echo HtmlEncode($news->description->getPlaceHolder()) ?>"<?php echo $news->description->editAttributes() ?>><?php echo $news->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="news" data-field="x_description" name="o<?php echo $news_list->RowIndex ?>_description" id="o<?php echo $news_list->RowIndex ?>_description" value="<?php echo HtmlEncode($news->description->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news->link->Visible) { // link ?>
		<td data-name="link">
<span id="el$rowindex$_news_link" class="form-group news_link">
<textarea data-table="news" data-field="x_link" name="x<?php echo $news_list->RowIndex ?>_link" id="x<?php echo $news_list->RowIndex ?>_link" cols="35" rows="4" placeholder="<?php echo HtmlEncode($news->link->getPlaceHolder()) ?>"<?php echo $news->link->editAttributes() ?>><?php echo $news->link->EditValue ?></textarea>
</span>
<input type="hidden" data-table="news" data-field="x_link" name="o<?php echo $news_list->RowIndex ?>_link" id="o<?php echo $news_list->RowIndex ?>_link" value="<?php echo HtmlEncode($news->link->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news->date->Visible) { // date ?>
		<td data-name="date">
<input type="hidden" data-table="news" data-field="x_date" name="o<?php echo $news_list->RowIndex ?>_date" id="o<?php echo $news_list->RowIndex ?>_date" value="<?php echo HtmlEncode($news->date->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$news_list->ListOptions->render("body", "right", $news_list->RowIndex);
?>
<script>
fnewslist.updateLists(<?php echo $news_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($news->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $news_list->FormKeyCountName ?>" id="<?php echo $news_list->FormKeyCountName ?>" value="<?php echo $news_list->KeyCount ?>">
<?php echo $news_list->MultiSelectKey ?>
<?php } ?>
<?php if ($news->isEdit()) { ?>
<input type="hidden" name="<?php echo $news_list->FormKeyCountName ?>" id="<?php echo $news_list->FormKeyCountName ?>" value="<?php echo $news_list->KeyCount ?>">
<?php } ?>
<?php if (!$news->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($news_list->Recordset)
	$news_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($news_list->TotalRecs == 0 && !$news->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $news_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$news_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$news->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$news_list->terminate();
?>
