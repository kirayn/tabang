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
$topics_edit = new topics_edit();

// Run the page
$topics_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$topics_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var ftopicsedit = currentForm = new ew.Form("ftopicsedit", "edit");

// Validate form
ftopicsedit.validate = function() {
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
		<?php if ($topics_edit->topicId->Required) { ?>
			elm = this.getElements("x" + infix + "_topicId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $topics->topicId->caption(), $topics->topicId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($topics_edit->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $topics->title->caption(), $topics->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($topics_edit->description->Required) { ?>
			elm = this.getElements("x" + infix + "_description");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $topics->description->caption(), $topics->description->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($topics_edit->parentId->Required) { ?>
			elm = this.getElements("x" + infix + "_parentId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $topics->parentId->caption(), $topics->parentId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_parentId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($topics->parentId->errorMessage()) ?>");

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
ftopicsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
ftopicsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $topics_edit->showPageHeader(); ?>
<?php
$topics_edit->showMessage();
?>
<form name="ftopicsedit" id="ftopicsedit" class="<?php echo $topics_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($topics_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $topics_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="topics">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$topics_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($topics->topicId->Visible) { // topicId ?>
	<div id="r_topicId" class="form-group row">
		<label id="elh_topics_topicId" class="<?php echo $topics_edit->LeftColumnClass ?>"><?php echo $topics->topicId->caption() ?><?php echo ($topics->topicId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $topics_edit->RightColumnClass ?>"><div<?php echo $topics->topicId->cellAttributes() ?>>
<span id="el_topics_topicId">
<span<?php echo $topics->topicId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($topics->topicId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="topics" data-field="x_topicId" name="x_topicId" id="x_topicId" value="<?php echo HtmlEncode($topics->topicId->CurrentValue) ?>">
<?php echo $topics->topicId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($topics->title->Visible) { // title ?>
	<div id="r_title" class="form-group row">
		<label id="elh_topics_title" for="x_title" class="<?php echo $topics_edit->LeftColumnClass ?>"><?php echo $topics->title->caption() ?><?php echo ($topics->title->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $topics_edit->RightColumnClass ?>"><div<?php echo $topics->title->cellAttributes() ?>>
<span id="el_topics_title">
<input type="text" data-table="topics" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="200" placeholder="<?php echo HtmlEncode($topics->title->getPlaceHolder()) ?>" value="<?php echo $topics->title->EditValue ?>"<?php echo $topics->title->editAttributes() ?>>
</span>
<?php echo $topics->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($topics->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_topics_description" for="x_description" class="<?php echo $topics_edit->LeftColumnClass ?>"><?php echo $topics->description->caption() ?><?php echo ($topics->description->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $topics_edit->RightColumnClass ?>"><div<?php echo $topics->description->cellAttributes() ?>>
<span id="el_topics_description">
<textarea data-table="topics" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($topics->description->getPlaceHolder()) ?>"<?php echo $topics->description->editAttributes() ?>><?php echo $topics->description->EditValue ?></textarea>
</span>
<?php echo $topics->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($topics->parentId->Visible) { // parentId ?>
	<div id="r_parentId" class="form-group row">
		<label id="elh_topics_parentId" for="x_parentId" class="<?php echo $topics_edit->LeftColumnClass ?>"><?php echo $topics->parentId->caption() ?><?php echo ($topics->parentId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $topics_edit->RightColumnClass ?>"><div<?php echo $topics->parentId->cellAttributes() ?>>
<span id="el_topics_parentId">
<input type="text" data-table="topics" data-field="x_parentId" name="x_parentId" id="x_parentId" size="30" placeholder="<?php echo HtmlEncode($topics->parentId->getPlaceHolder()) ?>" value="<?php echo $topics->parentId->EditValue ?>"<?php echo $topics->parentId->editAttributes() ?>>
</span>
<?php echo $topics->parentId->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$topics_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $topics_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $topics_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$topics_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$topics_edit->terminate();
?>
