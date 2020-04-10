<?php
namespace PHPMaker2019\tabelo_admin;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($adverts_grid))
	$adverts_grid = new adverts_grid();

// Run the page
$adverts_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$adverts_grid->Page_Render();
?>
<?php if (!$adverts->isExport()) { ?>
<script>

// Form object
var fadvertsgrid = new ew.Form("fadvertsgrid", "grid");
fadvertsgrid.formKeyCountName = '<?php echo $adverts_grid->FormKeyCountName ?>';

// Validate form
fadvertsgrid.validate = function() {
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
		<?php if ($adverts_grid->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->_userId->caption(), $adverts->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($adverts->_userId->errorMessage()) ?>");
		<?php if ($adverts_grid->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->title->caption(), $adverts->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_grid->description->Required) { ?>
			elm = this.getElements("x" + infix + "_description");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->description->caption(), $adverts->description->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_grid->categoryId->Required) { ?>
			elm = this.getElements("x" + infix + "_categoryId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->categoryId->caption(), $adverts->categoryId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_grid->locationId->Required) { ?>
			elm = this.getElements("x" + infix + "_locationId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->locationId->caption(), $adverts->locationId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_grid->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->date->caption(), $adverts->date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($adverts->date->errorMessage()) ?>");
		<?php if ($adverts_grid->cost->Required) { ?>
			elm = this.getElements("x" + infix + "_cost");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->cost->caption(), $adverts->cost->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fadvertsgrid.emptyRow = function(infix) {
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
fadvertsgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fadvertsgrid.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fadvertsgrid.lists["x__userId"] = <?php echo $adverts_grid->_userId->Lookup->toClientList() ?>;
fadvertsgrid.lists["x__userId"].options = <?php echo JsonEncode($adverts_grid->_userId->lookupOptions()) ?>;
fadvertsgrid.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fadvertsgrid.lists["x_categoryId"] = <?php echo $adverts_grid->categoryId->Lookup->toClientList() ?>;
fadvertsgrid.lists["x_categoryId"].options = <?php echo JsonEncode($adverts_grid->categoryId->lookupOptions()) ?>;
fadvertsgrid.lists["x_locationId"] = <?php echo $adverts_grid->locationId->Lookup->toClientList() ?>;
fadvertsgrid.lists["x_locationId"].options = <?php echo JsonEncode($adverts_grid->locationId->lookupOptions()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
$adverts_grid->renderOtherOptions();
?>
<?php $adverts_grid->showPageHeader(); ?>
<?php
$adverts_grid->showMessage();
?>
<?php if ($adverts_grid->TotalRecs > 0 || $adverts->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($adverts_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> adverts">
<?php if ($adverts_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $adverts_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fadvertsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_adverts" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table id="tbl_advertsgrid" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$adverts_grid->RowType = ROWTYPE_HEADER;

// Render list options
$adverts_grid->renderListOptions();

// Render list options (header, left)
$adverts_grid->ListOptions->render("header", "left");
?>
<?php if ($adverts->_userId->Visible) { // userId ?>
	<?php if ($adverts->sortUrl($adverts->_userId) == "") { ?>
		<th data-name="_userId" class="<?php echo $adverts->_userId->headerCellClass() ?>"><div id="elh_adverts__userId" class="adverts__userId"><div class="ew-table-header-caption"><?php echo $adverts->_userId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_userId" class="<?php echo $adverts->_userId->headerCellClass() ?>"><div><div id="elh_adverts__userId" class="adverts__userId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->_userId->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->_userId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->_userId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->title->Visible) { // title ?>
	<?php if ($adverts->sortUrl($adverts->title) == "") { ?>
		<th data-name="title" class="<?php echo $adverts->title->headerCellClass() ?>"><div id="elh_adverts_title" class="adverts_title"><div class="ew-table-header-caption"><?php echo $adverts->title->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $adverts->title->headerCellClass() ?>"><div><div id="elh_adverts_title" class="adverts_title">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->title->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->description->Visible) { // description ?>
	<?php if ($adverts->sortUrl($adverts->description) == "") { ?>
		<th data-name="description" class="<?php echo $adverts->description->headerCellClass() ?>"><div id="elh_adverts_description" class="adverts_description"><div class="ew-table-header-caption"><?php echo $adverts->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $adverts->description->headerCellClass() ?>"><div><div id="elh_adverts_description" class="adverts_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->description->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->description->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->description->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->categoryId->Visible) { // categoryId ?>
	<?php if ($adverts->sortUrl($adverts->categoryId) == "") { ?>
		<th data-name="categoryId" class="<?php echo $adverts->categoryId->headerCellClass() ?>"><div id="elh_adverts_categoryId" class="adverts_categoryId"><div class="ew-table-header-caption"><?php echo $adverts->categoryId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="categoryId" class="<?php echo $adverts->categoryId->headerCellClass() ?>"><div><div id="elh_adverts_categoryId" class="adverts_categoryId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->categoryId->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->categoryId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->categoryId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->locationId->Visible) { // locationId ?>
	<?php if ($adverts->sortUrl($adverts->locationId) == "") { ?>
		<th data-name="locationId" class="<?php echo $adverts->locationId->headerCellClass() ?>"><div id="elh_adverts_locationId" class="adverts_locationId"><div class="ew-table-header-caption"><?php echo $adverts->locationId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="locationId" class="<?php echo $adverts->locationId->headerCellClass() ?>"><div><div id="elh_adverts_locationId" class="adverts_locationId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->locationId->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->locationId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->locationId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->date->Visible) { // date ?>
	<?php if ($adverts->sortUrl($adverts->date) == "") { ?>
		<th data-name="date" class="<?php echo $adverts->date->headerCellClass() ?>"><div id="elh_adverts_date" class="adverts_date"><div class="ew-table-header-caption"><?php echo $adverts->date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $adverts->date->headerCellClass() ?>"><div><div id="elh_adverts_date" class="adverts_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->date->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adverts->cost->Visible) { // cost ?>
	<?php if ($adverts->sortUrl($adverts->cost) == "") { ?>
		<th data-name="cost" class="<?php echo $adverts->cost->headerCellClass() ?>"><div id="elh_adverts_cost" class="adverts_cost"><div class="ew-table-header-caption"><?php echo $adverts->cost->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cost" class="<?php echo $adverts->cost->headerCellClass() ?>"><div><div id="elh_adverts_cost" class="adverts_cost">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $adverts->cost->caption() ?></span><span class="ew-table-header-sort"><?php if ($adverts->cost->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($adverts->cost->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$adverts_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$adverts_grid->StartRec = 1;
$adverts_grid->StopRec = $adverts_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($CurrentForm && $adverts_grid->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($adverts_grid->FormKeyCountName) && ($adverts->isGridAdd() || $adverts->isGridEdit() || $adverts->isConfirm())) {
		$adverts_grid->KeyCount = $CurrentForm->getValue($adverts_grid->FormKeyCountName);
		$adverts_grid->StopRec = $adverts_grid->StartRec + $adverts_grid->KeyCount - 1;
	}
}
$adverts_grid->RecCnt = $adverts_grid->StartRec - 1;
if ($adverts_grid->Recordset && !$adverts_grid->Recordset->EOF) {
	$adverts_grid->Recordset->moveFirst();
	$selectLimit = $adverts_grid->UseSelectLimit;
	if (!$selectLimit && $adverts_grid->StartRec > 1)
		$adverts_grid->Recordset->move($adverts_grid->StartRec - 1);
} elseif (!$adverts->AllowAddDeleteRow && $adverts_grid->StopRec == 0) {
	$adverts_grid->StopRec = $adverts->GridAddRowCount;
}

// Initialize aggregate
$adverts->RowType = ROWTYPE_AGGREGATEINIT;
$adverts->resetAttributes();
$adverts_grid->renderRow();
if ($adverts->isGridAdd())
	$adverts_grid->RowIndex = 0;
if ($adverts->isGridEdit())
	$adverts_grid->RowIndex = 0;
while ($adverts_grid->RecCnt < $adverts_grid->StopRec) {
	$adverts_grid->RecCnt++;
	if ($adverts_grid->RecCnt >= $adverts_grid->StartRec) {
		$adverts_grid->RowCnt++;
		if ($adverts->isGridAdd() || $adverts->isGridEdit() || $adverts->isConfirm()) {
			$adverts_grid->RowIndex++;
			$CurrentForm->Index = $adverts_grid->RowIndex;
			if ($CurrentForm->hasValue($adverts_grid->FormActionName) && $adverts_grid->EventCancelled)
				$adverts_grid->RowAction = strval($CurrentForm->getValue($adverts_grid->FormActionName));
			elseif ($adverts->isGridAdd())
				$adverts_grid->RowAction = "insert";
			else
				$adverts_grid->RowAction = "";
		}

		// Set up key count
		$adverts_grid->KeyCount = $adverts_grid->RowIndex;

		// Init row class and style
		$adverts->resetAttributes();
		$adverts->CssClass = "";
		if ($adverts->isGridAdd()) {
			if ($adverts->CurrentMode == "copy") {
				$adverts_grid->loadRowValues($adverts_grid->Recordset); // Load row values
				$adverts_grid->setRecordKey($adverts_grid->RowOldKey, $adverts_grid->Recordset); // Set old record key
			} else {
				$adverts_grid->loadRowValues(); // Load default values
				$adverts_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$adverts_grid->loadRowValues($adverts_grid->Recordset); // Load row values
		}
		$adverts->RowType = ROWTYPE_VIEW; // Render view
		if ($adverts->isGridAdd()) // Grid add
			$adverts->RowType = ROWTYPE_ADD; // Render add
		if ($adverts->isGridAdd() && $adverts->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$adverts_grid->restoreCurrentRowFormValues($adverts_grid->RowIndex); // Restore form values
		if ($adverts->isGridEdit()) { // Grid edit
			if ($adverts->EventCancelled)
				$adverts_grid->restoreCurrentRowFormValues($adverts_grid->RowIndex); // Restore form values
			if ($adverts_grid->RowAction == "insert")
				$adverts->RowType = ROWTYPE_ADD; // Render add
			else
				$adverts->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($adverts->isGridEdit() && ($adverts->RowType == ROWTYPE_EDIT || $adverts->RowType == ROWTYPE_ADD) && $adverts->EventCancelled) // Update failed
			$adverts_grid->restoreCurrentRowFormValues($adverts_grid->RowIndex); // Restore form values
		if ($adverts->RowType == ROWTYPE_EDIT) // Edit row
			$adverts_grid->EditRowCnt++;
		if ($adverts->isConfirm()) // Confirm row
			$adverts_grid->restoreCurrentRowFormValues($adverts_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$adverts->RowAttrs = array_merge($adverts->RowAttrs, array('data-rowindex'=>$adverts_grid->RowCnt, 'id'=>'r' . $adverts_grid->RowCnt . '_adverts', 'data-rowtype'=>$adverts->RowType));

		// Render row
		$adverts_grid->renderRow();

		// Render list options
		$adverts_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($adverts_grid->RowAction <> "delete" && $adverts_grid->RowAction <> "insertdelete" && !($adverts_grid->RowAction == "insert" && $adverts->isConfirm() && $adverts_grid->emptyRow())) {
?>
	<tr<?php echo $adverts->rowAttributes() ?>>
<?php

// Render list options (body, left)
$adverts_grid->ListOptions->render("body", "left", $adverts_grid->RowCnt);
?>
	<?php if ($adverts->_userId->Visible) { // userId ?>
		<td data-name="_userId"<?php echo $adverts->_userId->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($adverts->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->ViewValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$adverts->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->EditValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<?php
$wrkonchange = "" . trim(@$adverts->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$adverts->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $adverts_grid->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $adverts_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $adverts_grid->RowIndex ?>__userId" id="sv_x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>"<?php echo $adverts->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" data-value-separator="<?php echo $adverts->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fadvertsgrid.createAutoSuggest({"id":"x<?php echo $adverts_grid->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $adverts->_userId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "__userId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x__userId" name="o<?php echo $adverts_grid->RowIndex ?>__userId" id="o<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($adverts->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->ViewValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$adverts->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->EditValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts__userId" class="form-group adverts__userId">
<?php
$wrkonchange = "" . trim(@$adverts->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$adverts->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $adverts_grid->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $adverts_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $adverts_grid->RowIndex ?>__userId" id="sv_x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>"<?php echo $adverts->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" data-value-separator="<?php echo $adverts->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fadvertsgrid.createAutoSuggest({"id":"x<?php echo $adverts_grid->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $adverts->_userId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts__userId" class="adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->getViewValue())) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><?php echo $adverts->_userId->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->_userId->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if (!$adverts->isConfirm()) { ?>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x__userId" name="o<?php echo $adverts_grid->RowIndex ?>__userId" id="o<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="adverts" data-field="x__userId" name="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>__userId" id="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x__userId" name="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>__userId" id="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="adverts" data-field="x_advId" name="x<?php echo $adverts_grid->RowIndex ?>_advId" id="x<?php echo $adverts_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($adverts->advId->CurrentValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_advId" name="o<?php echo $adverts_grid->RowIndex ?>_advId" id="o<?php echo $adverts_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($adverts->advId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT || $adverts->CurrentMode == "edit") { ?>
<input type="hidden" data-table="adverts" data-field="x_advId" name="x<?php echo $adverts_grid->RowIndex ?>_advId" id="x<?php echo $adverts_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($adverts->advId->CurrentValue) ?>">
<?php } ?>
	<?php if ($adverts->title->Visible) { // title ?>
		<td data-name="title"<?php echo $adverts->title->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_title" class="form-group adverts_title">
<input type="text" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_grid->RowIndex ?>_title" id="x<?php echo $adverts_grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($adverts->title->getPlaceHolder()) ?>" value="<?php echo $adverts->title->EditValue ?>"<?php echo $adverts->title->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_title" name="o<?php echo $adverts_grid->RowIndex ?>_title" id="o<?php echo $adverts_grid->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_title" class="form-group adverts_title">
<input type="text" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_grid->RowIndex ?>_title" id="x<?php echo $adverts_grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($adverts->title->getPlaceHolder()) ?>" value="<?php echo $adverts->title->EditValue ?>"<?php echo $adverts->title->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_title" class="adverts_title">
<span<?php echo $adverts->title->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->title->getViewValue())) && $adverts->title->linkAttributes() <> "") { ?>
<a<?php echo $adverts->title->linkAttributes() ?>><?php echo $adverts->title->getViewValue() ?></a>
<?php } else { ?>
<?php echo $adverts->title->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if (!$adverts->isConfirm()) { ?>
<input type="hidden" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_grid->RowIndex ?>_title" id="x<?php echo $adverts_grid->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_title" name="o<?php echo $adverts_grid->RowIndex ?>_title" id="o<?php echo $adverts_grid->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="adverts" data-field="x_title" name="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_title" id="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_title" name="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_title" id="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->description->Visible) { // description ?>
		<td data-name="description"<?php echo $adverts->description->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_description" class="form-group adverts_description">
<textarea data-table="adverts" data-field="x_description" name="x<?php echo $adverts_grid->RowIndex ?>_description" id="x<?php echo $adverts_grid->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($adverts->description->getPlaceHolder()) ?>"<?php echo $adverts->description->editAttributes() ?>><?php echo $adverts->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="adverts" data-field="x_description" name="o<?php echo $adverts_grid->RowIndex ?>_description" id="o<?php echo $adverts_grid->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_description" class="form-group adverts_description">
<textarea data-table="adverts" data-field="x_description" name="x<?php echo $adverts_grid->RowIndex ?>_description" id="x<?php echo $adverts_grid->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($adverts->description->getPlaceHolder()) ?>"<?php echo $adverts->description->editAttributes() ?>><?php echo $adverts->description->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_description" class="adverts_description">
<span<?php echo $adverts->description->viewAttributes() ?>>
<?php echo $adverts->description->getViewValue() ?></span>
</span>
<?php if (!$adverts->isConfirm()) { ?>
<input type="hidden" data-table="adverts" data-field="x_description" name="x<?php echo $adverts_grid->RowIndex ?>_description" id="x<?php echo $adverts_grid->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_description" name="o<?php echo $adverts_grid->RowIndex ?>_description" id="o<?php echo $adverts_grid->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="adverts" data-field="x_description" name="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_description" id="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_description" name="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_description" id="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->categoryId->Visible) { // categoryId ?>
		<td data-name="categoryId"<?php echo $adverts->categoryId->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($adverts->categoryId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="adverts" data-field="x_categoryId" data-value-separator="<?php echo $adverts->categoryId->displayValueSeparatorAttribute() ?>" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId"<?php echo $adverts->categoryId->editAttributes() ?>>
		<?php echo $adverts->categoryId->selectOptionListHtml("x<?php echo $adverts_grid->RowIndex ?>_categoryId") ?>
	</select>
</div>
<?php echo $adverts->categoryId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "_categoryId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="o<?php echo $adverts_grid->RowIndex ?>_categoryId" id="o<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($adverts->categoryId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_categoryId" class="form-group adverts_categoryId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="adverts" data-field="x_categoryId" data-value-separator="<?php echo $adverts->categoryId->displayValueSeparatorAttribute() ?>" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId"<?php echo $adverts->categoryId->editAttributes() ?>>
		<?php echo $adverts->categoryId->selectOptionListHtml("x<?php echo $adverts_grid->RowIndex ?>_categoryId") ?>
	</select>
</div>
<?php echo $adverts->categoryId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "_categoryId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_categoryId" class="adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<?php echo $adverts->categoryId->getViewValue() ?></span>
</span>
<?php if (!$adverts->isConfirm()) { ?>
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="o<?php echo $adverts_grid->RowIndex ?>_categoryId" id="o<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_categoryId" id="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_categoryId" id="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->locationId->Visible) { // locationId ?>
		<td data-name="locationId"<?php echo $adverts->locationId->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($adverts->locationId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $adverts_grid->RowIndex ?>_locationId"><?php echo strval($adverts->locationId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $adverts->locationId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($adverts->locationId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($adverts->locationId->ReadOnly || $adverts->locationId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $adverts_grid->RowIndex ?>_locationId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $adverts->locationId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "_locationId") ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $adverts->locationId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo $adverts->locationId->CurrentValue ?>"<?php echo $adverts->locationId->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" name="o<?php echo $adverts_grid->RowIndex ?>_locationId" id="o<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($adverts->locationId->getSessionValue() <> "") { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_locationId" class="form-group adverts_locationId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $adverts_grid->RowIndex ?>_locationId"><?php echo strval($adverts->locationId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $adverts->locationId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($adverts->locationId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($adverts->locationId->ReadOnly || $adverts->locationId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $adverts_grid->RowIndex ?>_locationId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $adverts->locationId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "_locationId") ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $adverts->locationId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo $adverts->locationId->CurrentValue ?>"<?php echo $adverts->locationId->editAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_locationId" class="adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<?php echo $adverts->locationId->getViewValue() ?></span>
</span>
<?php if (!$adverts->isConfirm()) { ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_locationId" name="o<?php echo $adverts_grid->RowIndex ?>_locationId" id="o<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" name="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_locationId" id="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_locationId" name="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_locationId" id="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->date->Visible) { // date ?>
		<td data-name="date"<?php echo $adverts->date->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_date" class="form-group adverts_date">
<input type="text" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_grid->RowIndex ?>_date" id="x<?php echo $adverts_grid->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($adverts->date->getPlaceHolder()) ?>" value="<?php echo $adverts->date->EditValue ?>"<?php echo $adverts->date->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_date" name="o<?php echo $adverts_grid->RowIndex ?>_date" id="o<?php echo $adverts_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_date" class="form-group adverts_date">
<input type="text" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_grid->RowIndex ?>_date" id="x<?php echo $adverts_grid->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($adverts->date->getPlaceHolder()) ?>" value="<?php echo $adverts->date->EditValue ?>"<?php echo $adverts->date->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_date" class="adverts_date">
<span<?php echo $adverts->date->viewAttributes() ?>>
<?php echo $adverts->date->getViewValue() ?></span>
</span>
<?php if (!$adverts->isConfirm()) { ?>
<input type="hidden" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_grid->RowIndex ?>_date" id="x<?php echo $adverts_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_date" name="o<?php echo $adverts_grid->RowIndex ?>_date" id="o<?php echo $adverts_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="adverts" data-field="x_date" name="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_date" id="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_date" name="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_date" id="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($adverts->cost->Visible) { // cost ?>
		<td data-name="cost"<?php echo $adverts->cost->cellAttributes() ?>>
<?php if ($adverts->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_cost" class="form-group adverts_cost">
<input type="text" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_grid->RowIndex ?>_cost" id="x<?php echo $adverts_grid->RowIndex ?>_cost" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($adverts->cost->getPlaceHolder()) ?>" value="<?php echo $adverts->cost->EditValue ?>"<?php echo $adverts->cost->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x_cost" name="o<?php echo $adverts_grid->RowIndex ?>_cost" id="o<?php echo $adverts_grid->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->OldValue) ?>">
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_cost" class="form-group adverts_cost">
<input type="text" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_grid->RowIndex ?>_cost" id="x<?php echo $adverts_grid->RowIndex ?>_cost" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($adverts->cost->getPlaceHolder()) ?>" value="<?php echo $adverts->cost->EditValue ?>"<?php echo $adverts->cost->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($adverts->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $adverts_grid->RowCnt ?>_adverts_cost" class="adverts_cost">
<span<?php echo $adverts->cost->viewAttributes() ?>>
<?php echo $adverts->cost->getViewValue() ?></span>
</span>
<?php if (!$adverts->isConfirm()) { ?>
<input type="hidden" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_grid->RowIndex ?>_cost" id="x<?php echo $adverts_grid->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_cost" name="o<?php echo $adverts_grid->RowIndex ?>_cost" id="o<?php echo $adverts_grid->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="adverts" data-field="x_cost" name="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_cost" id="fadvertsgrid$x<?php echo $adverts_grid->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->FormValue) ?>">
<input type="hidden" data-table="adverts" data-field="x_cost" name="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_cost" id="fadvertsgrid$o<?php echo $adverts_grid->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$adverts_grid->ListOptions->render("body", "right", $adverts_grid->RowCnt);
?>
	</tr>
<?php if ($adverts->RowType == ROWTYPE_ADD || $adverts->RowType == ROWTYPE_EDIT) { ?>
<script>
fadvertsgrid.updateLists(<?php echo $adverts_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$adverts->isGridAdd() || $adverts->CurrentMode == "copy")
		if (!$adverts_grid->Recordset->EOF)
			$adverts_grid->Recordset->moveNext();
}
?>
<?php
	if ($adverts->CurrentMode == "add" || $adverts->CurrentMode == "copy" || $adverts->CurrentMode == "edit") {
		$adverts_grid->RowIndex = '$rowindex$';
		$adverts_grid->loadRowValues();

		// Set row properties
		$adverts->resetAttributes();
		$adverts->RowAttrs = array_merge($adverts->RowAttrs, array('data-rowindex'=>$adverts_grid->RowIndex, 'id'=>'r0_adverts', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($adverts->RowAttrs["class"], "ew-template");
		$adverts->RowType = ROWTYPE_ADD;

		// Render row
		$adverts_grid->renderRow();

		// Render list options
		$adverts_grid->renderListOptions();
		$adverts_grid->StartRowCnt = 0;
?>
	<tr<?php echo $adverts->rowAttributes() ?>>
<?php

// Render list options (body, left)
$adverts_grid->ListOptions->render("body", "left", $adverts_grid->RowIndex);
?>
	<?php if ($adverts->_userId->Visible) { // userId ?>
		<td data-name="_userId">
<?php if (!$adverts->isConfirm()) { ?>
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
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$adverts->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->EditValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_adverts__userId" class="form-group adverts__userId">
<?php
$wrkonchange = "" . trim(@$adverts->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$adverts->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $adverts_grid->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $adverts_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $adverts_grid->RowIndex ?>__userId" id="sv_x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>"<?php echo $adverts->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" data-value-separator="<?php echo $adverts->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fadvertsgrid.createAutoSuggest({"id":"x<?php echo $adverts_grid->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $adverts->_userId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_adverts__userId" class="form-group adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->ViewValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x<?php echo $adverts_grid->RowIndex ?>__userId" id="x<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x__userId" name="o<?php echo $adverts_grid->RowIndex ?>__userId" id="o<?php echo $adverts_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($adverts->_userId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->title->Visible) { // title ?>
		<td data-name="title">
<?php if (!$adverts->isConfirm()) { ?>
<span id="el$rowindex$_adverts_title" class="form-group adverts_title">
<input type="text" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_grid->RowIndex ?>_title" id="x<?php echo $adverts_grid->RowIndex ?>_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($adverts->title->getPlaceHolder()) ?>" value="<?php echo $adverts->title->EditValue ?>"<?php echo $adverts->title->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_adverts_title" class="form-group adverts_title">
<span<?php echo $adverts->title->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->title->ViewValue)) && $adverts->title->linkAttributes() <> "") { ?>
<a<?php echo $adverts->title->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->title->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->title->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x_title" name="x<?php echo $adverts_grid->RowIndex ?>_title" id="x<?php echo $adverts_grid->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_title" name="o<?php echo $adverts_grid->RowIndex ?>_title" id="o<?php echo $adverts_grid->RowIndex ?>_title" value="<?php echo HtmlEncode($adverts->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->description->Visible) { // description ?>
		<td data-name="description">
<?php if (!$adverts->isConfirm()) { ?>
<span id="el$rowindex$_adverts_description" class="form-group adverts_description">
<textarea data-table="adverts" data-field="x_description" name="x<?php echo $adverts_grid->RowIndex ?>_description" id="x<?php echo $adverts_grid->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($adverts->description->getPlaceHolder()) ?>"<?php echo $adverts->description->editAttributes() ?>><?php echo $adverts->description->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_adverts_description" class="form-group adverts_description">
<span<?php echo $adverts->description->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->description->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="adverts" data-field="x_description" name="x<?php echo $adverts_grid->RowIndex ?>_description" id="x<?php echo $adverts_grid->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_description" name="o<?php echo $adverts_grid->RowIndex ?>_description" id="o<?php echo $adverts_grid->RowIndex ?>_description" value="<?php echo HtmlEncode($adverts->description->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->categoryId->Visible) { // categoryId ?>
		<td data-name="categoryId">
<?php if (!$adverts->isConfirm()) { ?>
<?php if ($adverts->categoryId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_adverts_categoryId" class="form-group adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_adverts_categoryId" class="form-group adverts_categoryId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="adverts" data-field="x_categoryId" data-value-separator="<?php echo $adverts->categoryId->displayValueSeparatorAttribute() ?>" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId"<?php echo $adverts->categoryId->editAttributes() ?>>
		<?php echo $adverts->categoryId->selectOptionListHtml("x<?php echo $adverts_grid->RowIndex ?>_categoryId") ?>
	</select>
</div>
<?php echo $adverts->categoryId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "_categoryId") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_adverts_categoryId" class="form-group adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="x<?php echo $adverts_grid->RowIndex ?>_categoryId" id="x<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_categoryId" name="o<?php echo $adverts_grid->RowIndex ?>_categoryId" id="o<?php echo $adverts_grid->RowIndex ?>_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->locationId->Visible) { // locationId ?>
		<td data-name="locationId">
<?php if (!$adverts->isConfirm()) { ?>
<?php if ($adverts->locationId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_adverts_locationId" class="form-group adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_adverts_locationId" class="form-group adverts_locationId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $adverts_grid->RowIndex ?>_locationId"><?php echo strval($adverts->locationId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $adverts->locationId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($adverts->locationId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($adverts->locationId->ReadOnly || $adverts->locationId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $adverts_grid->RowIndex ?>_locationId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $adverts->locationId->Lookup->getParamTag("p_x" . $adverts_grid->RowIndex . "_locationId") ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $adverts->locationId->displayValueSeparatorAttribute() ?>" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo $adverts->locationId->CurrentValue ?>"<?php echo $adverts->locationId->editAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_adverts_locationId" class="form-group adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="adverts" data-field="x_locationId" name="x<?php echo $adverts_grid->RowIndex ?>_locationId" id="x<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" name="o<?php echo $adverts_grid->RowIndex ?>_locationId" id="o<?php echo $adverts_grid->RowIndex ?>_locationId" value="<?php echo HtmlEncode($adverts->locationId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->date->Visible) { // date ?>
		<td data-name="date">
<?php if (!$adverts->isConfirm()) { ?>
<span id="el$rowindex$_adverts_date" class="form-group adverts_date">
<input type="text" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_grid->RowIndex ?>_date" id="x<?php echo $adverts_grid->RowIndex ?>_date" placeholder="<?php echo HtmlEncode($adverts->date->getPlaceHolder()) ?>" value="<?php echo $adverts->date->EditValue ?>"<?php echo $adverts->date->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_adverts_date" class="form-group adverts_date">
<span<?php echo $adverts->date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->date->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="adverts" data-field="x_date" name="x<?php echo $adverts_grid->RowIndex ?>_date" id="x<?php echo $adverts_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_date" name="o<?php echo $adverts_grid->RowIndex ?>_date" id="o<?php echo $adverts_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($adverts->date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($adverts->cost->Visible) { // cost ?>
		<td data-name="cost">
<?php if (!$adverts->isConfirm()) { ?>
<span id="el$rowindex$_adverts_cost" class="form-group adverts_cost">
<input type="text" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_grid->RowIndex ?>_cost" id="x<?php echo $adverts_grid->RowIndex ?>_cost" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($adverts->cost->getPlaceHolder()) ?>" value="<?php echo $adverts->cost->EditValue ?>"<?php echo $adverts->cost->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_adverts_cost" class="form-group adverts_cost">
<span<?php echo $adverts->cost->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->cost->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="adverts" data-field="x_cost" name="x<?php echo $adverts_grid->RowIndex ?>_cost" id="x<?php echo $adverts_grid->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="adverts" data-field="x_cost" name="o<?php echo $adverts_grid->RowIndex ?>_cost" id="o<?php echo $adverts_grid->RowIndex ?>_cost" value="<?php echo HtmlEncode($adverts->cost->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$adverts_grid->ListOptions->render("body", "right", $adverts_grid->RowIndex);
?>
<script>
fadvertsgrid.updateLists(<?php echo $adverts_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($adverts->CurrentMode == "add" || $adverts->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $adverts_grid->FormKeyCountName ?>" id="<?php echo $adverts_grid->FormKeyCountName ?>" value="<?php echo $adverts_grid->KeyCount ?>">
<?php echo $adverts_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($adverts->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $adverts_grid->FormKeyCountName ?>" id="<?php echo $adverts_grid->FormKeyCountName ?>" value="<?php echo $adverts_grid->KeyCount ?>">
<?php echo $adverts_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($adverts->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fadvertsgrid">
</div><!-- /.ew-grid-middle-panel -->
<?php

// Close recordset
if ($adverts_grid->Recordset)
	$adverts_grid->Recordset->Close();
?>
</div>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($adverts_grid->TotalRecs == 0 && !$adverts->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $adverts_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$adverts_grid->terminate();
?>
