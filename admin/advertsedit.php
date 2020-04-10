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
$adverts_edit = new adverts_edit();

// Run the page
$adverts_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$adverts_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fadvertsedit = currentForm = new ew.Form("fadvertsedit", "edit");

// Validate form
fadvertsedit.validate = function() {
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
		<?php if ($adverts_edit->advId->Required) { ?>
			elm = this.getElements("x" + infix + "_advId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->advId->caption(), $adverts->advId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_edit->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->_userId->caption(), $adverts->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($adverts->_userId->errorMessage()) ?>");
		<?php if ($adverts_edit->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->title->caption(), $adverts->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_edit->description->Required) { ?>
			elm = this.getElements("x" + infix + "_description");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->description->caption(), $adverts->description->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_edit->categoryId->Required) { ?>
			elm = this.getElements("x" + infix + "_categoryId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->categoryId->caption(), $adverts->categoryId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_edit->locationId->Required) { ?>
			elm = this.getElements("x" + infix + "_locationId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->locationId->caption(), $adverts->locationId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_edit->validity->Required) { ?>
			elm = this.getElements("x" + infix + "_validity");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->validity->caption(), $adverts->validity->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_validity");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($adverts->validity->errorMessage()) ?>");
		<?php if ($adverts_edit->contactPerson->Required) { ?>
			elm = this.getElements("x" + infix + "_contactPerson");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->contactPerson->caption(), $adverts->contactPerson->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_edit->contactNumber->Required) { ?>
			elm = this.getElements("x" + infix + "_contactNumber");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->contactNumber->caption(), $adverts->contactNumber->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($adverts_edit->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->date->caption(), $adverts->date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($adverts->date->errorMessage()) ?>");
		<?php if ($adverts_edit->cost->Required) { ?>
			elm = this.getElements("x" + infix + "_cost");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $adverts->cost->caption(), $adverts->cost->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ew.forms[val])
			if (!ew.forms[val].validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fadvertsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fadvertsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fadvertsedit.lists["x__userId"] = <?php echo $adverts_edit->_userId->Lookup->toClientList() ?>;
fadvertsedit.lists["x__userId"].options = <?php echo JsonEncode($adverts_edit->_userId->lookupOptions()) ?>;
fadvertsedit.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fadvertsedit.lists["x_categoryId"] = <?php echo $adverts_edit->categoryId->Lookup->toClientList() ?>;
fadvertsedit.lists["x_categoryId"].options = <?php echo JsonEncode($adverts_edit->categoryId->lookupOptions()) ?>;
fadvertsedit.lists["x_locationId"] = <?php echo $adverts_edit->locationId->Lookup->toClientList() ?>;
fadvertsedit.lists["x_locationId"].options = <?php echo JsonEncode($adverts_edit->locationId->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $adverts_edit->showPageHeader(); ?>
<?php
$adverts_edit->showMessage();
?>
<form name="fadvertsedit" id="fadvertsedit" class="<?php echo $adverts_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($adverts_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $adverts_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="adverts">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$adverts_edit->IsModal ?>">
<?php if ($adverts->getCurrentMasterTable() == "categories") { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="categories">
<input type="hidden" name="fk_categoryId" value="<?php echo $adverts->categoryId->getSessionValue() ?>">
<?php } ?>
<?php if ($adverts->getCurrentMasterTable() == "locations") { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="locations">
<input type="hidden" name="fk_locationId" value="<?php echo $adverts->locationId->getSessionValue() ?>">
<?php } ?>
<?php if ($adverts->getCurrentMasterTable() == "users") { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="users">
<input type="hidden" name="fk_ID" value="<?php echo $adverts->_userId->getSessionValue() ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($adverts->advId->Visible) { // advId ?>
	<div id="r_advId" class="form-group row">
		<label id="elh_adverts_advId" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->advId->caption() ?><?php echo ($adverts->advId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->advId->cellAttributes() ?>>
<span id="el_adverts_advId">
<span<?php echo $adverts->advId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->advId->EditValue)) && $adverts->advId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->advId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->advId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->advId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x_advId" name="x_advId" id="x_advId" value="<?php echo HtmlEncode($adverts->advId->CurrentValue) ?>">
<?php echo $adverts->advId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->_userId->Visible) { // userId ?>
	<div id="r__userId" class="form-group row">
		<label id="elh_adverts__userId" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->_userId->caption() ?><?php echo ($adverts->_userId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->_userId->cellAttributes() ?>>
<?php if ($adverts->_userId->getSessionValue() <> "") { ?>
<span id="el_adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->ViewValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->ViewValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" id="x__userId" name="x__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$adverts->userIDAllow("edit")) { // Non system admin ?>
<span id="el_adverts__userId">
<span<?php echo $adverts->_userId->viewAttributes() ?>>
<?php if ((!EmptyString($adverts->_userId->EditValue)) && $adverts->_userId->linkAttributes() <> "") { ?>
<a<?php echo $adverts->_userId->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" name="x__userId" id="x__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>">
<?php } else { ?>
<span id="el_adverts__userId">
<?php
$wrkonchange = "" . trim(@$adverts->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$adverts->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x__userId" class="text-nowrap" style="z-index: 8980">
	<input type="text" class="form-control" name="sv_x__userId" id="sv_x__userId" value="<?php echo RemoveHtml($adverts->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($adverts->_userId->getPlaceHolder()) ?>"<?php echo $adverts->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="adverts" data-field="x__userId" data-value-separator="<?php echo $adverts->_userId->displayValueSeparatorAttribute() ?>" name="x__userId" id="x__userId" value="<?php echo HtmlEncode($adverts->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fadvertsedit.createAutoSuggest({"id":"x__userId","forceSelect":false});
</script>
<?php echo $adverts->_userId->Lookup->getParamTag("p_x__userId") ?>
</span>
<?php } ?>
<?php echo $adverts->_userId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->title->Visible) { // title ?>
	<div id="r_title" class="form-group row">
		<label id="elh_adverts_title" for="x_title" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->title->caption() ?><?php echo ($adverts->title->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->title->cellAttributes() ?>>
<span id="el_adverts_title">
<input type="text" data-table="adverts" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($adverts->title->getPlaceHolder()) ?>" value="<?php echo $adverts->title->EditValue ?>"<?php echo $adverts->title->editAttributes() ?>>
</span>
<?php echo $adverts->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_adverts_description" for="x_description" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->description->caption() ?><?php echo ($adverts->description->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->description->cellAttributes() ?>>
<span id="el_adverts_description">
<textarea data-table="adverts" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($adverts->description->getPlaceHolder()) ?>"<?php echo $adverts->description->editAttributes() ?>><?php echo $adverts->description->EditValue ?></textarea>
</span>
<?php echo $adverts->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->categoryId->Visible) { // categoryId ?>
	<div id="r_categoryId" class="form-group row">
		<label id="elh_adverts_categoryId" for="x_categoryId" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->categoryId->caption() ?><?php echo ($adverts->categoryId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->categoryId->cellAttributes() ?>>
<?php if ($adverts->categoryId->getSessionValue() <> "") { ?>
<span id="el_adverts_categoryId">
<span<?php echo $adverts->categoryId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->categoryId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x_categoryId" name="x_categoryId" value="<?php echo HtmlEncode($adverts->categoryId->CurrentValue) ?>">
<?php } else { ?>
<span id="el_adverts_categoryId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="adverts" data-field="x_categoryId" data-value-separator="<?php echo $adverts->categoryId->displayValueSeparatorAttribute() ?>" id="x_categoryId" name="x_categoryId"<?php echo $adverts->categoryId->editAttributes() ?>>
		<?php echo $adverts->categoryId->selectOptionListHtml("x_categoryId") ?>
	</select>
</div>
<?php echo $adverts->categoryId->Lookup->getParamTag("p_x_categoryId") ?>
</span>
<?php } ?>
<?php echo $adverts->categoryId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->locationId->Visible) { // locationId ?>
	<div id="r_locationId" class="form-group row">
		<label id="elh_adverts_locationId" for="x_locationId" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->locationId->caption() ?><?php echo ($adverts->locationId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->locationId->cellAttributes() ?>>
<?php if ($adverts->locationId->getSessionValue() <> "") { ?>
<span id="el_adverts_locationId">
<span<?php echo $adverts->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($adverts->locationId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x_locationId" name="x_locationId" value="<?php echo HtmlEncode($adverts->locationId->CurrentValue) ?>">
<?php } else { ?>
<span id="el_adverts_locationId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_locationId"><?php echo strval($adverts->locationId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $adverts->locationId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($adverts->locationId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($adverts->locationId->ReadOnly || $adverts->locationId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x_locationId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $adverts->locationId->Lookup->getParamTag("p_x_locationId") ?>
<input type="hidden" data-table="adverts" data-field="x_locationId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $adverts->locationId->displayValueSeparatorAttribute() ?>" name="x_locationId" id="x_locationId" value="<?php echo $adverts->locationId->CurrentValue ?>"<?php echo $adverts->locationId->editAttributes() ?>>
</span>
<?php } ?>
<?php echo $adverts->locationId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->validity->Visible) { // validity ?>
	<div id="r_validity" class="form-group row">
		<label id="elh_adverts_validity" for="x_validity" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->validity->caption() ?><?php echo ($adverts->validity->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->validity->cellAttributes() ?>>
<span id="el_adverts_validity">
<input type="text" data-table="adverts" data-field="x_validity" name="x_validity" id="x_validity" size="30" placeholder="<?php echo HtmlEncode($adverts->validity->getPlaceHolder()) ?>" value="<?php echo $adverts->validity->EditValue ?>"<?php echo $adverts->validity->editAttributes() ?>>
</span>
<?php echo $adverts->validity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->contactPerson->Visible) { // contactPerson ?>
	<div id="r_contactPerson" class="form-group row">
		<label id="elh_adverts_contactPerson" for="x_contactPerson" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->contactPerson->caption() ?><?php echo ($adverts->contactPerson->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->contactPerson->cellAttributes() ?>>
<span id="el_adverts_contactPerson">
<input type="text" data-table="adverts" data-field="x_contactPerson" name="x_contactPerson" id="x_contactPerson" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($adverts->contactPerson->getPlaceHolder()) ?>" value="<?php echo $adverts->contactPerson->EditValue ?>"<?php echo $adverts->contactPerson->editAttributes() ?>>
</span>
<?php echo $adverts->contactPerson->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->contactNumber->Visible) { // contactNumber ?>
	<div id="r_contactNumber" class="form-group row">
		<label id="elh_adverts_contactNumber" for="x_contactNumber" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->contactNumber->caption() ?><?php echo ($adverts->contactNumber->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->contactNumber->cellAttributes() ?>>
<span id="el_adverts_contactNumber">
<input type="text" data-table="adverts" data-field="x_contactNumber" name="x_contactNumber" id="x_contactNumber" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($adverts->contactNumber->getPlaceHolder()) ?>" value="<?php echo $adverts->contactNumber->EditValue ?>"<?php echo $adverts->contactNumber->editAttributes() ?>>
</span>
<?php echo $adverts->contactNumber->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->date->Visible) { // date ?>
	<div id="r_date" class="form-group row">
		<label id="elh_adverts_date" for="x_date" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->date->caption() ?><?php echo ($adverts->date->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->date->cellAttributes() ?>>
<span id="el_adverts_date">
<input type="text" data-table="adverts" data-field="x_date" name="x_date" id="x_date" placeholder="<?php echo HtmlEncode($adverts->date->getPlaceHolder()) ?>" value="<?php echo $adverts->date->EditValue ?>"<?php echo $adverts->date->editAttributes() ?>>
</span>
<?php echo $adverts->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($adverts->cost->Visible) { // cost ?>
	<div id="r_cost" class="form-group row">
		<label id="elh_adverts_cost" for="x_cost" class="<?php echo $adverts_edit->LeftColumnClass ?>"><?php echo $adverts->cost->caption() ?><?php echo ($adverts->cost->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $adverts_edit->RightColumnClass ?>"><div<?php echo $adverts->cost->cellAttributes() ?>>
<span id="el_adverts_cost">
<input type="text" data-table="adverts" data-field="x_cost" name="x_cost" id="x_cost" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($adverts->cost->getPlaceHolder()) ?>" value="<?php echo $adverts->cost->EditValue ?>"<?php echo $adverts->cost->editAttributes() ?>>
</span>
<?php echo $adverts->cost->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("media", explode(",", $adverts->getCurrentDetailTable())) && $media->DetailEdit) {
?>
<?php if ($adverts->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("media", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "mediagrid.php" ?>
<?php } ?>
<?php if (!$adverts_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $adverts_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $adverts_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$adverts_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$adverts_edit->terminate();
?>
