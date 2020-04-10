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
$users_list = new users_list();

// Run the page
$users_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$users->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fuserslist = currentForm = new ew.Form("fuserslist", "list");
fuserslist.formKeyCountName = '<?php echo $users_list->FormKeyCountName ?>';

// Validate form
fuserslist.validate = function() {
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
		<?php if ($users_list->ID->Required) { ?>
			elm = this.getElements("x" + infix + "_ID");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->ID->caption(), $users->ID->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_list->mobile->Required) { ?>
			elm = this.getElements("x" + infix + "_mobile");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->mobile->caption(), $users->mobile->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_mobile");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->mobile->errorMessage()) ?>");
		<?php if ($users_list->passcode->Required) { ?>
			elm = this.getElements("x" + infix + "_passcode");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->passcode->caption(), $users->passcode->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_passcode");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->passcode->errorMessage()) ?>");
		<?php if ($users_list->role->Required) { ?>
			elm = this.getElements("x" + infix + "_role");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->role->caption(), $users->role->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_list->status->Required) { ?>
			elm = this.getElements("x" + infix + "_status");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->status->caption(), $users->status->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_status");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->status->errorMessage()) ?>");
		<?php if ($users_list->activation->Required) { ?>
			elm = this.getElements("x" + infix + "_activation");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->activation->caption(), $users->activation->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_activation");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->activation->errorMessage()) ?>");
		<?php if ($users_list->registered->Required) { ?>
			elm = this.getElements("x" + infix + "_registered");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->registered->caption(), $users->registered->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_registered");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->registered->errorMessage()) ?>");

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
fuserslist.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "mobile", false)) return false;
	if (ew.valueChanged(fobj, infix, "passcode", false)) return false;
	if (ew.valueChanged(fobj, infix, "role", false)) return false;
	if (ew.valueChanged(fobj, infix, "status", false)) return false;
	if (ew.valueChanged(fobj, infix, "activation", false)) return false;
	if (ew.valueChanged(fobj, infix, "registered", false)) return false;
	return true;
}

// Form_CustomValidate event
fuserslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fuserslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserslist.lists["x_role"] = <?php echo $users_list->role->Lookup->toClientList() ?>;
fuserslist.lists["x_role"].options = <?php echo JsonEncode($users_list->role->options(FALSE, TRUE)) ?>;

// Form object for search
var fuserslistsrch = currentSearchForm = new ew.Form("fuserslistsrch");

// Filters
fuserslistsrch.filterList = <?php echo $users_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$users->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($users_list->TotalRecs > 0 && $users_list->ExportOptions->visible()) { ?>
<?php $users_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($users_list->ImportOptions->visible()) { ?>
<?php $users_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($users_list->SearchOptions->visible()) { ?>
<?php $users_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($users_list->FilterOptions->visible()) { ?>
<?php $users_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$users_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$users->isExport() && !$users->CurrentAction) { ?>
<form name="fuserslistsrch" id="fuserslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($users_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fuserslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="users">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($users_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($users_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $users_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($users_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($users_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($users_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($users_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $users_list->showPageHeader(); ?>
<?php
$users_list->showMessage();
?>
<?php if ($users_list->TotalRecs > 0 || $users->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($users_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> users">
<?php if (!$users->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$users->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($users_list->Pager)) $users_list->Pager = new PrevNextPager($users_list->StartRec, $users_list->DisplayRecs, $users_list->TotalRecs, $users_list->AutoHidePager) ?>
<?php if ($users_list->Pager->RecordCount > 0 && $users_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($users_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $users_list->pageUrl() ?>start=<?php echo $users_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($users_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $users_list->pageUrl() ?>start=<?php echo $users_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $users_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($users_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $users_list->pageUrl() ?>start=<?php echo $users_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($users_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $users_list->pageUrl() ?>start=<?php echo $users_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($users_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $users_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $users_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $users_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $users_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fuserslist" id="fuserslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($users_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $users_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<div id="gmp_users" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($users_list->TotalRecs > 0 || $users->isGridEdit()) { ?>
<table id="tbl_userslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$users_list->RowType = ROWTYPE_HEADER;

// Render list options
$users_list->renderListOptions();

// Render list options (header, left)
$users_list->ListOptions->render("header", "left");
?>
<?php if ($users->ID->Visible) { // ID ?>
	<?php if ($users->sortUrl($users->ID) == "") { ?>
		<th data-name="ID" class="<?php echo $users->ID->headerCellClass() ?>"><div id="elh_users_ID" class="users_ID"><div class="ew-table-header-caption"><?php echo $users->ID->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ID" class="<?php echo $users->ID->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $users->SortUrl($users->ID) ?>',1);"><div id="elh_users_ID" class="users_ID">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $users->ID->caption() ?></span><span class="ew-table-header-sort"><?php if ($users->ID->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($users->ID->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->mobile->Visible) { // mobile ?>
	<?php if ($users->sortUrl($users->mobile) == "") { ?>
		<th data-name="mobile" class="<?php echo $users->mobile->headerCellClass() ?>"><div id="elh_users_mobile" class="users_mobile"><div class="ew-table-header-caption"><?php echo $users->mobile->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mobile" class="<?php echo $users->mobile->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $users->SortUrl($users->mobile) ?>',1);"><div id="elh_users_mobile" class="users_mobile">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $users->mobile->caption() ?></span><span class="ew-table-header-sort"><?php if ($users->mobile->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($users->mobile->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
	<?php if ($users->sortUrl($users->passcode) == "") { ?>
		<th data-name="passcode" class="<?php echo $users->passcode->headerCellClass() ?>"><div id="elh_users_passcode" class="users_passcode"><div class="ew-table-header-caption"><?php echo $users->passcode->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="passcode" class="<?php echo $users->passcode->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $users->SortUrl($users->passcode) ?>',1);"><div id="elh_users_passcode" class="users_passcode">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $users->passcode->caption() ?></span><span class="ew-table-header-sort"><?php if ($users->passcode->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($users->passcode->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
	<?php if ($users->sortUrl($users->role) == "") { ?>
		<th data-name="role" class="<?php echo $users->role->headerCellClass() ?>"><div id="elh_users_role" class="users_role"><div class="ew-table-header-caption"><?php echo $users->role->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="role" class="<?php echo $users->role->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $users->SortUrl($users->role) ?>',1);"><div id="elh_users_role" class="users_role">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $users->role->caption() ?></span><span class="ew-table-header-sort"><?php if ($users->role->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($users->role->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
	<?php if ($users->sortUrl($users->status) == "") { ?>
		<th data-name="status" class="<?php echo $users->status->headerCellClass() ?>"><div id="elh_users_status" class="users_status"><div class="ew-table-header-caption"><?php echo $users->status->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $users->status->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $users->SortUrl($users->status) ?>',1);"><div id="elh_users_status" class="users_status">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $users->status->caption() ?></span><span class="ew-table-header-sort"><?php if ($users->status->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($users->status->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->activation->Visible) { // activation ?>
	<?php if ($users->sortUrl($users->activation) == "") { ?>
		<th data-name="activation" class="<?php echo $users->activation->headerCellClass() ?>"><div id="elh_users_activation" class="users_activation"><div class="ew-table-header-caption"><?php echo $users->activation->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="activation" class="<?php echo $users->activation->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $users->SortUrl($users->activation) ?>',1);"><div id="elh_users_activation" class="users_activation">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $users->activation->caption() ?></span><span class="ew-table-header-sort"><?php if ($users->activation->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($users->activation->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->registered->Visible) { // registered ?>
	<?php if ($users->sortUrl($users->registered) == "") { ?>
		<th data-name="registered" class="<?php echo $users->registered->headerCellClass() ?>"><div id="elh_users_registered" class="users_registered"><div class="ew-table-header-caption"><?php echo $users->registered->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="registered" class="<?php echo $users->registered->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $users->SortUrl($users->registered) ?>',1);"><div id="elh_users_registered" class="users_registered">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $users->registered->caption() ?></span><span class="ew-table-header-sort"><?php if ($users->registered->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($users->registered->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$users_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($users->ExportAll && $users->isExport()) {
	$users_list->StopRec = $users_list->TotalRecs;
} else {

	// Set the last record to display
	if ($users_list->TotalRecs > $users_list->StartRec + $users_list->DisplayRecs - 1)
		$users_list->StopRec = $users_list->StartRec + $users_list->DisplayRecs - 1;
	else
		$users_list->StopRec = $users_list->TotalRecs;
}

// Restore number of post back records
if ($CurrentForm && $users_list->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($users_list->FormKeyCountName) && ($users->isGridAdd() || $users->isGridEdit() || $users->isConfirm())) {
		$users_list->KeyCount = $CurrentForm->getValue($users_list->FormKeyCountName);
		$users_list->StopRec = $users_list->StartRec + $users_list->KeyCount - 1;
	}
}
$users_list->RecCnt = $users_list->StartRec - 1;
if ($users_list->Recordset && !$users_list->Recordset->EOF) {
	$users_list->Recordset->moveFirst();
	$selectLimit = $users_list->UseSelectLimit;
	if (!$selectLimit && $users_list->StartRec > 1)
		$users_list->Recordset->move($users_list->StartRec - 1);
} elseif (!$users->AllowAddDeleteRow && $users_list->StopRec == 0) {
	$users_list->StopRec = $users->GridAddRowCount;
}

// Initialize aggregate
$users->RowType = ROWTYPE_AGGREGATEINIT;
$users->resetAttributes();
$users_list->renderRow();
$users_list->EditRowCnt = 0;
if ($users->isEdit())
	$users_list->RowIndex = 1;
if ($users->isGridAdd())
	$users_list->RowIndex = 0;
while ($users_list->RecCnt < $users_list->StopRec) {
	$users_list->RecCnt++;
	if ($users_list->RecCnt >= $users_list->StartRec) {
		$users_list->RowCnt++;
		if ($users->isGridAdd() || $users->isGridEdit() || $users->isConfirm()) {
			$users_list->RowIndex++;
			$CurrentForm->Index = $users_list->RowIndex;
			if ($CurrentForm->hasValue($users_list->FormActionName) && $users_list->EventCancelled)
				$users_list->RowAction = strval($CurrentForm->getValue($users_list->FormActionName));
			elseif ($users->isGridAdd())
				$users_list->RowAction = "insert";
			else
				$users_list->RowAction = "";
		}

		// Set up key count
		$users_list->KeyCount = $users_list->RowIndex;

		// Init row class and style
		$users->resetAttributes();
		$users->CssClass = "";
		if ($users->isGridAdd()) {
			$users_list->loadRowValues(); // Load default values
		} else {
			$users_list->loadRowValues($users_list->Recordset); // Load row values
		}
		$users->RowType = ROWTYPE_VIEW; // Render view
		if ($users->isGridAdd()) // Grid add
			$users->RowType = ROWTYPE_ADD; // Render add
		if ($users->isGridAdd() && $users->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$users_list->restoreCurrentRowFormValues($users_list->RowIndex); // Restore form values
		if ($users->isEdit()) {
			if ($users_list->checkInlineEditKey() && $users_list->EditRowCnt == 0) { // Inline edit
				$users->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($users->isEdit() && $users->RowType == ROWTYPE_EDIT && $users->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$users_list->restoreFormValues(); // Restore form values
		}
		if ($users->RowType == ROWTYPE_EDIT) // Edit row
			$users_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$users->RowAttrs = array_merge($users->RowAttrs, array('data-rowindex'=>$users_list->RowCnt, 'id'=>'r' . $users_list->RowCnt . '_users', 'data-rowtype'=>$users->RowType));

		// Render row
		$users_list->renderRow();

		// Render list options
		$users_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($users_list->RowAction <> "delete" && $users_list->RowAction <> "insertdelete" && !($users_list->RowAction == "insert" && $users->isConfirm() && $users_list->emptyRow())) {
?>
	<tr<?php echo $users->rowAttributes() ?>>
<?php

// Render list options (body, left)
$users_list->ListOptions->render("body", "left", $users_list->RowCnt);
?>
	<?php if ($users->ID->Visible) { // ID ?>
		<td data-name="ID"<?php echo $users->ID->cellAttributes() ?>>
<?php if ($users->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="users" data-field="x_ID" name="o<?php echo $users_list->RowIndex ?>_ID" id="o<?php echo $users_list->RowIndex ?>_ID" value="<?php echo HtmlEncode($users->ID->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_ID" class="form-group users_ID">
<span<?php echo $users->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($users->ID->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_ID" name="x<?php echo $users_list->RowIndex ?>_ID" id="x<?php echo $users_list->RowIndex ?>_ID" value="<?php echo HtmlEncode($users->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_ID" class="users_ID">
<span<?php echo $users->ID->viewAttributes() ?>>
<?php echo $users->ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->mobile->Visible) { // mobile ?>
		<td data-name="mobile"<?php echo $users->mobile->cellAttributes() ?>>
<?php if ($users->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_mobile" class="form-group users_mobile">
<input type="text" data-table="users" data-field="x_mobile" name="x<?php echo $users_list->RowIndex ?>_mobile" id="x<?php echo $users_list->RowIndex ?>_mobile" size="30" placeholder="<?php echo HtmlEncode($users->mobile->getPlaceHolder()) ?>" value="<?php echo $users->mobile->EditValue ?>"<?php echo $users->mobile->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_mobile" name="o<?php echo $users_list->RowIndex ?>_mobile" id="o<?php echo $users_list->RowIndex ?>_mobile" value="<?php echo HtmlEncode($users->mobile->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_mobile" class="form-group users_mobile">
<input type="text" data-table="users" data-field="x_mobile" name="x<?php echo $users_list->RowIndex ?>_mobile" id="x<?php echo $users_list->RowIndex ?>_mobile" size="30" placeholder="<?php echo HtmlEncode($users->mobile->getPlaceHolder()) ?>" value="<?php echo $users->mobile->EditValue ?>"<?php echo $users->mobile->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_mobile" class="users_mobile">
<span<?php echo $users->mobile->viewAttributes() ?>>
<?php echo $users->mobile->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->passcode->Visible) { // passcode ?>
		<td data-name="passcode"<?php echo $users->passcode->cellAttributes() ?>>
<?php if ($users->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_passcode" class="form-group users_passcode">
<input type="text" data-table="users" data-field="x_passcode" name="x<?php echo $users_list->RowIndex ?>_passcode" id="x<?php echo $users_list->RowIndex ?>_passcode" size="30" placeholder="<?php echo HtmlEncode($users->passcode->getPlaceHolder()) ?>" value="<?php echo $users->passcode->EditValue ?>"<?php echo $users->passcode->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_passcode" name="o<?php echo $users_list->RowIndex ?>_passcode" id="o<?php echo $users_list->RowIndex ?>_passcode" value="<?php echo HtmlEncode($users->passcode->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_passcode" class="form-group users_passcode">
<input type="text" data-table="users" data-field="x_passcode" name="x<?php echo $users_list->RowIndex ?>_passcode" id="x<?php echo $users_list->RowIndex ?>_passcode" size="30" placeholder="<?php echo HtmlEncode($users->passcode->getPlaceHolder()) ?>" value="<?php echo $users->passcode->EditValue ?>"<?php echo $users->passcode->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_passcode" class="users_passcode">
<span<?php echo $users->passcode->viewAttributes() ?>>
<?php echo $users->passcode->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->role->Visible) { // role ?>
		<td data-name="role"<?php echo $users->role->cellAttributes() ?>>
<?php if ($users->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_role" class="form-group users_role">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="users" data-field="x_role" data-value-separator="<?php echo $users->role->displayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_role" name="x<?php echo $users_list->RowIndex ?>_role"<?php echo $users->role->editAttributes() ?>>
		<?php echo $users->role->selectOptionListHtml("x<?php echo $users_list->RowIndex ?>_role") ?>
	</select>
</div>
</span>
<input type="hidden" data-table="users" data-field="x_role" name="o<?php echo $users_list->RowIndex ?>_role" id="o<?php echo $users_list->RowIndex ?>_role" value="<?php echo HtmlEncode($users->role->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_role" class="form-group users_role">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="users" data-field="x_role" data-value-separator="<?php echo $users->role->displayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_role" name="x<?php echo $users_list->RowIndex ?>_role"<?php echo $users->role->editAttributes() ?>>
		<?php echo $users->role->selectOptionListHtml("x<?php echo $users_list->RowIndex ?>_role") ?>
	</select>
</div>
</span>
<?php } ?>
<?php if ($users->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_role" class="users_role">
<span<?php echo $users->role->viewAttributes() ?>>
<?php echo $users->role->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->status->Visible) { // status ?>
		<td data-name="status"<?php echo $users->status->cellAttributes() ?>>
<?php if ($users->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_status" class="form-group users_status">
<input type="text" data-table="users" data-field="x_status" name="x<?php echo $users_list->RowIndex ?>_status" id="x<?php echo $users_list->RowIndex ?>_status" size="30" placeholder="<?php echo HtmlEncode($users->status->getPlaceHolder()) ?>" value="<?php echo $users->status->EditValue ?>"<?php echo $users->status->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_status" name="o<?php echo $users_list->RowIndex ?>_status" id="o<?php echo $users_list->RowIndex ?>_status" value="<?php echo HtmlEncode($users->status->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_status" class="form-group users_status">
<input type="text" data-table="users" data-field="x_status" name="x<?php echo $users_list->RowIndex ?>_status" id="x<?php echo $users_list->RowIndex ?>_status" size="30" placeholder="<?php echo HtmlEncode($users->status->getPlaceHolder()) ?>" value="<?php echo $users->status->EditValue ?>"<?php echo $users->status->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_status" class="users_status">
<span<?php echo $users->status->viewAttributes() ?>>
<?php echo $users->status->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->activation->Visible) { // activation ?>
		<td data-name="activation"<?php echo $users->activation->cellAttributes() ?>>
<?php if ($users->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_activation" class="form-group users_activation">
<input type="text" data-table="users" data-field="x_activation" name="x<?php echo $users_list->RowIndex ?>_activation" id="x<?php echo $users_list->RowIndex ?>_activation" size="30" placeholder="<?php echo HtmlEncode($users->activation->getPlaceHolder()) ?>" value="<?php echo $users->activation->EditValue ?>"<?php echo $users->activation->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_activation" name="o<?php echo $users_list->RowIndex ?>_activation" id="o<?php echo $users_list->RowIndex ?>_activation" value="<?php echo HtmlEncode($users->activation->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_activation" class="form-group users_activation">
<input type="text" data-table="users" data-field="x_activation" name="x<?php echo $users_list->RowIndex ?>_activation" id="x<?php echo $users_list->RowIndex ?>_activation" size="30" placeholder="<?php echo HtmlEncode($users->activation->getPlaceHolder()) ?>" value="<?php echo $users->activation->EditValue ?>"<?php echo $users->activation->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_activation" class="users_activation">
<span<?php echo $users->activation->viewAttributes() ?>>
<?php echo $users->activation->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->registered->Visible) { // registered ?>
		<td data-name="registered"<?php echo $users->registered->cellAttributes() ?>>
<?php if ($users->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_registered" class="form-group users_registered">
<input type="text" data-table="users" data-field="x_registered" name="x<?php echo $users_list->RowIndex ?>_registered" id="x<?php echo $users_list->RowIndex ?>_registered" placeholder="<?php echo HtmlEncode($users->registered->getPlaceHolder()) ?>" value="<?php echo $users->registered->EditValue ?>"<?php echo $users->registered->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_registered" name="o<?php echo $users_list->RowIndex ?>_registered" id="o<?php echo $users_list->RowIndex ?>_registered" value="<?php echo HtmlEncode($users->registered->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_registered" class="form-group users_registered">
<input type="text" data-table="users" data-field="x_registered" name="x<?php echo $users_list->RowIndex ?>_registered" id="x<?php echo $users_list->RowIndex ?>_registered" placeholder="<?php echo HtmlEncode($users->registered->getPlaceHolder()) ?>" value="<?php echo $users->registered->EditValue ?>"<?php echo $users->registered->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_registered" class="users_registered">
<span<?php echo $users->registered->viewAttributes() ?>>
<?php echo $users->registered->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$users_list->ListOptions->render("body", "right", $users_list->RowCnt);
?>
	</tr>
<?php if ($users->RowType == ROWTYPE_ADD || $users->RowType == ROWTYPE_EDIT) { ?>
<script>
fuserslist.updateLists(<?php echo $users_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$users->isGridAdd())
		if (!$users_list->Recordset->EOF)
			$users_list->Recordset->moveNext();
}
?>
<?php
	if ($users->isGridAdd() || $users->isGridEdit()) {
		$users_list->RowIndex = '$rowindex$';
		$users_list->loadRowValues();

		// Set row properties
		$users->resetAttributes();
		$users->RowAttrs = array_merge($users->RowAttrs, array('data-rowindex'=>$users_list->RowIndex, 'id'=>'r0_users', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($users->RowAttrs["class"], "ew-template");
		$users->RowType = ROWTYPE_ADD;

		// Render row
		$users_list->renderRow();

		// Render list options
		$users_list->renderListOptions();
		$users_list->StartRowCnt = 0;
?>
	<tr<?php echo $users->rowAttributes() ?>>
<?php

// Render list options (body, left)
$users_list->ListOptions->render("body", "left", $users_list->RowIndex);
?>
	<?php if ($users->ID->Visible) { // ID ?>
		<td data-name="ID">
<input type="hidden" data-table="users" data-field="x_ID" name="o<?php echo $users_list->RowIndex ?>_ID" id="o<?php echo $users_list->RowIndex ?>_ID" value="<?php echo HtmlEncode($users->ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->mobile->Visible) { // mobile ?>
		<td data-name="mobile">
<span id="el$rowindex$_users_mobile" class="form-group users_mobile">
<input type="text" data-table="users" data-field="x_mobile" name="x<?php echo $users_list->RowIndex ?>_mobile" id="x<?php echo $users_list->RowIndex ?>_mobile" size="30" placeholder="<?php echo HtmlEncode($users->mobile->getPlaceHolder()) ?>" value="<?php echo $users->mobile->EditValue ?>"<?php echo $users->mobile->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_mobile" name="o<?php echo $users_list->RowIndex ?>_mobile" id="o<?php echo $users_list->RowIndex ?>_mobile" value="<?php echo HtmlEncode($users->mobile->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->passcode->Visible) { // passcode ?>
		<td data-name="passcode">
<span id="el$rowindex$_users_passcode" class="form-group users_passcode">
<input type="text" data-table="users" data-field="x_passcode" name="x<?php echo $users_list->RowIndex ?>_passcode" id="x<?php echo $users_list->RowIndex ?>_passcode" size="30" placeholder="<?php echo HtmlEncode($users->passcode->getPlaceHolder()) ?>" value="<?php echo $users->passcode->EditValue ?>"<?php echo $users->passcode->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_passcode" name="o<?php echo $users_list->RowIndex ?>_passcode" id="o<?php echo $users_list->RowIndex ?>_passcode" value="<?php echo HtmlEncode($users->passcode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->role->Visible) { // role ?>
		<td data-name="role">
<span id="el$rowindex$_users_role" class="form-group users_role">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="users" data-field="x_role" data-value-separator="<?php echo $users->role->displayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_role" name="x<?php echo $users_list->RowIndex ?>_role"<?php echo $users->role->editAttributes() ?>>
		<?php echo $users->role->selectOptionListHtml("x<?php echo $users_list->RowIndex ?>_role") ?>
	</select>
</div>
</span>
<input type="hidden" data-table="users" data-field="x_role" name="o<?php echo $users_list->RowIndex ?>_role" id="o<?php echo $users_list->RowIndex ?>_role" value="<?php echo HtmlEncode($users->role->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->status->Visible) { // status ?>
		<td data-name="status">
<span id="el$rowindex$_users_status" class="form-group users_status">
<input type="text" data-table="users" data-field="x_status" name="x<?php echo $users_list->RowIndex ?>_status" id="x<?php echo $users_list->RowIndex ?>_status" size="30" placeholder="<?php echo HtmlEncode($users->status->getPlaceHolder()) ?>" value="<?php echo $users->status->EditValue ?>"<?php echo $users->status->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_status" name="o<?php echo $users_list->RowIndex ?>_status" id="o<?php echo $users_list->RowIndex ?>_status" value="<?php echo HtmlEncode($users->status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->activation->Visible) { // activation ?>
		<td data-name="activation">
<span id="el$rowindex$_users_activation" class="form-group users_activation">
<input type="text" data-table="users" data-field="x_activation" name="x<?php echo $users_list->RowIndex ?>_activation" id="x<?php echo $users_list->RowIndex ?>_activation" size="30" placeholder="<?php echo HtmlEncode($users->activation->getPlaceHolder()) ?>" value="<?php echo $users->activation->EditValue ?>"<?php echo $users->activation->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_activation" name="o<?php echo $users_list->RowIndex ?>_activation" id="o<?php echo $users_list->RowIndex ?>_activation" value="<?php echo HtmlEncode($users->activation->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->registered->Visible) { // registered ?>
		<td data-name="registered">
<span id="el$rowindex$_users_registered" class="form-group users_registered">
<input type="text" data-table="users" data-field="x_registered" name="x<?php echo $users_list->RowIndex ?>_registered" id="x<?php echo $users_list->RowIndex ?>_registered" placeholder="<?php echo HtmlEncode($users->registered->getPlaceHolder()) ?>" value="<?php echo $users->registered->EditValue ?>"<?php echo $users->registered->editAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_registered" name="o<?php echo $users_list->RowIndex ?>_registered" id="o<?php echo $users_list->RowIndex ?>_registered" value="<?php echo HtmlEncode($users->registered->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$users_list->ListOptions->render("body", "right", $users_list->RowIndex);
?>
<script>
fuserslist.updateLists(<?php echo $users_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($users->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $users_list->FormKeyCountName ?>" id="<?php echo $users_list->FormKeyCountName ?>" value="<?php echo $users_list->KeyCount ?>">
<?php echo $users_list->MultiSelectKey ?>
<?php } ?>
<?php if ($users->isEdit()) { ?>
<input type="hidden" name="<?php echo $users_list->FormKeyCountName ?>" id="<?php echo $users_list->FormKeyCountName ?>" value="<?php echo $users_list->KeyCount ?>">
<?php } ?>
<?php if (!$users->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($users_list->Recordset)
	$users_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($users_list->TotalRecs == 0 && !$users->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $users_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$users_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$users->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$users_list->terminate();
?>
