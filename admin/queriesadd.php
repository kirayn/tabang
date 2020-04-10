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
$queries_add = new queries_add();

// Run the page
$queries_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$queries_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fqueriesadd = currentForm = new ew.Form("fqueriesadd", "add");

// Validate form
fqueriesadd.validate = function() {
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
		<?php if ($queries_add->topicId->Required) { ?>
			elm = this.getElements("x" + infix + "_topicId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->topicId->caption(), $queries->topicId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($queries_add->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->_userId->caption(), $queries->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($queries->_userId->errorMessage()) ?>");
		<?php if ($queries_add->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->title->caption(), $queries->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($queries_add->details->Required) { ?>
			elm = this.getElements("x" + infix + "_details");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->details->caption(), $queries->details->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($queries_add->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->date->caption(), $queries->date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($queries->date->errorMessage()) ?>");
		<?php if ($queries_add->status->Required) { ?>
			elm = this.getElements("x" + infix + "_status");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $queries->status->caption(), $queries->status->RequiredErrorMessage)) ?>");
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
fqueriesadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fqueriesadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fqueriesadd.lists["x_topicId"] = <?php echo $queries_add->topicId->Lookup->toClientList() ?>;
fqueriesadd.lists["x_topicId"].options = <?php echo JsonEncode($queries_add->topicId->lookupOptions()) ?>;
fqueriesadd.lists["x__userId"] = <?php echo $queries_add->_userId->Lookup->toClientList() ?>;
fqueriesadd.lists["x__userId"].options = <?php echo JsonEncode($queries_add->_userId->lookupOptions()) ?>;
fqueriesadd.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $queries_add->showPageHeader(); ?>
<?php
$queries_add->showMessage();
?>
<form name="fqueriesadd" id="fqueriesadd" class="<?php echo $queries_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($queries_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $queries_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="queries">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$queries_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($queries->topicId->Visible) { // topicId ?>
	<div id="r_topicId" class="form-group row">
		<label id="elh_queries_topicId" for="x_topicId" class="<?php echo $queries_add->LeftColumnClass ?>"><?php echo $queries->topicId->caption() ?><?php echo ($queries->topicId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $queries_add->RightColumnClass ?>"><div<?php echo $queries->topicId->cellAttributes() ?>>
<span id="el_queries_topicId">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="queries" data-field="x_topicId" data-value-separator="<?php echo $queries->topicId->displayValueSeparatorAttribute() ?>" id="x_topicId" name="x_topicId"<?php echo $queries->topicId->editAttributes() ?>>
		<?php echo $queries->topicId->selectOptionListHtml("x_topicId") ?>
	</select>
</div>
<?php echo $queries->topicId->Lookup->getParamTag("p_x_topicId") ?>
</span>
<?php echo $queries->topicId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($queries->_userId->Visible) { // userId ?>
	<div id="r__userId" class="form-group row">
		<label id="elh_queries__userId" class="<?php echo $queries_add->LeftColumnClass ?>"><?php echo $queries->_userId->caption() ?><?php echo ($queries->_userId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $queries_add->RightColumnClass ?>"><div<?php echo $queries->_userId->cellAttributes() ?>>
<span id="el_queries__userId">
<?php
$wrkonchange = "" . trim(@$queries->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$queries->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x__userId" class="text-nowrap" style="z-index: 8970">
	<input type="text" class="form-control" name="sv_x__userId" id="sv_x__userId" value="<?php echo RemoveHtml($queries->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($queries->_userId->getPlaceHolder()) ?>"<?php echo $queries->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="queries" data-field="x__userId" data-value-separator="<?php echo $queries->_userId->displayValueSeparatorAttribute() ?>" name="x__userId" id="x__userId" value="<?php echo HtmlEncode($queries->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fqueriesadd.createAutoSuggest({"id":"x__userId","forceSelect":false});
</script>
<?php echo $queries->_userId->Lookup->getParamTag("p_x__userId") ?>
</span>
<?php echo $queries->_userId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($queries->title->Visible) { // title ?>
	<div id="r_title" class="form-group row">
		<label id="elh_queries_title" for="x_title" class="<?php echo $queries_add->LeftColumnClass ?>"><?php echo $queries->title->caption() ?><?php echo ($queries->title->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $queries_add->RightColumnClass ?>"><div<?php echo $queries->title->cellAttributes() ?>>
<span id="el_queries_title">
<textarea data-table="queries" data-field="x_title" name="x_title" id="x_title" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->title->getPlaceHolder()) ?>"<?php echo $queries->title->editAttributes() ?>><?php echo $queries->title->EditValue ?></textarea>
</span>
<?php echo $queries->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($queries->details->Visible) { // details ?>
	<div id="r_details" class="form-group row">
		<label id="elh_queries_details" for="x_details" class="<?php echo $queries_add->LeftColumnClass ?>"><?php echo $queries->details->caption() ?><?php echo ($queries->details->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $queries_add->RightColumnClass ?>"><div<?php echo $queries->details->cellAttributes() ?>>
<span id="el_queries_details">
<textarea data-table="queries" data-field="x_details" name="x_details" id="x_details" cols="35" rows="4" placeholder="<?php echo HtmlEncode($queries->details->getPlaceHolder()) ?>"<?php echo $queries->details->editAttributes() ?>><?php echo $queries->details->EditValue ?></textarea>
</span>
<?php echo $queries->details->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($queries->date->Visible) { // date ?>
	<div id="r_date" class="form-group row">
		<label id="elh_queries_date" for="x_date" class="<?php echo $queries_add->LeftColumnClass ?>"><?php echo $queries->date->caption() ?><?php echo ($queries->date->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $queries_add->RightColumnClass ?>"><div<?php echo $queries->date->cellAttributes() ?>>
<span id="el_queries_date">
<input type="text" data-table="queries" data-field="x_date" name="x_date" id="x_date" placeholder="<?php echo HtmlEncode($queries->date->getPlaceHolder()) ?>" value="<?php echo $queries->date->EditValue ?>"<?php echo $queries->date->editAttributes() ?>>
</span>
<?php echo $queries->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($queries->status->Visible) { // status ?>
	<div id="r_status" class="form-group row">
		<label id="elh_queries_status" for="x_status" class="<?php echo $queries_add->LeftColumnClass ?>"><?php echo $queries->status->caption() ?><?php echo ($queries->status->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $queries_add->RightColumnClass ?>"><div<?php echo $queries->status->cellAttributes() ?>>
<span id="el_queries_status">
<input type="text" data-table="queries" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="10" placeholder="<?php echo HtmlEncode($queries->status->getPlaceHolder()) ?>" value="<?php echo $queries->status->EditValue ?>"<?php echo $queries->status->editAttributes() ?>>
</span>
<?php echo $queries->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$queries_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $queries_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $queries_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$queries_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$queries_add->terminate();
?>
