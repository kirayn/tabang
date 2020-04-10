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
$media_add = new media_add();

// Run the page
$media_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$media_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fmediaadd = currentForm = new ew.Form("fmediaadd", "add");

// Validate form
fmediaadd.validate = function() {
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
		<?php if ($media_add->advId->Required) { ?>
			elm = this.getElements("x" + infix + "_advId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $media->advId->caption(), $media->advId->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_advId");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($media->advId->errorMessage()) ?>");
		<?php if ($media_add->filename->Required) { ?>
			felm = this.getElements("x" + infix + "_filename");
			elm = this.getElements("fn_x" + infix + "_filename");
			if (felm && elm && !ew.hasValue(elm))
				return this.onError(felm, "<?php echo JsEncode(str_replace("%s", $media->filename->caption(), $media->filename->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($media_add->_thumbnail->Required) { ?>
			felm = this.getElements("x" + infix + "__thumbnail");
			elm = this.getElements("fn_x" + infix + "__thumbnail");
			if (felm && elm && !ew.hasValue(elm))
				return this.onError(felm, "<?php echo JsEncode(str_replace("%s", $media->_thumbnail->caption(), $media->_thumbnail->RequiredErrorMessage)) ?>");
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
fmediaadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fmediaadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmediaadd.lists["x_advId"] = <?php echo $media_add->advId->Lookup->toClientList() ?>;
fmediaadd.lists["x_advId"].options = <?php echo JsonEncode($media_add->advId->lookupOptions()) ?>;
fmediaadd.autoSuggests["x_advId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $media_add->showPageHeader(); ?>
<?php
$media_add->showMessage();
?>
<form name="fmediaadd" id="fmediaadd" class="<?php echo $media_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($media_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $media_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="media">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$media_add->IsModal ?>">
<?php if ($media->getCurrentMasterTable() == "adverts") { ?>
<input type="hidden" name="<?php echo TABLE_SHOW_MASTER ?>" value="adverts">
<input type="hidden" name="fk_advId" value="<?php echo $media->advId->getSessionValue() ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($media->advId->Visible) { // advId ?>
	<div id="r_advId" class="form-group row">
		<label id="elh_media_advId" class="<?php echo $media_add->LeftColumnClass ?>"><?php echo $media->advId->caption() ?><?php echo ($media->advId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $media_add->RightColumnClass ?>"><div<?php echo $media->advId->cellAttributes() ?>>
<?php if ($media->advId->getSessionValue() <> "") { ?>
<span id="el_media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($media->advId->ViewValue) ?>"></span>
</span>
<input type="hidden" id="x_advId" name="x_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>">
<?php } else { ?>
<span id="el_media_advId">
<?php
$wrkonchange = "" . trim(@$media->advId->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$media->advId->EditAttrs["onchange"] = "";
?>
<span id="as_x_advId" class="text-nowrap" style="z-index: 8980">
	<input type="text" class="form-control" name="sv_x_advId" id="sv_x_advId" value="<?php echo RemoveHtml($media->advId->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($media->advId->getPlaceHolder()) ?>"<?php echo $media->advId->editAttributes() ?>>
</span>
<input type="hidden" data-table="media" data-field="x_advId" data-value-separator="<?php echo $media->advId->displayValueSeparatorAttribute() ?>" name="x_advId" id="x_advId" value="<?php echo HtmlEncode($media->advId->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
fmediaadd.createAutoSuggest({"id":"x_advId","forceSelect":true});
</script>
<?php echo $media->advId->Lookup->getParamTag("p_x_advId") ?>
</span>
<?php } ?>
<?php echo $media->advId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($media->filename->Visible) { // filename ?>
	<div id="r_filename" class="form-group row">
		<label id="elh_media_filename" class="<?php echo $media_add->LeftColumnClass ?>"><?php echo $media->filename->caption() ?><?php echo ($media->filename->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $media_add->RightColumnClass ?>"><div<?php echo $media->filename->cellAttributes() ?>>
<span id="el_media_filename">
<div id="fd_x_filename">
<span title="<?php echo $media->filename->title() ? $media->filename->title() : $Language->phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->filename->ReadOnly || $media->filename->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x_filename" name="x_filename" id="x_filename" multiple="multiple"<?php echo $media->filename->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x_filename" id= "fn_x_filename" value="<?php echo $media->filename->Upload->FileName ?>">
<input type="hidden" name="fa_x_filename" id= "fa_x_filename" value="0">
<input type="hidden" name="fs_x_filename" id= "fs_x_filename" value="255">
<input type="hidden" name="fx_x_filename" id= "fx_x_filename" value="<?php echo $media->filename->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_filename" id= "fm_x_filename" value="<?php echo $media->filename->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_filename" id= "fc_x_filename" value="<?php echo $media->filename->UploadMaxFileCount ?>">
</div>
<table id="ft_x_filename" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php echo $media->filename->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
	<div id="r__thumbnail" class="form-group row">
		<label id="elh_media__thumbnail" class="<?php echo $media_add->LeftColumnClass ?>"><?php echo $media->_thumbnail->caption() ?><?php echo ($media->_thumbnail->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $media_add->RightColumnClass ?>"><div<?php echo $media->_thumbnail->cellAttributes() ?>>
<span id="el_media__thumbnail">
<div id="fd_x__thumbnail">
<span title="<?php echo $media->_thumbnail->title() ? $media->_thumbnail->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($media->_thumbnail->ReadOnly || $media->_thumbnail->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="media" data-field="x__thumbnail" name="x__thumbnail" id="x__thumbnail"<?php echo $media->_thumbnail->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x__thumbnail" id= "fn_x__thumbnail" value="<?php echo $media->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x__thumbnail" id= "fa_x__thumbnail" value="0">
<input type="hidden" name="fs_x__thumbnail" id= "fs_x__thumbnail" value="255">
<input type="hidden" name="fx_x__thumbnail" id= "fx_x__thumbnail" value="<?php echo $media->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x__thumbnail" id= "fm_x__thumbnail" value="<?php echo $media->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x__thumbnail" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php echo $media->_thumbnail->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$media_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $media_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $media_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$media_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$media_add->terminate();
?>
