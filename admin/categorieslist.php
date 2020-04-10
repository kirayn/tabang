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
$categories_list = new categories_list();

// Run the page
$categories_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$categories_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$categories->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fcategorieslist = currentForm = new ew.Form("fcategorieslist", "list");
fcategorieslist.formKeyCountName = '<?php echo $categories_list->FormKeyCountName ?>';

// Validate form
fcategorieslist.validate = function() {
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
		<?php if ($categories_list->categoryId->Required) { ?>
			elm = this.getElements("x" + infix + "_categoryId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $categories->categoryId->caption(), $categories->categoryId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($categories_list->name->Required) { ?>
			elm = this.getElements("x" + infix + "_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $categories->name->caption(), $categories->name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($categories_list->parentId->Required) { ?>
			elm = this.getElements("x" + infix + "_parentId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $categories->parentId->caption(), $categories->parentId->RequiredErrorMessage)) ?>");
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
fcategorieslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "name", false)) return false;
	if (ew.valueChanged(fobj, infix, "parentId", false)) return false;
	return true;
}

// Form_CustomValidate event
fcategorieslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcategorieslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcategorieslist.lists["x_parentId"] = <?php echo $categories_list->parentId->Lookup->toClientList() ?>;
fcategorieslist.lists["x_parentId"].options = <?php echo JsonEncode($categories_list->parentId->lookupOptions()) ?>;

// Form object for search
var fcategorieslistsrch = currentSearchForm = new ew.Form("fcategorieslistsrch");

// Filters
fcategorieslistsrch.filterList = <?php echo $categories_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$categories->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($categories_list->TotalRecs > 0 && $categories_list->ExportOptions->visible()) { ?>
<?php $categories_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($categories_list->ImportOptions->visible()) { ?>
<?php $categories_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($categories_list->SearchOptions->visible()) { ?>
<?php $categories_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($categories_list->FilterOptions->visible()) { ?>
<?php $categories_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$categories_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$categories->isExport() && !$categories->CurrentAction) { ?>
<form name="fcategorieslistsrch" id="fcategorieslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($categories_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fcategorieslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="categories">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($categories_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($categories_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $categories_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($categories_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($categories_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($categories_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($categories_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $categories_list->showPageHeader(); ?>
<?php
$categories_list->showMessage();
?>
<?php if ($categories_list->TotalRecs > 0 || $categories->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($categories_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> categories">
<?php if (!$categories->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$categories->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($categories_list->Pager)) $categories_list->Pager = new PrevNextPager($categories_list->StartRec, $categories_list->DisplayRecs, $categories_list->TotalRecs, $categories_list->AutoHidePager) ?>
<?php if ($categories_list->Pager->RecordCount > 0 && $categories_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($categories_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $categories_list->pageUrl() ?>start=<?php echo $categories_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($categories_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $categories_list->pageUrl() ?>start=<?php echo $categories_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $categories_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($categories_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $categories_list->pageUrl() ?>start=<?php echo $categories_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($categories_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $categories_list->pageUrl() ?>start=<?php echo $categories_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $categories_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($categories_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $categories_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $categories_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $categories_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $categories_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fcategorieslist" id="fcategorieslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($categories_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $categories_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="categories">
<div id="gmp_categories" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($categories_list->TotalRecs > 0 || $categories->isGridEdit()) { ?>
<table id="tbl_categorieslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$categories_list->RowType = ROWTYPE_HEADER;

// Render list options
$categories_list->renderListOptions();

// Render list options (header, left)
$categories_list->ListOptions->render("header", "left");
?>
<?php if ($categories->categoryId->Visible) { // categoryId ?>
	<?php if ($categories->sortUrl($categories->categoryId) == "") { ?>
		<th data-name="categoryId" class="<?php echo $categories->categoryId->headerCellClass() ?>"><div id="elh_categories_categoryId" class="categories_categoryId"><div class="ew-table-header-caption"><?php echo $categories->categoryId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="categoryId" class="<?php echo $categories->categoryId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $categories->SortUrl($categories->categoryId) ?>',1);"><div id="elh_categories_categoryId" class="categories_categoryId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $categories->categoryId->caption() ?></span><span class="ew-table-header-sort"><?php if ($categories->categoryId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($categories->categoryId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($categories->name->Visible) { // name ?>
	<?php if ($categories->sortUrl($categories->name) == "") { ?>
		<th data-name="name" class="<?php echo $categories->name->headerCellClass() ?>"><div id="elh_categories_name" class="categories_name"><div class="ew-table-header-caption"><?php echo $categories->name->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="name" class="<?php echo $categories->name->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $categories->SortUrl($categories->name) ?>',1);"><div id="elh_categories_name" class="categories_name">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $categories->name->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($categories->name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($categories->name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($categories->parentId->Visible) { // parentId ?>
	<?php if ($categories->sortUrl($categories->parentId) == "") { ?>
		<th data-name="parentId" class="<?php echo $categories->parentId->headerCellClass() ?>"><div id="elh_categories_parentId" class="categories_parentId"><div class="ew-table-header-caption"><?php echo $categories->parentId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="parentId" class="<?php echo $categories->parentId->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $categories->SortUrl($categories->parentId) ?>',1);"><div id="elh_categories_parentId" class="categories_parentId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $categories->parentId->caption() ?></span><span class="ew-table-header-sort"><?php if ($categories->parentId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($categories->parentId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$categories_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($categories->ExportAll && $categories->isExport()) {
	$categories_list->StopRec = $categories_list->TotalRecs;
} else {

	// Set the last record to display
	if ($categories_list->TotalRecs > $categories_list->StartRec + $categories_list->DisplayRecs - 1)
		$categories_list->StopRec = $categories_list->StartRec + $categories_list->DisplayRecs - 1;
	else
		$categories_list->StopRec = $categories_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $categories_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($categories_list->FormKeyCountName) && ($categories->isGridAdd() || $categories->isGridEdit() || $categories->isConfirm())) {
		$categories_list->KeyCount = $CurrentForm->getValue($categories_list->FormKeyCountName);
		$categories_list->StopRec = $categories_list->StartRec + $categories_list->KeyCount - 1;
	}
}
$categories_list->RecCnt = $categories_list->StartRec - 1;
if ($categories_list->Recordset && !$categories_list->Recordset->EOF) {
	$categories_list->Recordset->moveFirst();
	$selectLimit = $categories_list->UseSelectLimit;
	if (!$selectLimit && $categories_list->StartRec > 1)
		$categories_list->Recordset->move($categories_list->StartRec - 1);
} elseif (!$categories->AllowAddDeleteRow && $categories_list->StopRec == 0) {
	$categories_list->StopRec = $categories->GridAddRowCount;
}

// Initialize aggregate
$categories->RowType = ROWTYPE_AGGREGATEINIT;
$categories->resetAttributes();
$categories_list->renderRow();
$categories_list->EditRowCnt = 0;
if ($categories->isEdit())
	$categories_list->RowIndex = 1;
if ($categories->isGridAdd())
	$categories_list->RowIndex = 0;
while ($categories_list->RecCnt < $categories_list->StopRec) {
	$categories_list->RecCnt++;
	if ($categories_list->RecCnt >= $categories_list->StartRec) {
		$categories_list->RowCnt++;
		if ($categories->isGridAdd() || $categories->isGridEdit() || $categories->isConfirm()) {
			$categories_list->RowIndex++;
			$CurrentForm->Index = $categories_list->RowIndex;
			if ($CurrentForm->hasValue($categories_list->FormActionName) && $categories_list->EventCancelled)
				$categories_list->RowAction = strval($CurrentForm->getValue($categories_list->FormActionName));
			elseif ($categories->isGridAdd())
				$categories_list->RowAction = "insert";
			else
				$categories_list->RowAction = "";
		}

		// Set up key count
		$categories_list->KeyCount = $categories_list->RowIndex;

		// Init row class and style
		$categories->resetAttributes();
		$categories->CssClass = "";
		if ($categories->isGridAdd()) {
			$categories_list->loadRowValues(); // Load default values
		} else {
			$categories_list->loadRowValues($categories_list->Recordset); // Load row values
		}
		$categories->RowType = ROWTYPE_VIEW; // Render view
		if ($categories->isGridAdd()) // Grid add
			$categories->RowType = ROWTYPE_ADD; // Render add
		if ($categories->isGridAdd() && $categories->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$categories_list->restoreCurrentRowFormValues($categories_list->RowIndex); // Restore form values
		if ($categories->isEdit()) {
			if ($categories_list->checkInlineEditKey() && $categories_list->EditRowCnt == 0) { // Inline edit
				$categories->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($categories->isEdit() && $categories->RowType == ROWTYPE_EDIT && $categories->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$categories_list->restoreFormValues(); // Restore form values
		}
		if ($categories->RowType == ROWTYPE_EDIT) // Edit row
			$categories_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$categories->RowAttrs = array_merge($categories->RowAttrs, array('data-rowindex'=>$categories_list->RowCnt, 'id'=>'r' . $categories_list->RowCnt . '_categories', 'data-rowtype'=>$categories->RowType));

		// Render row
		$categories_list->renderRow();

		// Render list options
		$categories_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($categories_list->RowAction <> "delete" && $categories_list->RowAction <> "insertdelete" && !($categories_list->RowAction == "insert" && $categories->isConfirm() && $categories_list->emptyRow())) {
?>
	<tr<?php echo $categories->rowAttributes() ?>>
<?php

// Render list options (body, left)
$categories_list->ListOptions->render("body", "left", $categories_list->RowCnt);
?>
	<?php if ($categories->categoryId->Visible) { // categoryId ?>
		<td data-name="categoryId"<?php echo $categories->categoryId->cellAttributes() ?>>
<?php if ($categories->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="categories" data-field="x_categoryId" name="o<?php echo $categories_list->RowIndex ?>_categoryId" id="o<?php echo $categories_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($categories->categoryId->OldValue) ?>">
<?php } ?>
<?php if ($categories->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_categoryId" class="form-group categories_categoryId">
<span<?php echo $categories->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($categories->categoryId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="categories" data-field="x_categoryId" name="x<?php echo $categories_list->RowIndex ?>_categoryId" id="x<?php echo $categories_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($categories->categoryId->CurrentValue) ?>">
<?php } ?>
<?php if ($categories->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_categoryId" class="categories_categoryId">
<span<?php echo $categories->categoryId->viewAttributes() ?>>
<?php echo $categories->categoryId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($categories->name->Visible) { // name ?>
		<td data-name="name"<?php echo $categories->name->cellAttributes() ?>>
<?php if ($categories->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_name" class="form-group categories_name">
<input type="text" data-table="categories" data-field="x_name" name="x<?php echo $categories_list->RowIndex ?>_name" id="x<?php echo $categories_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($categories->name->getPlaceHolder()) ?>" value="<?php echo $categories->name->EditValue ?>"<?php echo $categories->name->editAttributes() ?>>
</span>
<input type="hidden" data-table="categories" data-field="x_name" name="o<?php echo $categories_list->RowIndex ?>_name" id="o<?php echo $categories_list->RowIndex ?>_name" value="<?php echo HtmlEncode($categories->name->OldValue) ?>">
<?php } ?>
<?php if ($categories->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_name" class="form-group categories_name">
<input type="text" data-table="categories" data-field="x_name" name="x<?php echo $categories_list->RowIndex ?>_name" id="x<?php echo $categories_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($categories->name->getPlaceHolder()) ?>" value="<?php echo $categories->name->EditValue ?>"<?php echo $categories->name->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($categories->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_name" class="categories_name">
<span<?php echo $categories->name->viewAttributes() ?>>
<?php echo $categories->name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($categories->parentId->Visible) { // parentId ?>
		<td data-name="parentId"<?php echo $categories->parentId->cellAttributes() ?>>
<?php if ($categories->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_parentId" class="form-group categories_parentId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $categories_list->RowIndex ?>_parentId"><?php echo strval($categories->parentId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $categories->parentId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($categories->parentId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($categories->parentId->ReadOnly || $categories->parentId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $categories_list->RowIndex ?>_parentId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $categories->parentId->Lookup->getParamTag("p_x" . $categories_list->RowIndex . "_parentId") ?>
<input type="hidden" data-table="categories" data-field="x_parentId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $categories->parentId->displayValueSeparatorAttribute() ?>" name="x<?php echo $categories_list->RowIndex ?>_parentId" id="x<?php echo $categories_list->RowIndex ?>_parentId" value="<?php echo $categories->parentId->CurrentValue ?>"<?php echo $categories->parentId->editAttributes() ?>>
</span>
<input type="hidden" data-table="categories" data-field="x_parentId" name="o<?php echo $categories_list->RowIndex ?>_parentId" id="o<?php echo $categories_list->RowIndex ?>_parentId" value="<?php echo HtmlEncode($categories->parentId->OldValue) ?>">
<?php } ?>
<?php if ($categories->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_parentId" class="form-group categories_parentId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $categories_list->RowIndex ?>_parentId"><?php echo strval($categories->parentId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $categories->parentId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($categories->parentId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($categories->parentId->ReadOnly || $categories->parentId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $categories_list->RowIndex ?>_parentId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $categories->parentId->Lookup->getParamTag("p_x" . $categories_list->RowIndex . "_parentId") ?>
<input type="hidden" data-table="categories" data-field="x_parentId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $categories->parentId->displayValueSeparatorAttribute() ?>" name="x<?php echo $categories_list->RowIndex ?>_parentId" id="x<?php echo $categories_list->RowIndex ?>_parentId" value="<?php echo $categories->parentId->CurrentValue ?>"<?php echo $categories->parentId->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($categories->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $categories_list->RowCnt ?>_categories_parentId" class="categories_parentId">
<span<?php echo $categories->parentId->viewAttributes() ?>>
<?php echo $categories->parentId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$categories_list->ListOptions->render("body", "right", $categories_list->RowCnt);
?>
	</tr>
<?php if ($categories->RowType == ROWTYPE_ADD || $categories->RowType == ROWTYPE_EDIT) { ?>
<script>
fcategorieslist.updateLists(<?php echo $categories_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$categories->isGridAdd())
		if (!$categories_list->Recordset->EOF)
			$categories_list->Recordset->moveNext();
}
?>
<?php
	if ($categories->isGridAdd() || $categories->isGridEdit()) {
		$categories_list->RowIndex = '$rowindex$';
		$categories_list->loadRowValues();

		// Set row properties
		$categories->resetAttributes();
		$categories->RowAttrs = array_merge($categories->RowAttrs, array('data-rowindex'=>$categories_list->RowIndex, 'id'=>'r0_categories', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($categories->RowAttrs["class"], "ew-template");
		$categories->RowType = ROWTYPE_ADD;

		// Render row
		$categories_list->renderRow();

		// Render list options
		$categories_list->renderListOptions();
		$categories_list->StartRowCnt = 0;
?>
	<tr<?php echo $categories->rowAttributes() ?>>
<?php

// Render list options (body, left)
$categories_list->ListOptions->render("body", "left", $categories_list->RowIndex);
?>
	<?php if ($categories->categoryId->Visible) { // categoryId ?>
		<td data-name="categoryId">
<input type="hidden" data-table="categories" data-field="x_categoryId" name="o<?php echo $categories_list->RowIndex ?>_categoryId" id="o<?php echo $categories_list->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($categories->categoryId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($categories->name->Visible) { // name ?>
		<td data-name="name">
<span id="el$rowindex$_categories_name" class="form-group categories_name">
<input type="text" data-table="categories" data-field="x_name" name="x<?php echo $categories_list->RowIndex ?>_name" id="x<?php echo $categories_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($categories->name->getPlaceHolder()) ?>" value="<?php echo $categories->name->EditValue ?>"<?php echo $categories->name->editAttributes() ?>>
</span>
<input type="hidden" data-table="categories" data-field="x_name" name="o<?php echo $categories_list->RowIndex ?>_name" id="o<?php echo $categories_list->RowIndex ?>_name" value="<?php echo HtmlEncode($categories->name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($categories->parentId->Visible) { // parentId ?>
		<td data-name="parentId">
<span id="el$rowindex$_categories_parentId" class="form-group categories_parentId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $categories_list->RowIndex ?>_parentId"><?php echo strval($categories->parentId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $categories->parentId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($categories->parentId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($categories->parentId->ReadOnly || $categories->parentId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $categories_list->RowIndex ?>_parentId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $categories->parentId->Lookup->getParamTag("p_x" . $categories_list->RowIndex . "_parentId") ?>
<input type="hidden" data-table="categories" data-field="x_parentId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $categories->parentId->displayValueSeparatorAttribute() ?>" name="x<?php echo $categories_list->RowIndex ?>_parentId" id="x<?php echo $categories_list->RowIndex ?>_parentId" value="<?php echo $categories->parentId->CurrentValue ?>"<?php echo $categories->parentId->editAttributes() ?>>
</span>
<input type="hidden" data-table="categories" data-field="x_parentId" name="o<?php echo $categories_list->RowIndex ?>_parentId" id="o<?php echo $categories_list->RowIndex ?>_parentId" value="<?php echo HtmlEncode($categories->parentId->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$categories_list->ListOptions->render("body", "right", $categories_list->RowIndex);
?>
<script>
fcategorieslist.updateLists(<?php echo $categories_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($categories->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $categories_list->FormKeyCountName ?>" id="<?php echo $categories_list->FormKeyCountName ?>" value="<?php echo $categories_list->KeyCount ?>">
<?php echo $categories_list->MultiSelectKey ?>
<?php } ?>
<?php if ($categories->isEdit()) { ?>
<input type="hidden" name="<?php echo $categories_list->FormKeyCountName ?>" id="<?php echo $categories_list->FormKeyCountName ?>" value="<?php echo $categories_list->KeyCount ?>">
<?php } ?>
<?php if (!$categories->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($categories_list->Recordset)
	$categories_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($categories_list->TotalRecs == 0 && !$categories->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $categories_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$categories_list->showPageFooter();
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
$categories_list->terminate();
?>
