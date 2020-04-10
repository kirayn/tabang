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
$media_delete = new media_delete();

// Run the page
$media_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$media_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fmediadelete = currentForm = new ew.Form("fmediadelete", "delete");

// Form_CustomValidate event
fmediadelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fmediadelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmediadelete.lists["x_advId"] = <?php echo $media_delete->advId->Lookup->toClientList() ?>;
fmediadelete.lists["x_advId"].options = <?php echo JsonEncode($media_delete->advId->lookupOptions()) ?>;
fmediadelete.autoSuggests["x_advId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $media_delete->showPageHeader(); ?>
<?php
$media_delete->showMessage();
?>
<form name="fmediadelete" id="fmediadelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($media_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $media_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="media">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($media_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($media->mediaId->Visible) { // mediaId ?>
		<th class="<?php echo $media->mediaId->headerCellClass() ?>"><span id="elh_media_mediaId" class="media_mediaId"><?php echo $media->mediaId->caption() ?></span></th>
<?php } ?>
<?php if ($media->advId->Visible) { // advId ?>
		<th class="<?php echo $media->advId->headerCellClass() ?>"><span id="elh_media_advId" class="media_advId"><?php echo $media->advId->caption() ?></span></th>
<?php } ?>
<?php if ($media->filename->Visible) { // filename ?>
		<th class="<?php echo $media->filename->headerCellClass() ?>"><span id="elh_media_filename" class="media_filename"><?php echo $media->filename->caption() ?></span></th>
<?php } ?>
<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
		<th class="<?php echo $media->_thumbnail->headerCellClass() ?>"><span id="elh_media__thumbnail" class="media__thumbnail"><?php echo $media->_thumbnail->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$media_delete->RecCnt = 0;
$i = 0;
while (!$media_delete->Recordset->EOF) {
	$media_delete->RecCnt++;
	$media_delete->RowCnt++;

	// Set row properties
	$media->resetAttributes();
	$media->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$media_delete->loadRowValues($media_delete->Recordset);

	// Render row
	$media_delete->renderRow();
?>
	<tr<?php echo $media->rowAttributes() ?>>
<?php if ($media->mediaId->Visible) { // mediaId ?>
		<td<?php echo $media->mediaId->cellAttributes() ?>>
<span id="el<?php echo $media_delete->RowCnt ?>_media_mediaId" class="media_mediaId">
<span<?php echo $media->mediaId->viewAttributes() ?>>
<?php echo $media->mediaId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($media->advId->Visible) { // advId ?>
		<td<?php echo $media->advId->cellAttributes() ?>>
<span id="el<?php echo $media_delete->RowCnt ?>_media_advId" class="media_advId">
<span<?php echo $media->advId->viewAttributes() ?>>
<?php echo $media->advId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($media->filename->Visible) { // filename ?>
		<td<?php echo $media->filename->cellAttributes() ?>>
<span id="el<?php echo $media_delete->RowCnt ?>_media_filename" class="media_filename">
<span>
<?php echo GetFileViewTag($media->filename, $media->filename->getViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($media->_thumbnail->Visible) { // thumbnail ?>
		<td<?php echo $media->_thumbnail->cellAttributes() ?>>
<span id="el<?php echo $media_delete->RowCnt ?>_media__thumbnail" class="media__thumbnail">
<span>
<?php echo GetFileViewTag($media->_thumbnail, $media->_thumbnail->getViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$media_delete->Recordset->moveNext();
}
$media_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $media_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$media_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$media_delete->terminate();
?>
