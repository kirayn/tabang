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
$categories_add = new categories_add();

// Run the page
$categories_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$categories_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fcategoriesadd = currentForm = new ew.Form("fcategoriesadd", "add");

// Validate form
fcategoriesadd.validate = function() {
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
		<?php if ($categories_add->name->Required) { ?>
			elm = this.getElements("x" + infix + "_name");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $categories->name->caption(), $categories->name->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($categories_add->description->Required) { ?>
			elm = this.getElements("x" + infix + "_description");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $categories->description->caption(), $categories->description->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($categories_add->parentId->Required) { ?>
			elm = this.getElements("x" + infix + "_parentId");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $categories->parentId->caption(), $categories->parentId->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($categories_add->image->Required) { ?>
			felm = this.getElements("x" + infix + "_image");
			elm = this.getElements("fn_x" + infix + "_image");
			if (felm && elm && !ew.hasValue(elm))
				return this.onError(felm, "<?php echo JsEncode(str_replace("%s", $categories->image->caption(), $categories->image->RequiredErrorMessage)) ?>");
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
fcategoriesadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcategoriesadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcategoriesadd.lists["x_parentId"] = <?php echo $categories_add->parentId->Lookup->toClientList() ?>;
fcategoriesadd.lists["x_parentId"].options = <?php echo JsonEncode($categories_add->parentId->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $categories_add->showPageHeader(); ?>
<?php
$categories_add->showMessage();
?>
<form name="fcategoriesadd" id="fcategoriesadd" class="<?php echo $categories_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($categories_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $categories_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="categories">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$categories_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($categories->name->Visible) { // name ?>
	<div id="r_name" class="form-group row">
		<label id="elh_categories_name" for="x_name" class="<?php echo $categories_add->LeftColumnClass ?>"><?php echo $categories->name->caption() ?><?php echo ($categories->name->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $categories_add->RightColumnClass ?>"><div<?php echo $categories->name->cellAttributes() ?>>
<span id="el_categories_name">
<input type="text" data-table="categories" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($categories->name->getPlaceHolder()) ?>" value="<?php echo $categories->name->EditValue ?>"<?php echo $categories->name->editAttributes() ?>>
</span>
<?php echo $categories->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($categories->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_categories_description" for="x_description" class="<?php echo $categories_add->LeftColumnClass ?>"><?php echo $categories->description->caption() ?><?php echo ($categories->description->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $categories_add->RightColumnClass ?>"><div<?php echo $categories->description->cellAttributes() ?>>
<span id="el_categories_description">
<textarea data-table="categories" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($categories->description->getPlaceHolder()) ?>"<?php echo $categories->description->editAttributes() ?>><?php echo $categories->description->EditValue ?></textarea>
</span>
<?php echo $categories->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($categories->parentId->Visible) { // parentId ?>
	<div id="r_parentId" class="form-group row">
		<label id="elh_categories_parentId" for="x_parentId" class="<?php echo $categories_add->LeftColumnClass ?>"><?php echo $categories->parentId->caption() ?><?php echo ($categories->parentId->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $categories_add->RightColumnClass ?>"><div<?php echo $categories->parentId->cellAttributes() ?>>
<span id="el_categories_parentId">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_parentId"><?php echo strval($categories->parentId->ViewValue) == "" ? $Language->phrase("PleaseSelect") : $categories->parentId->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($categories->parentId->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($categories->parentId->ReadOnly || $categories->parentId->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x_parentId',m:0,n:10});"><i class="fa fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $categories->parentId->Lookup->getParamTag("p_x_parentId") ?>
<input type="hidden" data-table="categories" data-field="x_parentId" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $categories->parentId->displayValueSeparatorAttribute() ?>" name="x_parentId" id="x_parentId" value="<?php echo $categories->parentId->CurrentValue ?>"<?php echo $categories->parentId->editAttributes() ?>>
</span>
<?php echo $categories->parentId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($categories->image->Visible) { // image ?>
	<div id="r_image" class="form-group row">
		<label id="elh_categories_image" class="<?php echo $categories_add->LeftColumnClass ?>"><?php echo $categories->image->caption() ?><?php echo ($categories->image->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $categories_add->RightColumnClass ?>"><div<?php echo $categories->image->cellAttributes() ?>>
<span id="el_categories_image">
<div id="fd_x_image">
<span title="<?php echo $categories->image->title() ? $categories->image->title() : $Language->phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ew-tooltip<?php if ($categories->image->ReadOnly || $categories->image->Disabled) echo " d-none"; ?>">
	<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="categories" data-field="x_image" name="x_image" id="x_image"<?php echo $categories->image->editAttributes() ?>>
</span>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?php echo $categories->image->Upload->FileName ?>">
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="0">
<input type="hidden" name="fs_x_image" id= "fs_x_image" value="300">
<input type="hidden" name="fx_x_image" id= "fx_x_image" value="<?php echo $categories->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image" id= "fm_x_image" value="<?php echo $categories->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_image" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php echo $categories->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("adverts", explode(",", $categories->getCurrentDetailTable())) && $adverts->DetailAdd) {
?>
<?php if ($categories->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("adverts", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "advertsgrid.php" ?>
<?php } ?>
<?php if (!$categories_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $categories_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $categories_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$categories_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$categories_add->terminate();
?>
