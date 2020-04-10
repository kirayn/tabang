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
$register = new register();

// Run the page
$register->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$register->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "register";
var fregister = currentForm = new ew.Form("fregister", "register");

// Validate form
fregister.validate = function() {
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
		<?php if ($register->mobile->Required) { ?>
			elm = this.getElements("x" + infix + "_mobile");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, ew.language.phrase("EnterUserName"));
		<?php } ?>
			elm = this.getElements("x" + infix + "_mobile");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->mobile->errorMessage()) ?>");
		<?php if ($register->emailid->Required) { ?>
			elm = this.getElements("x" + infix + "_emailid");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $users->emailid->caption(), $users->emailid->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($register->passcode->Required) { ?>
			elm = this.getElements("x" + infix + "_passcode");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, ew.language.phrase("EnterPassword"));
		<?php } ?>
			if (fobj.c_passcode.value != fobj.x_passcode.value)
				return this.onError(fobj.c_passcode, ew.language.phrase("MismatchPassword"));
			elm = this.getElements("x" + infix + "_passcode");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($users->passcode->errorMessage()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fregister.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fregister.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $register->showPageHeader(); ?>
<?php
$register->showMessage();
?>
<form name="fregister" id="fregister" class="<?php echo $register->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($register->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $register->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="insert">
<!-- Fields to prevent google autofill -->
<input type="hidden" type="text" name="<?php echo Encrypt(Random()) ?>">
<input type="hidden" type="password" name="<?php echo Encrypt(Random()) ?>">
<?php if ($users->isConfirm()) { // Confirm page ?>
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } ?>
<div class="ew-register-div"><!-- page* -->
<?php if ($users->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group row">
		<label id="elh_users_mobile" for="x_mobile" class="<?php echo $register->LeftColumnClass ?>"><?php echo $users->mobile->caption() ?><?php echo ($users->mobile->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $users->mobile->cellAttributes() ?>>
<?php if (!$users->isConfirm()) { ?>
<span id="el_users_mobile">
<input type="text" data-table="users" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" placeholder="<?php echo HtmlEncode($users->mobile->getPlaceHolder()) ?>" value="<?php echo $users->mobile->EditValue ?>"<?php echo $users->mobile->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_users_mobile">
<span<?php echo $users->mobile->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($users->mobile->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_mobile" name="x_mobile" id="x_mobile" value="<?php echo HtmlEncode($users->mobile->FormValue) ?>">
<?php } ?>
<?php echo $users->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->emailid->Visible) { // emailid ?>
	<div id="r_emailid" class="form-group row">
		<label id="elh_users_emailid" for="x_emailid" class="<?php echo $register->LeftColumnClass ?>"><?php echo $users->emailid->caption() ?><?php echo ($users->emailid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $users->emailid->cellAttributes() ?>>
<?php if (!$users->isConfirm()) { ?>
<span id="el_users_emailid">
<input type="text" data-table="users" data-field="x_emailid" name="x_emailid" id="x_emailid" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($users->emailid->getPlaceHolder()) ?>" value="<?php echo $users->emailid->EditValue ?>"<?php echo $users->emailid->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_users_emailid">
<span<?php echo $users->emailid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($users->emailid->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_emailid" name="x_emailid" id="x_emailid" value="<?php echo HtmlEncode($users->emailid->FormValue) ?>">
<?php } ?>
<?php echo $users->emailid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
	<div id="r_passcode" class="form-group row">
		<label id="elh_users_passcode" for="x_passcode" class="<?php echo $register->LeftColumnClass ?>"><?php echo $users->passcode->caption() ?><?php echo ($users->passcode->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $users->passcode->cellAttributes() ?>>
<?php if (!$users->isConfirm()) { ?>
<span id="el_users_passcode">
<input type="text" data-table="users" data-field="x_passcode" name="x_passcode" id="x_passcode" size="30" placeholder="<?php echo HtmlEncode($users->passcode->getPlaceHolder()) ?>" value="<?php echo $users->passcode->EditValue ?>"<?php echo $users->passcode->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_users_passcode">
<span<?php echo $users->passcode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($users->passcode->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_passcode" name="x_passcode" id="x_passcode" value="<?php echo HtmlEncode($users->passcode->FormValue) ?>">
<?php } ?>
<?php echo $users->passcode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
	<div id="r_c_passcode" class="form-group row">
		<label id="elh_c_users_passcode" for="c_passcode" class="<?php echo $register->LeftColumnClass ?>"><?php echo $Language->phrase("Confirm") ?> <?php echo $users->passcode->caption() ?><?php echo ($users->passcode->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $users->passcode->cellAttributes() ?>>
<?php if (!$users->isConfirm()) { ?>
<span id="el_c_users_passcode">
<input type="text" data-table="users" data-field="c_passcode" name="c_passcode" id="c_passcode" size="30" placeholder="<?php echo HtmlEncode($users->passcode->getPlaceHolder()) ?>" value="<?php echo $users->passcode->EditValue ?>"<?php echo $users->passcode->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_c_users_passcode">
<span<?php echo $users->passcode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($users->passcode->ViewValue) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="c_passcode" name="c_passcode" id="c_passcode" value="<?php echo HtmlEncode($users->passcode->FormValue) ?>">
<?php } ?>
</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $register->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$users->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?php echo $Language->phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
</form>
<?php
$register->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$register->terminate();
?>
