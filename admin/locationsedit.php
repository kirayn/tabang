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
$locations_edit = new locations_edit();

// Run the page
$locations_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$locations_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var flocationsedit = currentForm = new ew.Form("flocationsedit", "edit");

// Validate form
flocationsedit.validate = function() {
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
		<?php if ($locations_edit->locationId->Required) { ?>
			elm = this.getElements("x" + infix + "_locationId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $locations->locationId->caption(), $locations->locationId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($locations_edit->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $locations->title->caption(), $locations->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($locations_edit->pincode->Required) { ?>
			elm = this.getElements("x" + infix + "_pincode");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $locations->pincode->caption(), $locations->pincode->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_pincode");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($locations->pincode->errorMessage()) ?>");

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
flocationsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flocationsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $locations_edit->showPageHeader(); ?>
<?php
$locations_edit->showMessage();
?>
<form name="flocationsedit" id="flocationsedit" class="<?php echo $locations_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($locations_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $locations_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="locations">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$locations_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($locations->locationId->Visible) { // locationId ?>
	<div id="r_locationId" class="form-group row">
		<label id="elh_locations_locationId" class="<?php echo $locations_edit->LeftColumnClass ?>"><?php echo $locations->locationId->caption() ?><?php echo ($locations->locationId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $locations_edit->RightColumnClass ?>"><div<?php echo $locations->locationId->cellAttributes() ?>>
<span id="el_locations_locationId">
<span<?php echo $locations->locationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($locations->locationId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="locations" data-field="x_locationId" name="x_locationId" id="x_locationId" value="<?php echo HtmlEncode($locations->locationId->CurrentValue) ?>">
<?php echo $locations->locationId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($locations->title->Visible) { // title ?>
	<div id="r_title" class="form-group row">
		<label id="elh_locations_title" for="x_title" class="<?php echo $locations_edit->LeftColumnClass ?>"><?php echo $locations->title->caption() ?><?php echo ($locations->title->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $locations_edit->RightColumnClass ?>"><div<?php echo $locations->title->cellAttributes() ?>>
<span id="el_locations_title">
<input type="text" data-table="locations" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($locations->title->getPlaceHolder()) ?>" value="<?php echo $locations->title->EditValue ?>"<?php echo $locations->title->editAttributes() ?>>
</span>
<?php echo $locations->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($locations->pincode->Visible) { // pincode ?>
	<div id="r_pincode" class="form-group row">
		<label id="elh_locations_pincode" for="x_pincode" class="<?php echo $locations_edit->LeftColumnClass ?>"><?php echo $locations->pincode->caption() ?><?php echo ($locations->pincode->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $locations_edit->RightColumnClass ?>"><div<?php echo $locations->pincode->cellAttributes() ?>>
<span id="el_locations_pincode">
<input type="text" data-table="locations" data-field="x_pincode" name="x_pincode" id="x_pincode" size="30" placeholder="<?php echo HtmlEncode($locations->pincode->getPlaceHolder()) ?>" value="<?php echo $locations->pincode->EditValue ?>"<?php echo $locations->pincode->editAttributes() ?>>
</span>
<?php echo $locations->pincode->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("adverts", explode(",", $locations->getCurrentDetailTable())) && $adverts->DetailEdit) {
?>
<?php if ($locations->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("adverts", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "advertsgrid.php" ?>
<?php } ?>
<?php if (!$locations_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $locations_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $locations_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$locations_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$locations_edit->terminate();
?>
