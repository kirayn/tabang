<?php
namespace PHPMaker2019\tabelo_admin;

/**
 * Table class for userprofiles
 */
class userprofiles extends DbTable
{
	protected $SqlFrom = "";
	protected $SqlSelect = "";
	protected $SqlSelectList = "";
	protected $SqlWhere = "";
	protected $SqlGroupBy = "";
	protected $SqlHaving = "";
	protected $SqlOrderBy = "";
	public $UseSessionForListSql = TRUE;

	// Column CSS classes
	public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
	public $RightColumnClass = "col-sm-10";
	public $OffsetColumnClass = "col-sm-10 offset-sm-2";
	public $TableLeftColumnClass = "w-col-2";

	// Export
	public $ExportDoc;

	// Fields
	public $profileId;
	public $_userId;
	public $firstName;
	public $lastName;
	public $address;
	public $village;
	public $city;
	public $pincode;
	public $source;
	public $agent;
	public $date;
	public $status;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'userprofiles';
		$this->TableName = 'userprofiles';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`userprofiles`";
		$this->Dbid = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// profileId
		$this->profileId = new DbField('userprofiles', 'userprofiles', 'x_profileId', 'profileId', '`profileId`', '`profileId`', 3, -1, FALSE, '`profileId`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->profileId->IsAutoIncrement = TRUE; // Autoincrement field
		$this->profileId->IsPrimaryKey = TRUE; // Primary key field
		$this->profileId->Sortable = TRUE; // Allow sort
		$this->profileId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['profileId'] = &$this->profileId;

		// userId
		$this->_userId = new DbField('userprofiles', 'userprofiles', 'x__userId', 'userId', '`userId`', '`userId`', 3, -1, FALSE, '`userId`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_userId->IsForeignKey = TRUE; // Foreign key field
		$this->_userId->Nullable = FALSE; // NOT NULL field
		$this->_userId->Required = TRUE; // Required field
		$this->_userId->Sortable = TRUE; // Allow sort
		switch ($CurrentLanguage) {
			case "en":
				$this->_userId->Lookup = new Lookup('userId', 'users', FALSE, 'ID', ["mobile","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->_userId->Lookup = new Lookup('userId', 'users', FALSE, 'ID', ["mobile","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->_userId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['userId'] = &$this->_userId;

		// firstName
		$this->firstName = new DbField('userprofiles', 'userprofiles', 'x_firstName', 'firstName', '`firstName`', '`firstName`', 200, -1, FALSE, '`firstName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->firstName->Required = TRUE; // Required field
		$this->firstName->Sortable = TRUE; // Allow sort
		$this->fields['firstName'] = &$this->firstName;

		// lastName
		$this->lastName = new DbField('userprofiles', 'userprofiles', 'x_lastName', 'lastName', '`lastName`', '`lastName`', 200, -1, FALSE, '`lastName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lastName->Sortable = TRUE; // Allow sort
		$this->fields['lastName'] = &$this->lastName;

		// address
		$this->address = new DbField('userprofiles', 'userprofiles', 'x_address', 'address', '`address`', '`address`', 201, -1, FALSE, '`address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->address->Sortable = TRUE; // Allow sort
		$this->fields['address'] = &$this->address;

		// village
		$this->village = new DbField('userprofiles', 'userprofiles', 'x_village', 'village', '`village`', '`village`', 200, -1, FALSE, '`village`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->village->Sortable = TRUE; // Allow sort
		$this->fields['village'] = &$this->village;

		// city
		$this->city = new DbField('userprofiles', 'userprofiles', 'x_city', 'city', '`city`', '`city`', 200, -1, FALSE, '`city`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->city->Required = TRUE; // Required field
		$this->city->Sortable = TRUE; // Allow sort
		$this->fields['city'] = &$this->city;

		// pincode
		$this->pincode = new DbField('userprofiles', 'userprofiles', 'x_pincode', 'pincode', '`pincode`', '`pincode`', 3, -1, FALSE, '`pincode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pincode->Required = TRUE; // Required field
		$this->pincode->Sortable = TRUE; // Allow sort
		$this->pincode->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['pincode'] = &$this->pincode;

		// source
		$this->source = new DbField('userprofiles', 'userprofiles', 'x_source', 'source', '`source`', '`source`', 200, -1, FALSE, '`source`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->source->Nullable = FALSE; // NOT NULL field
		$this->source->Required = TRUE; // Required field
		$this->source->Sortable = TRUE; // Allow sort
		$this->source->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->source->PleaseSelectText = $Language->phrase("PleaseSelect"); // PleaseSelect text
		switch ($CurrentLanguage) {
			case "en":
				$this->source->Lookup = new Lookup('source', 'userprofiles', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->source->Lookup = new Lookup('source', 'userprofiles', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->source->OptionCount = 2;
		$this->fields['source'] = &$this->source;

		// agent
		$this->agent = new DbField('userprofiles', 'userprofiles', 'x_agent', 'agent', '`agent`', '`agent`', 3, -1, FALSE, '`agent`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->agent->Nullable = FALSE; // NOT NULL field
		$this->agent->Required = TRUE; // Required field
		$this->agent->Sortable = TRUE; // Allow sort
		$this->agent->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['agent'] = &$this->agent;

		// date
		$this->date = new DbField('userprofiles', 'userprofiles', 'x_date', 'date', '`date`', CastDateFieldForLike('`date`', 0, "DB"), 135, 0, FALSE, '`date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date->Required = TRUE; // Required field
		$this->date->Sortable = TRUE; // Allow sort
		$this->date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['date'] = &$this->date;

		// status
		$this->status = new DbField('userprofiles', 'userprofiles', 'x_status', 'status', '`status`', '`status`', 200, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->status->Nullable = FALSE; // NOT NULL field
		$this->status->Required = TRUE; // Required field
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // PleaseSelect text
		switch ($CurrentLanguage) {
			case "en":
				$this->status->Lookup = new Lookup('status', 'userprofiles', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->status->Lookup = new Lookup('status', 'userprofiles', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->status->OptionCount = 2;
		$this->fields['status'] = &$this->status;
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function setLeftColumnClass($class)
	{
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " col-form-label ew-label";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
			$this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
		}
	}

	// Single column sort
	public function updateSort(&$fld)
	{
		if ($this->CurrentOrder == $fld->Name) {
			$sortField = $fld->Expression;
			$lastSort = $fld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$thisSort = $this->CurrentOrderType;
			} else {
				$thisSort = ($lastSort == "ASC") ? "DESC" : "ASC";
			}
			$fld->setSort($thisSort);
			$this->setSessionOrderBy($sortField . " " . $thisSort); // Save to Session
		} else {
			$fld->setSort("");
		}
	}

	// Current master table name
	public function getCurrentMasterTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_MASTER_TABLE];
	}
	public function setCurrentMasterTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	public function getMasterFilter()
	{

		// Master filter
		$masterFilter = "";
		if ($this->getCurrentMasterTable() == "users") {
			if ($this->_userId->getSessionValue() <> "")
				$masterFilter .= "`ID`=" . QuotedValue($this->_userId->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $masterFilter;
	}

	// Session detail WHERE clause
	public function getDetailFilter()
	{

		// Detail filter
		$detailFilter = "";
		if ($this->getCurrentMasterTable() == "users") {
			if ($this->_userId->getSessionValue() <> "")
				$detailFilter .= "`userId`=" . QuotedValue($this->_userId->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $detailFilter;
	}

	// Master filter
	public function sqlMasterFilter_users()
	{
		return "`ID`=@ID@";
	}

	// Detail filter
	public function sqlDetailFilter_users()
	{
		return "`userId`=@_userId@";
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom <> "") ? $this->SqlFrom : "`userprofiles`";
	}
	public function sqlFrom() // For backward compatibility
	{
		return $this->getSqlFrom();
	}
	public function setSqlFrom($v)
	{
		$this->SqlFrom = $v;
	}
	public function getSqlSelect() // Select
	{
		return ($this->SqlSelect <> "") ? $this->SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}
	public function sqlSelect() // For backward compatibility
	{
		return $this->getSqlSelect();
	}
	public function setSqlSelect($v)
	{
		$this->SqlSelect = $v;
	}
	public function getSqlWhere() // Where
	{
		$where = ($this->SqlWhere <> "") ? $this->SqlWhere : "";
		$this->TableFilter = "";
		AddFilter($where, $this->TableFilter);
		return $where;
	}
	public function sqlWhere() // For backward compatibility
	{
		return $this->getSqlWhere();
	}
	public function setSqlWhere($v)
	{
		$this->SqlWhere = $v;
	}
	public function getSqlGroupBy() // Group By
	{
		return ($this->SqlGroupBy <> "") ? $this->SqlGroupBy : "";
	}
	public function sqlGroupBy() // For backward compatibility
	{
		return $this->getSqlGroupBy();
	}
	public function setSqlGroupBy($v)
	{
		$this->SqlGroupBy = $v;
	}
	public function getSqlHaving() // Having
	{
		return ($this->SqlHaving <> "") ? $this->SqlHaving : "";
	}
	public function sqlHaving() // For backward compatibility
	{
		return $this->getSqlHaving();
	}
	public function setSqlHaving($v)
	{
		$this->SqlHaving = $v;
	}
	public function getSqlOrderBy() // Order By
	{
		return ($this->SqlOrderBy <> "") ? $this->SqlOrderBy : "";
	}
	public function sqlOrderBy() // For backward compatibility
	{
		return $this->getSqlOrderBy();
	}
	public function setSqlOrderBy($v)
	{
		$this->SqlOrderBy = $v;
	}

	// Apply User ID filters
	public function applyUserIDFilters($filter)
	{
		global $Security;

		// Add User ID filter
		if ($Security->currentUserID() <> "" && !$Security->isAdmin()) { // Non system admin
			$filter = $this->addUserIDFilter($filter);
		}
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = $this->UserIDAllowSecurity;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	public function getSql($where, $orderBy = "")
	{
		return BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderBy);
	}

	// Table SQL
	public function getCurrentSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->getSql($filter, $sort);
	}

	// Table SQL with List page filter
	public function getListSql()
	{
		$filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->getSqlSelect();
		$sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
		return BuildSelectSql($select, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Get ORDER BY clause
	public function getOrderBy()
	{
		$sort = $this->getSessionOrderBy();
		return BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sort);
	}

	// Get record count
	public function getRecordCount($sql)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery and SELECT DISTINCT
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) && !preg_match('/^\s*select\s+distinct\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = &$this->getConnection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Get record count based on filter (for detail record count in master table pages)
	public function loadRecordCount($filter)
	{
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->getRecordCount($sql);
		$this->CurrentFilter = $origFilter;
		return $cnt;
	}

	// Get record count (for current List page)
	public function listRecordCount()
	{
		$filter = $this->getSessionWhere();
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->getRecordCount($sql);
		return $cnt;
	}

	// INSERT statement
	protected function insertSql(&$rs)
	{
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom)
				continue;
			$names .= $this->fields[$name]->Expression . ",";
			$values .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	public function insert(&$rs)
	{
		$conn = &$this->getConnection();
		$success = $conn->execute($this->insertSql($rs));
		if ($success) {

			// Get insert id if necessary
			$this->profileId->setDbValue($conn->insert_ID());
			$rs['profileId'] = $this->profileId->DbValue;
		}
		return $success;
	}

	// UPDATE statement
	protected function updateSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom || $this->fields[$name]->IsPrimaryKey)
				continue;
			$sql .= $this->fields[$name]->Expression . "=";
			$sql .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	public function update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE)
	{
		$conn = &$this->getConnection();
		$success = $conn->execute($this->updateSql($rs, $where, $curfilter));
		return $success;
	}

	// DELETE statement
	protected function deleteSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		if ($rs) {
			if (array_key_exists('profileId', $rs))
				AddFilter($where, QuotedName('profileId', $this->Dbid) . '=' . QuotedValue($rs['profileId'], $this->profileId->DataType, $this->Dbid));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	public function delete(&$rs, $where = "", $curfilter = FALSE)
	{
		$success = TRUE;
		$conn = &$this->getConnection();
		if ($success)
			$success = $conn->execute($this->deleteSql($rs, $where, $curfilter));
		return $success;
	}

	// Load DbValue from recordset or array
	protected function loadDbValues(&$rs)
	{
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->profileId->DbValue = $row['profileId'];
		$this->_userId->DbValue = $row['userId'];
		$this->firstName->DbValue = $row['firstName'];
		$this->lastName->DbValue = $row['lastName'];
		$this->address->DbValue = $row['address'];
		$this->village->DbValue = $row['village'];
		$this->city->DbValue = $row['city'];
		$this->pincode->DbValue = $row['pincode'];
		$this->source->DbValue = $row['source'];
		$this->agent->DbValue = $row['agent'];
		$this->date->DbValue = $row['date'];
		$this->status->DbValue = $row['status'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`profileId` = @profileId@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		$val = is_array($row) ? (array_key_exists('profileId', $row) ? $row['profileId'] : NULL) : $this->profileId->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@profileId@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
		return $keyFilter;
	}

	// Return page URL
	public function getReturnUrl()
	{
		$name = PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ServerVar("HTTP_REFERER") <> "" && ReferPageName() <> CurrentPageName() && ReferPageName() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "userprofileslist.php";
		}
	}
	public function setReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	public function getModalCaption($pageName)
	{
		global $Language;
		if ($pageName == "userprofilesview.php")
			return $Language->phrase("View");
		elseif ($pageName == "userprofilesedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "userprofilesadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "userprofileslist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("userprofilesview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("userprofilesview.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm <> "")
			$url = "userprofilesadd.php?" . $this->getUrlParm($parm);
		else
			$url = "userprofilesadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("userprofilesedit.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline edit URL
	public function getInlineEditUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
		return $this->addMasterUrl($url);
	}

	// Copy URL
	public function getCopyUrl($parm = "")
	{
		$url = $this->keyUrl("userprofilesadd.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline copy URL
	public function getInlineCopyUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
		return $this->addMasterUrl($url);
	}

	// Delete URL
	public function getDeleteUrl()
	{
		return $this->keyUrl("userprofilesdelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		if ($this->getCurrentMasterTable() == "users" && !ContainsString($url, TABLE_SHOW_MASTER . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_ID=" . urlencode($this->_userId->CurrentValue);
		}
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "profileId:" . JsonEncode($this->profileId->CurrentValue, "number");
		$json = "{" . $json . "}";
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}

	// Add key value to URL
	public function keyUrl($url, $parm = "")
	{
		$url = $url . "?";
		if ($parm <> "")
			$url .= $parm . "&";
		if ($this->profileId->CurrentValue != NULL) {
			$url .= "profileId=" . urlencode($this->profileId->CurrentValue);
		} else {
			return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
		}
		return $url;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		if ($this->CurrentAction || $this->isExport() ||
			in_array($fld->Type, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort());
			return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
		} else {
			return "";
		}
	}

	// Get record keys from Post/Get/Session
	public function getRecordKeys()
	{
		global $COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (Param("key_m") !== NULL) {
			$arKeys = Param("key_m");
			$cnt = count($arKeys);
		} else {
			if (Param("profileId") !== NULL)
				$arKeys[] = Param("profileId");
			elseif (IsApi() && Key(0) !== NULL)
				$arKeys[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKeys[] = Route(2);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get filter from record keys
	public function getFilterFromRecordKeys()
	{
		$arKeys = $this->getRecordKeys();
		$keyFilter = "";
		foreach ($arKeys as $key) {
			if ($keyFilter <> "") $keyFilter .= " OR ";
			$this->profileId->CurrentValue = $key;
			$keyFilter .= "(" . $this->getRecordFilter() . ")";
		}
		return $keyFilter;
	}

	// Load rows based on filter
	public function &loadRs($filter)
	{

		// Set up filter (WHERE Clause)
		$sql = $this->getSql($filter);
		$conn = &$this->getConnection();
		$rs = $conn->execute($sql);
		return $rs;
	}

	// Load row values from recordset
	public function loadListRowValues(&$rs)
	{
		$this->profileId->setDbValue($rs->fields('profileId'));
		$this->_userId->setDbValue($rs->fields('userId'));
		$this->firstName->setDbValue($rs->fields('firstName'));
		$this->lastName->setDbValue($rs->fields('lastName'));
		$this->address->setDbValue($rs->fields('address'));
		$this->village->setDbValue($rs->fields('village'));
		$this->city->setDbValue($rs->fields('city'));
		$this->pincode->setDbValue($rs->fields('pincode'));
		$this->source->setDbValue($rs->fields('source'));
		$this->agent->setDbValue($rs->fields('agent'));
		$this->date->setDbValue($rs->fields('date'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
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

		// userId
		$this->_userId->LinkCustomAttributes = "";
		$this->_userId->HrefValue = "";
		$this->_userId->TooltipValue = "";

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

		// date
		$this->date->LinkCustomAttributes = "";
		$this->date->HrefValue = "";
		$this->date->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Render edit row values
	public function renderEditRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// profileId
		$this->profileId->EditAttrs["class"] = "form-control";
		$this->profileId->EditCustomAttributes = "";
		$this->profileId->EditValue = $this->profileId->CurrentValue;
		$this->profileId->ViewCustomAttributes = "";

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
		} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
			$this->_userId->CurrentValue = CurrentUserID();
		$this->_userId->EditValue = $this->_userId->CurrentValue;
		$curVal = strval($this->_userId->CurrentValue);
		if ($curVal <> "") {
			$this->_userId->EditValue = $this->_userId->lookupCacheOption($curVal);
			if ($this->_userId->EditValue === NULL) { // Lookup from database
				$filterWrk = "`ID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
				$sqlWrk = $this->_userId->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('df');
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
		$this->_userId->EditValue = $this->_userId->CurrentValue;
		$this->_userId->PlaceHolder = RemoveHtml($this->_userId->caption());
		}

		// firstName
		$this->firstName->EditAttrs["class"] = "form-control";
		$this->firstName->EditCustomAttributes = "";
		$this->firstName->EditValue = $this->firstName->CurrentValue;
		$this->firstName->PlaceHolder = RemoveHtml($this->firstName->caption());

		// lastName
		$this->lastName->EditAttrs["class"] = "form-control";
		$this->lastName->EditCustomAttributes = "";
		$this->lastName->EditValue = $this->lastName->CurrentValue;
		$this->lastName->PlaceHolder = RemoveHtml($this->lastName->caption());

		// address
		$this->address->EditAttrs["class"] = "form-control";
		$this->address->EditCustomAttributes = "";
		$this->address->EditValue = $this->address->CurrentValue;
		$this->address->PlaceHolder = RemoveHtml($this->address->caption());

		// village
		$this->village->EditAttrs["class"] = "form-control";
		$this->village->EditCustomAttributes = "";
		$this->village->EditValue = $this->village->CurrentValue;
		$this->village->PlaceHolder = RemoveHtml($this->village->caption());

		// city
		$this->city->EditAttrs["class"] = "form-control";
		$this->city->EditCustomAttributes = "";
		$this->city->EditValue = $this->city->CurrentValue;
		$this->city->PlaceHolder = RemoveHtml($this->city->caption());

		// pincode
		$this->pincode->EditAttrs["class"] = "form-control";
		$this->pincode->EditCustomAttributes = "";
		$this->pincode->EditValue = $this->pincode->CurrentValue;
		$this->pincode->PlaceHolder = RemoveHtml($this->pincode->caption());

		// source
		$this->source->EditAttrs["class"] = "form-control";
		$this->source->EditCustomAttributes = "";
		$this->source->EditValue = $this->source->options(TRUE);

		// agent
		$this->agent->EditAttrs["class"] = "form-control";
		$this->agent->EditCustomAttributes = "";
		$this->agent->EditValue = $this->agent->CurrentValue;
		$this->agent->PlaceHolder = RemoveHtml($this->agent->caption());

		// date
		$this->date->EditAttrs["class"] = "form-control";
		$this->date->EditCustomAttributes = "";
		$this->date->EditValue = FormatDateTime($this->date->CurrentValue, 8);
		$this->date->PlaceHolder = RemoveHtml($this->date->caption());

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->options(TRUE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	public function aggregateListRowValues()
	{
	}

	// Aggregate list row (for rendering)
	public function aggregateListRow()
	{

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
	{
		if (!$recordset || !$doc)
			return;
		if (!$doc->ExportCustom) {

			// Write header
			$doc->exportTableHeader();
			if ($doc->Horizontal) { // Horizontal format, write header
				$doc->beginExportRow();
				if ($exportPageType == "view") {
					$doc->exportCaption($this->profileId);
					$doc->exportCaption($this->_userId);
					$doc->exportCaption($this->firstName);
					$doc->exportCaption($this->lastName);
					$doc->exportCaption($this->address);
					$doc->exportCaption($this->village);
					$doc->exportCaption($this->city);
					$doc->exportCaption($this->pincode);
					$doc->exportCaption($this->source);
					$doc->exportCaption($this->agent);
					$doc->exportCaption($this->date);
					$doc->exportCaption($this->status);
				} else {
					$doc->exportCaption($this->profileId);
					$doc->exportCaption($this->_userId);
					$doc->exportCaption($this->firstName);
					$doc->exportCaption($this->lastName);
					$doc->exportCaption($this->village);
					$doc->exportCaption($this->city);
					$doc->exportCaption($this->pincode);
					$doc->exportCaption($this->source);
					$doc->exportCaption($this->agent);
					$doc->exportCaption($this->date);
					$doc->exportCaption($this->status);
				}
				$doc->endExportRow();
			}
		}

		// Move to first record
		$recCnt = $startRec - 1;
		if (!$recordset->EOF) {
			$recordset->moveFirst();
			if ($startRec > 1)
				$recordset->move($startRec - 1);
		}
		while (!$recordset->EOF && $recCnt < $stopRec) {
			$recCnt++;
			if ($recCnt >= $startRec) {
				$rowCnt = $recCnt - $startRec + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0)
						$doc->exportPageBreak();
				}
				$this->loadListRowValues($recordset);

				// Render row
				$this->RowType = ROWTYPE_VIEW; // Render view
				$this->resetAttributes();
				$this->renderListRow();
				if (!$doc->ExportCustom) {
					$doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
					if ($exportPageType == "view") {
						$doc->exportField($this->profileId);
						$doc->exportField($this->_userId);
						$doc->exportField($this->firstName);
						$doc->exportField($this->lastName);
						$doc->exportField($this->address);
						$doc->exportField($this->village);
						$doc->exportField($this->city);
						$doc->exportField($this->pincode);
						$doc->exportField($this->source);
						$doc->exportField($this->agent);
						$doc->exportField($this->date);
						$doc->exportField($this->status);
					} else {
						$doc->exportField($this->profileId);
						$doc->exportField($this->_userId);
						$doc->exportField($this->firstName);
						$doc->exportField($this->lastName);
						$doc->exportField($this->village);
						$doc->exportField($this->city);
						$doc->exportField($this->pincode);
						$doc->exportField($this->source);
						$doc->exportField($this->agent);
						$doc->exportField($this->date);
						$doc->exportField($this->status);
					}
					$doc->endExportRow($rowCnt);
				}
			}

			// Call Row Export server event
			if ($doc->ExportCustom)
				$this->Row_Export($recordset->fields);
			$recordset->moveNext();
		}
		if (!$doc->ExportCustom) {
			$doc->exportTableFooter();
		}
	}

	// Add User ID filter
	public function addUserIDFilter($filter = "")
	{
		global $Security;
		$filterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->userIdAllow($id) && !$Security->isAdmin()) {
			$filterWrk = $Security->userIdList();
			if ($filterWrk <> "")
				$filterWrk = '`userId` IN (' . $filterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($filterWrk);
		AddFilter($filter, $filterWrk);
		return $filter;
	}

	// User ID subquery
	public function getUserIDSubquery(&$fld, &$masterfld)
	{
		global $UserTableConn;
		$wrk = "";
		$sql = "SELECT " . $masterfld->Expression . " FROM `userprofiles`";
		$filter = $this->addUserIDFilter("");
		if ($filter <> "")
			$sql .= " WHERE " . $filter;

		// Use subquery
		if (USE_SUBQUERY_FOR_MASTER_USER_ID) {
			$wrk = $sql;
		} else {

			// List all values
			if ($rs = $UserTableConn->execute($sql)) {
				while (!$rs->EOF) {
					if ($wrk <> "")
						$wrk .= ",";
					$wrk .= QuotedValue($rs->fields[0], $masterfld->DataType, USER_TABLE_DBID);
					$rs->moveNext();
				}
				$rs->close();
			}
		}
		if ($wrk <> "")
			$wrk = $fld->Expression . " IN (" . $wrk . ")";
		return $wrk;
	}

	// Add master User ID filter
	public function addMasterUserIDFilter($filter, $currentMasterTable)
	{
		$filterWrk = $filter;
		if ($currentMasterTable == "users") {
			$filterWrk = $GLOBALS["users"]->addUserIDFilter($filterWrk);
		}
		return $filterWrk;
	}

	// Add detail User ID filter
	public function addDetailUserIDFilter($filter, $currentMasterTable)
	{
		$filterWrk = $filter;
		if ($currentMasterTable == "users") {
			$mastertable = $GLOBALS["users"];
			if (!$mastertable->userIdAllow()) {
				$subqueryWrk = $mastertable->getUserIDSubquery($this->_userId, $mastertable->ID);
				AddFilter($filterWrk, $subqueryWrk);
			}
		}
		return $filterWrk;
	}

	// Lookup data from table
	public function lookup()
	{
		global $Language, $LANGUAGE_FOLDER, $PROJECT_ID;
		if (!isset($Language))
			$Language = new Language($LANGUAGE_FOLDER, Post("language", ""));
		global $Security, $RequestSecurity;

		// Check token first
		$func = PROJECT_NAMESPACE . "CheckToken";
		$validRequest = FALSE;
		if (is_callable($func) && Post(TOKEN_NAME) !== NULL) {
			$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
			if ($validRequest) {
				if (!isset($Security)) {
					if (session_status() !== PHP_SESSION_ACTIVE)
						session_start(); // Init session data
					$Security = new AdvancedSecurity();
					$validRequest = $Security->isLoggedIn(); // Logged in
					if ($validRequest) {
						$Security->UserID_Loading();
						$Security->loadUserID();
						$Security->UserID_Loaded();
					}
				}
			}
		} else {

			// User profile
			$UserProfile = new UserProfile();

			// Security
			$Security = new AdvancedSecurity();
			if (is_array($RequestSecurity)) // Login user for API request
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
			$validRequest = $Security->isLoggedIn(); // Logged in
		}

		// Reject invalid request
		if (!$validRequest)
			return FALSE;

		// Load lookup parameters
		$distinct = ConvertToBool(Post("distinct"));
		$linkField = Post("linkField");
		$displayFields = Post("displayFields");
		$parentFields = Post("parentFields");
		if (!is_array($parentFields))
			$parentFields = [];
		$childFields = Post("childFields");
		if (!is_array($childFields))
			$childFields = [];
		$filterFields = Post("filterFields");
		if (!is_array($filterFields))
			$filterFields = [];
		$filterFieldVars = Post("filterFieldVars");
		if (!is_array($filterFieldVars))
			$filterFieldVars = [];
		$filterOperators = Post("filterOperators");
		if (!is_array($filterOperators))
			$filterOperators = [];
		$autoFillSourceFields = Post("autoFillSourceFields");
		if (!is_array($autoFillSourceFields))
			$autoFillSourceFields = [];
		$formatAutoFill = FALSE;
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Get("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = AUTO_SUGGEST_MAX_ENTRIES;
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));

		// Selected records from modal, skip parent/filter fields and show all records
		if (Post("keys") !== NULL) {
			$parentFields = [];
			$filterFields = [];
			$filterFieldVars = [];
			$offset = 0;
			$pageSize = 0;
		}

		// Create lookup object and output JSON
		$lookup = new Lookup($linkField, $this->TableVar, $distinct, $linkField, $displayFields, $parentFields, $childFields, $filterFields, $filterFieldVars, $autoFillSourceFields);
		foreach ($filterFields as $i => $filterField) { // Set up filter operators
			if (@$filterOperators[$i] <> "")
				$lookup->setFilterOperator($filterField, $filterOperators[$i]);
		}
		$lookup->LookupType = $lookupType; // Lookup type
		if (Post("keys") !== NULL) { // Selected records from modal
			$keys = Post("keys");
			if (is_array($keys))
				$keys = implode(LOOKUP_FILTER_VALUE_SEPARATOR, $keys);
			$lookup->FilterValues[] = $keys; // Lookup values
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($filterFields) ? count($filterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect <> "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter <> "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy <> "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson();
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = THUMBNAIL_DEFAULT_WIDTH, $height = THUMBNAIL_DEFAULT_HEIGHT)
	{

		// No binary fields
		return FALSE;
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
