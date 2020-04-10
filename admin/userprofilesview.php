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
$userprofiles_view = new userprofiles_view();

// Run the page
$userprofiles_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userprofiles_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$userprofiles->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fuserprofilesview = currentForm = new ew.Form("fuserprofilesview", "view");

// Form_CustomValidate event
fuserprofilesview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fuserprofilesview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserprofilesview.lists["x__userId"] = <?php echo $userprofiles_view->_userId->Lookup->toClientList() ?>;
fuserprofilesview.lists["x__userId"].options = <?php echo JsonEncode($userprofiles_view->_userId->lookupOptions()) ?>;
fuserprofilesview.autoSuggests["x__userId"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
fuserprofilesview.lists["x_source"] = <?php echo $userprofiles_view->source->Lookup->toClientList() ?>;
fuserprofilesview.lists["x_source"].options = <?php echo JsonEncode($userprofiles_view->source->options(FALSE, TRUE)) ?>;
fuserprofilesview.lists["x_status"] = <?php echo $userprofiles_view->status->Lookup->toClientList() ?>;
fuserprofilesview.lists["x_status"].options = <?php echo JsonEncode($userprofiles_view->status->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$userprofiles->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $userprofiles_view->ExportOptions->render("body") ?>
<?php $userprofiles_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $userprofiles_view->showPageHeader(); ?>
<?php
$userprofiles_view->showMessage();
?>
<?php if (!$userprofiles_view->IsModal) { ?>
<?php if (!$userprofiles->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($userprofiles_view->Pager)) $userprofiles_view->Pager = new PrevNextPager($userprofiles_view->StartRec, $userprofiles_view->DisplayRecs, $userprofiles_view->TotalRecs, $userprofiles_view->AutoHidePager) ?>
<?php if ($userprofiles_view->Pager->RecordCount > 0 && $userprofiles_view->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($userprofiles_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $userprofiles_view->pageUrl() ?>start=<?php echo $userprofiles_view->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($userprofiles_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $userprofiles_view->pageUrl() ?>start=<?php echo $userprofiles_view->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $userprofiles_view->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($userprofiles_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $userprofiles_view->pageUrl() ?>start=<?php echo $userprofiles_view->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($userprofiles_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $userprofiles_view->pageUrl() ?>start=<?php echo $userprofiles_view->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $userprofiles_view->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fuserprofilesview" id="fuserprofilesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($userprofiles_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $userprofiles_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userprofiles">
<input type="hidden" name="modal" value="<?php echo (int)$userprofiles_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($userprofiles->profileId->Visible) { // profileId ?>
	<tr id="r_profileId">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_profileId"><?php echo $userprofiles->profileId->caption() ?></span></td>
		<td data-name="profileId"<?php echo $userprofiles->profileId->cellAttributes() ?>>
<span id="el_userprofiles_profileId">
<span<?php echo $userprofiles->profileId->viewAttributes() ?>>
<?php echo $userprofiles->profileId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->_userId->Visible) { // userId ?>
	<tr id="r__userId">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles__userId"><?php echo $userprofiles->_userId->caption() ?></span></td>
		<td data-name="_userId"<?php echo $userprofiles->_userId->cellAttributes() ?>>
<span id="el_userprofiles__userId">
<span<?php echo $userprofiles->_userId->viewAttributes() ?>>
<?php echo $userprofiles->_userId->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->firstName->Visible) { // firstName ?>
	<tr id="r_firstName">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_firstName"><?php echo $userprofiles->firstName->caption() ?></span></td>
		<td data-name="firstName"<?php echo $userprofiles->firstName->cellAttributes() ?>>
<span id="el_userprofiles_firstName">
<span<?php echo $userprofiles->firstName->viewAttributes() ?>>
<?php echo $userprofiles->firstName->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->lastName->Visible) { // lastName ?>
	<tr id="r_lastName">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_lastName"><?php echo $userprofiles->lastName->caption() ?></span></td>
		<td data-name="lastName"<?php echo $userprofiles->lastName->cellAttributes() ?>>
<span id="el_userprofiles_lastName">
<span<?php echo $userprofiles->lastName->viewAttributes() ?>>
<?php echo $userprofiles->lastName->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->address->Visible) { // address ?>
	<tr id="r_address">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_address"><?php echo $userprofiles->address->caption() ?></span></td>
		<td data-name="address"<?php echo $userprofiles->address->cellAttributes() ?>>
<span id="el_userprofiles_address">
<span<?php echo $userprofiles->address->viewAttributes() ?>>
<?php echo $userprofiles->address->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->village->Visible) { // village ?>
	<tr id="r_village">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_village"><?php echo $userprofiles->village->caption() ?></span></td>
		<td data-name="village"<?php echo $userprofiles->village->cellAttributes() ?>>
<span id="el_userprofiles_village">
<span<?php echo $userprofiles->village->viewAttributes() ?>>
<?php echo $userprofiles->village->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->city->Visible) { // city ?>
	<tr id="r_city">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_city"><?php echo $userprofiles->city->caption() ?></span></td>
		<td data-name="city"<?php echo $userprofiles->city->cellAttributes() ?>>
<span id="el_userprofiles_city">
<span<?php echo $userprofiles->city->viewAttributes() ?>>
<?php echo $userprofiles->city->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->pincode->Visible) { // pincode ?>
	<tr id="r_pincode">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_pincode"><?php echo $userprofiles->pincode->caption() ?></span></td>
		<td data-name="pincode"<?php echo $userprofiles->pincode->cellAttributes() ?>>
<span id="el_userprofiles_pincode">
<span<?php echo $userprofiles->pincode->viewAttributes() ?>>
<?php echo $userprofiles->pincode->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->source->Visible) { // source ?>
	<tr id="r_source">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_source"><?php echo $userprofiles->source->caption() ?></span></td>
		<td data-name="source"<?php echo $userprofiles->source->cellAttributes() ?>>
<span id="el_userprofiles_source">
<span<?php echo $userprofiles->source->viewAttributes() ?>>
<?php echo $userprofiles->source->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->agent->Visible) { // agent ?>
	<tr id="r_agent">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_agent"><?php echo $userprofiles->agent->caption() ?></span></td>
		<td data-name="agent"<?php echo $userprofiles->agent->cellAttributes() ?>>
<span id="el_userprofiles_agent">
<span<?php echo $userprofiles->agent->viewAttributes() ?>>
<?php echo $userprofiles->agent->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->date->Visible) { // date ?>
	<tr id="r_date">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_date"><?php echo $userprofiles->date->caption() ?></span></td>
		<td data-name="date"<?php echo $userprofiles->date->cellAttributes() ?>>
<span id="el_userprofiles_date">
<span<?php echo $userprofiles->date->viewAttributes() ?>>
<?php echo $userprofiles->date->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userprofiles->status->Visible) { // status ?>
	<tr id="r_status">
		<td class="<?php echo $userprofiles_view->TableLeftColumnClass ?>"><span id="elh_userprofiles_status"><?php echo $userprofiles->status->caption() ?></span></td>
		<td data-name="status"<?php echo $userprofiles->status->cellAttributes() ?>>
<span id="el_userprofiles_status">
<span<?php echo $userprofiles->status->viewAttributes() ?>>
<?php echo $userprofiles->status->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$userprofiles_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$userprofiles->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$userprofiles_view->terminate();
?>
