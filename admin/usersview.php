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
$users_view = new users_view();

// Run the page
$users_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$users->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fusersview = currentForm = new ew.Form("fusersview", "view");

// Form_CustomValidate event
fusersview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusersview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersview.lists["x_role"] = <?php echo $users_view->role->Lookup->toClientList() ?>;
fusersview.lists["x_role"].options = <?php echo JsonEncode($users_view->role->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$users->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $users_view->ExportOptions->render("body") ?>
<?php $users_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $users_view->showPageHeader(); ?>
<?php
$users_view->showMessage();
?>
<?php if (!$users_view->IsModal) { ?>
<?php if (!$users->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($users_view->Pager)) $users_view->Pager = new PrevNextPager($users_view->StartRec, $users_view->DisplayRecs, $users_view->TotalRecs, $users_view->AutoHidePager) ?>
<?php if ($users_view->Pager->RecordCount > 0 && $users_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($users_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $users_view->pageUrl() ?>start=<?php echo $users_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($users_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $users_view->pageUrl() ?>start=<?php echo $users_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $users_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($users_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $users_view->pageUrl() ?>start=<?php echo $users_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($users_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $users_view->pageUrl() ?>start=<?php echo $users_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fusersview" id="fusersview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($users_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $users_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="modal" value="<?php echo (int)$users_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($users->ID->Visible) { // ID ?>
	<tr id="r_ID">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_ID"><?php echo $users->ID->caption() ?></span></td>
		<td data-name="ID"<?php echo $users->ID->cellAttributes() ?>>
<span id="el_users_ID">
<span<?php echo $users->ID->viewAttributes() ?>>
<?php echo $users->ID->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->mobile->Visible) { // mobile ?>
	<tr id="r_mobile">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_mobile"><?php echo $users->mobile->caption() ?></span></td>
		<td data-name="mobile"<?php echo $users->mobile->cellAttributes() ?>>
<span id="el_users_mobile">
<span<?php echo $users->mobile->viewAttributes() ?>>
<?php echo $users->mobile->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
	<tr id="r_name">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_name"><?php echo $users->name->caption() ?></span></td>
		<td data-name="name"<?php echo $users->name->cellAttributes() ?>>
<span id="el_users_name">
<span<?php echo $users->name->viewAttributes() ?>>
<?php echo $users->name->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->emailid->Visible) { // emailid ?>
	<tr id="r_emailid">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_emailid"><?php echo $users->emailid->caption() ?></span></td>
		<td data-name="emailid"<?php echo $users->emailid->cellAttributes() ?>>
<span id="el_users_emailid">
<span<?php echo $users->emailid->viewAttributes() ?>>
<?php echo $users->emailid->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->passcode->Visible) { // passcode ?>
	<tr id="r_passcode">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_passcode"><?php echo $users->passcode->caption() ?></span></td>
		<td data-name="passcode"<?php echo $users->passcode->cellAttributes() ?>>
<span id="el_users_passcode">
<span<?php echo $users->passcode->viewAttributes() ?>>
<?php echo $users->passcode->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
	<tr id="r_role">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_role"><?php echo $users->role->caption() ?></span></td>
		<td data-name="role"<?php echo $users->role->cellAttributes() ?>>
<span id="el_users_role">
<span<?php echo $users->role->viewAttributes() ?>>
<?php echo $users->role->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->status->Visible) { // status ?>
	<tr id="r_status">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_status"><?php echo $users->status->caption() ?></span></td>
		<td data-name="status"<?php echo $users->status->cellAttributes() ?>>
<span id="el_users_status">
<span<?php echo $users->status->viewAttributes() ?>>
<?php echo $users->status->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->activation->Visible) { // activation ?>
	<tr id="r_activation">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_activation"><?php echo $users->activation->caption() ?></span></td>
		<td data-name="activation"<?php echo $users->activation->cellAttributes() ?>>
<span id="el_users_activation">
<span<?php echo $users->activation->viewAttributes() ?>>
<?php echo $users->activation->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->registered->Visible) { // registered ?>
	<tr id="r_registered">
		<td class="<?php echo $users_view->TableLeftColumnClass ?>"><span id="elh_users_registered"><?php echo $users->registered->caption() ?></span></td>
		<td data-name="registered"<?php echo $users->registered->cellAttributes() ?>>
<span id="el_users_registered">
<span<?php echo $users->registered->viewAttributes() ?>>
<?php echo $users->registered->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("userprofiles", explode(",", $users->getCurrentDetailTable())) && $userprofiles->DetailView) {
?>
<?php if ($users->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("userprofiles", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "userprofilesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("adverts", explode(",", $users->getCurrentDetailTable())) && $adverts->DetailView) {
?>
<?php if ($users->getCurrentDetailTable() <> "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->TablePhrase("adverts", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "advertsgrid.php" ?>
<?php } ?>
</form>
<?php
$users_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$users->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$users_view->terminate();
?>
