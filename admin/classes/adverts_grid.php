<?php
namespace PHPMaker2019\tabelo_admin;

/**
 * Page class
 */
class adverts_grid extends adverts
{

	// Page ID
	public $PageID = "grid";

	// Project ID
	public $ProjectID = "{69E18FAC-2EFC-47EE-A765-B17249FAF990}";

	// Table name
	public $TableName = 'adverts';

	// Page object name
	public $PageObjName = "adverts_grid";

	// Grid form hidden field names
	public $FormName = "fadvertsgrid";
	public $FormActionName = "k_action";
	public $FormKeyName = "k_key";
	public $FormOldKeyName = "k_oldkey";
	public $FormBlankRowName = "k_blankrow";
	public $FormKeyCountName = "key_count";

	// Page URLs
	public $AddUrl;
	public $EditUrl;
	public $CopyUrl;
	public $DeleteUrl;
	public $ViewUrl;
	public $ListUrl;

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
		$this->FormActionName .= "_" . $this->FormName;
		$this->FormKeyName .= "_" . $this->FormName;
		$this->FormOldKeyName .= "_" . $this->FormName;
		$this->FormBlankRowName .= "_" . $this->FormName;
		$this->FormKeyCountName .= "_" . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (adverts)
		if (!isset($GLOBALS["adverts"]) || get_class($GLOBALS["adverts"]) == PROJECT_NAMESPACE . "adverts") {
			$GLOBALS["adverts"] = &$this;

			// $GLOBALS["MasterTable"] = &$GLOBALS["Table"];
			// if (!isset($GLOBALS["Table"]))
			// 	$GLOBALS["Table"] = &$GLOBALS["adverts"];

		}
		$this->AddUrl = "advertsadd.php";

		// Table object (userprofiles)
		if (!isset($GLOBALS['userprofiles']))
			$GLOBALS['userprofiles'] = new userprofiles();

		// Table object (users)
		if (!isset($GLOBALS['users']))
			$GLOBALS['users'] = new users();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'grid');

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

		// List options
		$this->ListOptions = new ListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		if (!$this->OtherOptions)
			$this->OtherOptions = new ListOptionsArray();
		$this->OtherOptions["addedit"] = new ListOptions();
		$this->OtherOptions["addedit"]->Tag = "div";
		$this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url === "")
			return;
		if (!IsApi())
			$this->Page_Redirecting($url);

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

	// Class variables
	public $ListOptions; // List options
	public $ExportOptions; // Export options
	public $SearchOptions; // Search options
	public $OtherOptions; // Other options
	public $FilterOptions; // Filter options
	public $ImportOptions; // Import options
	public $ListActions; // List actions
	public $SelectedCount = 0;
	public $SelectedIndex = 0;
	public $ShowOtherOptions = FALSE;
	public $DisplayRecs = 20;
	public $StartRec;
	public $StopRec;
	public $TotalRecs = 0;
	public $RecRange = 10;
	public $Pager;
	public $AutoHidePager = AUTO_HIDE_PAGER;
	public $AutoHidePageSizeSelector = AUTO_HIDE_PAGE_SIZE_SELECTOR;
	public $DefaultSearchWhere = ""; // Default search WHERE clause
	public $SearchWhere = ""; // Search WHERE clause
	public $RecCnt = 0; // Record count
	public $EditRowCnt;
	public $StartRowCnt = 1;
	public $RowCnt = 0;
	public $Attrs = array(); // Row attributes and cell attributes
	public $RowIndex = 0; // Row index
	public $KeyCount = 0; // Key count
	public $RowAction = ""; // Row action
	public $RowOldKey = ""; // Row old key (for copy)
	public $MultiColumnClass = "col-sm";
	public $MultiColumnEditClass = "w-100";
	public $DbMasterFilter = ""; // Master filter
	public $DbDetailFilter = ""; // Detail filter
	public $MasterRecordExists;
	public $MultiSelectKey;
	public $Command;
	public $RestoreSearch = FALSE;
	public $DetailPages;
	public $OldRecordset;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm,
			$FormError, $SearchError, $EXPORT;

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
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canList()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				$this->terminate(GetUrl("index.php"));
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

		// Get grid add count
		$gridaddcnt = Get(TABLE_GRID_ADD_ROW_COUNT, "");
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->setupListOptions();
		$this->advId->Visible = FALSE;
		$this->_userId->setVisibility();
		$this->title->setVisibility();
		$this->description->setVisibility();
		$this->categoryId->setVisibility();
		$this->locationId->setVisibility();
		$this->validity->Visible = FALSE;
		$this->contactPerson->Visible = FALSE;
		$this->contactNumber->Visible = FALSE;
		$this->date->setVisibility();
		$this->cost->setVisibility();
		$this->hideFieldsForAddEdit();

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

		// Set up master detail parameters
		$this->setupMasterParms();

		// Setup other options
		$this->setupOtherOptions();

		// Set up lookup cache
		$this->setupLookupOptions($this->_userId);
		$this->setupLookupOptions($this->categoryId);
		$this->setupLookupOptions($this->locationId);

		// Search filters
		$srchAdvanced = ""; // Advanced search filter
		$srchBasic = ""; // Basic search filter
		$filter = "";

		// Get command
		$this->Command = strtolower(Get("cmd"));
		if ($this->isPageRequest()) { // Validate request

			// Handle reset command
			$this->resetCmd();

			// Hide list options
			if ($this->isExport()) {
				$this->ListOptions->hideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->isGridAdd() || $this->isGridEdit()) {
				$this->ListOptions->hideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->isGridAdd() || $this->isGridEdit()) {
					$item = &$this->ListOptions->getItem("griddelete");
					if ($item)
						$item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->setupSortOrder();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->loadSortOrder();

		// Build filter
		$filter = "";
		if (!$Security->canList())
			$filter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter

		// Add master User ID filter
		if ($Security->currentUserID() <> "" && !$Security->isAdmin()) { // Non system admin
			if ($this->getCurrentMasterTable() == "categories")
				$this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "categories"); // Add master User ID filter
			if ($this->getCurrentMasterTable() == "locations")
				$this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "locations"); // Add master User ID filter
			if ($this->getCurrentMasterTable() == "users")
				$this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "users"); // Add master User ID filter
		}
		AddFilter($filter, $this->DbDetailFilter);
		AddFilter($filter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->getMasterFilter() <> "" && $this->getCurrentMasterTable() == "categories") {
			global $categories;
			$rsmaster = $categories->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("categorieslist.php"); // Return to master page
			} else {
				$categories->loadListRowValues($rsmaster);
				$categories->RowType = ROWTYPE_MASTER; // Master row
				$categories->renderListRow();
				$rsmaster->close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->getMasterFilter() <> "" && $this->getCurrentMasterTable() == "locations") {
			global $locations;
			$rsmaster = $locations->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("locationslist.php"); // Return to master page
			} else {
				$locations->loadListRowValues($rsmaster);
				$locations->RowType = ROWTYPE_MASTER; // Master row
				$locations->renderListRow();
				$rsmaster->close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->getMasterFilter() <> "" && $this->getCurrentMasterTable() == "users") {
			global $users;
			$rsmaster = $users->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("userslist.php"); // Return to master page
			} else {
				$users->loadListRowValues($rsmaster);
				$users->RowType = ROWTYPE_MASTER; // Master row
				$users->renderListRow();
				$rsmaster->close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSql = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $filter;
		} else {
			$this->setSessionWhere($filter);
			$this->CurrentFilter = "";
		}
		if ($this->isGridAdd()) {
			if ($this->CurrentMode == "copy") {
				$selectLimit = $this->UseSelectLimit;
				if ($selectLimit) {
					$this->TotalRecs = $this->listRecordCount();
					$this->Recordset = $this->loadRecordset($this->StartRec - 1, $this->DisplayRecs);
				} else {
					if ($this->Recordset = $this->loadRecordset())
						$this->TotalRecs = $this->Recordset->RecordCount();
				}
				$this->StartRec = 1;
				$this->DisplayRecs = $this->TotalRecs;
			} else {
				$this->CurrentFilter = "0=1";
				$this->StartRec = 1;
				$this->DisplayRecs = $this->GridAddRowCount;
			}
			$this->TotalRecs = $this->DisplayRecs;
			$this->StopRec = $this->DisplayRecs;
		} else {
			$selectLimit = $this->UseSelectLimit;
			if ($selectLimit) {
				$this->TotalRecs = $this->listRecordCount();
			} else {
				if ($this->Recordset = $this->loadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
			$this->StartRec = 1;
			$this->DisplayRecs = $this->TotalRecs; // Display all records
			if ($selectLimit)
				$this->Recordset = $this->loadRecordset($this->StartRec - 1, $this->DisplayRecs);

			// Set no record found message
			if (!$this->CurrentAction && $this->TotalRecs == 0) {
				if (!$Security->canList())
					$this->setWarningMessage(DeniedMessage());
				if ($this->SearchWhere == "0=101")
					$this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
				else
					$this->setWarningMessage($Language->phrase("NoRecord"));
			}
		}

		// Normal return
		if (IsApi()) {
			$rows = $this->getRecordsFromRecordset($this->Recordset);
			$this->Recordset->close();
			WriteJson(["success" => TRUE, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecs]);
			$this->terminate(TRUE);
		}
	}

	// Exit inline mode
	protected function clearInlineMode()
	{
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	protected function gridAddMode()
	{
		$this->CurrentAction = "gridadd";
		$_SESSION[SESSION_INLINE_MODE] = "gridadd";
		$this->hideFieldsForAddEdit();
	}

	// Switch to Grid Edit mode
	protected function gridEditMode()
	{
		$this->CurrentAction = "gridedit";
		$_SESSION[SESSION_INLINE_MODE] = "gridedit";
		$this->hideFieldsForAddEdit();
	}

	// Perform update to grid
	public function gridUpdate()
	{
		global $Language, $CurrentForm, $FormError;
		$gridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->buildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sql = $this->getCurrentSql();
		$conn = &$this->getConnection();
		if ($rs = $conn->execute($sql)) {
			$rsold = $rs->getRows();
			$rs->close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}
		$key = "";

		// Update row index and get row key
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$CurrentForm->Index = $rowindex;
			$rowkey = strval($CurrentForm->getValue($this->FormKeyName));
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->loadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$gridUpdate = $this->setupKeyValues($rowkey); // Set up key values
				} else {
					$gridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->emptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($gridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->getRecordFilter();
						$gridUpdate = $this->deleteRows(); // Delete this row
					} else if (!$this->validateForm()) {
						$gridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($FormError);
					} else {
						if ($rowaction == "insert") {
							$gridUpdate = $this->addRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$gridUpdate = $this->editRow(); // Update this row
							}
						} // End update
					}
				}
				if ($gridUpdate) {
					if ($key <> "")
						$key .= ", ";
					$key .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($gridUpdate) {

			// Get new recordset
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->clearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
		}
		return $gridUpdate;
	}

	// Build filter for all keys
	protected function buildKeyFilter()
	{
		global $CurrentForm;
		$wrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$CurrentForm->Index = $rowindex;
		$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		while ($thisKey <> "") {
			if ($this->setupKeyValues($thisKey)) {
				$filter = $this->getRecordFilter();
				if ($wrkFilter <> "")
					$wrkFilter .= " OR ";
				$wrkFilter .= $filter;
			} else {
				$wrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$CurrentForm->Index = $rowindex;
			$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		}
		return $wrkFilter;
	}

	// Set up key values
	protected function setupKeyValues($key)
	{
		$arKeyFlds = explode($GLOBALS["COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arKeyFlds) >= 1) {
			$this->advId->setFormValue($arKeyFlds[0]);
			if (!is_numeric($this->advId->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	public function gridInsert()
	{
		global $Language, $CurrentForm, $FormError;
		$rowindex = 1;
		$gridInsert = FALSE;
		$conn = &$this->getConnection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
			return FALSE;
		}

		// Init key filter
		$wrkfilter = "";
		$addcnt = 0;
		$key = "";

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
				$this->loadOldRecord(); // Load old record
			}
			$this->loadFormValues(); // Get form values
			if (!$this->emptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->validateForm()) {
					$gridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($FormError);
				} else {
					$gridInsert = $this->addRow($this->OldRecordset); // Insert this row
				}
				if ($gridInsert) {
					if ($key <> "")
						$key .= $GLOBALS["COMPOSITE_KEY_SEPARATOR"];
					$key .= $this->advId->CurrentValue;

					// Add filter for this record
					$filter = $this->getRecordFilter();
					if ($wrkfilter <> "")
						$wrkfilter .= " OR ";
					$wrkfilter .= $filter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->clearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($gridInsert) {

			// Get new recordset
			$this->CurrentFilter = $wrkfilter;
			$sql = $this->getCurrentSql();
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->clearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
		}
		return $gridInsert;
	}

	// Check if empty row
	public function emptyRow()
	{
		global $CurrentForm;
		if ($CurrentForm->hasValue("x__userId") && $CurrentForm->hasValue("o__userId") && $this->_userId->CurrentValue <> $this->_userId->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_title") && $CurrentForm->hasValue("o_title") && $this->title->CurrentValue <> $this->title->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_description") && $CurrentForm->hasValue("o_description") && $this->description->CurrentValue <> $this->description->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_categoryId") && $CurrentForm->hasValue("o_categoryId") && $this->categoryId->CurrentValue <> $this->categoryId->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_locationId") && $CurrentForm->hasValue("o_locationId") && $this->locationId->CurrentValue <> $this->locationId->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_date") && $CurrentForm->hasValue("o_date") && $this->date->CurrentValue <> $this->date->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_cost") && $CurrentForm->hasValue("o_cost") && $this->cost->CurrentValue <> $this->cost->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	public function validateGridForm()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else if (!$this->validateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	public function getGridFormValues()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->getFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	public function restoreCurrentRowFormValues($idx)
	{
		global $CurrentForm;

		// Get row based on current index
		$CurrentForm->Index = $idx;
		$this->loadFormValues(); // Load form values
	}

	// Set up sort parameters
	protected function setupSortOrder()
	{

		// Check for "order" parameter
		if (Get("order") !== NULL) {
			$this->CurrentOrder = Get("order");
			$this->CurrentOrderType = Get("ordertype", "");
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	protected function loadSortOrder()
	{
		$orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($orderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$orderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($orderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)

	protected function resetCmd()
	{

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->categoryId->setSessionValue("");
				$this->locationId->setSessionValue("");
				$this->_userId->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$orderBy = "";
				$this->setSessionOrderBy($orderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	protected function setupListOptions()
	{
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canAdd();
		$item->OnLeft = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;

		//$this->ListOptions->ButtonClass = ""; // Class for button group
		// Call ListOptions_Load event

		$this->ListOptions_Load();
		$item = &$this->ListOptions->getItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->groupOptionVisible();
	}

	// Render list options
	public function renderListOptions()
	{
		global $Security, $Language, $CurrentForm;
		$this->ListOptions->loadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$CurrentForm->Index = $this->RowIndex;
			$actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$keyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
			if ($CurrentForm->hasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $CurrentForm->getValue($this->FormKeyName);
				$this->setupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$options = &$this->ListOptions;
				$options->UseButtonGroup = TRUE; // Use button group for grid delete button
				$opt = &$options->Items["griddelete"];
				if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$opt->Body = "&nbsp;";
				} else {
					$opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
				}
			}
		}
		if ($this->CurrentMode == "view") { // View mode

		// "view"
		$opt = &$this->ListOptions->Items["view"];
		$viewcaption = HtmlTitle($Language->phrase("ViewLink"));
		if ($Security->canView() && $this->showOptionLink('view')) {
			$opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode($this->ViewUrl) . "\">" . $Language->phrase("ViewLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "edit"
		$opt = &$this->ListOptions->Items["edit"];
		$editcaption = HtmlTitle($Language->phrase("EditLink"));
		if ($Security->canEdit() && $this->showOptionLink('edit')) {
			$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode($this->EditUrl) . "\">" . $Language->phrase("EditLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "copy"
		$opt = &$this->ListOptions->Items["copy"];
		$copycaption = HtmlTitle($Language->phrase("CopyLink"));
		if ($Security->canAdd() && $this->showOptionLink('add')) {
			$opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode($this->CopyUrl) . "\">" . $Language->phrase("CopyLink") . "</a>";
		} else {
			$opt->Body = "";
		}
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . $this->advId->CurrentValue . "\">";
		}
		$this->renderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set record key
	public function setRecordKey(&$key, $rs)
	{
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('advId');
	}

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;

		//$option->ButtonClass = ""; // Class for button group
		$item = &$option->add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->add("add");
			$addcaption = HtmlTitle($Language->phrase("AddLink"));
			$this->AddUrl = $this->getAddUrl();
			$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode($this->AddUrl) . "\">" . $Language->phrase("AddLink") . "</a>";
			$item->Visible = ($this->AddUrl <> "" && $Security->canAdd());
		}
	}

	// Render other options
	public function renderOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$item = &$option->add("addblankrow");
				$item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
				$item->Visible = $Security->canAdd();
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = &$options["addedit"];
			$item = &$option->getItem("add");
			$this->ShowOtherOptions = $item && $item->Visible;
		}
	}
	protected function renderListOptionsExt()
	{
		global $Security, $Language;
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

	// Load default values
	protected function loadDefaultValues()
	{
		$this->advId->CurrentValue = NULL;
		$this->advId->OldValue = $this->advId->CurrentValue;
		$this->_userId->CurrentValue = CurrentUserID();
		$this->_userId->OldValue = $this->_userId->CurrentValue;
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->description->CurrentValue = NULL;
		$this->description->OldValue = $this->description->CurrentValue;
		$this->categoryId->CurrentValue = NULL;
		$this->categoryId->OldValue = $this->categoryId->CurrentValue;
		$this->locationId->CurrentValue = NULL;
		$this->locationId->OldValue = $this->locationId->CurrentValue;
		$this->validity->CurrentValue = 60;
		$this->validity->OldValue = $this->validity->CurrentValue;
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
		$CurrentForm->FormName = $this->FormName;

		// Check field name 'userId' first before field var 'x__userId'
		$val = $CurrentForm->hasValue("userId") ? $CurrentForm->getValue("userId") : $CurrentForm->getValue("x__userId");
		if (!$this->_userId->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->_userId->Visible = FALSE; // Disable update for API request
			else
				$this->_userId->setFormValue($val);
		}
		$this->_userId->setOldValue($CurrentForm->getValue("o__userId"));

		// Check field name 'title' first before field var 'x_title'
		$val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x_title");
		if (!$this->title->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->title->Visible = FALSE; // Disable update for API request
			else
				$this->title->setFormValue($val);
		}
		$this->title->setOldValue($CurrentForm->getValue("o_title"));

		// Check field name 'description' first before field var 'x_description'
		$val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
		if (!$this->description->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->description->Visible = FALSE; // Disable update for API request
			else
				$this->description->setFormValue($val);
		}
		$this->description->setOldValue($CurrentForm->getValue("o_description"));

		// Check field name 'categoryId' first before field var 'x_categoryId'
		$val = $CurrentForm->hasValue("categoryId") ? $CurrentForm->getValue("categoryId") : $CurrentForm->getValue("x_categoryId");
		if (!$this->categoryId->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->categoryId->Visible = FALSE; // Disable update for API request
			else
				$this->categoryId->setFormValue($val);
		}
		$this->categoryId->setOldValue($CurrentForm->getValue("o_categoryId"));

		// Check field name 'locationId' first before field var 'x_locationId'
		$val = $CurrentForm->hasValue("locationId") ? $CurrentForm->getValue("locationId") : $CurrentForm->getValue("x_locationId");
		if (!$this->locationId->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->locationId->Visible = FALSE; // Disable update for API request
			else
				$this->locationId->setFormValue($val);
		}
		$this->locationId->setOldValue($CurrentForm->getValue("o_locationId"));

		// Check field name 'date' first before field var 'x_date'
		$val = $CurrentForm->hasValue("date") ? $CurrentForm->getValue("date") : $CurrentForm->getValue("x_date");
		if (!$this->date->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->date->Visible = FALSE; // Disable update for API request
			else
				$this->date->setFormValue($val);
			$this->date->CurrentValue = UnFormatDateTime($this->date->CurrentValue, 0);
		}
		$this->date->setOldValue($CurrentForm->getValue("o_date"));

		// Check field name 'cost' first before field var 'x_cost'
		$val = $CurrentForm->hasValue("cost") ? $CurrentForm->getValue("cost") : $CurrentForm->getValue("x_cost");
		if (!$this->cost->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->cost->Visible = FALSE; // Disable update for API request
			else
				$this->cost->setFormValue($val);
		}
		$this->cost->setOldValue($CurrentForm->getValue("o_cost"));

		// Check field name 'advId' first before field var 'x_advId'
		$val = $CurrentForm->hasValue("advId") ? $CurrentForm->getValue("advId") : $CurrentForm->getValue("x_advId");
		if (!$this->advId->IsDetailKey && !$this->isGridAdd() && !$this->isAdd())
			$this->advId->setFormValue($val);
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		if (!$this->isGridAdd() && !$this->isAdd())
			$this->advId->CurrentValue = $this->advId->FormValue;
		$this->_userId->CurrentValue = $this->_userId->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->categoryId->CurrentValue = $this->categoryId->FormValue;
		$this->locationId->CurrentValue = $this->locationId->FormValue;
		$this->date->CurrentValue = $this->date->FormValue;
		$this->date->CurrentValue = UnFormatDateTime($this->date->CurrentValue, 0);
		$this->cost->CurrentValue = $this->cost->FormValue;
	}

	// Load recordset
	public function loadRecordset($offset = -1, $rowcnt = -1)
	{

		// Load List page SQL
		$sql = $this->getListSql();
		$conn = &$this->getConnection();

		// Load recordset
		$dbtype = GetConnectionType($this->Dbid);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())]);
			} else {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = LoadRecordset($sql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->advId->CurrentValue = strval($arKeys[0]); // advId
			else
				$validKey = FALSE;
		} else {
			$validKey = FALSE;
		}

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
		$this->ViewUrl = $this->getViewUrl();
		$this->EditUrl = $this->getEditUrl();
		$this->CopyUrl = $this->getCopyUrl();
		$this->DeleteUrl = $this->getDeleteUrl();

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
			$this->description->ViewValue = TruncateMemo($this->description->CurrentValue, 50, $this->description->TruncateMemoRemoveHtml);
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
				$this->_userId->OldValue = $this->_userId->CurrentValue;
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
			} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("grid")) { // Non system admin
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
				$this->categoryId->OldValue = $this->categoryId->CurrentValue;
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
				$this->locationId->OldValue = $this->locationId->CurrentValue;
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

			// date
			$this->date->LinkCustomAttributes = "";
			$this->date->HrefValue = "";

			// cost
			$this->cost->LinkCustomAttributes = "";
			$this->cost->HrefValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// userId
			$this->_userId->EditAttrs["class"] = "form-control";
			$this->_userId->EditCustomAttributes = "";
			if ($this->_userId->getSessionValue() <> "") {
				$this->_userId->CurrentValue = $this->_userId->getSessionValue();
				$this->_userId->OldValue = $this->_userId->CurrentValue;
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
			} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("grid")) { // Non system admin
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
				$this->categoryId->OldValue = $this->categoryId->CurrentValue;
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
				$this->locationId->OldValue = $this->locationId->CurrentValue;
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

			// Edit refer script
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

	// Delete records based on current filter
	protected function deleteRows()
	{
		global $Language, $Security;
		if (!$Security->canDelete()) {
			$this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$deleteRows = TRUE;
		$sql = $this->getCurrentSql();
		$conn = &$this->getConnection();
		$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
			$rs->close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->getRows() : [];

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->close();

		// Call row deleting event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$deleteRows = $this->Row_Deleting($row);
				if (!$deleteRows)
					break;
			}
		}
		if ($deleteRows) {
			$key = "";
			foreach ($rsold as $row) {
				$thisKey = "";
				if ($thisKey <> "")
					$thisKey .= $GLOBALS["COMPOSITE_KEY_SEPARATOR"];
				$thisKey .= $row['advId'];
				if (DELETE_UPLOADED_FILES) // Delete old files
					$this->deleteUploadedFiles($row);
				$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
				$deleteRows = $this->delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($deleteRows === FALSE)
					break;
				if ($key <> "")
					$key .= ", ";
				$key .= $thisKey;
			}
		}
		if (!$deleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("DeleteCancelled"));
			}
		}

		// Call Row Deleted event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}

		// Write JSON for API request (Support single row only)
		if (IsApi() && $deleteRows) {
			$row = $this->getRecordsFromRecordset($rsold, TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $deleteRows;
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

			// userId
			$this->_userId->setDbValueDef($rsnew, $this->_userId->CurrentValue, 0, $this->_userId->ReadOnly);

			// title
			$this->title->setDbValueDef($rsnew, $this->title->CurrentValue, "", $this->title->ReadOnly);

			// description
			$this->description->setDbValueDef($rsnew, $this->description->CurrentValue, "", $this->description->ReadOnly);

			// categoryId
			$this->categoryId->setDbValueDef($rsnew, $this->categoryId->CurrentValue, 0, $this->categoryId->ReadOnly);

			// locationId
			$this->locationId->setDbValueDef($rsnew, $this->locationId->CurrentValue, 0, $this->locationId->ReadOnly);

			// date
			$this->date->setDbValueDef($rsnew, UnFormatDateTime($this->date->CurrentValue, 0), NULL, $this->date->ReadOnly);

			// cost
			$this->cost->setDbValueDef($rsnew, $this->cost->CurrentValue, NULL, $this->cost->ReadOnly);

			// Check referential integrity for master table 'categories'
			$validMasterRecord = TRUE;
			$masterFilter = $this->sqlMasterFilter_categories();
			$keyValue = isset($rsnew['categoryId']) ? $rsnew['categoryId'] : $rsold['categoryId'];
			if (strval($keyValue) <> "") {
				$masterFilter = str_replace("@categoryId@", AdjustSql($keyValue), $masterFilter);
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
				$rs->close();
				return FALSE;
			}

			// Check referential integrity for master table 'locations'
			$validMasterRecord = TRUE;
			$masterFilter = $this->sqlMasterFilter_locations();
			$keyValue = isset($rsnew['locationId']) ? $rsnew['locationId'] : $rsold['locationId'];
			if (strval($keyValue) <> "") {
				$masterFilter = str_replace("@locationId@", AdjustSql($keyValue), $masterFilter);
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
				$rs->close();
				return FALSE;
			}

			// Check referential integrity for master table 'users'
			$validMasterRecord = TRUE;
			$masterFilter = $this->sqlMasterFilter_users();
			$keyValue = isset($rsnew['userId']) ? $rsnew['userId'] : $rsold['userId'];
			if (strval($keyValue) <> "") {
				$masterFilter = str_replace("@ID@", AdjustSql($keyValue), $masterFilter);
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
				$rs->close();
				return FALSE;
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

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "categories") {
				$this->categoryId->CurrentValue = $this->categoryId->getSessionValue();
			}
			if ($this->getCurrentMasterTable() == "locations") {
				$this->locationId->CurrentValue = $this->locationId->getSessionValue();
			}
			if ($this->getCurrentMasterTable() == "users") {
				$this->_userId->CurrentValue = $this->_userId->getSessionValue();
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

		// Hide foreign keys
		$masterTblVar = $this->getCurrentMasterTable();
		if ($masterTblVar == "categories") {
			$this->categoryId->Visible = FALSE;
			if ($GLOBALS["categories"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		if ($masterTblVar == "locations") {
			$this->locationId->Visible = FALSE;
			if ($GLOBALS["locations"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		if ($masterTblVar == "users") {
			$this->_userId->Visible = FALSE;
			if ($GLOBALS["users"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
