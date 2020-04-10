<?php
namespace PHPMaker2019\tabelo_admin;

/**
 * Page class
 */
class userprofiles_edit extends userprofiles
{

	// Page ID
	public $PageID = "edit";

	// Project ID
	public $ProjectID = "{69E18FAC-2EFC-47EE-A765-B17249FAF990}";

	// Table name
	public $TableName = 'userprofiles';

	// Page object name
	public $PageObjName = "userprofiles_edit";

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
		if ($this->TableName)
			return $Language->phrase($this->PageID);
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
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
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
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
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

		// Table object (userprofiles)
		if (!isset($GLOBALS["userprofiles"]) || get_class($GLOBALS["userprofiles"]) == PROJECT_NAMESPACE . "userprofiles") {
			$GLOBALS["userprofiles"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["userprofiles"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users']))
			$GLOBALS['users'] = new users();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'edit');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'userprofiles');

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
		global $EXPORT, $userprofiles;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($userprofiles);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "userprofilesview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = array();
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
			}
		}
		return $rows;
	}

	// Get record from array
	protected function getRecordFromArray($ar)
	{
		$row = array();
		if (is_array($ar)) {
			foreach ($ar as $fldname => $val) {
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {

								//$url = FullUrl($fld->TableVar . "/" . API_FILE_ACTION . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))); // URL rewrite format
								$url = FullUrl(GetPageName(API_URL) . "?" . API_OBJECT_NAME . "=" . $fld->TableVar . "&" . API_ACTION_NAME . "=" . API_FILE_ACTION . "&" . API_FIELD_NAME . "=" . $fld->Param . "&" . API_KEY_NAME . "=" . rawurlencode($this->getRecordKeyValue($ar))); // Query string format
								$row[$fldname] = ["mimeType" => ContentType($val), "url" => $url];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, MULTIPLE_UPLOAD_SEPARATOR)) { // Single file
								$row[$fldname] = ["mimeType" => MimeContentType($val), "url" => FullUrl($fld->hrefPath() . $val)];
							} else { // Multiple files
								$files = explode(MULTIPLE_UPLOAD_SEPARATOR, $val);
								$ar = [];
								foreach ($files as $file) {
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => FullUrl($fld->hrefPath() . $file)];
								}
								$row[$fldname] = $ar;
							}
						}
					} else {
						$row[$fldname] = $val;
					}
				}
			}
		}
		return $row;
	}

	// Get record key value from array
	protected function getRecordKeyValue($ar)
	{
		global $COMPOSITE_KEY_SEPARATOR;
		$key = "";
		if (is_array($ar)) {
			$key .= @$ar['profileId'];
		}
		return $key;
	}

	/**
	 * Hide fields for add/edit
	 *
	 * @return void
	 */
	protected function hideFieldsForAddEdit()
	{
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->profileId->Visible = FALSE;
	}
	public $FormClassName = "ew-horizontal ew-form ew-edit-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter;
	public $DbDetailFilter;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm,
			$FormError, $SkipHeaderFooter;

		// Init Session data for API request if token found
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Param(TOKEN_NAME) !== NULL && $func(Param(TOKEN_NAME), SessionTimeoutTime()))
				session_start();
		}

		// Is modal
		$this->IsModal = (Param("modal") == "1");

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
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canEdit()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("userprofileslist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
				if (strval($Security->currentUserID()) == "") {
					$this->setFailureMessage(DeniedMessage()); // Set no permission
					$this->terminate(GetUrl("userprofileslist.php"));
					return;
				}
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->profileId->setVisibility();
		$this->_userId->Visible = FALSE;
		$this->firstName->setVisibility();
		$this->lastName->setVisibility();
		$this->address->setVisibility();
		$this->village->setVisibility();
		$this->city->setVisibility();
		$this->pincode->setVisibility();
		$this->source->setVisibility();
		$this->agent->setVisibility();
		$this->date->Visible = FALSE;
		$this->status->setVisibility();
		$this->hideFieldsForAddEdit();

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

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

		// Set up lookup cache
		$this->setupLookupOptions($this->_userId);

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-edit-form ew-horizontal";
		$returnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (IsApi()) {
			$this->CurrentAction = "update"; // Update record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get action code
			if (!$this->isShow()) // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($CurrentForm->hasValue("x_profileId")) {
				$this->profileId->setFormValue($CurrentForm->getValue("x_profileId"));
			}
		} else {
			$this->CurrentAction = "show"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (Get("profileId") !== NULL) {
				$this->profileId->setQueryStringValue(Get("profileId"));
				$loadByQuery = TRUE;
			} else {
				$this->profileId->CurrentValue = NULL;
			}
		}

		// Set up master detail parameters
		$this->setupMasterParms();

		// Load current record
		$loaded = $this->loadRow();

		// Process form if post back
		if ($postBack) {
			$this->loadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->setFailureMessage($FormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues();
				if (IsApi()) {
					$this->terminate();
					return;
				} else {
					$this->CurrentAction = ""; // Form error, reset action
				}
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "show": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
					$this->terminate("userprofileslist.php"); // No matching record, return to list
				}
				break;
			case "update": // Update
				$returnUrl = $this->getReturnUrl();
				if (GetPageName($returnUrl) == "userprofileslist.php")
					$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->editRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
					if (IsApi()) {
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl); // Return to caller
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
					$this->terminate($returnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render the record
		$this->RowType = ROWTYPE_EDIT; // Render as Edit
		$this->resetAttributes();
		$this->renderRow();
	}

	// Set up starting record parameters
	public function setupStartRec()
	{
		if ($this->DisplayRecs == 0)
			return;
		if ($this->isPageRequest()) { // Validate request
			if (Get(TABLE_START_REC) !== NULL) { // Check for "start" parameter
				$this->StartRec = Get(TABLE_START_REC);
				$this->setStartRecordNumber($this->StartRec);
			} elseif (Get(TABLE_PAGE_NO) !== NULL) {
				$pageNo = Get(TABLE_PAGE_NO);
				if (is_numeric($pageNo)) {
					$this->StartRec = ($pageNo - 1) * $this->DisplayRecs + 1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1) {
						$this->StartRec = (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->StartRec > $this->TotalRecs) { // Avoid starting record > total records
			$this->StartRec = (int)(($this->TotalRecs - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec - 1) % $this->DisplayRecs <> 0) {
			$this->StartRec = (int)(($this->StartRec - 1)/$this->DisplayRecs) * $this->DisplayRecs + 1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'profileId' first before field var 'x_profileId'
		$val = $CurrentForm->hasValue("profileId") ? $CurrentForm->getValue("profileId") : $CurrentForm->getValue("x_profileId");
		if (!$this->profileId->IsDetailKey)
			$this->profileId->setFormValue($val);

		// Check field name 'firstName' first before field var 'x_firstName'
		$val = $CurrentForm->hasValue("firstName") ? $CurrentForm->getValue("firstName") : $CurrentForm->getValue("x_firstName");
		if (!$this->firstName->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->firstName->Visible = FALSE; // Disable update for API request
			else
				$this->firstName->setFormValue($val);
		}

		// Check field name 'lastName' first before field var 'x_lastName'
		$val = $CurrentForm->hasValue("lastName") ? $CurrentForm->getValue("lastName") : $CurrentForm->getValue("x_lastName");
		if (!$this->lastName->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->lastName->Visible = FALSE; // Disable update for API request
			else
				$this->lastName->setFormValue($val);
		}

		// Check field name 'address' first before field var 'x_address'
		$val = $CurrentForm->hasValue("address") ? $CurrentForm->getValue("address") : $CurrentForm->getValue("x_address");
		if (!$this->address->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->address->Visible = FALSE; // Disable update for API request
			else
				$this->address->setFormValue($val);
		}

		// Check field name 'village' first before field var 'x_village'
		$val = $CurrentForm->hasValue("village") ? $CurrentForm->getValue("village") : $CurrentForm->getValue("x_village");
		if (!$this->village->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->village->Visible = FALSE; // Disable update for API request
			else
				$this->village->setFormValue($val);
		}

		// Check field name 'city' first before field var 'x_city'
		$val = $CurrentForm->hasValue("city") ? $CurrentForm->getValue("city") : $CurrentForm->getValue("x_city");
		if (!$this->city->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->city->Visible = FALSE; // Disable update for API request
			else
				$this->city->setFormValue($val);
		}

		// Check field name 'pincode' first before field var 'x_pincode'
		$val = $CurrentForm->hasValue("pincode") ? $CurrentForm->getValue("pincode") : $CurrentForm->getValue("x_pincode");
		if (!$this->pincode->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->pincode->Visible = FALSE; // Disable update for API request
			else
				$this->pincode->setFormValue($val);
		}

		// Check field name 'source' first before field var 'x_source'
		$val = $CurrentForm->hasValue("source") ? $CurrentForm->getValue("source") : $CurrentForm->getValue("x_source");
		if (!$this->source->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->source->Visible = FALSE; // Disable update for API request
			else
				$this->source->setFormValue($val);
		}

		// Check field name 'agent' first before field var 'x_agent'
		$val = $CurrentForm->hasValue("agent") ? $CurrentForm->getValue("agent") : $CurrentForm->getValue("x_agent");
		if (!$this->agent->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->agent->Visible = FALSE; // Disable update for API request
			else
				$this->agent->setFormValue($val);
		}

		// Check field name 'status' first before field var 'x_status'
		$val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
		if (!$this->status->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->status->Visible = FALSE; // Disable update for API request
			else
				$this->status->setFormValue($val);
		}
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->profileId->CurrentValue = $this->profileId->FormValue;
		$this->firstName->CurrentValue = $this->firstName->FormValue;
		$this->lastName->CurrentValue = $this->lastName->FormValue;
		$this->address->CurrentValue = $this->address->FormValue;
		$this->village->CurrentValue = $this->village->FormValue;
		$this->city->CurrentValue = $this->city->FormValue;
		$this->pincode->CurrentValue = $this->pincode->FormValue;
		$this->source->CurrentValue = $this->source->FormValue;
		$this->agent->CurrentValue = $this->agent->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
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

		// Check if valid User ID
		if ($res) {
			$res = $this->showOptionLink('edit');
			if (!$res) {
				$userIdMsg = DeniedMessage();
				$this->setFailureMessage($userIdMsg);
			}
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
		$this->profileId->setDbValue($row['profileId']);
		$this->_userId->setDbValue($row['userId']);
		$this->firstName->setDbValue($row['firstName']);
		$this->lastName->setDbValue($row['lastName']);
		$this->address->setDbValue($row['address']);
		$this->village->setDbValue($row['village']);
		$this->city->setDbValue($row['city']);
		$this->pincode->setDbValue($row['pincode']);
		$this->source->setDbValue($row['source']);
		$this->agent->setDbValue($row['agent']);
		$this->date->setDbValue($row['date']);
		$this->status->setDbValue($row['status']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$row = [];
		$row['profileId'] = NULL;
		$row['userId'] = NULL;
		$row['firstName'] = NULL;
		$row['lastName'] = NULL;
		$row['address'] = NULL;
		$row['village'] = NULL;
		$row['city'] = NULL;
		$row['pincode'] = NULL;
		$row['source'] = NULL;
		$row['agent'] = NULL;
		$row['date'] = NULL;
		$row['status'] = NULL;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("profileId")) <> "")
			$this->profileId->CurrentValue = $this->getKey("profileId"); // profileId
		else
			$validKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = &$this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// profileId
		// userId
		// firstName
		// lastName
		// address
		// village
		// city
		// pincode
		// source
		// agent
		// date
		// status

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// profileId
			$this->profileId->ViewValue = $this->profileId->CurrentValue;
			$this->profileId->ViewCustomAttributes = "";

			// userId
			$this->_userId->ViewValue = $this->_userId->CurrentValue;
			$curVal = strval($this->_userId->CurrentValue);
			if ($curVal <> "") {
				$this->_userId->ViewValue = $this->_userId->lookupCacheOption($curVal);
				if ($this->_userId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`ID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->_userId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->_userId->ViewValue = $this->_userId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->_userId->ViewValue = $this->_userId->CurrentValue;
					}
				}
			} else {
				$this->_userId->ViewValue = NULL;
			}
			$this->_userId->ViewCustomAttributes = "";

			// firstName
			$this->firstName->ViewValue = $this->firstName->CurrentValue;
			$this->firstName->ViewCustomAttributes = "";

			// lastName
			$this->lastName->ViewValue = $this->lastName->CurrentValue;
			$this->lastName->ViewCustomAttributes = "";

			// address
			$this->address->ViewValue = $this->address->CurrentValue;
			$this->address->ViewCustomAttributes = "";

			// village
			$this->village->ViewValue = $this->village->CurrentValue;
			$this->village->ViewCustomAttributes = "";

			// city
			$this->city->ViewValue = $this->city->CurrentValue;
			$this->city->ViewCustomAttributes = "";

			// pincode
			$this->pincode->ViewValue = $this->pincode->CurrentValue;
			$this->pincode->ViewCustomAttributes = "";

			// source
			if (strval($this->source->CurrentValue) <> "") {
				$this->source->ViewValue = $this->source->optionCaption($this->source->CurrentValue);
			} else {
				$this->source->ViewValue = NULL;
			}
			$this->source->ViewCustomAttributes = "";

			// agent
			$this->agent->ViewValue = $this->agent->CurrentValue;
			$this->agent->ViewCustomAttributes = "";

			// date
			$this->date->ViewValue = $this->date->CurrentValue;
			$this->date->ViewValue = FormatDateTime($this->date->ViewValue, 0);
			$this->date->ViewCustomAttributes = "";

			// status
			if (strval($this->status->CurrentValue) <> "") {
				$this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
			} else {
				$this->status->ViewValue = NULL;
			}
			$this->status->ViewCustomAttributes = "";

			// profileId
			$this->profileId->LinkCustomAttributes = "";
			$this->profileId->HrefValue = "";
			$this->profileId->TooltipValue = "";

			// firstName
			$this->firstName->LinkCustomAttributes = "";
			$this->firstName->HrefValue = "";
			$this->firstName->TooltipValue = "";

			// lastName
			$this->lastName->LinkCustomAttributes = "";
			$this->lastName->HrefValue = "";
			$this->lastName->TooltipValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";
			$this->address->TooltipValue = "";

			// village
			$this->village->LinkCustomAttributes = "";
			$this->village->HrefValue = "";
			$this->village->TooltipValue = "";

			// city
			$this->city->LinkCustomAttributes = "";
			$this->city->HrefValue = "";
			$this->city->TooltipValue = "";

			// pincode
			$this->pincode->LinkCustomAttributes = "";
			$this->pincode->HrefValue = "";
			$this->pincode->TooltipValue = "";

			// source
			$this->source->LinkCustomAttributes = "";
			$this->source->HrefValue = "";
			$this->source->TooltipValue = "";

			// agent
			$this->agent->LinkCustomAttributes = "";
			$this->agent->HrefValue = "";
			$this->agent->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// profileId
			$this->profileId->EditAttrs["class"] = "form-control";
			$this->profileId->EditCustomAttributes = "";
			$this->profileId->EditValue = $this->profileId->CurrentValue;
			$this->profileId->ViewCustomAttributes = "";

			// firstName
			$this->firstName->EditAttrs["class"] = "form-control";
			$this->firstName->EditCustomAttributes = "";
			$this->firstName->EditValue = HtmlEncode($this->firstName->CurrentValue);
			$this->firstName->PlaceHolder = RemoveHtml($this->firstName->caption());

			// lastName
			$this->lastName->EditAttrs["class"] = "form-control";
			$this->lastName->EditCustomAttributes = "";
			$this->lastName->EditValue = HtmlEncode($this->lastName->CurrentValue);
			$this->lastName->PlaceHolder = RemoveHtml($this->lastName->caption());

			// address
			$this->address->EditAttrs["class"] = "form-control";
			$this->address->EditCustomAttributes = "";
			$this->address->EditValue = HtmlEncode($this->address->CurrentValue);
			$this->address->PlaceHolder = RemoveHtml($this->address->caption());

			// village
			$this->village->EditAttrs["class"] = "form-control";
			$this->village->EditCustomAttributes = "";
			$this->village->EditValue = HtmlEncode($this->village->CurrentValue);
			$this->village->PlaceHolder = RemoveHtml($this->village->caption());

			// city
			$this->city->EditAttrs["class"] = "form-control";
			$this->city->EditCustomAttributes = "";
			$this->city->EditValue = HtmlEncode($this->city->CurrentValue);
			$this->city->PlaceHolder = RemoveHtml($this->city->caption());

			// pincode
			$this->pincode->EditAttrs["class"] = "form-control";
			$this->pincode->EditCustomAttributes = "";
			$this->pincode->EditValue = HtmlEncode($this->pincode->CurrentValue);
			$this->pincode->PlaceHolder = RemoveHtml($this->pincode->caption());

			// source
			$this->source->EditAttrs["class"] = "form-control";
			$this->source->EditCustomAttributes = "";
			$this->source->EditValue = $this->source->options(TRUE);

			// agent
			$this->agent->EditAttrs["class"] = "form-control";
			$this->agent->EditCustomAttributes = "";
			$this->agent->EditValue = HtmlEncode($this->agent->CurrentValue);
			$this->agent->PlaceHolder = RemoveHtml($this->agent->caption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->options(TRUE);

			// Edit refer script
			// profileId

			$this->profileId->LinkCustomAttributes = "";
			$this->profileId->HrefValue = "";

			// firstName
			$this->firstName->LinkCustomAttributes = "";
			$this->firstName->HrefValue = "";

			// lastName
			$this->lastName->LinkCustomAttributes = "";
			$this->lastName->HrefValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";

			// village
			$this->village->LinkCustomAttributes = "";
			$this->village->HrefValue = "";

			// city
			$this->city->LinkCustomAttributes = "";
			$this->city->HrefValue = "";

			// pincode
			$this->pincode->LinkCustomAttributes = "";
			$this->pincode->HrefValue = "";

			// source
			$this->source->LinkCustomAttributes = "";
			$this->source->HrefValue = "";

			// agent
			$this->agent->LinkCustomAttributes = "";
			$this->agent->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
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
		if ($this->profileId->Required) {
			if (!$this->profileId->IsDetailKey && $this->profileId->FormValue != NULL && $this->profileId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->profileId->caption(), $this->profileId->RequiredErrorMessage));
			}
		}
		if ($this->_userId->Required) {
			if (!$this->_userId->IsDetailKey && $this->_userId->FormValue != NULL && $this->_userId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->_userId->caption(), $this->_userId->RequiredErrorMessage));
			}
		}
		if ($this->firstName->Required) {
			if (!$this->firstName->IsDetailKey && $this->firstName->FormValue != NULL && $this->firstName->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->firstName->caption(), $this->firstName->RequiredErrorMessage));
			}
		}
		if ($this->lastName->Required) {
			if (!$this->lastName->IsDetailKey && $this->lastName->FormValue != NULL && $this->lastName->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->lastName->caption(), $this->lastName->RequiredErrorMessage));
			}
		}
		if ($this->address->Required) {
			if (!$this->address->IsDetailKey && $this->address->FormValue != NULL && $this->address->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->address->caption(), $this->address->RequiredErrorMessage));
			}
		}
		if ($this->village->Required) {
			if (!$this->village->IsDetailKey && $this->village->FormValue != NULL && $this->village->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->village->caption(), $this->village->RequiredErrorMessage));
			}
		}
		if ($this->city->Required) {
			if (!$this->city->IsDetailKey && $this->city->FormValue != NULL && $this->city->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->city->caption(), $this->city->RequiredErrorMessage));
			}
		}
		if ($this->pincode->Required) {
			if (!$this->pincode->IsDetailKey && $this->pincode->FormValue != NULL && $this->pincode->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->pincode->caption(), $this->pincode->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->pincode->FormValue)) {
			AddMessage($FormError, $this->pincode->errorMessage());
		}
		if ($this->source->Required) {
			if (!$this->source->IsDetailKey && $this->source->FormValue != NULL && $this->source->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->source->caption(), $this->source->RequiredErrorMessage));
			}
		}
		if ($this->agent->Required) {
			if (!$this->agent->IsDetailKey && $this->agent->FormValue != NULL && $this->agent->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->agent->caption(), $this->agent->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->agent->FormValue)) {
			AddMessage($FormError, $this->agent->errorMessage());
		}
		if ($this->date->Required) {
			if (!$this->date->IsDetailKey && $this->date->FormValue != NULL && $this->date->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->date->caption(), $this->date->RequiredErrorMessage));
			}
		}
		if ($this->status->Required) {
			if (!$this->status->IsDetailKey && $this->status->FormValue != NULL && $this->status->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
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

	// Update record based on key values
	protected function editRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();
		$filter = $this->applyUserIDFilters($filter);
		$conn = &$this->getConnection();
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$editRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->loadDbValues($rsold);
			$rsnew = [];

			// firstName
			$this->firstName->setDbValueDef($rsnew, $this->firstName->CurrentValue, NULL, $this->firstName->ReadOnly);

			// lastName
			$this->lastName->setDbValueDef($rsnew, $this->lastName->CurrentValue, NULL, $this->lastName->ReadOnly);

			// address
			$this->address->setDbValueDef($rsnew, $this->address->CurrentValue, NULL, $this->address->ReadOnly);

			// village
			$this->village->setDbValueDef($rsnew, $this->village->CurrentValue, NULL, $this->village->ReadOnly);

			// city
			$this->city->setDbValueDef($rsnew, $this->city->CurrentValue, NULL, $this->city->ReadOnly);

			// pincode
			$this->pincode->setDbValueDef($rsnew, $this->pincode->CurrentValue, NULL, $this->pincode->ReadOnly);

			// source
			$this->source->setDbValueDef($rsnew, $this->source->CurrentValue, "", $this->source->ReadOnly);

			// agent
			$this->agent->setDbValueDef($rsnew, $this->agent->CurrentValue, 0, $this->agent->ReadOnly);

			// status
			$this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

			// Call Row Updating event
			$updateRow = $this->Row_Updating($rsold, $rsnew);
			if ($updateRow) {
				$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
				if (count($rsnew) > 0)
					$editRow = $this->update($rsnew, "", $rsold);
				else
					$editRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($editRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->phrase("UpdateCancelled"));
				}
				$editRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($editRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->close();

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
	}

	// Show link optionally based on User ID
	protected function showOptionLink($id = "")
	{
		global $Security;
		if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id))
			return $Security->isValidUserID($this->_userId->CurrentValue);
		return TRUE;
	}

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{
		$validMaster = FALSE;

		// Get the keys for master table
		if (Get(TABLE_SHOW_MASTER) !== NULL) {
			$masterTblVar = Get(TABLE_SHOW_MASTER);
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "users") {
				$validMaster = TRUE;
				if (Get("fk_ID") !== NULL) {
					$GLOBALS["users"]->ID->setQueryStringValue(Get("fk_ID"));
					$this->_userId->setQueryStringValue($GLOBALS["users"]->ID->QueryStringValue);
					$this->_userId->setSessionValue($this->_userId->QueryStringValue);
					if (!is_numeric($GLOBALS["users"]->ID->QueryStringValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
		} elseif (Post(TABLE_SHOW_MASTER) !== NULL) {
			$masterTblVar = Post(TABLE_SHOW_MASTER);
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "users") {
				$validMaster = TRUE;
				if (Post("fk_ID") !== NULL) {
					$GLOBALS["users"]->ID->setFormValue(Post("fk_ID"));
					$this->_userId->setFormValue($GLOBALS["users"]->ID->FormValue);
					$this->_userId->setSessionValue($this->_userId->FormValue);
					if (!is_numeric($GLOBALS["users"]->ID->FormValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
		}
		if ($validMaster) {

			// Save current master table
			$this->setCurrentMasterTable($masterTblVar);
			$this->setSessionWhere($this->getDetailFilter());

			// Reset start record counter (new master key)
			if (!$this->isAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($masterTblVar <> "users") {
				if ($this->_userId->CurrentValue == "")
					$this->_userId->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("userprofileslist.php"), "", $this->TableVar, TRUE);
		$pageId = "edit";
		$Breadcrumb->add("edit", $pageId, $url);
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
						case "x__userId":
							break;
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
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
