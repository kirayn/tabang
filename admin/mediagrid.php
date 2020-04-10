<?php
namespace PHPMaker2019\tabelo_admin;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($media_grid))
	$media_grid = new media_grid();

// Run the page
$media_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$media_grid->Page_Render();
?>
<?php if (!$media->isExport()) { ?>
<script>

// Form object
var fmediagrid = new ew.Form("fmediagrid", "grid");
fmediagrid.formKeyCountName = '<?php echo $media_grid->FormKeyCountName ?>';

// Validate form
fmediagrid.validate = function() {
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
		<?php if ($media_grid->mediaId->Required) { ?>
			elm = this.getElements("x" + infix + "_mediaId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $media->mediaId->caption(), $media->mediaId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($media_grid->advId->Required) { ?>
			elm = this.getElements("x" + infix + "_advId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $media->advId->caption(), $media->advId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_advId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($media->advId->errorMessage()) ?>");
		<?php if ($media_grid->filename->Required) { ?>
			felm = this.getElements("x" + infix + "_filename");
			elm = this.getElements("fn_x" + infix + "_filename");
			if (felm && elm && !ew.hasValue(elm))
				return this.onError(felm, "<?php echo JsEncode(str_replace("%s", $media->filename->caption(), $media->filename->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($media_grid->_thumbnail->Required) { ?>
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
	return true;
}

// Check empty row
fmediagrid.emptyRow = function(infix) {
	var fobj = this._form;
	if (ew.valueChanged(fobj, infix, "advId", false)) return false;
	if (ew.valueChanged(fobj, infix, "filename", false)) return false;
	if (ew.valueChanged(fobj, infix, "_thumbnail", false)) return false;
	return true;
}

// Form_CustomValidate event
fmediagrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fmediagrid.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmediagrid.lists["x_advId"] = <?php echo $media_grid->advId->Lookup->toClientList() ?>;
fmediagrid.lists["x_advId"].options = <?php echo JsonEncode($media_grid->advId->lookupOptions()) ?>;
fmediagrid.autoSuggests["x_advId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<?php } ?>
<?php
$media_grid->renderOtherOptions();
?>
<?php $media_grid->showPageHeader(); ?>
<?php
$media_grid->showMessage();
?>
<?php if ($media_grid->TotalRecs > 0 || $media->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($media_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> media">
<?php if ($media_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $media_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fmediagrid" class="ew-form ew-list-form form-inline">
<div id="gmp_media" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table id="tbl_mediagrid" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$media_grid->RowType = ROWTYPE_HEADER;

// Render list options
$media_grid->renderListOptions();

// Render list options (header, left)
$media_grid->ListOptions->render("header", "left");
?>
<?php if ($media->mediaId->Visible) { // mediaId ?>
	<?php if ($media->sortUrl($media->mediaId) == "") { ?>
		<th data-name="mediaId" class="<?php echo $media->mediaId->headerCellClass() ?>"><div id="elh_media_mediaId" class="media_mediaId"><div class="ew-table-header-caption"><?php echo $media->mediaId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mediaId" class="<?php echo $media->mediaId->headerCellClass() ?>"><div><div id="elh_media_mediaId" class="media_mediaId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->mediaId->caption() ?></span><span class="ew-table-header-sort"><?php if ($media->mediaId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->mediaId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($media->advId->Visible) { // advId ?>
	<?php if ($media->sortUrl($media->advId) == "") { ?>
		<th data-name="advId" class="<?php echo $media->advId->headerCellClass() ?>"><div id="elh_media_advId" class="media_advId"><div class="ew-table-header-caption"><?php echo $media->advId->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="advId" class="<?php echo $media->advId->headerCellClass() ?>"><div><div id="elh_media_advId" class="media_advId">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->advId->caption() ?></span><span class="ew-table-header-sort"><?php if ($media->advId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->advId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($media->filename->Visible) { // filename ?>
	<?php if ($media->sortUrl($media->filename) == "") { ?>
		<th data-name="filename" class="<?php echo $media->filename->headerCellClass() ?>"><div id="elh_media_filename" class="media_filename"><div class="ew-table-header-caption"><?php echo $media->filename->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="filename" class="<?php echo $media->filename->headerCellClass() ?>"><div><div id="elh_media_filename" class="media_filename">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->filename->caption() ?></span><span class="ew-table-header-sort"><?php if ($media->filename->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->filename->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
	<?php if ($media->sortUrl($media->_thumbnail) == "") { ?>
		<th data-name="_thumbnail" class="<?php echo $media->_thumbnail->headerCellClass() ?>"><div id="elh_media__thumbnail" class="media__thumbnail"><div class="ew-table-header-caption"><?php echo $media->_thumbnail->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_thumbnail" class="<?php echo $media->_thumbnail->headerCellClass() ?>"><div><div id="elh_media__thumbnail" class="media__thumbnail">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $media->_thumbnail->caption() ?></span><span class="ew-table-header-sort"><?php if ($media->_thumbnail->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($media->_thumbnail->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$media_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$media_grid->StartRec = 1;
$media_grid->StopRec = $media_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($CurrentForm && $media_grid->EventCancelled) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($media_grid->FormKeyCountName) && ($media->isGridAdd() || $media->isGridEdit() || $media->isConfirm())) {
		$media_grid->KeyCount = $CurrentForm->getValue($media_grid->FormKeyCountName);
		$media_grid->StopRec = $media_grid->StartRec + $media_grid->KeyCount - 1;
	}
}
$media_grid->RecCnt = $media_grid->StartRec - 1;
if ($media_grid->Recordset && !$media_grid->Recordset->EOF) {
	$media_grid->Recordset->moveFirst();
	$selectLimit = $media_grid->UseSelectLimit;
	if (!$selectLimit && $media_grid->StartRec > 1)
		$media_grid->Recordset->move($media_grid->StartRec - 1);
} elseif (!$media->AllowAddDeleteRow && $media_grid->StopRec == 0) {
	$media_grid->StopRec = $media->GridAddRowCount;
}

// Initialize aggregate
$media->RowType = ROWTYPE_AGGREGATEINIT;
$media->resetAttributes();
$media_grid->renderRow();
if ($media->isGridAdd())
	$media_grid->RowIndex = 0;
if ($media->isGridEdit())
	$media_grid->RowIndex = 0;
while ($media_grid->RecCnt < $media_grid->StopRec) {
	$media_grid->RecCnt++;
	if ($media_grid->RecCnt >= $media_grid->StartRec) {
		$media_grid->RowCnt++;
		if ($media->isGridAdd() || $media->isGridEdit() || $media->isConfirm()) {
			$media_grid->RowIndex++;
			$CurrentForm->Index = $media_grid->RowIndex;
			if ($CurrentForm->hasValue($media_grid->FormActionName) && $media_grid->EventCancelled)
				$media_grid->RowAction = strval($CurrentForm->getValue($media_grid->FormActionName));
			elseif ($media->isGridAdd())
				$media_grid->RowAction = "insert";
			else
				$media_grid->RowAction = "";
		}

		// Set up key count
		$media_grid->KeyCount = $media_grid->RowIndex;

		// Init row class and style
		$media->resetAttributes();
		$media->CssClass = "";
		if ($media->isGridAdd()) {
			if ($media->CurrentMode == "copy") {
				$media_grid->loadRowValues($media_grid->Recordset); // Load row values
				$media_grid->setRecordKey($media_grid->RowOldKey, $media_grid->Recordset); // Set old record key
			} else {
				$media_grid->loadRowValues(); // Load default values
				$media_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$media_grid->loadRowValues($media_grid->Recordset); // Load row values
		}
		$media->RowType = ROWTYPE_VIEW; // Render view
		if ($media->isGridAdd()) // Grid add
			$media->RowType = ROWTYPE_ADD; // Render add
		if ($media->isGridAdd() && $media->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$media_grid->restoreCurrentRowFormValues($media_grid->RowIndex); // Restore form values
		if ($media->isGridEdit()) { // Grid edit
			if ($media->EventCancelled)
				$media_grid->restoreCurrentRowFormValues($media_grid->RowIndex); // Restore form values
			if ($media_grid->RowAction == "insert")
				$media->RowType = ROWTYPE_ADD; // Render add
			else
				$media->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($media->isGridEdit() && ($media->RowType == ROWTYPE_EDIT || $media->RowType == ROWTYPE_ADD) && $media->EventCancelled) // Update failed
			$media_grid->restoreCurrentRowFormValues($media_grid->RowIndex); // Restore form values
		if ($media->RowType == ROWTYPE_EDIT) // Edit row
			$media_grid->EditRowCnt++;
		if ($media->isConfirm()) // Confirm row
			$media_grid->restoreCurrentRowFormValues($media_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$media->RowAttrs = array_merge($media->RowAttrs, array('data-rowindex'=>$media_grid->RowCnt, 'id'=>'r' . $media_grid->RowCnt . '_media', 'data-rowtype'=>$media->RowType));

		// Render row
		$media_grid->renderRow();

		// Render list options
		$media_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($media_grid->RowAction <> "delete" && $media_grid->RowAction <> "insertdelete" && !($media_grid->RowAction == "insert" && $media->isConfirm() && $media_grid->emptyRow())) {
?>
	<tr<?php echo $media->rowAttributes() ?>>
<?php

// Render list options (body, left)
$media_grid->ListOptions->render("body", "left", $media_grid->RowCnt);
?>
	<?php if ($media->mediaId->Visible) { // mediaId ?>
		<td data-name="mediaId"<?php echo $media->mediaId->cellAttributes() ?>>
<?php if ($media->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="media" data-field="x_mediaId" name="o<?php echo $media_grid->RowIndex ?>_mediaId" id="o<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->OldValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_mediaId" class="form-group media_mediaId">
<span<?php echo $media->mediaId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->mediaId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="media" data-field="x_mediaId" name="x<?php echo $media_grid->RowIndex ?>_mediaId" id="x<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->CurrentValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_mediaId" class="media_mediaId">
<span<?php echo $media->mediaId->viewAttributes() ?>>
<?php echo $media->mediaId->getViewValue() ?></span>
</span>
<?php if (!$media->isConfirm()) { ?>
<input type="hidden" data-table="media" data-field="x_mediaId" name="x<?php echo $media_grid->RowIndex ?>_mediaId" id="x<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->FormValue) ?>">
<input type="hidden" data-table="media" data-field="x_mediaId" name="o<?php echo $media_grid->RowIndex ?>_mediaId" id="o<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="media" data-field="x_mediaId" name="fmediagrid$x<?php echo $media_grid->RowIndex ?>_mediaId" id="fmediagrid$x<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->FormValue) ?>">
<input type="hidden" data-table="media" data-field="x_mediaId" name="fmediagrid$o<?php echo $media_grid->RowIndex ?>_mediaId" id="fmediagrid$o<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($media->advId->Visible) { // advId ?>
		<td data-name="advId"<?php echo $media->advId->cellAttributes() ?>>
<?php if ($media->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($media->advId->getSessionValue() <> "") { ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_advId" class="form-group media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $media_grid->RowIndex ?>_advId" name="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_advId" class="form-group media_advId">
<?php
$wrkonchange = "" . trim(@$media->advId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$media->advId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $media_grid->RowIndex ?>_advId" class="text-nowrap" style="z-index: <?php echo (9000 - $media_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $media_grid->RowIndex ?>_advId" id="sv_x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo RemoveHtml($media->advId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>"<?php echo $media->advId->editAttributes() ?>>
</span>
<input type="hidden" data-table="media" data-field="x_advId" data-value-separator="<?php echo $media->advId->displayValueSeparatorAttribute() ?>" name="x<?php echo $media_grid->RowIndex ?>_advId" id="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fmediagrid.createAutoSuggest({"id":"x<?php echo $media_grid->RowIndex ?>_advId","forceSelect":true});
</script>
<?php echo $media->advId->Lookup->getParamTag("p_x" . $media_grid->RowIndex . "_advId") ?>
</span>
<?php } ?>
<input type="hidden" data-table="media" data-field="x_advId" name="o<?php echo $media_grid->RowIndex ?>_advId" id="o<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->OldValue) ?>">
<?php } ?>
<?php if ($media->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($media->advId->getSessionValue() <> "") { ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_advId" class="form-group media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $media_grid->RowIndex ?>_advId" name="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_advId" class="form-group media_advId">
<?php
$wrkonchange = "" . trim(@$media->advId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$media->advId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $media_grid->RowIndex ?>_advId" class="text-nowrap" style="z-index: <?php echo (9000 - $media_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $media_grid->RowIndex ?>_advId" id="sv_x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo RemoveHtml($media->advId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>"<?php echo $media->advId->editAttributes() ?>>
</span>
<input type="hidden" data-table="media" data-field="x_advId" data-value-separator="<?php echo $media->advId->displayValueSeparatorAttribute() ?>" name="x<?php echo $media_grid->RowIndex ?>_advId" id="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fmediagrid.createAutoSuggest({"id":"x<?php echo $media_grid->RowIndex ?>_advId","forceSelect":true});
</script>
<?php echo $media->advId->Lookup->getParamTag("p_x" . $media_grid->RowIndex . "_advId") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_advId" class="media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<?php echo $media->advId->getViewValue() ?></span>
</span>
<?php if (!$media->isConfirm()) { ?>
<input type="hidden" data-table="media" data-field="x_advId" name="x<?php echo $media_grid->RowIndex ?>_advId" id="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->FormValue) ?>">
<input type="hidden" data-table="media" data-field="x_advId" name="o<?php echo $media_grid->RowIndex ?>_advId" id="o<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="media" data-field="x_advId" name="fmediagrid$x<?php echo $media_grid->RowIndex ?>_advId" id="fmediagrid$x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->FormValue) ?>">
<input type="hidden" data-table="media" data-field="x_advId" name="fmediagrid$o<?php echo $media_grid->RowIndex ?>_advId" id="fmediagrid$o<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($media->filename->Visible) { // filename ?>
		<td data-name="filename"<?php echo $media->filename->cellAttributes() ?>>
<?php if ($media_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_media_filename" class="form-group media_filename">
<div id="fd_x<?php echo $media_grid->RowIndex ?>_filename">
<span title="<?php echo $media->filename->title() ? $media->filename->title() : $Language->phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->filename->ReadOnly || $media->filename->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x_filename" name="x<?php echo $media_grid->RowIndex ?>_filename" id="x<?php echo $media_grid->RowIndex ?>_filename" multiple="multiple"<?php echo $media->filename->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_grid->RowIndex ?>_filename" id= "fn_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>_filename" id= "fa_x<?php echo $media_grid->RowIndex ?>_filename" value="0">
<input type="hidden" name="fs_x<?php echo $media_grid->RowIndex ?>_filename" id= "fs_x<?php echo $media_grid->RowIndex ?>_filename" value="255">
<input type="hidden" name="fx_x<?php echo $media_grid->RowIndex ?>_filename" id= "fx_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_grid->RowIndex ?>_filename" id= "fm_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $media_grid->RowIndex ?>_filename" id= "fc_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $media_grid->RowIndex ?>_filename" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x_filename" name="o<?php echo $media_grid->RowIndex ?>_filename" id="o<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo HtmlEncode($media->filename->OldValue) ?>">
<?php } elseif ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_filename" class="media_filename">
<span>
<?php echo GetFileViewTag($media->filename, $media->filename->getViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media_filename" class="form-group media_filename">
<div id="fd_x<?php echo $media_grid->RowIndex ?>_filename">
<span title="<?php echo $media->filename->title() ? $media->filename->title() : $Language->phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->filename->ReadOnly || $media->filename->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x_filename" name="x<?php echo $media_grid->RowIndex ?>_filename" id="x<?php echo $media_grid->RowIndex ?>_filename" multiple="multiple"<?php echo $media->filename->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_grid->RowIndex ?>_filename" id= "fn_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->Upload->FileName ?>">
<?php if (Post("fa_x<?php echo $media_grid->RowIndex ?>_filename") == "0") { ?>
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>_filename" id= "fa_x<?php echo $media_grid->RowIndex ?>_filename" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>_filename" id= "fa_x<?php echo $media_grid->RowIndex ?>_filename" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $media_grid->RowIndex ?>_filename" id= "fs_x<?php echo $media_grid->RowIndex ?>_filename" value="255">
<input type="hidden" name="fx_x<?php echo $media_grid->RowIndex ?>_filename" id= "fx_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_grid->RowIndex ?>_filename" id= "fm_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $media_grid->RowIndex ?>_filename" id= "fc_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $media_grid->RowIndex ?>_filename" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail"<?php echo $media->_thumbnail->cellAttributes() ?>>
<?php if ($media_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_media__thumbnail" class="form-group media__thumbnail">
<div id="fd_x<?php echo $media_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $media->_thumbnail->title() ? $media->_thumbnail->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->_thumbnail->ReadOnly || $media->_thumbnail->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x__thumbnail" name="x<?php echo $media_grid->RowIndex ?>__thumbnail" id="x<?php echo $media_grid->RowIndex ?>__thumbnail"<?php echo $media->_thumbnail->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="255">
<input type="hidden" name="fx_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $media_grid->RowIndex ?>__thumbnail" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x__thumbnail" name="o<?php echo $media_grid->RowIndex ?>__thumbnail" id="o<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo HtmlEncode($media->_thumbnail->OldValue) ?>">
<?php } elseif ($media->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media__thumbnail" class="media__thumbnail">
<span>
<?php echo GetFileViewTag($media->_thumbnail, $media->_thumbnail->getViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $media_grid->RowCnt ?>_media__thumbnail" class="form-group media__thumbnail">
<div id="fd_x<?php echo $media_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $media->_thumbnail->title() ? $media->_thumbnail->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->_thumbnail->ReadOnly || $media->_thumbnail->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x__thumbnail" name="x<?php echo $media_grid->RowIndex ?>__thumbnail" id="x<?php echo $media_grid->RowIndex ?>__thumbnail"<?php echo $media->_thumbnail->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->Upload->FileName ?>">
<?php if (Post("fa_x<?php echo $media_grid->RowIndex ?>__thumbnail") == "0") { ?>
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="255">
<input type="hidden" name="fx_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $media_grid->RowIndex ?>__thumbnail" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$media_grid->ListOptions->render("body", "right", $media_grid->RowCnt);
?>
	</tr>
<?php if ($media->RowType == ROWTYPE_ADD || $media->RowType == ROWTYPE_EDIT) { ?>
<script>
fmediagrid.updateLists(<?php echo $media_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$media->isGridAdd() || $media->CurrentMode == "copy")
		if (!$media_grid->Recordset->EOF)
			$media_grid->Recordset->moveNext();
}
?>
<?php
	if ($media->CurrentMode == "add" || $media->CurrentMode == "copy" || $media->CurrentMode == "edit") {
		$media_grid->RowIndex = '$rowindex$';
		$media_grid->loadRowValues();

		// Set row properties
		$media->resetAttributes();
		$media->RowAttrs = array_merge($media->RowAttrs, array('data-rowindex'=>$media_grid->RowIndex, 'id'=>'r0_media', 'data-rowtype'=>ROWTYPE_ADD));
		AppendClass($media->RowAttrs["class"], "ew-template");
		$media->RowType = ROWTYPE_ADD;

		// Render row
		$media_grid->renderRow();

		// Render list options
		$media_grid->renderListOptions();
		$media_grid->StartRowCnt = 0;
?>
	<tr<?php echo $media->rowAttributes() ?>>
<?php

// Render list options (body, left)
$media_grid->ListOptions->render("body", "left", $media_grid->RowIndex);
?>
	<?php if ($media->mediaId->Visible) { // mediaId ?>
		<td data-name="mediaId">
<?php if (!$media->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_media_mediaId" class="form-group media_mediaId">
<span<?php echo $media->mediaId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->mediaId->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="media" data-field="x_mediaId" name="x<?php echo $media_grid->RowIndex ?>_mediaId" id="x<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="media" data-field="x_mediaId" name="o<?php echo $media_grid->RowIndex ?>_mediaId" id="o<?php echo $media_grid->RowIndex ?>_mediaId" value="<?php echo HtmlEncode($media->mediaId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($media->advId->Visible) { // advId ?>
		<td data-name="advId">
<?php if (!$media->isConfirm()) { ?>
<?php if ($media->advId->getSessionValue() <> "") { ?>
<span id="el$rowindex$_media_advId" class="form-group media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $media_grid->RowIndex ?>_advId" name="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_media_advId" class="form-group media_advId">
<?php
$wrkonchange = "" . trim(@$media->advId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$media->advId->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $media_grid->RowIndex ?>_advId" class="text-nowrap" style="z-index: <?php echo (9000 - $media_grid->RowCnt * 10) ?>">
	<input type="text" class="form-control" name="sv_x<?php echo $media_grid->RowIndex ?>_advId" id="sv_x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo RemoveHtml($media->advId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>"<?php echo $media->advId->editAttributes() ?>>
</span>
<input type="hidden" data-table="media" data-field="x_advId" data-value-separator="<?php echo $media->advId->displayValueSeparatorAttribute() ?>" name="x<?php echo $media_grid->RowIndex ?>_advId" id="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fmediagrid.createAutoSuggest({"id":"x<?php echo $media_grid->RowIndex ?>_advId","forceSelect":true});
</script>
<?php echo $media->advId->Lookup->getParamTag("p_x" . $media_grid->RowIndex . "_advId") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_media_advId" class="form-group media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="media" data-field="x_advId" name="x<?php echo $media_grid->RowIndex ?>_advId" id="x<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="media" data-field="x_advId" name="o<?php echo $media_grid->RowIndex ?>_advId" id="o<?php echo $media_grid->RowIndex ?>_advId" value="<?php echo HtmlEncode($media->advId->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($media->filename->Visible) { // filename ?>
		<td data-name="filename">
<span id="el$rowindex$_media_filename" class="form-group media_filename">
<div id="fd_x<?php echo $media_grid->RowIndex ?>_filename">
<span title="<?php echo $media->filename->title() ? $media->filename->title() : $Language->phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->filename->ReadOnly || $media->filename->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x_filename" name="x<?php echo $media_grid->RowIndex ?>_filename" id="x<?php echo $media_grid->RowIndex ?>_filename" multiple="multiple"<?php echo $media->filename->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_grid->RowIndex ?>_filename" id= "fn_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>_filename" id= "fa_x<?php echo $media_grid->RowIndex ?>_filename" value="0">
<input type="hidden" name="fs_x<?php echo $media_grid->RowIndex ?>_filename" id= "fs_x<?php echo $media_grid->RowIndex ?>_filename" value="255">
<input type="hidden" name="fx_x<?php echo $media_grid->RowIndex ?>_filename" id= "fx_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_grid->RowIndex ?>_filename" id= "fm_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $media_grid->RowIndex ?>_filename" id= "fc_x<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo $media->filename->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $media_grid->RowIndex ?>_filename" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x_filename" name="o<?php echo $media_grid->RowIndex ?>_filename" id="o<?php echo $media_grid->RowIndex ?>_filename" value="<?php echo HtmlEncode($media->filename->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail">
<span id="el$rowindex$_media__thumbnail" class="form-group media__thumbnail">
<div id="fd_x<?php echo $media_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $media->_thumbnail->title() ? $media->_thumbnail->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->_thumbnail->ReadOnly || $media->_thumbnail->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x__thumbnail" name="x<?php echo $media_grid->RowIndex ?>__thumbnail" id="x<?php echo $media_grid->RowIndex ?>__thumbnail"<?php echo $media->_thumbnail->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="255">
<input type="hidden" name="fx_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $media_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo $media->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $media_grid->RowIndex ?>__thumbnail" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="media" data-field="x__thumbnail" name="o<?php echo $media_grid->RowIndex ?>__thumbnail" id="o<?php echo $media_grid->RowIndex ?>__thumbnail" value="<?php echo HtmlEncode($media->_thumbnail->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$media_grid->ListOptions->render("body", "right", $media_grid->RowIndex);
?>
<script>
fmediagrid.updateLists(<?php echo $media_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($media->CurrentMode == "add" || $media->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $media_grid->FormKeyCountName ?>" id="<?php echo $media_grid->FormKeyCountName ?>" value="<?php echo $media_grid->KeyCount ?>">
<?php echo $media_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($media->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $media_grid->FormKeyCountName ?>" id="<?php echo $media_grid->FormKeyCountName ?>" value="<?php echo $media_grid->KeyCount ?>">
<?php echo $media_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($media->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmediagrid">
</div><!-- /.ew-grid-middle-panel -->
<?php

// Close recordset
if ($media_grid->Recordset)
	$media_grid->Recordset->Close();
?>
</div>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($media_grid->TotalRecs == 0 && !$media->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $media_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$media_grid->terminate();
?>
