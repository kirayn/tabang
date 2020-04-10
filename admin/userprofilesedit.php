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
$userprofiles_edit = new userprofiles_edit();

// Run the page
$userprofiles_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userprofiles_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fuserprofilesedit = currentForm = new ew.Form("fuserprofilesedit", "edit");

// Validate form
fuserprofilesedit.validate = function() {
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
		<?php if ($userprofiles_edit->profileId->Required) { ?>
			elm = this.getElements("x" + infix + "_profileId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->profileId->caption(), $userprofiles->profileId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_edit->firstName->Required) { ?>
			elm = this.getElements("x" + infix + "_firstName");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->firstName->caption(), $userprofiles->firstName->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_edit->lastName->Required) { ?>
			elm = this.getElements("x" + infix + "_lastName");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->lastName->caption(), $userprofiles->lastName->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_edit->address->Required) { ?>
			elm = this.getElements("x" + infix + "_address");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->address->caption(), $userprofiles->address->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_edit->village->Required) { ?>
			elm = this.getElements("x" + infix + "_village");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->village->caption(), $userprofiles->village->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_edit->city->Required) { ?>
			elm = this.getElements("x" + infix + "_city");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->city->caption(), $userprofiles->city->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_edit->pincode->Required) { ?>
			elm = this.getElements("x" + infix + "_pincode");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->pincode->caption(), $userprofiles->pincode->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_pincode");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($userprofiles->pincode->errorMessage()) ?>");
		<?php if ($userprofiles_edit->source->Required) { ?>
			elm = this.getElements("x" + infix + "_source");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->source->caption(), $userprofiles->source->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($userprofiles_edit->agent->Required) { ?>
			elm = this.getElements("x" + infix + "_agent");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->agent->caption(), $userprofiles->agent->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_agent");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($userprofiles->agent->errorMessage()) ?>");
		<?php if ($userprofiles_edit->status->Required) { ?>
			elm = this.getElements("x" + infix + "_status");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userprofiles->status->caption(), $userprofiles->status->RequiredErrorMessage)) ?>");
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
fuserprofilesedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fuserprofilesedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserprofilesedit.lists["x_source"] = <?php echo $userprofiles_edit->source->Lookup->toClientList() ?>;
fuserprofilesedit.lists["x_source"].options = <?php echo JsonEncode($userprofiles_edit->source->options(FALSE, TRUE)) ?>;
fuserprofilesedit.lists["x_status"] = <?php echo $userprofiles_edit->status->Lookup->toClientList() ?>;
fuserprofilesedit.lists["x_status"].options = <?php echo JsonEncode($userprofiles_edit->status->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $userprofiles_edit->showPageHeader(); ?>
<?php
$userprofiles_edit->showMessage();
?>
<form name="fuserprofilesedit" id="fuserprofilesedit" class="<?php echo $userprofiles_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($userprofiles_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $userprofiles_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userprofiles">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$userprofiles_edit->IsModal ?>">
<?php if ($userprofiles->getCurrentMasterTable() == "users") { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="users">
<input type="hidden" name="fk_ID" value="<?php echo $userprofiles->_userId->getSessionValue() ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($userprofiles->profileId->Visible) { // profileId ?>
	<div id="r_profileId" class="form-group row">
		<label id="elh_userprofiles_profileId" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->profileId->caption() ?><?php echo ($userprofiles->profileId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->profileId->cellAttributes() ?>>
<span id="el_userprofiles_profileId">
<span<?php echo $userprofiles->profileId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($userprofiles->profileId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="userprofiles" data-field="x_profileId" name="x_profileId" id="x_profileId" value="<?php echo HtmlEncode($userprofiles->profileId->CurrentValue) ?>">
<?php echo $userprofiles->profileId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->firstName->Visible) { // firstName ?>
	<div id="r_firstName" class="form-group row">
		<label id="elh_userprofiles_firstName" for="x_firstName" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->firstName->caption() ?><?php echo ($userprofiles->firstName->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->firstName->cellAttributes() ?>>
<span id="el_userprofiles_firstName">
<input type="text" data-table="userprofiles" data-field="x_firstName" name="x_firstName" id="x_firstName" placeholder="<?php echo HtmlEncode($userprofiles->firstName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->firstName->EditValue ?>"<?php echo $userprofiles->firstName->editAttributes() ?>>
</span>
<?php echo $userprofiles->firstName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->lastName->Visible) { // lastName ?>
	<div id="r_lastName" class="form-group row">
		<label id="elh_userprofiles_lastName" for="x_lastName" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->lastName->caption() ?><?php echo ($userprofiles->lastName->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->lastName->cellAttributes() ?>>
<span id="el_userprofiles_lastName">
<input type="text" data-table="userprofiles" data-field="x_lastName" name="x_lastName" id="x_lastName" placeholder="<?php echo HtmlEncode($userprofiles->lastName->getPlaceHolder()) ?>" value="<?php echo $userprofiles->lastName->EditValue ?>"<?php echo $userprofiles->lastName->editAttributes() ?>>
</span>
<?php echo $userprofiles->lastName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->address->Visible) { // address ?>
	<div id="r_address" class="form-group row">
		<label id="elh_userprofiles_address" for="x_address" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->address->caption() ?><?php echo ($userprofiles->address->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->address->cellAttributes() ?>>
<span id="el_userprofiles_address">
<textarea data-table="userprofiles" data-field="x_address" name="x_address" id="x_address" cols="35" rows="4" placeholder="<?php echo HtmlEncode($userprofiles->address->getPlaceHolder()) ?>"<?php echo $userprofiles->address->editAttributes() ?>><?php echo $userprofiles->address->EditValue ?></textarea>
</span>
<?php echo $userprofiles->address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->village->Visible) { // village ?>
	<div id="r_village" class="form-group row">
		<label id="elh_userprofiles_village" for="x_village" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->village->caption() ?><?php echo ($userprofiles->village->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->village->cellAttributes() ?>>
<span id="el_userprofiles_village">
<input type="text" data-table="userprofiles" data-field="x_village" name="x_village" id="x_village" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($userprofiles->village->getPlaceHolder()) ?>" value="<?php echo $userprofiles->village->EditValue ?>"<?php echo $userprofiles->village->editAttributes() ?>>
</span>
<?php echo $userprofiles->village->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->city->Visible) { // city ?>
	<div id="r_city" class="form-group row">
		<label id="elh_userprofiles_city" for="x_city" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->city->caption() ?><?php echo ($userprofiles->city->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->city->cellAttributes() ?>>
<span id="el_userprofiles_city">
<input type="text" data-table="userprofiles" data-field="x_city" name="x_city" id="x_city" placeholder="<?php echo HtmlEncode($userprofiles->city->getPlaceHolder()) ?>" value="<?php echo $userprofiles->city->EditValue ?>"<?php echo $userprofiles->city->editAttributes() ?>>
</span>
<?php echo $userprofiles->city->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->pincode->Visible) { // pincode ?>
	<div id="r_pincode" class="form-group row">
		<label id="elh_userprofiles_pincode" for="x_pincode" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->pincode->caption() ?><?php echo ($userprofiles->pincode->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->pincode->cellAttributes() ?>>
<span id="el_userprofiles_pincode">
<input type="text" data-table="userprofiles" data-field="x_pincode" name="x_pincode" id="x_pincode" size="30" placeholder="<?php echo HtmlEncode($userprofiles->pincode->getPlaceHolder()) ?>" value="<?php echo $userprofiles->pincode->EditValue ?>"<?php echo $userprofiles->pincode->editAttributes() ?>>
</span>
<?php echo $userprofiles->pincode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->source->Visible) { // source ?>
	<div id="r_source" class="form-group row">
		<label id="elh_userprofiles_source" for="x_source" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->source->caption() ?><?php echo ($userprofiles->source->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->source->cellAttributes() ?>>
<span id="el_userprofiles_source">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="userprofiles" data-field="x_source" data-value-separator="<?php echo $userprofiles->source->displayValueSeparatorAttribute() ?>" id="x_source" name="x_source"<?php echo $userprofiles->source->editAttributes() ?>>
		<?php echo $userprofiles->source->selectOptionListHtml("x_source") ?>
	</select>
</div>
</span>
<?php echo $userprofiles->source->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->agent->Visible) { // agent ?>
	<div id="r_agent" class="form-group row">
		<label id="elh_userprofiles_agent" for="x_agent" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->agent->caption() ?><?php echo ($userprofiles->agent->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->agent->cellAttributes() ?>>
<span id="el_userprofiles_agent">
<input type="text" data-table="userprofiles" data-field="x_agent" name="x_agent" id="x_agent" size="30" placeholder="<?php echo HtmlEncode($userprofiles->agent->getPlaceHolder()) ?>" value="<?php echo $userprofiles->agent->EditValue ?>"<?php echo $userprofiles->agent->editAttributes() ?>>
</span>
<?php echo $userprofiles->agent->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userprofiles->status->Visible) { // status ?>
	<div id="r_status" class="form-group row">
		<label id="elh_userprofiles_status" for="x_status" class="<?php echo $userprofiles_edit->LeftColumnClass ?>"><?php echo $userprofiles->status->caption() ?><?php echo ($userprofiles->status->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userprofiles_edit->RightColumnClass ?>"><div<?php echo $userprofiles->status->cellAttributes() ?>>
<span id="el_userprofiles_status">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="userprofiles" data-field="x_status" data-value-separator="<?php echo $userprofiles->status->displayValueSeparatorAttribute() ?>" id="x_status" name="x_status"<?php echo $userprofiles->status->editAttributes() ?>>
		<?php echo $userprofiles->status->selectOptionListHtml("x_status") ?>
	</select>
</div>
</span>
<?php echo $userprofiles->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$userprofiles_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $userprofiles_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userprofiles_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$userprofiles_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$userprofiles_edit->terminate();
?>
