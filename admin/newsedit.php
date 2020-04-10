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
$news_edit = new news_edit();

// Run the page
$news_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$news_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fnewsedit = currentForm = new ew.Form("fnewsedit", "edit");

// Validate form
fnewsedit.validate = function() {
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
		<?php if ($news_edit->newsId->Required) { ?>
			elm = this.getElements("x" + infix + "_newsId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->newsId->caption(), $news->newsId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_edit->type->Required) { ?>
			elm = this.getElements("x" + infix + "_type");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->type->caption(), $news->type->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_edit->title->Required) { ?>
			elm = this.getElements("x" + infix + "_title");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->title->caption(), $news->title->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_edit->description->Required) { ?>
			elm = this.getElements("x" + infix + "_description");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->description->caption(), $news->description->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_edit->fimage->Required) { ?>
			felm = this.getElements("x" + infix + "_fimage");
			elm = this.getElements("fn_x" + infix + "_fimage");
			if (felm && elm && !ew.hasValue(elm))
				return this.onError(felm, "<?php echo JsEncode(str_replace("%s", $news->fimage->caption(), $news->fimage->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_edit->link->Required) { ?>
			elm = this.getElements("x" + infix + "_link");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->link->caption(), $news->link->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($news_edit->date->Required) { ?>
			elm = this.getElements("x" + infix + "_date");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $news->date->caption(), $news->date->RequiredErrorMessage)) ?>");
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
fnewsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fnewsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fnewsedit.lists["x_type"] = <?php echo $news_edit->type->Lookup->toClientList() ?>;
fnewsedit.lists["x_type"].options = <?php echo JsonEncode($news_edit->type->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $news_edit->showPageHeader(); ?>
<?php
$news_edit->showMessage();
?>
<form name="fnewsedit" id="fnewsedit" class="<?php echo $news_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($news_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $news_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="news">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$news_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($news->newsId->Visible) { // newsId ?>
	<div id="r_newsId" class="form-group row">
		<label id="elh_news_newsId" class="<?php echo $news_edit->LeftColumnClass ?>"><?php echo $news->newsId->caption() ?><?php echo ($news->newsId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $news_edit->RightColumnClass ?>"><div<?php echo $news->newsId->cellAttributes() ?>>
<span id="el_news_newsId">
<span<?php echo $news->newsId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($news->newsId->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="news" data-field="x_newsId" name="x_newsId" id="x_newsId" value="<?php echo HtmlEncode($news->newsId->CurrentValue) ?>">
<?php echo $news->newsId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($news->type->Visible) { // type ?>
	<div id="r_type" class="form-group row">
		<label id="elh_news_type" for="x_type" class="<?php echo $news_edit->LeftColumnClass ?>"><?php echo $news->type->caption() ?><?php echo ($news->type->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $news_edit->RightColumnClass ?>"><div<?php echo $news->type->cellAttributes() ?>>
<span id="el_news_type">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="news" data-field="x_type" data-value-separator="<?php echo $news->type->displayValueSeparatorAttribute() ?>" id="x_type" name="x_type"<?php echo $news->type->editAttributes() ?>>
		<?php echo $news->type->selectOptionListHtml("x_type") ?>
	</select>
</div>
</span>
<?php echo $news->type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($news->title->Visible) { // title ?>
	<div id="r_title" class="form-group row">
		<label id="elh_news_title" for="x_title" class="<?php echo $news_edit->LeftColumnClass ?>"><?php echo $news->title->caption() ?><?php echo ($news->title->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $news_edit->RightColumnClass ?>"><div<?php echo $news->title->cellAttributes() ?>>
<span id="el_news_title">
<input type="text" data-table="news" data-field="x_title" name="x_title" id="x_title" placeholder="<?php echo HtmlEncode($news->title->getPlaceHolder()) ?>" value="<?php echo $news->title->EditValue ?>"<?php echo $news->title->editAttributes() ?>>
</span>
<?php echo $news->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($news->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_news_description" class="<?php echo $news_edit->LeftColumnClass ?>"><?php echo $news->description->caption() ?><?php echo ($news->description->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $news_edit->RightColumnClass ?>"><div<?php echo $news->description->cellAttributes() ?>>
<span id="el_news_description">
<?php AppendClass($news->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="news" data-field="x_description" name="x_description" id="x_description" cols="50" rows="6" placeholder="<?php echo HtmlEncode($news->description->getPlaceHolder()) ?>"<?php echo $news->description->editAttributes() ?>><?php echo $news->description->EditValue ?></textarea>
</span>
<?php echo $news->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($news->fimage->Visible) { // fimage ?>
	<div id="r_fimage" class="form-group row">
		<label id="elh_news_fimage" class="<?php echo $news_edit->LeftColumnClass ?>"><?php echo $news->fimage->caption() ?><?php echo ($news->fimage->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $news_edit->RightColumnClass ?>"><div<?php echo $news->fimage->cellAttributes() ?>>
<span id="el_news_fimage">
<div id="fd_x_fimage">
<span title="<?php echo $news->fimage->title() ? $news->fimage->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($news->fimage->ReadOnly || $news->fimage->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="news" data-field="x_fimage" name="x_fimage" id="x_fimage"<?php echo $news->fimage->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x_fimage" id= "fn_x_fimage" value="<?php echo $news->fimage->Upload->FileName ?>">
<?php if (Post("fa_x_fimage") == "0") { ?>
<input type="hidden" name="fa_x_fimage" id= "fa_x_fimage" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_fimage" id= "fa_x_fimage" value="1">
<?php } ?>
<input type="hidden" name="fs_x_fimage" id= "fs_x_fimage" value="500">
<input type="hidden" name="fx_x_fimage" id= "fx_x_fimage" value="<?php echo $news->fimage->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_fimage" id= "fm_x_fimage" value="<?php echo $news->fimage->UploadMaxFileSize ?>">
</div>
<table id="ft_x_fimage" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php echo $news->fimage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($news->link->Visible) { // link ?>
	<div id="r_link" class="form-group row">
		<label id="elh_news_link" for="x_link" class="<?php echo $news_edit->LeftColumnClass ?>"><?php echo $news->link->caption() ?><?php echo ($news->link->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $news_edit->RightColumnClass ?>"><div<?php echo $news->link->cellAttributes() ?>>
<span id="el_news_link">
<textarea data-table="news" data-field="x_link" name="x_link" id="x_link" cols="35" rows="4" placeholder="<?php echo HtmlEncode($news->link->getPlaceHolder()) ?>"<?php echo $news->link->editAttributes() ?>><?php echo $news->link->EditValue ?></textarea>
</span>
<?php echo $news->link->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$news_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $news_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $news_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$news_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$news_edit->terminate();
?>
