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
$comments_edit = new comments_edit();

// Run the page
$comments_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comments_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fcommentsedit = currentForm = new ew.Form("fcommentsedit", "edit");

// Validate form
fcommentsedit.validate = function() {
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
		<?php if ($comments_edit->commentId->Required) { ?>
			elm = this.getElements("x" + infix + "_commentId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->commentId->caption(), $comments->commentId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($comments_edit->queryId->Required) { ?>
			elm = this.getElements("x" + infix + "_queryId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->queryId->caption(), $comments->queryId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_queryId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($comments->queryId->errorMessage()) ?>");
		<?php if ($comments_edit->_userId->Required) { ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->_userId->caption(), $comments->_userId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "__userId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($comments->_userId->errorMessage()) ?>");
		<?php if ($comments_edit->details->Required) { ?>
			elm = this.getElements("x" + infix + "_details");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->details->caption(), $comments->details->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($comments_edit->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->date->caption(), $comments->date->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.checkDateDef(elm.value))
				return this.onError(elm, "<?php echo JsEncode($comments->date->errorMessage()) ?>");
		<?php if ($comments_edit->image->Required) { ?>
			elm = this.getElements("x" + infix + "_image");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $comments->image->caption(), $comments->image->RequiredErrorMessage)) ?>");
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
fcommentsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcommentsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcommentsedit.lists["x_queryId"] = <?php echo $comments_edit->queryId->Lookup->toClientList() ?>;
fcommentsedit.lists["x_queryId"].options = <?php echo JsonEncode($comments_edit->queryId->lookupOptions()) ?>;
fcommentsedit.autoSuggests["x_queryId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fcommentsedit.lists["x__userId"] = <?php echo $comments_edit->_userId->Lookup->toClientList() ?>;
fcommentsedit.lists["x__userId"].options = <?php echo JsonEncode($comments_edit->_userId->lookupOptions()) ?>;
fcommentsedit.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $comments_edit->showPageHeader(); ?>
<?php
$comments_edit->showMessage();
?>
<form name="fcommentsedit" id="fcommentsedit" class="<?php echo $comments_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($comments_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $comments_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="comments">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$comments_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($comments->commentId->Visible) { // commentId ?>
	<div id="r_commentId" class="form-group row">
		<label id="elh_comments_commentId" class="<?php echo $comments_edit->LeftColumnClass ?>"><?php echo $comments->commentId->caption() ?><?php echo ($comments->commentId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $comments_edit->RightColumnClass ?>"><div<?php echo $comments->commentId->cellAttributes() ?>>
<span id="el_comments_commentId">
<span<?php echo $comments->commentId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($comments->commentId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="comments" data-field="x_commentId" name="x_commentId" id="x_commentId" value="<?php echo HtmlEncode($comments->commentId->CurrentValue) ?>">
<?php echo $comments->commentId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($comments->queryId->Visible) { // queryId ?>
	<div id="r_queryId" class="form-group row">
		<label id="elh_comments_queryId" class="<?php echo $comments_edit->LeftColumnClass ?>"><?php echo $comments->queryId->caption() ?><?php echo ($comments->queryId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $comments_edit->RightColumnClass ?>"><div<?php echo $comments->queryId->cellAttributes() ?>>
<span id="el_comments_queryId">
<?php
$wrkonchange = "" . trim(@$comments->queryId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->queryId->EditAttrs["onchange"] = "";
?>
<span id="as_x_queryId" class="text-nowrap" style="z-index: 8980">
	<input type="text" class="form-control" name="sv_x_queryId" id="sv_x_queryId" value="<?php echo RemoveHtml($comments->queryId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->queryId->getPlaceHolder()) ?>"<?php echo $comments->queryId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x_queryId" data-value-separator="<?php echo $comments->queryId->displayValueSeparatorAttribute() ?>" name="x_queryId" id="x_queryId" value="<?php echo HtmlEncode($comments->queryId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentsedit.createAutoSuggest({"id":"x_queryId","forceSelect":false});
</script>
<?php echo $comments->queryId->Lookup->getParamTag("p_x_queryId") ?>
</span>
<?php echo $comments->queryId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($comments->_userId->Visible) { // userId ?>
	<div id="r__userId" class="form-group row">
		<label id="elh_comments__userId" class="<?php echo $comments_edit->LeftColumnClass ?>"><?php echo $comments->_userId->caption() ?><?php echo ($comments->_userId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $comments_edit->RightColumnClass ?>"><div<?php echo $comments->_userId->cellAttributes() ?>>
<span id="el_comments__userId">
<?php
$wrkonchange = "" . trim(@$comments->_userId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$comments->_userId->EditAttrs["onchange"] = "";
?>
<span id="as_x__userId" class="text-nowrap" style="z-index: 8970">
	<input type="text" class="form-control" name="sv_x__userId" id="sv_x__userId" value="<?php echo RemoveHtml($comments->_userId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($comments->_userId->getPlaceHolder()) ?>"<?php echo $comments->_userId->editAttributes() ?>>
</span>
<input type="hidden" data-table="comments" data-field="x__userId" data-value-separator="<?php echo $comments->_userId->displayValueSeparatorAttribute() ?>" name="x__userId" id="x__userId" value="<?php echo HtmlEncode($comments->_userId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fcommentsedit.createAutoSuggest({"id":"x__userId","forceSelect":false});
</script>
<?php echo $comments->_userId->Lookup->getParamTag("p_x__userId") ?>
</span>
<?php echo $comments->_userId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($comments->details->Visible) { // details ?>
	<div id="r_details" class="form-group row">
		<label id="elh_comments_details" for="x_details" class="<?php echo $comments_edit->LeftColumnClass ?>"><?php echo $comments->details->caption() ?><?php echo ($comments->details->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $comments_edit->RightColumnClass ?>"><div<?php echo $comments->details->cellAttributes() ?>>
<span id="el_comments_details">
<textarea data-table="comments" data-field="x_details" name="x_details" id="x_details" cols="35" rows="4" placeholder="<?php echo HtmlEncode($comments->details->getPlaceHolder()) ?>"<?php echo $comments->details->editAttributes() ?>><?php echo $comments->details->EditValue ?></textarea>
</span>
<?php echo $comments->details->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($comments->date->Visible) { // date ?>
	<div id="r_date" class="form-group row">
		<label id="elh_comments_date" for="x_date" class="<?php echo $comments_edit->LeftColumnClass ?>"><?php echo $comments->date->caption() ?><?php echo ($comments->date->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $comments_edit->RightColumnClass ?>"><div<?php echo $comments->date->cellAttributes() ?>>
<span id="el_comments_date">
<input type="text" data-table="comments" data-field="x_date" name="x_date" id="x_date" placeholder="<?php echo HtmlEncode($comments->date->getPlaceHolder()) ?>" value="<?php echo $comments->date->EditValue ?>"<?php echo $comments->date->editAttributes() ?>>
</span>
<?php echo $comments->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($comments->image->Visible) { // image ?>
	<div id="r_image" class="form-group row">
		<label id="elh_comments_image" for="x_image" class="<?php echo $comments_edit->LeftColumnClass ?>"><?php echo $comments->image->caption() ?><?php echo ($comments->image->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $comments_edit->RightColumnClass ?>"><div<?php echo $comments->image->cellAttributes() ?>>
<span id="el_comments_image">
<input type="text" data-table="comments" data-field="x_image" name="x_image" id="x_image" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($comments->image->getPlaceHolder()) ?>" value="<?php echo $comments->image->EditValue ?>"<?php echo $comments->image->editAttributes() ?>>
</span>
<?php echo $comments->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$comments_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $comments_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $comments_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$comments_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$comments_edit->terminate();
?>
