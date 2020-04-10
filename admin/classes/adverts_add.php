<?php
namespace PHPMaker2019\tabelo_admin;

/**
 * Page class
 */
class adverts_add extends adverts
{

	// Page ID
	public $PageID = "add";

	// Project ID
	public $ProjectID = "{69E18FAC-2EFC-47EE-A765-B17249FAF990}";

	// Table name
	public $TableName = 'adverts';

	// Page object name
	public $PageObjName = "adverts_add";

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

		// Table object (adverts)
		if (!isset($GLOBALS["adverts"]) || get_class($GLOBALS["adverts"]) == PROJECT_NAMESPACE . "adverts") {
			$GLOBALS["adverts"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["adverts"];
		}

		// Table object (categories)
		if (!isset($GLOBALS['categories']))
			$GLOBALS['categories'] = new categories();

		// Table object (locations)
		if (!isset($GLOBALS['locations']))
			$GLOBALS['locations'] = new locations();

		// Table object (userprofiles)
		if (!isset($GLOBALS['userprofiles']))
			$GLOBALS['userprofiles'] = new userprofiles();

		// Table object (users)
		if (!isset($GLOBALS['users']))
			$GLOBALS['users'] = new users();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'add');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'adverts');

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
		global $EXPORT, $adverts;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($adverts);
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
					if ($pageName == "advertsview.php")
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
			$key .= @$ar['advId'];
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
			$this->advId->Visible = FALSE;
	}
	public $FormClassName = "ew-horizontal ew-form ew-add-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRec;
	public $Priv = 0;
	public $OldRecordset;
	public $CopyRecord;

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
			if (!$Security->canAdd()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("advertslist.php"));
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
					$this->terminate(GetUrl("advertslist.php"));
					return;
				}
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->advId->Visible = FALSE;
		$this->_userId->setVisibility();
		$this->title->setVisibility();
		$this->description->setVisibility();
		$this->categoryId->setVisibility();
		$this->locationId->setVisibility();
		$this->validity->Visible = FALSE;
		$this->contactPerson->setVisibility();
		$this->contactNumber->setVisibility();
		$this->date->setVisibility();
		$this->cost->setVisibility();
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
		$this->setupLookupOptions($this->categoryId);
		$this->setupLookupOptions($this->locationId);

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-add-form ew-horizontal";

		// Set up master/detail parameters
		$this->setupMasterParms();
		$postBack = FALSE;

		// Set up current action
		if (IsApi()) {
			$this->CurrentAction = "insert"; // Add record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get form action
			$postBack = TRUE;
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (Get("advId") !== NULL) {
				$this->advId->setQueryStringValue(Get("advId"));
				$this->setKey("advId", $this->advId->CurrentValue); // Set up key
			} else {
				$this->setKey("advId", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "copy"; // Copy record
			} else {
				$this->CurrentAction = "show"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->loadOldRecord();

		// Load form values
		if ($postBack) {
			$this->loadFormValues(); // Load form values
		}

		// Set up detail parameters
		$this->setupDetailParms();

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues(); // Restore form values
				$this->setFailureMessage($FormError);
				if (IsApi()) {
					$this->terminate();
					return;
				} else {
					$this->CurrentAction = "show"; // Form error, reset action
				}
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "copy": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
					$this->terminate("advertslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->setupDetailParms();
				break;
			case "insert": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$returnUrl = $this->getDetailUrl();
					else
						$returnUrl = $this->getReturnUrl();
					if (GetPageName($returnUrl) == "advertslist.php")
						$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
					elseif (GetPageName($returnUrl) == "advertsview.php")
						$returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
					if (IsApi()) { // Return to caller
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl);
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->setupDetailParms();
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render row based on row type
		$this->RowType = ROWTYPE_ADD; // Render add type

		// Render row
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
		$this->advId->CurrentValue = NULL;
		$this->advId->OldValue = $this->advId->CurrentValue;
		$this->_userId->CurrentValue = CurrentUserID();
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->description->CurrentValue = NULL;
		$this->description->OldValue = $this->description->CurrentValue;
		$this->categoryId->CurrentValue = NULL;
		$this->categoryId->OldValue = $this->categoryId->CurrentValue;
		$this->locationId->CurrentValue = NULL;
		$this->locationId->OldValue = $this->locationId->CurrentValue;
		$this->validity->CurrentValue = 60;
		$this->contactPerson->CurrentValue = NULL;
		$this->contactPerson->OldValue = $this->contactPerson->CurrentValue;
		$this->contactNumber->CurrentValue = NULL;
		$this->contactNumber->OldValue = $this->contactNumber->CurrentValue;
		$this->date->CurrentValue = NULL;
		$this->date->OldValue = $this->date->CurrentValue;
		$this->cost->CurrentValue = NULL;
		$this->cost->OldValue = $this->cost->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'userId' first before field var 'x__userId'
		$val = $CurrentForm->hasValue("userId") ? $CurrentForm->getValue("userId") : $CurrentForm->getValue("x__userId");
		if (!$this->_userId->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->_userId->Visible = FALSE; // Disable update for API request
			else
				$this->_userId->setFormValue($val);
		}

		// Check field name 'title' first before field var 'x_title'
		$val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x_title");
		if (!$this->title->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->title->Visible = FALSE; // Disable update for API request
			else
				$this->title->setFormValue($val);
		}

		// Check field name 'description' first before field var 'x_description'
		$val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
		if (!$this->description->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->description->Visible = FALSE; // Disable update for API request
			else
				$this->description->setFormValue($val);
		}

		// Check field name 'categoryId' first before field var 'x_categoryId'
		$val = $CurrentForm->hasValue("categoryId") ? $CurrentForm->getValue("categoryId") : $CurrentForm->getValue("x_categoryId");
		if (!$this->categoryId->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->categoryId->Visible = FALSE; // Disable update for API request
			else
				$this->categoryId->setFormValue($val);
		}

		// Check field name 'locationId' first before field var 'x_locationId'
		$val = $CurrentForm->hasValue("locationId") ? $CurrentForm->getValue("locationId") : $CurrentForm->getValue("x_locationId");
		if (!$this->locationId->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->locationId->Visible = FALSE; // Disable update for API request
			else
				$this->locationId->setFormValue($val);
		}

		// Check field name 'contactPerson' first before field var 'x_contactPerson'
		$val = $CurrentForm->hasValue("contactPerson") ? $CurrentForm->getValue("contactPerson") : $CurrentForm->getValue("x_contactPerson");
		if (!$this->contactPerson->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->contactPerson->Visible = FALSE; // Disable update for API request
			else
				$this->contactPerson->setFormValue($val);
		}

		// Check field name 'contactNumber' first before field var 'x_contactNumber'
		$val = $CurrentForm->hasValue("contactNumber") ? $CurrentForm->getValue("contactNumber") : $CurrentForm->getValue("x_contactNumber");
		if (!$this->contactNumber->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->contactNumber->Visible = FALSE; // Disable update for API request
			else
				$this->contactNumber->setFormValue($val);
		}

		// Check field name 'date' first before field var 'x_date'
		$val = $CurrentForm->hasValue("date") ? $CurrentForm->getValue("date") : $CurrentForm->getValue("x_date");
		if (!$this->date->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->date->Visible = FALSE; // Disable update for API request
			else
				$this->date->setFormValue($val);
			$this->date->CurrentValue = UnFormatDateTime($this->date->CurrentValue, 0);
		}

		// Check field name 'cost' first before field var 'x_cost'
		$val = $CurrentForm->hasValue("cost") ? $CurrentForm->getValue("cost") : $CurrentForm->getValue("x_cost");
		if (!$this->cost->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->cost->Visible = FALSE; // Disable update for API request
			else
				$this->cost->setFormValue($val);
		}

		// Check field name 'advId' first before field var 'x_advId'
		$val = $CurrentForm->hasValue("advId") ? $CurrentForm->getValue("advId") : $CurrentForm->getValue("x_advId");
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->_userId->CurrentValue = $this->_userId->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->categoryId->CurrentValue = $this->categoryId->FormValue;
		$this->locationId->CurrentValue = $this->locationId->FormValue;
		$this->contactPerson->CurrentValue = $this->contactPerson->FormValue;
		$this->contactNumber->CurrentValue = $this->contactNumber->FormValue;
		$this->date->CurrentValue = $this->date->FormValue;
		$this->date->CurrentValue = UnFormatDateTime($this->date->CurrentValue, 0);
		$this->cost->CurrentValue = $this->cost->FormValue;
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
			$res = $this->showOptionLink('add');
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
		$this->advId->setDbValue($row['advId']);
		$this->_userId->setDbValue($row['userId']);
		$this->title->setDbValue($row['title']);
		$this->description->setDbValue($row['description']);
		$this->categoryId->setDbValue($row['categoryId']);
		$this->locationId->setDbValue($row['locationId']);
		$this->validity->setDbValue($row['validity']);
		$this->contactPerson->setDbValue($row['contactPerson']);
		$this->contactNumber->setDbValue($row['contactNumber']);
		$this->date->setDbValue($row['date']);
		$this->cost->setDbValue($row['cost']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['advId'] = $this->advId->CurrentValue;
		$row['userId'] = $this->_userId->CurrentValue;
		$row['title'] = $this->title->CurrentValue;
		$row['description'] = $this->description->CurrentValue;
		$row['categoryId'] = $this->categoryId->CurrentValue;
		$row['locationId'] = $this->locationId->CurrentValue;
		$row['validity'] = $this->validity->CurrentValue;
		$row['contactPerson'] = $this->contactPerson->CurrentValue;
		$row['contactNumber'] = $this->contactNumber->CurrentValue;
		$row['date'] = $this->date->CurrentValue;
		$row['cost'] = $this->cost->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("advId")) <> "")
			$this->advId->CurrentValue = $this->getKey("advId"); // advId
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
		// advId
		// userId
		// title
		// description
		// categoryId
		// locationId
		// validity
		// contactPerson
		// contactNumber
		// date
		// cost

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// advId
			$this->advId->ViewValue = $this->advId->CurrentValue;
			$this->advId->ViewCustomAttributes = "";

			// userId
			$this->_userId->ViewValue = $this->_userId->CurrentValue;
			$curVal = strval($this->_userId->CurrentValue);
			if ($curVal <> "") {
				$this->_userId->ViewValue = $this->_userId->lookupCacheOption($curVal);
				if ($this->_userId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`userId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->_userId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
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

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// description
			$this->description->ViewValue = $this->description->CurrentValue;
			$this->description->ViewCustomAttributes = "";

			// categoryId
			$curVal = strval($this->categoryId->CurrentValue);
			if ($curVal <> "") {
				$this->categoryId->ViewValue = $this->categoryId->lookupCacheOption($curVal);
				if ($this->categoryId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`categoryId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->categoryId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->categoryId->ViewValue = $this->categoryId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->categoryId->ViewValue = $this->categoryId->CurrentValue;
					}
				}
			} else {
				$this->categoryId->ViewValue = NULL;
			}
			$this->categoryId->ViewCustomAttributes = "";

			// locationId
			$curVal = strval($this->locationId->CurrentValue);
			if ($curVal <> "") {
				$this->locationId->ViewValue = $this->locationId->lookupCacheOption($curVal);
				if ($this->locationId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`locationId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->locationId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->locationId->ViewValue = $this->locationId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->locationId->ViewValue = $this->locationId->CurrentValue;
					}
				}
			} else {
				$this->locationId->ViewValue = NULL;
			}
			$this->locationId->ViewCustomAttributes = "";

			// validity
			$this->validity->ViewValue = $this->validity->CurrentValue;
			$this->validity->ViewCustomAttributes = "";

			// contactPerson
			$this->contactPerson->ViewValue = $this->contactPerson->CurrentValue;
			$this->contactPerson->ViewCustomAttributes = "";

			// contactNumber
			$this->contactNumber->ViewValue = $this->contactNumber->CurrentValue;
			$this->contactNumber->ViewCustomAttributes = "";

			// date
			$this->date->ViewValue = $this->date->CurrentValue;
			$this->date->ViewValue = FormatDateTime($this->date->ViewValue, 0);
			$this->date->ViewCustomAttributes = "";

			// cost
			$this->cost->ViewValue = $this->cost->CurrentValue;
			$this->cost->ViewCustomAttributes = "";

			// userId
			$this->_userId->LinkCustomAttributes = "";
			if (!EmptyValue($this->_userId->CurrentValue)) {
				$this->_userId->HrefValue = ((!empty($this->_userId->ViewValue) && !is_array($this->_userId->ViewValue)) ? RemoveHtml($this->_userId->ViewValue) : $this->_userId->CurrentValue); // Add prefix/suffix
				$this->_userId->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->_userId->HrefValue = FullUrl($this->_userId->HrefValue, "href");
			} else {
				$this->_userId->HrefValue = "";
			}
			$this->_userId->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			if (!EmptyValue($this->advId->CurrentValue)) {
				$this->title->HrefValue = "advertsview.php?showdetail=&advId=" . ((!empty($this->advId->ViewValue) && !is_array($this->advId->ViewValue)) ? RemoveHtml($this->advId->ViewValue) : $this->advId->CurrentValue); // Add prefix/suffix
				$this->title->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->title->HrefValue = FullUrl($this->title->HrefValue, "href");
			} else {
				$this->title->HrefValue = "";
			}
			$this->title->TooltipValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// categoryId
			$this->categoryId->LinkCustomAttributes = "";
			$this->categoryId->HrefValue = "";
			$this->categoryId->TooltipValue = "";

			// locationId
			$this->locationId->LinkCustomAttributes = "";
			$this->locationId->HrefValue = "";
			$this->locationId->TooltipValue = "";

			// contactPerson
			$this->contactPerson->LinkCustomAttributes = "";
			$this->contactPerson->HrefValue = "";
			$this->contactPerson->TooltipValue = "";

			// contactNumber
			$this->contactNumber->LinkCustomAttributes = "";
			$this->contactNumber->HrefValue = "";
			$this->contactNumber->TooltipValue = "";

			// date
			$this->date->LinkCustomAttributes = "";
			$this->date->HrefValue = "";
			$this->date->TooltipValue = "";

			// cost
			$this->cost->LinkCustomAttributes = "";
			$this->cost->HrefValue = "";
			$this->cost->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// userId
			$this->_userId->EditAttrs["class"] = "form-control";
			$this->_userId->EditCustomAttributes = "";
			if ($this->_userId->getSessionValue() <> "") {
				$this->_userId->CurrentValue = $this->_userId->getSessionValue();
			$this->_userId->ViewValue = $this->_userId->CurrentValue;
			$curVal = strval($this->_userId->CurrentValue);
			if ($curVal <> "") {
				$this->_userId->ViewValue = $this->_userId->lookupCacheOption($curVal);
				if ($this->_userId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`userId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->_userId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
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
			} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("add")) { // Non system admin
				$this->_userId->CurrentValue = CurrentUserID();
			$this->_userId->EditValue = $this->_userId->CurrentValue;
			$curVal = strval($this->_userId->CurrentValue);
			if ($curVal <> "") {
				$this->_userId->EditValue = $this->_userId->lookupCacheOption($curVal);
				if ($this->_userId->EditValue === NULL) { // Lookup from database
					$filterWrk = "`userId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->_userId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
						$this->_userId->EditValue = $this->_userId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->_userId->EditValue = $this->_userId->CurrentValue;
					}
				}
			} else {
				$this->_userId->EditValue = NULL;
			}
			$this->_userId->ViewCustomAttributes = "";
			} else {
			$this->_userId->EditValue = HtmlEncode($this->_userId->CurrentValue);
			$curVal = strval($this->_userId->CurrentValue);
			if ($curVal <> "") {
				$this->_userId->EditValue = $this->_userId->lookupCacheOption($curVal);
				if ($this->_userId->EditValue === NULL) { // Lookup from database
					$filterWrk = "`userId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->_userId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$arwrk[2] = HtmlEncode($rswrk->fields('df2'));
						$this->_userId->EditValue = $this->_userId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->_userId->EditValue = HtmlEncode($this->_userId->CurrentValue);
					}
				}
			} else {
				$this->_userId->EditValue = NULL;
			}
			$this->_userId->PlaceHolder = RemoveHtml($this->_userId->caption());
			}

			// title
			$this->title->EditAttrs["class"] = "form-control";
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = RemoveHtml($this->title->caption());

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = HtmlEncode($this->description->CurrentValue);
			$this->description->PlaceHolder = RemoveHtml($this->description->caption());

			// categoryId
			$this->categoryId->EditAttrs["class"] = "form-control";
			$this->categoryId->EditCustomAttributes = "";
			if ($this->categoryId->getSessionValue() <> "") {
				$this->categoryId->CurrentValue = $this->categoryId->getSessionValue();
			$curVal = strval($this->categoryId->CurrentValue);
			if ($curVal <> "") {
				$this->categoryId->ViewValue = $this->categoryId->lookupCacheOption($curVal);
				if ($this->categoryId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`categoryId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->categoryId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->categoryId->ViewValue = $this->categoryId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->categoryId->ViewValue = $this->categoryId->CurrentValue;
					}
				}
			} else {
				$this->categoryId->ViewValue = NULL;
			}
			$this->categoryId->ViewCustomAttributes = "";
			} else {
			$curVal = trim(strval($this->categoryId->CurrentValue));
			if ($curVal <> "")
				$this->categoryId->ViewValue = $this->categoryId->lookupCacheOption($curVal);
			else
				$this->categoryId->ViewValue = $this->categoryId->Lookup !== NULL && is_array($this->categoryId->Lookup->Options) ? $curVal : NULL;
			if ($this->categoryId->ViewValue !== NULL) { // Load from cache
				$this->categoryId->EditValue = array_values($this->categoryId->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`categoryId`" . SearchString("=", $this->categoryId->CurrentValue, DATATYPE_NUMBER, "");
				}
				$sqlWrk = $this->categoryId->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->categoryId->EditValue = $arwrk;
			}
			}

			// locationId
			$this->locationId->EditCustomAttributes = "";
			if ($this->locationId->getSessionValue() <> "") {
				$this->locationId->CurrentValue = $this->locationId->getSessionValue();
			$curVal = strval($this->locationId->CurrentValue);
			if ($curVal <> "") {
				$this->locationId->ViewValue = $this->locationId->lookupCacheOption($curVal);
				if ($this->locationId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`locationId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->locationId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->locationId->ViewValue = $this->locationId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->locationId->ViewValue = $this->locationId->CurrentValue;
					}
				}
			} else {
				$this->locationId->ViewValue = NULL;
			}
			$this->locationId->ViewCustomAttributes = "";
			} else {
			$curVal = trim(strval($this->locationId->CurrentValue));
			if ($curVal <> "")
				$this->locationId->ViewValue = $this->locationId->lookupCacheOption($curVal);
			else
				$this->locationId->ViewValue = $this->locationId->Lookup !== NULL && is_array($this->locationId->Lookup->Options) ? $curVal : NULL;
			if ($this->locationId->ViewValue !== NULL) { // Load from cache
				$this->locationId->EditValue = array_values($this->locationId->Lookup->Options);
				if ($this->locationId->ViewValue == "")
					$this->locationId->ViewValue = $Language->phrase("PleaseSelect");
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`locationId`" . SearchString("=", $this->locationId->CurrentValue, DATATYPE_NUMBER, "");
				}
				$sqlWrk = $this->locationId->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = HtmlEncode($rswrk->fields('df'));
					$this->locationId->ViewValue = $this->locationId->displayValue($arwrk);
				} else {
					$this->locationId->ViewValue = $Language->phrase("PleaseSelect");
				}
				$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
				if ($rswrk) $rswrk->Close();
				$this->locationId->EditValue = $arwrk;
			}
			}

			// contactPerson
			$this->contactPerson->EditAttrs["class"] = "form-control";
			$this->contactPerson->EditCustomAttributes = "";
			$this->contactPerson->EditValue = HtmlEncode($this->contactPerson->CurrentValue);
			$this->contactPerson->PlaceHolder = RemoveHtml($this->contactPerson->caption());

			// contactNumber
			$this->contactNumber->EditAttrs["class"] = "form-control";
			$this->contactNumber->EditCustomAttributes = "";
			$this->contactNumber->EditValue = HtmlEncode($this->contactNumber->CurrentValue);
			$this->contactNumber->PlaceHolder = RemoveHtml($this->contactNumber->caption());

			// date
			$this->date->EditAttrs["class"] = "form-control";
			$this->date->EditCustomAttributes = "";
			$this->date->EditValue = HtmlEncode(FormatDateTime($this->date->CurrentValue, 8));
			$this->date->PlaceHolder = RemoveHtml($this->date->caption());

			// cost
			$this->cost->EditAttrs["class"] = "form-control";
			$this->cost->EditCustomAttributes = "";
			$this->cost->EditValue = HtmlEncode($this->cost->CurrentValue);
			$this->cost->PlaceHolder = RemoveHtml($this->cost->caption());

			// Add refer script
			// userId

			$this->_userId->LinkCustomAttributes = "";
			if (!EmptyValue($this->_userId->CurrentValue)) {
				$this->_userId->HrefValue = ((!empty($this->_userId->EditValue) && !is_array($this->_userId->EditValue)) ? RemoveHtml($this->_userId->EditValue) : $this->_userId->CurrentValue); // Add prefix/suffix
				$this->_userId->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->_userId->HrefValue = FullUrl($this->_userId->HrefValue, "href");
			} else {
				$this->_userId->HrefValue = "";
			}

			// title
			$this->title->LinkCustomAttributes = "";
			if (!EmptyValue($this->advId->CurrentValue)) {
				$this->title->HrefValue = "advertsview.php?showdetail=&advId=" . ((!empty($this->advId->EditValue) && !is_array($this->advId->EditValue)) ? RemoveHtml($this->advId->EditValue) : $this->advId->CurrentValue); // Add prefix/suffix
				$this->title->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->title->HrefValue = FullUrl($this->title->HrefValue, "href");
			} else {
				$this->title->HrefValue = "";
			}

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// categoryId
			$this->categoryId->LinkCustomAttributes = "";
			$this->categoryId->HrefValue = "";

			// locationId
			$this->locationId->LinkCustomAttributes = "";
			$this->locationId->HrefValue = "";

			// contactPerson
			$this->contactPerson->LinkCustomAttributes = "";
			$this->contactPerson->HrefValue = "";

			// contactNumber
			$this->contactNumber->LinkCustomAttributes = "";
			$this->contactNumber->HrefValue = "";

			// date
			$this->date->LinkCustomAttributes = "";
			$this->date->HrefValue = "";

			// cost
			$this->cost->LinkCustomAttributes = "";
			$this->cost->HrefValue = "";
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
		if ($this->advId->Required) {
			if (!$this->advId->IsDetailKey && $this->advId->FormValue != NULL && $this->advId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->advId->caption(), $this->advId->RequiredErrorMessage));
			}
		}
		if ($this->_userId->Required) {
			if (!$this->_userId->IsDetailKey && $this->_userId->FormValue != NULL && $this->_userId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->_userId->caption(), $this->_userId->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->_userId->FormValue)) {
			AddMessage($FormError, $this->_userId->errorMessage());
		}
		if ($this->title->Required) {
			if (!$this->title->IsDetailKey && $this->title->FormValue != NULL && $this->title->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->title->caption(), $this->title->RequiredErrorMessage));
			}
		}
		if ($this->description->Required) {
			if (!$this->description->IsDetailKey && $this->description->FormValue != NULL && $this->description->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
			}
		}
		if ($this->categoryId->Required) {
			if (!$this->categoryId->IsDetailKey && $this->categoryId->FormValue != NULL && $this->categoryId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->categoryId->caption(), $this->categoryId->RequiredErrorMessage));
			}
		}
		if ($this->locationId->Required) {
			if (!$this->locationId->IsDetailKey && $this->locationId->FormValue != NULL && $this->locationId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->locationId->caption(), $this->locationId->RequiredErrorMessage));
			}
		}
		if ($this->validity->Required) {
			if (!$this->validity->IsDetailKey && $this->validity->FormValue != NULL && $this->validity->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->validity->caption(), $this->validity->RequiredErrorMessage));
			}
		}
		if ($this->contactPerson->Required) {
			if (!$this->contactPerson->IsDetailKey && $this->contactPerson->FormValue != NULL && $this->contactPerson->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->contactPerson->caption(), $this->contactPerson->RequiredErrorMessage));
			}
		}
		if ($this->contactNumber->Required) {
			if (!$this->contactNumber->IsDetailKey && $this->contactNumber->FormValue != NULL && $this->contactNumber->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->contactNumber->caption(), $this->contactNumber->RequiredErrorMessage));
			}
		}
		if ($this->date->Required) {
			if (!$this->date->IsDetailKey && $this->date->FormValue != NULL && $this->date->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->date->caption(), $this->date->RequiredErrorMessage));
			}
		}
		if (!CheckDate($this->date->FormValue)) {
			AddMessage($FormError, $this->date->errorMessage());
		}
		if ($this->cost->Required) {
			if (!$this->cost->IsDetailKey && $this->cost->FormValue != NULL && $this->cost->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->cost->caption(), $this->cost->RequiredErrorMessage));
			}
		}

		// Validate detail grid
		$detailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("media", $detailTblVar) && $GLOBALS["media"]->DetailAdd) {
			if (!isset($GLOBALS["media_grid"]))
				$GLOBALS["media_grid"] = new media_grid(); // Get detail page object
			$GLOBALS["media_grid"]->validateGridForm();
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
		if ($Security->currentUserID() <> "" && !EmptyValue($this->_userId->CurrentValue) && !$Security->isAdmin()) { // Non system admin
			$validUser = $Security->isValidUserID($this->_userId->CurrentValue);
			if (!$validUser) {
				$userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
				$userIdMsg = str_replace("%u", $this->_userId->CurrentValue, $userIdMsg);
				$this->setFailureMessage($userIdMsg);
				return FALSE;
			}
		}

		// Check if valid key values for master user
		if ($Security->currentUserID() <> "" && !$Security->isAdmin()) { // Non system admin
			$masterFilter = $this->sqlMasterFilter_users();
			if (strval($this->_userId->CurrentValue) <> "") {
				$masterFilter = str_replace("@ID@", AdjustSql($this->_userId->CurrentValue, "DB"), $masterFilter);
			} else {
				$masterFilter = "";
			}
			if ($masterFilter <> "") {
				$rsmaster = $GLOBALS["users"]->loadRs($masterFilter);
				$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
				$validMasterKey = TRUE;
				if ($this->MasterRecordExists) {
					$validMasterKey = $Security->isValidUserID($rsmaster->fields['ID']);
				} elseif ($this->getCurrentMasterTable() == "users") {
					$validMasterKey = FALSE;
				}
				if (!$validMasterKey) {
					$masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
					$masterUserIdMsg = str_replace("%f", $sMasterFilter, $masterUserIdMsg);
					$this->setFailureMessage($masterUserIdMsg);
					return FALSE;
				}
				if ($rsmaster)
					$rsmaster->close();
			}
		}

		// Check referential integrity for master table 'categories'
		$validMasterRecord = TRUE;
		$masterFilter = $this->sqlMasterFilter_categories();
		if (strval($this->categoryId->CurrentValue) <> "") {
			$masterFilter = str_replace("@categoryId@", AdjustSql($this->categoryId->CurrentValue, "DB"), $masterFilter);
		} else {
			$validMasterRecord = FALSE;
		}
		if ($validMasterRecord) {
			if (!isset($GLOBALS["categories"]))
				$GLOBALS["categories"] = new categories();
			$rsmaster = $GLOBALS["categories"]->loadRs($masterFilter);
			$validMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->close();
		}
		if (!$validMasterRecord) {
			$relatedRecordMsg = str_replace("%t", "categories", $Language->phrase("RelatedRecordRequired"));
			$this->setFailureMessage($relatedRecordMsg);
			return FALSE;
		}

		// Check referential integrity for master table 'locations'
		$validMasterRecord = TRUE;
		$masterFilter = $this->sqlMasterFilter_locations();
		if (strval($this->locationId->CurrentValue) <> "") {
			$masterFilter = str_replace("@locationId@", AdjustSql($this->locationId->CurrentValue, "DB"), $masterFilter);
		} else {
			$validMasterRecord = FALSE;
		}
		if ($validMasterRecord) {
			if (!isset($GLOBALS["locations"]))
				$GLOBALS["locations"] = new locations();
			$rsmaster = $GLOBALS["locations"]->loadRs($masterFilter);
			$validMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->close();
		}
		if (!$validMasterRecord) {
			$relatedRecordMsg = str_replace("%t", "locations", $Language->phrase("RelatedRecordRequired"));
			$this->setFailureMessage($relatedRecordMsg);
			return FALSE;
		}

		// Check referential integrity for master table 'users'
		$validMasterRecord = TRUE;
		$masterFilter = $this->sqlMasterFilter_users();
		if (strval($this->_userId->CurrentValue) <> "") {
			$masterFilter = str_replace("@ID@", AdjustSql($this->_userId->CurrentValue, "DB"), $masterFilter);
		} else {
			$validMasterRecord = FALSE;
		}
		if ($validMasterRecord) {
			if (!isset($GLOBALS["users"]))
				$GLOBALS["users"] = new users();
			$rsmaster = $GLOBALS["users"]->loadRs($masterFilter);
			$validMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->close();
		}
		if (!$validMasterRecord) {
			$relatedRecordMsg = str_replace("%t", "users", $Language->phrase("RelatedRecordRequired"));
			$this->setFailureMessage($relatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->getConnection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->beginTrans();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// userId
		$this->_userId->setDbValueDef($rsnew, $this->_userId->CurrentValue, 0, FALSE);

		// title
		$this->title->setDbValueDef($rsnew, $this->title->CurrentValue, "", FALSE);

		// description
		$this->description->setDbValueDef($rsnew, $this->description->CurrentValue, "", FALSE);

		// categoryId
		$this->categoryId->setDbValueDef($rsnew, $this->categoryId->CurrentValue, 0, FALSE);

		// locationId
		$this->locationId->setDbValueDef($rsnew, $this->locationId->CurrentValue, 0, FALSE);

		// contactPerson
		$this->contactPerson->setDbValueDef($rsnew, $this->contactPerson->CurrentValue, "", FALSE);

		// contactNumber
		$this->contactNumber->setDbValueDef($rsnew, $this->contactNumber->CurrentValue, "", FALSE);

		// date
		$this->date->setDbValueDef($rsnew, UnFormatDateTime($this->date->CurrentValue, 0), NULL, FALSE);

		// cost
		$this->cost->setDbValueDef($rsnew, $this->cost->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($addRow) {
			$detailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("media", $detailTblVar) && $GLOBALS["media"]->DetailAdd) {
				$GLOBALS["media"]->advId->setSessionValue($this->advId->CurrentValue); // Set master key
				if (!isset($GLOBALS["media_grid"]))
					$GLOBALS["media_grid"] = new media_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "media"); // Load user level of detail table
				$addRow = $GLOBALS["media_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow)
					$GLOBALS["media"]->advId->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($addRow) {
				$conn->commitTrans(); // Commit transaction
			} else {
				$conn->rollbackTrans(); // Rollback transaction
			}
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
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
			if ($masterTblVar == "categories") {
				$validMaster = TRUE;
				if (Get("fk_categoryId") !== NULL) {
					$GLOBALS["categories"]->categoryId->setQueryStringValue(Get("fk_categoryId"));
					$this->categoryId->setQueryStringValue($GLOBALS["categories"]->categoryId->QueryStringValue);
					$this->categoryId->setSessionValue($this->categoryId->QueryStringValue);
					if (!is_numeric($GLOBALS["categories"]->categoryId->QueryStringValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
			if ($masterTblVar == "locations") {
				$validMaster = TRUE;
				if (Get("fk_locationId") !== NULL) {
					$GLOBALS["locations"]->locationId->setQueryStringValue(Get("fk_locationId"));
					$this->locationId->setQueryStringValue($GLOBALS["locations"]->locationId->QueryStringValue);
					$this->locationId->setSessionValue($this->locationId->QueryStringValue);
					if (!is_numeric($GLOBALS["locations"]->locationId->QueryStringValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
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
			if ($masterTblVar == "categories") {
				$validMaster = TRUE;
				if (Post("fk_categoryId") !== NULL) {
					$GLOBALS["categories"]->categoryId->setFormValue(Post("fk_categoryId"));
					$this->categoryId->setFormValue($GLOBALS["categories"]->categoryId->FormValue);
					$this->categoryId->setSessionValue($this->categoryId->FormValue);
					if (!is_numeric($GLOBALS["categories"]->categoryId->FormValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
			if ($masterTblVar == "locations") {
				$validMaster = TRUE;
				if (Post("fk_locationId") !== NULL) {
					$GLOBALS["locations"]->locationId->setFormValue(Post("fk_locationId"));
					$this->locationId->setFormValue($GLOBALS["locations"]->locationId->FormValue);
					$this->locationId->setSessionValue($this->locationId->FormValue);
					if (!is_numeric($GLOBALS["locations"]->locationId->FormValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
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

			// Reset start record counter (new master key)
			if (!$this->isAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($masterTblVar <> "categories") {
				if ($this->categoryId->CurrentValue == "")
					$this->categoryId->setSessionValue("");
			}
			if ($masterTblVar <> "locations") {
				if ($this->locationId->CurrentValue == "")
					$this->locationId->setSessionValue("");
			}
			if ($masterTblVar <> "users") {
				if ($this->_userId->CurrentValue == "")
					$this->_userId->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	protected function setupDetailParms()
	{

		// Get the keys for master table
		if (Get(TABLE_SHOW_DETAIL) !== NULL) {
			$detailTblVar = Get(TABLE_SHOW_DETAIL);
			$this->setCurrentDetailTable($detailTblVar);
		} else {
			$detailTblVar = $this->getCurrentDetailTable();
		}
		if ($detailTblVar <> "") {
			$detailTblVar = explode(",", $detailTblVar);
			if (in_array("media", $detailTblVar)) {
				if (!isset($GLOBALS["media_grid"]))
					$GLOBALS["media_grid"] = new media_grid();
				if ($GLOBALS["media_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["media_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["media_grid"]->CurrentMode = "add";
					$GLOBALS["media_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["media_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["media_grid"]->setStartRecordNumber(1);
					$GLOBALS["media_grid"]->advId->IsDetailKey = TRUE;
					$GLOBALS["media_grid"]->advId->CurrentValue = $this->advId->CurrentValue;
					$GLOBALS["media_grid"]->advId->setSessionValue($GLOBALS["media_grid"]->advId->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("advertslist.php"), "", $this->TableVar, TRUE);
		$pageId = ($this->isCopy()) ? "Copy" : "Add";
		$Breadcrumb->add("add", $pageId, $url);
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
						case "x_categoryId":
							break;
						case "x_locationId":
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
