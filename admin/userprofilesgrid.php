<?php
namespace PHPMaker2019\tabelo_admin;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($userprofiles_grid))
	$userprofiles_grid = new userprofiles_grid();

// Run the page
$userprofiles_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userprofiles_grid->Page_Render();
?>
<?php if (!$userprofiles->isExport()) { ?>
<script>

// Form object
var fuserprofilesgrid = new ew.Form("fuserprofilesgrid", "grid");
fuserprofilesgrid.formKeyCountName = '<?php echo $userprofiles_grid->FormKeyCountName ?>';

// Validate form
fuserprofilesgrid.validate = function() {
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
		<?php if ($userprofiles_grid->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->_userId->caption(), $userprofiles->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($userprofiles->_userId->errorMessage()) ?>");
		<?php if ($userprofiles_grid->firstName->Required) { ?>
			elm = this.getElements("x" + infix + "_firstName");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->firstName->caption(), $userprofiles->firstName->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_grid->lastName->Required) { ?>
			elm = this.getElements("x" + infix + "_lastName");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->lastName->caption(), $userprofiles->lastName->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_grid->address->Required) { ?>
			elm = this.getElements("x" + infix + "_address");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->address->caption(), $userprofiles->address->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_grid->village->Required) { ?>
			elm = this.getElements("x" + infix + "_village");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->village->caption(), $userprofiles->village->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_grid->city->Required) { ?>
			elm = this.getElements("x" + infix + "_city");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->city->caption(), $userprofiles->city->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fuserprofilesgrid.emptyRow = function(infix) {
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
fuserprofilesgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fuserprofilesgrid.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserprofilesgrid.lists["x__userId"] = <?php echo $userprofiles_grid->_userId->Lookup->toClientList() ?>;
fuserprofilesgrid.lists["x__userId"].options = <?php echo JsonEncode($userprofiles_grid->_userId->lookupOptions()) ?>;
fuserprofilesgrid.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<?php } ?>
<?php
$userprofiles_grid->renderOtherOptions();
?>
<?php $userprofiles_grid->showPageHeader(); ?>
<?php
$userprofiles_grid->showMessage();
?>
<?php if ($userprofiles_grid->TotalRecs > 0 || $userprofiles->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($userprofiles_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> userprofiles">
<?php if ($userprofiles_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $userprofiles_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fuserprofilesgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_userprofiles" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table id="tbl_userprofilesgrid" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$userprofiles_grid->RowType = ROWTYPE_HEADER;

// Render list options
$userprofiles_grid->renderListOptions();

// Render list options (header, left)
$userprofiles_grid->ListOptions->render("header", "left");
?>
<?php if ($userprofiles->_userId->Visible) { // userId ?>
	<?php if ($userprofiles->sortUrl($userprofiles->_userId) == "") { ?>
		<th data-name="_userId" class="<?php echo $userprofiles->_userId->headerCellClass() ?>"><div id="elh_userprofiles__userId" class="userprofiles__userId"><div class="ew-table-header-caption"><?php echo $userprofiles->_userId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_userId" class="<?php echo $userprofiles->_userId->headerCellClass() ?>"><div><div id="elh_userprofiles__userId" class="userprofiles__userId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->_userId->caption() ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->_userId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->_userId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->firstName->Visible) { // firstName ?>
	<?php if ($userprofiles->sortUrl($userprofiles->firstName) == "") { ?>
		<th data-name="firstName" class="<?php echo $userprofiles->firstName->headerCellClass() ?>"><div id="elh_userprofiles_firstName" class="userprofiles_firstName"><div class="ew-table-header-caption"><?php echo $userprofiles->firstName->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="firstName" class="<?php echo $userprofiles->firstName->headerCellClass() ?>"><div><div id="elh_userprofiles_firstName" class="userprofiles_firstName">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->firstName->caption() ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->firstName->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->firstName->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->lastName->Visible) { // lastName ?>
	<?php if ($userprofiles->sortUrl($userprofiles->lastName) == "") { ?>
		<th data-name="lastName" class="<?php echo $userprofiles->lastName->headerCellClass() ?>"><div id="elh_userprofiles_lastName" class="userprofiles_lastName"><div class="ew-table-header-caption"><?php echo $userprofiles->lastName->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lastName" class="<?php echo $userprofiles->lastName->headerCellClass() ?>"><div><div id="elh_userprofiles_lastName" class="userprofiles_lastName">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->lastName->caption() ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->lastName->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->lastName->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->address->Visible) { // address ?>
	<?php if ($userprofiles->sortUrl($userprofiles->address) == "") { ?>
		<th data-name="address" class="<?php echo $userprofiles->address->headerCellClass() ?>"><div id="elh_userprofiles_address" class="userprofiles_address"><div class="ew-table-header-caption"><?php echo $userprofiles->address->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="address" class="<?php echo $userprofiles->address->headerCellClass() ?>"><div><div id="elh_userprofiles_address" class="userprofiles_address">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->address->caption() ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->address->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->address->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->village->Visible) { // village ?>
	<?php if ($userprofiles->sortUrl($userprofiles->village) == "") { ?>
		<th data-name="village" class="<?php echo $userprofiles->village->headerCellClass() ?>"><div id="elh_userprofiles_village" class="userprofiles_village"><div class="ew-table-header-caption"><?php echo $userprofiles->village->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="village" class="<?php echo $userprofiles->village->headerCellClass() ?>"><div><div id="elh_userprofiles_village" class="userprofiles_village">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->village->caption() ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->village->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->village->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userprofiles->city->Visible) { // city ?>
	<?php if ($userprofiles->sortUrl($userprofiles->city) == "") { ?>
		<th data-name="city" class="<?php echo $userprofiles->city->headerCellClass() ?>"><div id="elh_userprofiles_city" class="userprofiles_city"><div class="ew-table-header-caption"><?php echo $userprofiles->city->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="city" class="<?php echo $userprofiles->city->headerCellClass() ?>"><div><div id="elh_userprofiles_city" class="userprofiles_city">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userprofiles->city->caption() ?></span><span class="ew-table-header-sort"><?php if ($userprofiles->city->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($userprofiles->city->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$userprofiles_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$userprofiles_grid->StartRec = 1;
$userprofiles_grid->StopRec = $userprofiles_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($CurrentForm && $userprofiles_grid->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($userprofiles_grid->FormKeyCountName) && ($userprofiles->isGridAdd() || $userprofiles->isGridEdit() || $userprofiles->isConfirm())) {
		$userprofiles_grid->KeyCount = $CurrentForm->getValue($userprofiles_grid->FormKeyCountName);
		$userprofiles_grid->StopRec = $userprofiles_grid->StartRec + $userprofiles_grid->KeyCount - 1;
	}
}
$userprofiles_grid->RecCnt = $userprofiles_grid->StartRec - 1;
if ($userprofiles_grid->Recordset && !$userprofiles_grid->Recordset->EOF) {
	$userprofiles_grid->Recordset->moveFirst();
	$selectLimit = $userprofiles_grid->UseSelectLimit;
	if (!$selectLimit && $userprofiles_grid->StartRec > 1)
		$userprofiles_grid->Recordset->move($userprofiles_grid->StartRec - 1);
} elseif (!$userprofiles->AllowAddDeleteRow && $userprofiles_grid->StopRec == 0) {
	$userprofiles_grid->StopRec = $userprofiles->GridAddRowCount;
}

// Initialize aggregate
$userprofiles->RowType = ROWTYPE_AGGREGATEINIT;
$userprofiles->resetAttributes();
$userprofiles_grid->renderRow();
if ($userprofiles->isGridAdd())
	$userprofiles_grid->RowIndex = 0;
if ($userprofiles->isGridEdit())
	$userprofiles_grid->RowIndex = 0;
while ($userprofiles_grid->RecCnt < $userprofiles_grid->StopRec) {
	$userprofiles_grid->RecCnt++;
	if ($userprofiles_grid->RecCnt >= $userprofiles_grid->StartRec) {
		$userprofiles_grid->RowCnt++;
		if ($userprofiles->isGridAdd() || $userprofiles->isGridEdit() || $userprofiles->isConfirm()) {
			$userprofiles_grid->RowIndex++;
			$CurrentForm->Index = $userprofiles_grid->RowIndex;
			if ($CurrentForm->hasValue($userprofiles_grid->FormActionName) && $userprofiles_grid->EventCancelled)
				$userprofiles_grid->RowAction = strval($CurrentForm->getValue($userprofiles_grid->FormActionName));
			elseif ($userprofiles->isGridAdd())
				$userprofiles_grid->RowAction = "insert";
			else
				$userprofiles_grid->RowAction = "";
		}

		// Set up key count
		$userprofiles_grid->KeyCount = $userprofiles_grid->RowIndex;

		// Init row class and style
		$userprofiles->resetAttributes();
		$userprofiles->CssClass = "";
		if ($userprofiles->isGridAdd()) {
			if ($userprofiles->CurrentMode == "copy") {
				$userprofiles_grid->loadRowValues($userprofiles_grid->Recordset); // Load row values
				$userprofiles_grid->setRecordKey($userprofiles_grid->RowOldKey, $userprofiles_grid->Recordset); // Set old record key
			} else {
				$userprofiles_grid->loadRowValues(); // Load default values
				$userprofiles_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$userprofiles_grid->loadRowValues($userprofiles_grid->Recordset); // Load row values
		}
		$userprofiles->RowType = ROWTYPE_VIEW; // Render view
		if ($userprofiles->isGridAdd()) // Grid add
			$userprofiles->RowType = ROWTYPE_ADD; // Render add
		if ($userprofiles->isGridAdd() && $userprofiles->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$userprofiles_grid->restoreCurrentRowFormValues($userprofiles_grid->RowIndex); // Restore form values
		if ($userprofiles->isGridEdit()) { // Grid edit
			if ($userprofiles->EventCancelled)
				$userprofiles_grid->restoreCurrentRowFormValues($userprofiles_grid->RowIndex); // Restore form values
			if ($userprofiles_grid->RowAction == "insert")
				$userprofiles->RowType = ROWTYPE_ADD; // Render add
			else
				$userprofiles->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($userprofiles->isGridEdit() && ($userprofiles->RowType == ROWTYPE_EDIT || $userprofiles->RowType == ROWTYPE_ADD) && $userprofiles->EventCancelled) // Update failed
			$userprofiles_grid->restoreCurrentRowFormValues($userprofiles_grid->RowIndex); // Restore form values
		if ($userprofiles->RowType == ROWTYPE_EDIT) // Edit row
			$userprofiles_grid->EditRowCnt++;
		if ($userprofiles->isConfirm()) // Confirm row
			$userprofiles_grid->restoreCurrentRowFormValues($userprofiles_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$userprofiles->RowAttrs = array_merge($userprofiles->RowAttrs, array('data-rowindex'=>$userprofiles_grid->RowCnt, 'id'=>'r' . $userprofiles_grid->RowCnt . '_userprofiles', 'data-rowtype'=>$userprofiles->RowType));

		// Render row
		$userprofiles_grid->renderRow();

		// Render list options
		$userprofiles_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($userprofiles_grid->RowAction <> "delete" && $userprofiles_grid->RowAction <> "insertdelete" && !($userprofiles_grid->RowAction == "insert" && $userprofiles->isConfirm() && $userprofiles_grid->emptyRow())) {
?>
	<tr<?php echo $userprofiles->rowAttributes() ?>>
<?php

// Render list options (body, left)
$userprofiles_grid->ListOptions->render("body", "left", $userprofiles_grid->RowCnt);
?>
	<?php if ($userprofiles->_userId->Visible) { // userId ?>
		<td data-name="_userId"<?php echo $userprofiles->_userId->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($userprofiles->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$userprofiles->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<?php
$wrkonchange = "" . trim(@$userprofiles->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$userprofiles->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $userprofiles_grid->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $userprofiles_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="sv_x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>"<?php echo $userprofiles->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" data-value-separator="<?php echo $userprofiles->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fuserprofilesgrid.createAutoSuggest({"id":"x<?php echo $userprofiles_grid->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $userprofiles->_userId->Lookup->getParamTag("p_x" . $userprofiles_grid->RowIndex . "__userId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="o<?php echo $userprofiles_grid->RowIndex ?>__userId" id="o<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($userprofiles->_userId->getSessionValue() <> "") { ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$userprofiles->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles__userId" class="form-group userprofiles__userId">
<?php
$wrkonchange = "" . trim(@$userprofiles->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$userprofiles->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $userprofiles_grid->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $userprofiles_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="sv_x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>"<?php echo $userprofiles->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" data-value-separator="<?php echo $userprofiles->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fuserprofilesgrid.createAutoSuggest({"id":"x<?php echo $userprofiles_grid->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $userprofiles->_userId->Lookup->getParamTag("p_x" . $userprofiles_grid->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles__userId" class="userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<?php echo $userprofiles->_userId->getViewValue() ?></span>
</span>
<?php if (!$userprofiles->isConfirm()) { ?>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="o<?php echo $userprofiles_grid->RowIndex ?>__userId" id="o<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>__userId" id="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="userprofiles" data-field="x_profileId" name="x<?php echo $userprofiles_grid->RowIndex ?>_profileId" id="x<?php echo $userprofiles_grid->RowIndex ?>_profileId" value="<?php echo HtmlEncode($userprofiles->profileId->CurrentValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_profileId" name="o<?php echo $userprofiles_grid->RowIndex ?>_profileId" id="o<?php echo $userprofiles_grid->RowIndex ?>_profileId" value="<?php echo HtmlEncode($userprofiles->profileId->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT || $userprofiles->CurrentMode == "edit") { ?>
<input type="hidden" data-table="userprofiles" data-field="x_profileId" name="x<?php echo $userprofiles_grid->RowIndex ?>_profileId" id="x<?php echo $userprofiles_grid->RowIndex ?>_profileId" value="<?php echo HtmlEncode($userprofiles->profileId->CurrentValue) ?>">
<?php } ?>
	<?php if ($userprofiles->firstName->Visible) { // firstName ?>
		<td data-name="firstName"<?php echo $userprofiles->firstName->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_firstName" class="form-group userprofiles_firstName">
<input type="text" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" placeholder="<?php echo HtmlEncode($userprofiles->firstName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->firstName->EditValue ?>"<?php echo $userprofiles->firstName->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="o<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="o<?php echo $userprofiles_grid->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_firstName" class="form-group userprofiles_firstName">
<input type="text" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" placeholder="<?php echo HtmlEncode($userprofiles->firstName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->firstName->EditValue ?>"<?php echo $userprofiles->firstName->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_firstName" class="userprofiles_firstName">
<span<?php echo $userprofiles->firstName->viewAttributes() ?>>
<?php echo $userprofiles->firstName->getViewValue() ?></span>
</span>
<?php if (!$userprofiles->isConfirm()) { ?>
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="o<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="o<?php echo $userprofiles_grid->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->lastName->Visible) { // lastName ?>
		<td data-name="lastName"<?php echo $userprofiles->lastName->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_lastName" class="form-group userprofiles_lastName">
<input type="text" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" placeholder="<?php echo HtmlEncode($userprofiles->lastName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->lastName->EditValue ?>"<?php echo $userprofiles->lastName->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="o<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="o<?php echo $userprofiles_grid->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_lastName" class="form-group userprofiles_lastName">
<input type="text" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" placeholder="<?php echo HtmlEncode($userprofiles->lastName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->lastName->EditValue ?>"<?php echo $userprofiles->lastName->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_lastName" class="userprofiles_lastName">
<span<?php echo $userprofiles->lastName->viewAttributes() ?>>
<?php echo $userprofiles->lastName->getViewValue() ?></span>
</span>
<?php if (!$userprofiles->isConfirm()) { ?>
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="o<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="o<?php echo $userprofiles_grid->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->address->Visible) { // address ?>
		<td data-name="address"<?php echo $userprofiles->address->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_address" class="form-group userprofiles_address">
<textarea data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_grid->RowIndex ?>_address" id="x<?php echo $userprofiles_grid->RowIndex ?>_address" cols="35" rows="4" placeholder="<?php echo HtmlEncode($userprofiles->address->getPlaceHolder()) ?>"<?php echo $userprofiles->address->editAttributes() ?>><?php echo $userprofiles->address->EditValue ?></textarea>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_address" name="o<?php echo $userprofiles_grid->RowIndex ?>_address" id="o<?php echo $userprofiles_grid->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_address" class="form-group userprofiles_address">
<textarea data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_grid->RowIndex ?>_address" id="x<?php echo $userprofiles_grid->RowIndex ?>_address" cols="35" rows="4" placeholder="<?php echo HtmlEncode($userprofiles->address->getPlaceHolder()) ?>"<?php echo $userprofiles->address->editAttributes() ?>><?php echo $userprofiles->address->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_address" class="userprofiles_address">
<span<?php echo $userprofiles->address->viewAttributes() ?>>
<?php echo $userprofiles->address->getViewValue() ?></span>
</span>
<?php if (!$userprofiles->isConfirm()) { ?>
<input type="hidden" data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_grid->RowIndex ?>_address" id="x<?php echo $userprofiles_grid->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_address" name="o<?php echo $userprofiles_grid->RowIndex ?>_address" id="o<?php echo $userprofiles_grid->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="userprofiles" data-field="x_address" name="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_address" id="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_address" name="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_address" id="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->village->Visible) { // village ?>
		<td data-name="village"<?php echo $userprofiles->village->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_village" class="form-group userprofiles_village">
<input type="text" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_grid->RowIndex ?>_village" id="x<?php echo $userprofiles_grid->RowIndex ?>_village" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($userprofiles->village->getPlaceHolder()) ?>" value="<?php echo $userprofiles->village->EditValue ?>"<?php echo $userprofiles->village->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_village" name="o<?php echo $userprofiles_grid->RowIndex ?>_village" id="o<?php echo $userprofiles_grid->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_village" class="form-group userprofiles_village">
<input type="text" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_grid->RowIndex ?>_village" id="x<?php echo $userprofiles_grid->RowIndex ?>_village" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($userprofiles->village->getPlaceHolder()) ?>" value="<?php echo $userprofiles->village->EditValue ?>"<?php echo $userprofiles->village->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_village" class="userprofiles_village">
<span<?php echo $userprofiles->village->viewAttributes() ?>>
<?php echo $userprofiles->village->getViewValue() ?></span>
</span>
<?php if (!$userprofiles->isConfirm()) { ?>
<input type="hidden" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_grid->RowIndex ?>_village" id="x<?php echo $userprofiles_grid->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_village" name="o<?php echo $userprofiles_grid->RowIndex ?>_village" id="o<?php echo $userprofiles_grid->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="userprofiles" data-field="x_village" name="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_village" id="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_village" name="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_village" id="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userprofiles->city->Visible) { // city ?>
		<td data-name="city"<?php echo $userprofiles->city->cellAttributes() ?>>
<?php if ($userprofiles->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_city" class="form-group userprofiles_city">
<input type="text" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_grid->RowIndex ?>_city" id="x<?php echo $userprofiles_grid->RowIndex ?>_city" placeholder="<?php echo HtmlEncode($userprofiles->city->getPlaceHolder()) ?>" value="<?php echo $userprofiles->city->EditValue ?>"<?php echo $userprofiles->city->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_city" name="o<?php echo $userprofiles_grid->RowIndex ?>_city" id="o<?php echo $userprofiles_grid->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->OldValue) ?>">
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_city" class="form-group userprofiles_city">
<input type="text" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_grid->RowIndex ?>_city" id="x<?php echo $userprofiles_grid->RowIndex ?>_city" placeholder="<?php echo HtmlEncode($userprofiles->city->getPlaceHolder()) ?>" value="<?php echo $userprofiles->city->EditValue ?>"<?php echo $userprofiles->city->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userprofiles->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userprofiles_grid->RowCnt ?>_userprofiles_city" class="userprofiles_city">
<span<?php echo $userprofiles->city->viewAttributes() ?>>
<?php echo $userprofiles->city->getViewValue() ?></span>
</span>
<?php if (!$userprofiles->isConfirm()) { ?>
<input type="hidden" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_grid->RowIndex ?>_city" id="x<?php echo $userprofiles_grid->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_city" name="o<?php echo $userprofiles_grid->RowIndex ?>_city" id="o<?php echo $userprofiles_grid->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="userprofiles" data-field="x_city" name="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_city" id="fuserprofilesgrid$x<?php echo $userprofiles_grid->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->FormValue) ?>">
<input type="hidden" data-table="userprofiles" data-field="x_city" name="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_city" id="fuserprofilesgrid$o<?php echo $userprofiles_grid->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$userprofiles_grid->ListOptions->render("body", "right", $userprofiles_grid->RowCnt);
?>
	</tr>
<?php if ($userprofiles->RowType == ROWTYPE_ADD || $userprofiles->RowType == ROWTYPE_EDIT) { ?>
<script>
fuserprofilesgrid.updateLists(<?php echo $userprofiles_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$userprofiles->isGridAdd() || $userprofiles->CurrentMode == "copy")
		if (!$userprofiles_grid->Recordset->EOF)
			$userprofiles_grid->Recordset->moveNext();
}
?>
<?php
	if ($userprofiles->CurrentMode == "add" || $userprofiles->CurrentMode == "copy" || $userprofiles->CurrentMode == "edit") {
		$userprofiles_grid->RowIndex = '$rowindex$';
		$userprofiles_grid->loadRowValues();

		// Set row properties
		$userprofiles->resetAttributes();
		$userprofiles->RowAttrs = array_merge($userprofiles->RowAttrs, array('data-rowindex'=>$userprofiles_grid->RowIndex, 'id'=>'r0_userprofiles', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($userprofiles->RowAttrs["class"], "ew-template");
		$userprofiles->RowType = ROWTYPE_ADD;

		// Render row
		$userprofiles_grid->renderRow();

		// Render list options
		$userprofiles_grid->renderListOptions();
		$userprofiles_grid->StartRowCnt = 0;
?>
	<tr<?php echo $userprofiles->rowAttributes() ?>>
<?php

// Render list options (body, left)
$userprofiles_grid->ListOptions->render("body", "left", $userprofiles_grid->RowIndex);
?>
	<?php if ($userprofiles->_userId->Visible) { // userId ?>
		<td data-name="_userId">
<?php if (!$userprofiles->isConfirm()) { ?>
<?php if ($userprofiles->_userId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$userprofiles->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_userprofiles__userId" class="form-group userprofiles__userId">
<?php
$wrkonchange = "" . trim(@$userprofiles->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$userprofiles->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $userprofiles_grid->RowIndex ?>__userId" class="text-nowrap" style="z-index: <?php echo (9000 - $userprofiles_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="sv_x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo RemoveHtml($userprofiles->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($userprofiles->_userId->getPlaceHolder()) ?>"<?php echo $userprofiles->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" data-value-separator="<?php echo $userprofiles->_userId->displayValueSeparatorAttribute() ?>" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fuserprofilesgrid.createAutoSuggest({"id":"x<?php echo $userprofiles_grid->RowIndex ?>__userId","forceSelect":false});
</script>
<?php echo $userprofiles->_userId->Lookup->getParamTag("p_x" . $userprofiles_grid->RowIndex . "__userId") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_userprofiles__userId" class="form-group userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->_userId->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="x<?php echo $userprofiles_grid->RowIndex ?>__userId" id="x<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x__userId" name="o<?php echo $userprofiles_grid->RowIndex ?>__userId" id="o<?php echo $userprofiles_grid->RowIndex ?>__userId" value="<?php echo HtmlEncode($userprofiles->_userId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->firstName->Visible) { // firstName ?>
		<td data-name="firstName">
<?php if (!$userprofiles->isConfirm()) { ?>
<span id="el$rowindex$_userprofiles_firstName" class="form-group userprofiles_firstName">
<input type="text" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" placeholder="<?php echo HtmlEncode($userprofiles->firstName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->firstName->EditValue ?>"<?php echo $userprofiles->firstName->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_userprofiles_firstName" class="form-group userprofiles_firstName">
<span<?php echo $userprofiles->firstName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->firstName->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="x<?php echo $userprofiles_grid->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x_firstName" name="o<?php echo $userprofiles_grid->RowIndex ?>_firstName" id="o<?php echo $userprofiles_grid->RowIndex ?>_firstName" value="<?php echo HtmlEncode($userprofiles->firstName->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->lastName->Visible) { // lastName ?>
		<td data-name="lastName">
<?php if (!$userprofiles->isConfirm()) { ?>
<span id="el$rowindex$_userprofiles_lastName" class="form-group userprofiles_lastName">
<input type="text" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" placeholder="<?php echo HtmlEncode($userprofiles->lastName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->lastName->EditValue ?>"<?php echo $userprofiles->lastName->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_userprofiles_lastName" class="form-group userprofiles_lastName">
<span<?php echo $userprofiles->lastName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->lastName->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="x<?php echo $userprofiles_grid->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x_lastName" name="o<?php echo $userprofiles_grid->RowIndex ?>_lastName" id="o<?php echo $userprofiles_grid->RowIndex ?>_lastName" value="<?php echo HtmlEncode($userprofiles->lastName->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->address->Visible) { // address ?>
		<td data-name="address">
<?php if (!$userprofiles->isConfirm()) { ?>
<span id="el$rowindex$_userprofiles_address" class="form-group userprofiles_address">
<textarea data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_grid->RowIndex ?>_address" id="x<?php echo $userprofiles_grid->RowIndex ?>_address" cols="35" rows="4" placeholder="<?php echo HtmlEncode($userprofiles->address->getPlaceHolder()) ?>"<?php echo $userprofiles->address->editAttributes() ?>><?php echo $userprofiles->address->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_userprofiles_address" class="form-group userprofiles_address">
<span<?php echo $userprofiles->address->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->address->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_address" name="x<?php echo $userprofiles_grid->RowIndex ?>_address" id="x<?php echo $userprofiles_grid->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x_address" name="o<?php echo $userprofiles_grid->RowIndex ?>_address" id="o<?php echo $userprofiles_grid->RowIndex ?>_address" value="<?php echo HtmlEncode($userprofiles->address->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->village->Visible) { // village ?>
		<td data-name="village">
<?php if (!$userprofiles->isConfirm()) { ?>
<span id="el$rowindex$_userprofiles_village" class="form-group userprofiles_village">
<input type="text" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_grid->RowIndex ?>_village" id="x<?php echo $userprofiles_grid->RowIndex ?>_village" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($userprofiles->village->getPlaceHolder()) ?>" value="<?php echo $userprofiles->village->EditValue ?>"<?php echo $userprofiles->village->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_userprofiles_village" class="form-group userprofiles_village">
<span<?php echo $userprofiles->village->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->village->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_village" name="x<?php echo $userprofiles_grid->RowIndex ?>_village" id="x<?php echo $userprofiles_grid->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x_village" name="o<?php echo $userprofiles_grid->RowIndex ?>_village" id="o<?php echo $userprofiles_grid->RowIndex ?>_village" value="<?php echo HtmlEncode($userprofiles->village->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userprofiles->city->Visible) { // city ?>
		<td data-name="city">
<?php if (!$userprofiles->isConfirm()) { ?>
<span id="el$rowindex$_userprofiles_city" class="form-group userprofiles_city">
<input type="text" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_grid->RowIndex ?>_city" id="x<?php echo $userprofiles_grid->RowIndex ?>_city" placeholder="<?php echo HtmlEncode($userprofiles->city->getPlaceHolder()) ?>" value="<?php echo $userprofiles->city->EditValue ?>"<?php echo $userprofiles->city->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_userprofiles_city" class="form-group userprofiles_city">
<span<?php echo $userprofiles->city->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->city->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_city" name="x<?php echo $userprofiles_grid->RowIndex ?>_city" id="x<?php echo $userprofiles_grid->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="userprofiles" data-field="x_city" name="o<?php echo $userprofiles_grid->RowIndex ?>_city" id="o<?php echo $userprofiles_grid->RowIndex ?>_city" value="<?php echo HtmlEncode($userprofiles->city->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$userprofiles_grid->ListOptions->render("body", "right", $userprofiles_grid->RowIndex);
?>
<script>
fuserprofilesgrid.updateLists(<?php echo $userprofiles_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($userprofiles->CurrentMode == "add" || $userprofiles->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $userprofiles_grid->FormKeyCountName ?>" id="<?php echo $userprofiles_grid->FormKeyCountName ?>" value="<?php echo $userprofiles_grid->KeyCount ?>">
<?php echo $userprofiles_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($userprofiles->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $userprofiles_grid->FormKeyCountName ?>" id="<?php echo $userprofiles_grid->FormKeyCountName ?>" value="<?php echo $userprofiles_grid->KeyCount ?>">
<?php echo $userprofiles_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($userprofiles->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fuserprofilesgrid">
</div><!-- /.ew-grid-middle-panel -->
<?php

// Close recordset
if ($userprofiles_grid->Recordset)
	$userprofiles_grid->Recordset->Close();
?>
</div>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($userprofiles_grid->TotalRecs == 0 && !$userprofiles->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $userprofiles_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$userprofiles_grid->terminate();
?>
