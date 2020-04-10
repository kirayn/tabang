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
$users_add = new users_add();

// Run the page
$users_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fusersadd = currentForm = new ew.Form("fusersadd", "add");

// Validate form
fusersadd.validate = function() {
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
		<?php if ($users_add->mobile->Required) { ?>
			elm = this.getElements("x" + infix + "_mobile");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->mobile->caption(), $users->mobile->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_mobile");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->mobile->errorMessage()) ?>");
		<?php if ($users_add->name->Required) { ?>
			elm = this.getElements("x" + infix + "_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->name->caption(), $users->name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->emailid->Required) { ?>
			elm = this.getElements("x" + infix + "_emailid");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->emailid->caption(), $users->emailid->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->passcode->Required) { ?>
			elm = this.getElements("x" + infix + "_passcode");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->passcode->caption(), $users->passcode->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_passcode");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->passcode->errorMessage()) ?>");
		<?php if ($users_add->role->Required) { ?>
			elm = this.getElements("x" + infix + "_role");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->role->caption(), $users->role->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($users_add->status->Required) { ?>
			elm = this.getElements("x" + infix + "_status");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->status->caption(), $users->status->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_status");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->status->errorMessage()) ?>");
		<?php if ($users_add->activation->Required) { ?>
			elm = this.getElements("x" + infix + "_activation");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->activation->caption(), $users->activation->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_activation");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->activation->errorMessage()) ?>");

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
fusersadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusersadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersadd.lists["x_role"] = <?php echo $users_add->role->Lookup->toClientList() ?>;
fusersadd.lists["x_role"].options = <?php echo JsonEncode($users_add->role->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $users_add->showPageHeader(); ?>
<?php
$users_add->showMessage();
?>
<form name="fusersadd" id="fusersadd" class="<?php echo $users_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($users_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $users_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$users_add->IsModal ?>">
<!-- Fields to prevent google autofill -->
<input class="d-none" type="text" name="<?php echo Encrypt(Random()) ?>">
<input class="d-none" type="password" name="<?php echo Encrypt(Random()) ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($users->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group row">
		<label id="elh_users_mobile" for="x_mobile" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->mobile->caption() ?><?php echo ($users->mobile->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->mobile->cellAttributes() ?>>
<span id="el_users_mobile">
<input type="text" data-table="users" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" placeholder="<?php echo HtmlEncode($users->mobile->getPlaceHolder()) ?>" value="<?php echo $users->mobile->EditValue ?>"<?php echo $users->mobile->editAttributes() ?>>
</span>
<?php echo $users->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
	<div id="r_name" class="form-group row">
		<label id="elh_users_name" for="x_name" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->name->caption() ?><?php echo ($users->name->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->name->cellAttributes() ?>>
<span id="el_users_name">
<textarea data-table="users" data-field="x_name" name="x_name" id="x_name" cols="35" rows="4" placeholder="<?php echo HtmlEncode($users->name->getPlaceHolder()) ?>"<?php echo $users->name->editAttributes() ?>><?php echo $users->name->EditValue ?></textarea>
</span>
<?php echo $users->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->emailid->Visible) { // emailid ?>
	<div id="r_emailid" class="form-group row">
		<label id="elh_users_emailid" for="x_emailid" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->emailid->caption() ?><?php echo ($users->emailid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->emailid->cellAttributes() ?>>
<span id="el_users_emailid">
<input type="text" data-table="users" data-field="x_emailid" name="x_emailid" id="x_emailid" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($users->emailid->getPlaceHolder()) ?>" value="<?php echo $users->emailid->EditValue ?>"<?php echo $users->emailid->editAttributes() ?>>
</span>
<?php echo $users->emailid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
	<div id="r_passcode" class="form-group row">
		<label id="elh_users_passcode" for="x_passcode" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->passcode->caption() ?><?php echo ($users->passcode->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->passcode->cellAttributes() ?>>
<span id="el_users_passcode">
<input type="text" data-table="users" data-field="x_passcode" name="x_passcode" id="x_passcode" size="30" placeholder="<?php echo HtmlEncode($users->passcode->getPlaceHolder()) ?>" value="<?php echo $users->passcode->EditValue ?>"<?php echo $users->passcode->editAttributes() ?>>
</span>
<?php echo $users->passcode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
	<div id="r_role" class="form-group row">
		<label id="elh_users_role" for="x_role" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->role->caption() ?><?php echo ($users->role->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->role->cellAttributes() ?>>
<span id="el_users_role">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="users" data-field="x_role" data-value-separator="<?php echo $users->role->displayValueSeparatorAttribute() ?>" id="x_role" name="x_role"<?php echo $users->role->editAttributes() ?>>
		<?php echo $users->role->selectOptionListHtml("x_role") ?>
	</select>
</div>
</span>
<?php echo $users->role->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
	<div id="r_status" class="form-group row">
		<label id="elh_users_status" for="x_status" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->status->caption() ?><?php echo ($users->status->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->status->cellAttributes() ?>>
<span id="el_users_status">
<input type="text" data-table="users" data-field="x_status" name="x_status" id="x_status" size="30" placeholder="<?php echo HtmlEncode($users->status->getPlaceHolder()) ?>" value="<?php echo $users->status->EditValue ?>"<?php echo $users->status->editAttributes() ?>>
</span>
<?php echo $users->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->activation->Visible) { // activation ?>
	<div id="r_activation" class="form-group row">
		<label id="elh_users_activation" for="x_activation" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->activation->caption() ?><?php echo ($users->activation->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->activation->cellAttributes() ?>>
<span id="el_users_activation">
<input type="text" data-table="users" data-field="x_activation" name="x_activation" id="x_activation" size="30" placeholder="<?php echo HtmlEncode($users->activation->getPlaceHolder()) ?>" value="<?php echo $users->activation->EditValue ?>"<?php echo $users->activation->editAttributes() ?>>
</span>
<?php echo $users->activation->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("userprofiles", explode(",", $users->getCurrentDetailTable())) && $userprofiles->DetailAdd) {
?>
<?php if ($users->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("userprofiles", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "userprofilesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("adverts", explode(",", $users->getCurrentDetailTable())) && $adverts->DetailAdd) {
?>
<?php if ($users->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("adverts", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "advertsgrid.php" ?>
<?php } ?>
<?php if (!$users_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $users_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $users_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$users_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_add->terminate();
?>
