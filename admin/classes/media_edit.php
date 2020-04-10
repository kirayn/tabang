<?php
namespace PHPMaker2019\tabelo_admin;

/**
 * Page class
 */
class media_edit extends media
{

	// Page ID
	public $PageID = "edit";

	// Project ID
	public $ProjectID = "{69E18FAC-2EFC-47EE-A765-B17249FAF990}";

	// Table name
	public $TableName = 'media';

	// Page object name
	public $PageObjName = "media_edit";

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

		// Table object (media)
		if (!isset($GLOBALS["media"]) || get_class($GLOBALS["media"]) == PROJECT_NAMESPACE . "media") {
			$GLOBALS["media"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["media"];
		}

		// Table object (adverts)
		if (!isset($GLOBALS['adverts']))
			$GLOBALS['adverts'] = new adverts();

		// Table object (users)
		if (!isset($GLOBALS['users']))
			$GLOBALS['users'] = new users();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'edit');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'media');

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
		global $EXPORT, $media;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EXPORT)) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . $EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($media);
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
					if ($pageName == "mediaview.php")
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
			$key .= @$ar['mediaId'];
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
			$this->mediaId->Visible = FALSE;
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
					$this->terminate(GetUrl("medialist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->mediaId->setVisibility();
		$this->advId->setVisibility();
		$this->filename->setVisibility();
		$this->_thumbnail->setVisibility();
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
		$this->setupLookupOptions($this->advId);

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
			if ($CurrentForm->hasValue("x_mediaId")) {
				$this->mediaId->setFormValue($CurrentForm->getValue("x_mediaId"));
			}
		} else {
			$this->CurrentAction = "show"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (Get("mediaId") !== NULL) {
				$this->mediaId->setQueryStringValue(Get("mediaId"));
				$loadByQuery = TRUE;
			} else {
				$this->mediaId->CurrentValue = NULL;
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
					$this->terminate("medialist.php"); // No matching record, return to list
				}
				break;
			case "update": // Update
				$returnUrl = $this->getReturnUrl();
				if (GetPageName($returnUrl) == "medialist.php")
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
		$this->filename->Upload->Index = $CurrentForm->Index;
		$this->filename->Upload->uploadFile();
		$this->filename->CurrentValue = $this->filename->Upload->FileName;
		$this->_thumbnail->Upload->Index = $CurrentForm->Index;
		$this->_thumbnail->Upload->uploadFile();
		$this->_thumbnail->CurrentValue = $this->_thumbnail->Upload->FileName;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;
		$this->getUploadFiles(); // Get upload files

		// Check field name 'mediaId' first before field var 'x_mediaId'
		$val = $CurrentForm->hasValue("mediaId") ? $CurrentForm->getValue("mediaId") : $CurrentForm->getValue("x_mediaId");
		if (!$this->mediaId->IsDetailKey)
			$this->mediaId->setFormValue($val);

		// Check field name 'advId' first before field var 'x_advId'
		$val = $CurrentForm->hasValue("advId") ? $CurrentForm->getValue("advId") : $CurrentForm->getValue("x_advId");
		if (!$this->advId->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->advId->Visible = FALSE; // Disable update for API request
			else
				$this->advId->setFormValue($val);
		}
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->mediaId->CurrentValue = $this->mediaId->FormValue;
		$this->advId->CurrentValue = $this->advId->FormValue;
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
		$this->mediaId->setDbValue($row['mediaId']);
		$this->advId->setDbValue($row['advId']);
		$this->filename->Upload->DbValue = $row['filename'];
		$this->filename->setDbValue($this->filename->Upload->DbValue);
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->_thumbnail->setDbValue($this->_thumbnail->Upload->DbValue);
	}

	// Return a row with default values
	protected function newRow()
	{
		$row = [];
		$row['mediaId'] = NULL;
		$row['advId'] = NULL;
		$row['filename'] = NULL;
		$row['thumbnail'] = NULL;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("mediaId")) <> "")
			$this->mediaId->CurrentValue = $this->getKey("mediaId"); // mediaId
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
		// mediaId
		// advId
		// filename
		// thumbnail

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// mediaId
			$this->mediaId->ViewValue = $this->mediaId->CurrentValue;
			$this->mediaId->ViewCustomAttributes = "";

			// advId
			$this->advId->ViewValue = $this->advId->CurrentValue;
			$curVal = strval($this->advId->CurrentValue);
			if ($curVal <> "") {
				$this->advId->ViewValue = $this->advId->lookupCacheOption($curVal);
				if ($this->advId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`advId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->advId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->advId->ViewValue = $this->advId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->advId->ViewValue = $this->advId->CurrentValue;
					}
				}
			} else {
				$this->advId->ViewValue = NULL;
			}
			$this->advId->ViewCustomAttributes = "";

			// filename
			$this->filename->UploadPath = "../media";
			if (!EmptyValue($this->filename->Upload->DbValue)) {
				$this->filename->ImageWidth = 100;
				$this->filename->ImageHeight = 0;
				$this->filename->ImageAlt = $this->filename->alt();
				$this->filename->ViewValue = $this->filename->Upload->DbValue;
			} else {
				$this->filename->ViewValue = "";
			}
			$this->filename->ViewCustomAttributes = "";

			// thumbnail
			$this->_thumbnail->UploadPath = "../media";
			if (!EmptyValue($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->ImageAlt = $this->_thumbnail->alt();
				$this->_thumbnail->ViewValue = $this->_thumbnail->Upload->DbValue;
			} else {
				$this->_thumbnail->ViewValue = "";
			}
			$this->_thumbnail->ViewCustomAttributes = "";

			// mediaId
			$this->mediaId->LinkCustomAttributes = "";
			$this->mediaId->HrefValue = "";
			$this->mediaId->TooltipValue = "";

			// advId
			$this->advId->LinkCustomAttributes = "";
			$this->advId->HrefValue = "";
			$this->advId->TooltipValue = "";

			// filename
			$this->filename->LinkCustomAttributes = "";
			$this->filename->UploadPath = "../media";
			if (!EmptyValue($this->filename->Upload->DbValue)) {
				$this->filename->HrefValue = "%u"; // Add prefix/suffix
				$this->filename->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->filename->HrefValue = FullUrl($this->filename->HrefValue, "href");
			} else {
				$this->filename->HrefValue = "";
			}
			$this->filename->ExportHrefValue = $this->filename->UploadPath . $this->filename->Upload->DbValue;
			$this->filename->TooltipValue = "";
			if ($this->filename->UseColorbox) {
				if (EmptyValue($this->filename->TooltipValue))
					$this->filename->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
				$this->filename->LinkAttrs["data-rel"] = "media_x_filename";
				AppendClass($this->filename->LinkAttrs["class"], "ew-lightbox");
			}

			// thumbnail
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = "../media";
			if (!EmptyValue($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->HrefValue = GetFileUploadUrl($this->_thumbnail, $this->_thumbnail->Upload->DbValue); // Add prefix/suffix
				$this->_thumbnail->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->_thumbnail->HrefValue = FullUrl($this->_thumbnail->HrefValue, "href");
			} else {
				$this->_thumbnail->HrefValue = "";
			}
			$this->_thumbnail->ExportHrefValue = $this->_thumbnail->UploadPath . $this->_thumbnail->Upload->DbValue;
			$this->_thumbnail->TooltipValue = "";
			if ($this->_thumbnail->UseColorbox) {
				if (EmptyValue($this->_thumbnail->TooltipValue))
					$this->_thumbnail->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
				$this->_thumbnail->LinkAttrs["data-rel"] = "media_x__thumbnail";
				AppendClass($this->_thumbnail->LinkAttrs["class"], "ew-lightbox");
			}
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// mediaId
			$this->mediaId->EditAttrs["class"] = "form-control";
			$this->mediaId->EditCustomAttributes = "";
			$this->mediaId->EditValue = $this->mediaId->CurrentValue;
			$this->mediaId->ViewCustomAttributes = "";

			// advId
			$this->advId->EditAttrs["class"] = "form-control";
			$this->advId->EditCustomAttributes = "";
			if ($this->advId->getSessionValue() <> "") {
				$this->advId->CurrentValue = $this->advId->getSessionValue();
			$this->advId->ViewValue = $this->advId->CurrentValue;
			$curVal = strval($this->advId->CurrentValue);
			if ($curVal <> "") {
				$this->advId->ViewValue = $this->advId->lookupCacheOption($curVal);
				if ($this->advId->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`advId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->advId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->advId->ViewValue = $this->advId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->advId->ViewValue = $this->advId->CurrentValue;
					}
				}
			} else {
				$this->advId->ViewValue = NULL;
			}
			$this->advId->ViewCustomAttributes = "";
			} else {
			$this->advId->EditValue = HtmlEncode($this->advId->CurrentValue);
			$curVal = strval($this->advId->CurrentValue);
			if ($curVal <> "") {
				$this->advId->EditValue = $this->advId->lookupCacheOption($curVal);
				if ($this->advId->EditValue === NULL) { // Lookup from database
					$filterWrk = "`advId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->advId->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$this->advId->EditValue = $this->advId->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->advId->EditValue = HtmlEncode($this->advId->CurrentValue);
					}
				}
			} else {
				$this->advId->EditValue = NULL;
			}
			$this->advId->PlaceHolder = RemoveHtml($this->advId->caption());
			}

			// filename
			$this->filename->EditAttrs["class"] = "form-control";
			$this->filename->EditCustomAttributes = "";
			$this->filename->UploadPath = "../media";
			if (!EmptyValue($this->filename->Upload->DbValue)) {
				$this->filename->ImageWidth = 100;
				$this->filename->ImageHeight = 0;
				$this->filename->ImageAlt = $this->filename->alt();
				$this->filename->EditValue = $this->filename->Upload->DbValue;
			} else {
				$this->filename->EditValue = "";
			}
			if (!EmptyValue($this->filename->CurrentValue))
					$this->filename->Upload->FileName = $this->filename->CurrentValue;
			if ($this->isShow() && !$this->EventCancelled)
				RenderUploadField($this->filename);

			// thumbnail
			$this->_thumbnail->EditAttrs["class"] = "form-control";
			$this->_thumbnail->EditCustomAttributes = "";
			$this->_thumbnail->UploadPath = "../media";
			if (!EmptyValue($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->ImageAlt = $this->_thumbnail->alt();
				$this->_thumbnail->EditValue = $this->_thumbnail->Upload->DbValue;
			} else {
				$this->_thumbnail->EditValue = "";
			}
			if (!EmptyValue($this->_thumbnail->CurrentValue))
					$this->_thumbnail->Upload->FileName = $this->_thumbnail->CurrentValue;
			if ($this->isShow() && !$this->EventCancelled)
				RenderUploadField($this->_thumbnail);

			// Edit refer script
			// mediaId

			$this->mediaId->LinkCustomAttributes = "";
			$this->mediaId->HrefValue = "";

			// advId
			$this->advId->LinkCustomAttributes = "";
			$this->advId->HrefValue = "";

			// filename
			$this->filename->LinkCustomAttributes = "";
			$this->filename->UploadPath = "../media";
			if (!EmptyValue($this->filename->Upload->DbValue)) {
				$this->filename->HrefValue = "%u"; // Add prefix/suffix
				$this->filename->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->filename->HrefValue = FullUrl($this->filename->HrefValue, "href");
			} else {
				$this->filename->HrefValue = "";
			}
			$this->filename->ExportHrefValue = $this->filename->UploadPath . $this->filename->Upload->DbValue;

			// thumbnail
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = "../media";
			if (!EmptyValue($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->HrefValue = GetFileUploadUrl($this->_thumbnail, $this->_thumbnail->Upload->DbValue); // Add prefix/suffix
				$this->_thumbnail->LinkAttrs["target"] = ""; // Add target
				if ($this->isExport()) $this->_thumbnail->HrefValue = FullUrl($this->_thumbnail->HrefValue, "href");
			} else {
				$this->_thumbnail->HrefValue = "";
			}
			$this->_thumbnail->ExportHrefValue = $this->_thumbnail->UploadPath . $this->_thumbnail->Upload->DbValue;
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
		if ($this->mediaId->Required) {
			if (!$this->mediaId->IsDetailKey && $this->mediaId->FormValue != NULL && $this->mediaId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->mediaId->caption(), $this->mediaId->RequiredErrorMessage));
			}
		}
		if ($this->advId->Required) {
			if (!$this->advId->IsDetailKey && $this->advId->FormValue != NULL && $this->advId->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->advId->caption(), $this->advId->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->advId->FormValue)) {
			AddMessage($FormError, $this->advId->errorMessage());
		}
		if ($this->filename->Required) {
			if ($this->filename->Upload->FileName == "" && !$this->filename->Upload->KeepFile) {
				AddMessage($FormError, str_replace("%s", $this->filename->caption(), $this->filename->RequiredErrorMessage));
			}
		}
		if ($this->_thumbnail->Required) {
			if ($this->_thumbnail->Upload->FileName == "" && !$this->_thumbnail->Upload->KeepFile) {
				AddMessage($FormError, str_replace("%s", $this->_thumbnail->caption(), $this->_thumbnail->RequiredErrorMessage));
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
			$this->filename->OldUploadPath = "../media";
			$this->filename->UploadPath = $this->filename->OldUploadPath;
			$this->_thumbnail->OldUploadPath = "../media";
			$this->_thumbnail->UploadPath = $this->_thumbnail->OldUploadPath;
			$rsnew = [];

			// advId
			$this->advId->setDbValueDef($rsnew, $this->advId->CurrentValue, 0, $this->advId->ReadOnly);

			// filename
			if ($this->filename->Visible && !$this->filename->ReadOnly && !$this->filename->Upload->KeepFile) {
				$this->filename->Upload->DbValue = $rsold['filename']; // Get original value
				if ($this->filename->Upload->FileName == "") {
					$rsnew['filename'] = NULL;
				} else {
					$rsnew['filename'] = $this->filename->Upload->FileName;
				}
			}

			// thumbnail
			if ($this->_thumbnail->Visible && !$this->_thumbnail->ReadOnly && !$this->_thumbnail->Upload->KeepFile) {
				$this->_thumbnail->Upload->DbValue = $rsold['thumbnail']; // Get original value
				if ($this->_thumbnail->Upload->FileName == "") {
					$rsnew['thumbnail'] = NULL;
				} else {
					$rsnew['thumbnail'] = $this->_thumbnail->Upload->FileName;
				}
			}

			// Check referential integrity for master table 'adverts'
			$validMasterRecord = TRUE;
			$masterFilter = $this->sqlMasterFilter_adverts();
			$keyValue = isset($rsnew['advId']) ? $rsnew['advId'] : $rsold['advId'];
			if (strval($keyValue) <> "") {
				$masterFilter = str_replace("@advId@", AdjustSql($keyValue), $masterFilter);
			} else {
				$validMasterRecord = FALSE;
			}
			if ($validMasterRecord) {
				if (!isset($GLOBALS["adverts"]))
					$GLOBALS["adverts"] = new adverts();
				$rsmaster = $GLOBALS["adverts"]->loadRs($masterFilter);
				$validMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->close();
			}
			if (!$validMasterRecord) {
				$relatedRecordMsg = str_replace("%t", "adverts", $Language->phrase("RelatedRecordRequired"));
				$this->setFailureMessage($relatedRecordMsg);
				$rs->close();
				return FALSE;
			}
			if ($this->filename->Visible && !$this->filename->Upload->KeepFile) {
				$this->filename->UploadPath = "../media";
				$oldFiles = EmptyValue($this->filename->Upload->DbValue) ? array() : explode(MULTIPLE_UPLOAD_SEPARATOR, strval($this->filename->Upload->DbValue));
				if (!EmptyValue($this->filename->Upload->FileName)) {
					$newFiles = explode(MULTIPLE_UPLOAD_SEPARATOR, strval($this->filename->Upload->FileName));
					$NewFileCount = count($newFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						if ($newFiles[$i] <> "") {
							$file = $newFiles[$i];
							if (file_exists(UploadTempPath($this->filename, $this->filename->Upload->Index) . $file)) {
								if (DELETE_UPLOADED_FILES) {
									$oldFileFound = FALSE;
									$oldFileCount = count($oldFiles);
									for ($j = 0; $j < $oldFileCount; $j++) {
										$oldFile = $oldFiles[$j];
										if ($oldFile == $file) { // Old file found, no need to delete anymore
											unset($oldFiles[$j]);
											$oldFileFound = TRUE;
											break;
										}
									}
									if ($oldFileFound) // No need to check if file exists further
										continue;
								}
								$file1 = UniqueFilename($this->filename->physicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(UploadTempPath($this->filename, $this->filename->Upload->Index) . $file1) || file_exists($this->filename->physicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = UniqueFilename($this->filename->physicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(UploadTempPath($this->filename, $this->filename->Upload->Index) . $file, UploadTempPath($this->filename, $this->filename->Upload->Index) . $file1);
									$newFiles[$i] = $file1;
								}
							}
						}
					}
					$this->filename->Upload->DbValue = empty($oldFiles) ? "" : implode(MULTIPLE_UPLOAD_SEPARATOR, $oldFiles);
					$this->filename->Upload->FileName = implode(MULTIPLE_UPLOAD_SEPARATOR, $newFiles);
					$this->filename->setDbValueDef($rsnew, $this->filename->Upload->FileName, "", $this->filename->ReadOnly);
				}
			}
			if ($this->_thumbnail->Visible && !$this->_thumbnail->Upload->KeepFile) {
				$this->_thumbnail->UploadPath = "../media";
				$oldFiles = EmptyValue($this->_thumbnail->Upload->DbValue) ? array() : array($this->_thumbnail->Upload->DbValue);
				if (!EmptyValue($this->_thumbnail->Upload->FileName)) {
					$newFiles = array($this->_thumbnail->Upload->FileName);
					$NewFileCount = count($newFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						if ($newFiles[$i] <> "") {
							$file = $newFiles[$i];
							if (file_exists(UploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index) . $file)) {
								if (DELETE_UPLOADED_FILES) {
									$oldFileFound = FALSE;
									$oldFileCount = count($oldFiles);
									for ($j = 0; $j < $oldFileCount; $j++) {
										$oldFile = $oldFiles[$j];
										if ($oldFile == $file) { // Old file found, no need to delete anymore
											unset($oldFiles[$j]);
											$oldFileFound = TRUE;
											break;
										}
									}
									if ($oldFileFound) // No need to check if file exists further
										continue;
								}
								$file1 = UniqueFilename($this->_thumbnail->physicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(UploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index) . $file1) || file_exists($this->_thumbnail->physicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = UniqueFilename($this->_thumbnail->physicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(UploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index) . $file, UploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index) . $file1);
									$newFiles[$i] = $file1;
								}
							}
						}
					}
					$this->_thumbnail->Upload->DbValue = empty($oldFiles) ? "" : implode(MULTIPLE_UPLOAD_SEPARATOR, $oldFiles);
					$this->_thumbnail->Upload->FileName = implode(MULTIPLE_UPLOAD_SEPARATOR, $newFiles);
					$this->_thumbnail->setDbValueDef($rsnew, $this->_thumbnail->Upload->FileName, NULL, $this->_thumbnail->ReadOnly);
				}
			}

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
					if ($this->filename->Visible && !$this->filename->Upload->KeepFile) {
						$oldFiles = EmptyValue($this->filename->Upload->DbValue) ? array() : explode(MULTIPLE_UPLOAD_SEPARATOR, strval($this->filename->Upload->DbValue));
						if (!EmptyValue($this->filename->Upload->FileName)) {
							$newFiles = explode(MULTIPLE_UPLOAD_SEPARATOR, $this->filename->Upload->FileName);
							$newFiles2 = explode(MULTIPLE_UPLOAD_SEPARATOR, $rsnew['filename']);
							$newFileCount = count($newFiles);
							for ($i = 0; $i < $newFileCount; $i++) {
								if ($newFiles[$i] <> "") {
									$file = UploadTempPath($this->filename, $this->filename->Upload->Index) . $newFiles[$i];
									if (file_exists($file)) {
										if (@$newFiles2[$i] <> "") // Use correct file name
											$newFiles[$i] = $newFiles2[$i];
										if (!$this->filename->Upload->saveToFile($newFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$newFiles = array();
						}
						if (DELETE_UPLOADED_FILES) {
							foreach ($oldFiles as $oldFile) {
								if ($oldFile <> "" && !in_array($oldFile, $newFiles))
									@unlink($this->filename->oldPhysicalUploadPath() . $oldFile);
							}
						}
					}
					if ($this->_thumbnail->Visible && !$this->_thumbnail->Upload->KeepFile) {
						$oldFiles = EmptyValue($this->_thumbnail->Upload->DbValue) ? array() : array($this->_thumbnail->Upload->DbValue);
						if (!EmptyValue($this->_thumbnail->Upload->FileName)) {
							$newFiles = array($this->_thumbnail->Upload->FileName);
							$newFiles2 = array($rsnew['thumbnail']);
							$newFileCount = count($newFiles);
							for ($i = 0; $i < $newFileCount; $i++) {
								if ($newFiles[$i] <> "") {
									$file = UploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index) . $newFiles[$i];
									if (file_exists($file)) {
										if (@$newFiles2[$i] <> "") // Use correct file name
											$newFiles[$i] = $newFiles2[$i];
										if (!$this->_thumbnail->Upload->saveToFile($newFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$newFiles = array();
						}
						if (DELETE_UPLOADED_FILES) {
							foreach ($oldFiles as $oldFile) {
								if ($oldFile <> "" && !in_array($oldFile, $newFiles))
									@unlink($this->_thumbnail->oldPhysicalUploadPath() . $oldFile);
							}
						}
					}
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

		// filename
		if ($this->filename->Upload->FileToken <> "")
			CleanUploadTempPath($this->filename->Upload->FileToken, $this->filename->Upload->Index);
		else
			CleanUploadTempPath($this->filename, $this->filename->Upload->Index);

		// thumbnail
		if ($this->_thumbnail->Upload->FileToken <> "")
			CleanUploadTempPath($this->_thumbnail->Upload->FileToken, $this->_thumbnail->Upload->Index);
		else
			CleanUploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index);

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
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
			if ($masterTblVar == "adverts") {
				$validMaster = TRUE;
				if (Get("fk_advId") !== NULL) {
					$GLOBALS["adverts"]->advId->setQueryStringValue(Get("fk_advId"));
					$this->advId->setQueryStringValue($GLOBALS["adverts"]->advId->QueryStringValue);
					$this->advId->setSessionValue($this->advId->QueryStringValue);
					if (!is_numeric($GLOBALS["adverts"]->advId->QueryStringValue))
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
			if ($masterTblVar == "adverts") {
				$validMaster = TRUE;
				if (Post("fk_advId") !== NULL) {
					$GLOBALS["adverts"]->advId->setFormValue(Post("fk_advId"));
					$this->advId->setFormValue($GLOBALS["adverts"]->advId->FormValue);
					$this->advId->setSessionValue($this->advId->FormValue);
					if (!is_numeric($GLOBALS["adverts"]->advId->FormValue))
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
			if ($masterTblVar <> "adverts") {
				if ($this->advId->CurrentValue == "")
					$this->advId->setSessionValue("");
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
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("medialist.php"), "", $this->TableVar, TRUE);
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
						case "x_advId":
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
