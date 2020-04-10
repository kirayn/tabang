<?php
namespace PHPMaker2019\tabelo_admin;

/**
 * Page class
 */
class register extends users
{

	// Page ID
	public $PageID = "register";

	// Project ID
	public $ProjectID = "{69E18FAC-2EFC-47EE-A765-B17249FAF990}";

	// Page object name
	public $PageObjName = "register";

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken = CHECK_TOKEN;

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		return $url;
	}

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = FALSE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message <> "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fa fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fa fa-warning"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage <> "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fa fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fa fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = array();

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message <> "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage <> "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage <> "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage <> "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header <> "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer <> "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(TOKEN_NAME) === NULL)
			return FALSE;
		$fn = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
		if (is_callable($fn))
			return $fn(Post(TOKEN_NAME), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = PROJECT_NAMESPACE . CREATE_TOKEN_FUNC; // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $COMPOSITE_KEY_SEPARATOR;
		global $UserTable, $UserTableConn;

		// Initialize
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == PROJECT_NAMESPACE . "users") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}
		if (!isset($GLOBALS["users"]))
			$GLOBALS["users"] = new users();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'register');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = &$this->getConnection();

		// User table object (users)
		if (!isset($UserTable)) {
			$UserTable = new users();
			$UserTableConn = Conn($UserTable->Dbid);
		}
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url <> "") {
			if (!DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			SaveDebugMessage();
			AddHeader("Location", $url);
		}
		exit();
	}
	public $FormClassName = "ew-horizontal ew-form ew-register-form";

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm,
			$UserTableConn, $CurrentLanguage, $FormError, $Breadcrumb;

		// Init Session data for API request if token found
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Param(TOKEN_NAME) !== NULL && $func(Param(TOKEN_NAME), SessionTimeoutTime()))
				session_start();
		}

		// User profile
		$UserProfile = new UserProfile();

		// Security
		$Security = new AdvancedSecurity();
		$validRequest = FALSE;

		// Check security for API request
		If (IsApi()) {

			// Check token first
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Post(TOKEN_NAME) !== NULL)
				$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
			elseif (is_array($RequestSecurity) && @$RequestSecurity["username"] <> "") // Login user for API request
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
		}
		if (!$validRequest) {
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();
		$this->FormClassName = "ew-form ew-register-form ew-horizontal";

		// Set up Breadcrumb
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb = new Breadcrumb();
		$Breadcrumb->add("register", "RegisterPage", $url, "", "", TRUE);
		$this->Heading = $Language->phrase("RegisterPage");
		$userExists = FALSE;
		$this->loadRowValues(); // Load default values
		if (Post("action") <> "") {

			// Get action
			$this->CurrentAction = Post("action");
			$this->loadFormValues(); // Get form values

			// Validate form
			if (!$this->validateForm()) {
				$this->CurrentAction = "show"; // Form error, reset action
				$this->setFailureMessage($FormError);
			}
		} else {
			$this->CurrentAction = "show"; // Display blank record
		}

		// Insert record
		if ($this->isInsert()) {

			// Check for duplicate User ID
			$filter = str_replace("%u", AdjustSql($this->mobile->CurrentValue, USER_TABLE_DBID), USER_NAME_FILTER);

			// Set up filter (WHERE Clause)
			$this->CurrentFilter = $filter;
			$userSql = $this->getCurrentSql();
			if ($rs = $UserTableConn->execute($userSql)) {
				if (!$rs->EOF) {
					$userExists = TRUE;
					$this->restoreFormValues(); // Restore form values
					$this->setFailureMessage($Language->phrase("UserExists")); // Set user exist message
				}
				$rs->Close();
			}
			if (!$userExists) {
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow()) { // Add record
					$email = $this->prepareRegisterEmail();

					// Get new recordset
					$this->CurrentFilter = $this->getRecordFilter();
					$sql = $this->getCurrentSql();
					$rsnew = $UserTableConn->execute($sql);
					$row = $rsnew->fields;
					$args = array();
					$args["rs"] = $row;
					$emailSent = FALSE;
					if ($this->Email_Sending($email, $args))
						$emailSent = $email->send();

					// Send email failed
					if (!$emailSent)
						$this->setFailureMessage($email->SendErrDescription);
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("RegisterSuccess")); // Register success

					// Auto login user
					if ($Security->validateUser($this->mobile->CurrentValue, $this->passcode->FormValue, TRUE)) {

						// Nothing to do
					} else {
						$this->setFailureMessage($Language->phrase("AutoLoginFailed")); // Set auto login failed message
					}
					$this->terminate("index.php"); // Return
				} else {
					$this->restoreFormValues(); // Restore form values
				}
			}
		}

		// Render row
		if ($this->isConfirm()) { // Confirm page
			$this->RowType = ROWTYPE_VIEW; // Render view
		} else {
			$this->RowType = ROWTYPE_ADD; // Render add
		}
		$this->resetAttributes();
		$this->renderRow();
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->ID->CurrentValue = NULL;
		$this->ID->OldValue = $this->ID->CurrentValue;
		$this->mobile->CurrentValue = NULL;
		$this->mobile->OldValue = $this->mobile->CurrentValue;
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->emailid->CurrentValue = NULL;
		$this->emailid->OldValue = $this->emailid->CurrentValue;
		$this->passcode->CurrentValue = NULL;
		$this->passcode->OldValue = $this->passcode->CurrentValue;
		$this->role->CurrentValue = "subscriber";
		$this->status->CurrentValue = 0;
		$this->activation->CurrentValue = 0;
		$this->registered->CurrentValue = NULL;
		$this->registered->OldValue = $this->registered->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'mobile' first before field var 'x_mobile'
		$val = $CurrentForm->hasValue("mobile") ? $CurrentForm->getValue("mobile") : $CurrentForm->getValue("x_mobile");
		if (!$this->mobile->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->mobile->Visible = FALSE; // Disable update for API request
			else
				$this->mobile->setFormValue($val);
		}

		// Check field name 'emailid' first before field var 'x_emailid'
		$val = $CurrentForm->hasValue("emailid") ? $CurrentForm->getValue("emailid") : $CurrentForm->getValue("x_emailid");
		if (!$this->emailid->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->emailid->Visible = FALSE; // Disable update for API request
			else
				$this->emailid->setFormValue($val);
		}

		// Check field name 'passcode' first before field var 'x_passcode'
		$val = $CurrentForm->hasValue("passcode") ? $CurrentForm->getValue("passcode") : $CurrentForm->getValue("x_passcode");
		if (!$this->passcode->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->passcode->Visible = FALSE; // Disable update for API request
			else
				$this->passcode->setFormValue($val);
		}
		$this->passcode->ConfirmValue = $CurrentForm->getValue("c_passcode");

		// Check field name 'ID' first before field var 'x_ID'
		$val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->mobile->CurrentValue = $this->mobile->FormValue;
		$this->emailid->CurrentValue = $this->emailid->FormValue;
		$this->passcode->CurrentValue = $this->passcode->FormValue;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = &$this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->ID->setDbValue($row['ID']);
		$this->mobile->setDbValue($row['mobile']);
		$this->name->setDbValue($row['name']);
		$this->emailid->setDbValue($row['emailid']);
		$this->passcode->setDbValue($row['passcode']);
		$this->role->setDbValue($row['role']);
		$this->status->setDbValue($row['status']);
		$this->activation->setDbValue($row['activation']);
		$this->registered->setDbValue($row['registered']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['ID'] = $this->ID->CurrentValue;
		$row['mobile'] = $this->mobile->CurrentValue;
		$row['name'] = $this->name->CurrentValue;
		$row['emailid'] = $this->emailid->CurrentValue;
		$row['passcode'] = $this->passcode->CurrentValue;
		$row['role'] = $this->role->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		$row['activation'] = $this->activation->CurrentValue;
		$row['registered'] = $this->registered->CurrentValue;
		return $row;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// ID
		// mobile
		// name
		// emailid
		// passcode
		// role
		// status
		// activation
		// registered

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// ID
			$this->ID->ViewValue = $this->ID->CurrentValue;
			$this->ID->ViewCustomAttributes = "";

			// mobile
			$this->mobile->ViewValue = $this->mobile->CurrentValue;
			$this->mobile->ViewCustomAttributes = "";

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// emailid
			$this->emailid->ViewValue = $this->emailid->CurrentValue;
			$this->emailid->ViewCustomAttributes = "";

			// passcode
			$this->passcode->ViewValue = $this->passcode->CurrentValue;
			$this->passcode->ViewCustomAttributes = "";

			// role
			if (strval($this->role->CurrentValue) <> "") {
				$this->role->ViewValue = $this->role->optionCaption($this->role->CurrentValue);
			} else {
				$this->role->ViewValue = NULL;
			}
			$this->role->ViewCustomAttributes = "";

			// status
			$this->status->ViewValue = $this->status->CurrentValue;
			$this->status->ViewCustomAttributes = "";

			// activation
			$this->activation->ViewValue = $this->activation->CurrentValue;
			$this->activation->ViewCustomAttributes = "";

			// registered
			$this->registered->ViewValue = $this->registered->CurrentValue;
			$this->registered->ViewValue = FormatDateTime($this->registered->ViewValue, 0);
			$this->registered->ViewCustomAttributes = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";
			$this->mobile->TooltipValue = "";

			// emailid
			$this->emailid->LinkCustomAttributes = "";
			$this->emailid->HrefValue = "";
			$this->emailid->TooltipValue = "";

			// passcode
			$this->passcode->LinkCustomAttributes = "";
			$this->passcode->HrefValue = "";
			$this->passcode->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// mobile
			$this->mobile->EditAttrs["class"] = "form-control";
			$this->mobile->EditCustomAttributes = "";
			$this->mobile->EditValue = HtmlEncode($this->mobile->CurrentValue);
			$this->mobile->PlaceHolder = RemoveHtml($this->mobile->caption());

			// emailid
			$this->emailid->EditAttrs["class"] = "form-control";
			$this->emailid->EditCustomAttributes = "";
			$this->emailid->EditValue = HtmlEncode($this->emailid->CurrentValue);
			$this->emailid->PlaceHolder = RemoveHtml($this->emailid->caption());

			// passcode
			$this->passcode->EditAttrs["class"] = "form-control";
			$this->passcode->EditCustomAttributes = "";
			$this->passcode->EditValue = HtmlEncode($this->passcode->CurrentValue);
			$this->passcode->PlaceHolder = RemoveHtml($this->passcode->caption());

			// Add refer script
			// mobile

			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";

			// emailid
			$this->emailid->LinkCustomAttributes = "";
			$this->emailid->HrefValue = "";

			// passcode
			$this->passcode->LinkCustomAttributes = "";
			$this->passcode->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!SERVER_VALIDATE)
			return ($FormError == "");
		if ($this->ID->Required) {
			if (!$this->ID->IsDetailKey && $this->ID->FormValue != NULL && $this->ID->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->ID->caption(), $this->ID->RequiredErrorMessage));
			}
		}
		if ($this->mobile->Required) {
			if (!$this->mobile->IsDetailKey && $this->mobile->FormValue != NULL && $this->mobile->FormValue == "") {
				AddMessage($FormError, $Language->phrase("EnterUserName"));
			}
		}
		if (!CheckInteger($this->mobile->FormValue)) {
			AddMessage($FormError, $this->mobile->errorMessage());
		}
		if ($this->name->Required) {
			if (!$this->name->IsDetailKey && $this->name->FormValue != NULL && $this->name->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
			}
		}
		if ($this->emailid->Required) {
			if (!$this->emailid->IsDetailKey && $this->emailid->FormValue != NULL && $this->emailid->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->emailid->caption(), $this->emailid->RequiredErrorMessage));
			}
		}
		if ($this->passcode->Required) {
			if (!$this->passcode->IsDetailKey && $this->passcode->FormValue != NULL && $this->passcode->FormValue == "") {
				AddMessage($FormError, $Language->phrase("EnterPassword"));
			}
		}
		if ($this->passcode->ConfirmValue <> $this->passcode->FormValue) {
			AddMessage($FormError, $Language->phrase("MismatchPassword"));
		}
		if ($this->role->Required) {
			if (!$this->role->IsDetailKey && $this->role->FormValue != NULL && $this->role->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->role->caption(), $this->role->RequiredErrorMessage));
			}
		}
		if ($this->status->Required) {
			if (!$this->status->IsDetailKey && $this->status->FormValue != NULL && $this->status->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
			}
		}
		if ($this->activation->Required) {
			if (!$this->activation->IsDetailKey && $this->activation->FormValue != NULL && $this->activation->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->activation->caption(), $this->activation->RequiredErrorMessage));
			}
		}
		if ($this->registered->Required) {
			if (!$this->registered->IsDetailKey && $this->registered->FormValue != NULL && $this->registered->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->registered->caption(), $this->registered->RequiredErrorMessage));
			}
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError <> "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check if valid User ID
		$validUser = FALSE;
		if ($Security->currentUserID() <> "" && !EmptyValue($this->ID->CurrentValue) && !$Security->isAdmin()) { // Non system admin
			$validUser = $Security->isValidUserID($this->ID->CurrentValue);
			if (!$validUser) {
				$userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
				$userIdMsg = str_replace("%u", $this->ID->CurrentValue, $userIdMsg);
				$this->setFailureMessage($userIdMsg);
				return FALSE;
			}
		}
		$conn = &$this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// mobile
		$this->mobile->setDbValueDef($rsnew, $this->mobile->CurrentValue, 0, FALSE);

		// emailid
		$this->emailid->setDbValueDef($rsnew, $this->emailid->CurrentValue, NULL, FALSE);

		// passcode
		$this->passcode->setDbValueDef($rsnew, $this->passcode->CurrentValue, NULL, FALSE);

		// ID
		// Call Row Inserting event

		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
		if ($insertRow) {
			$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($addRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("InsertCancelled"));
			}
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);

			// Call User Registered event
			$this->User_Registered($rsnew);
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL
			switch ($fld->FieldVar) {
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql <> "" && count($fld->Lookup->Options) == 0) {
				$conn = &$this->getConnection();
				$totalCnt = $this->getRecordCount($sql);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Email Sending event
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User Registered event
	function User_Registered(&$rs) {

		//echo "User_Registered";
	}

	// User Activated event
	function User_Activated(&$rs) {

		//echo "User_Activated";
	}
}
?>
