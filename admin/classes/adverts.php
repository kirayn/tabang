<?php
namespace PHPMaker2019\tabelo_admin;

/**
 * Table class for adverts
 */
class adverts extends DbTable
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
	public $advId;
	public $_userId;
	public $title;
	public $description;
	public $categoryId;
	public $locationId;
	public $validity;
	public $contactPerson;
	public $contactNumber;
	public $date;
	public $cost;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'adverts';
		$this->TableName = 'adverts';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`adverts`";
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

		// advId
		$this->advId = new DbField('adverts', 'adverts', 'x_advId', 'advId', '`advId`', '`advId`', 20, -1, FALSE, '`advId`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->advId->IsAutoIncrement = TRUE; // Autoincrement field
		$this->advId->IsPrimaryKey = TRUE; // Primary key field
		$this->advId->IsForeignKey = TRUE; // Foreign key field
		$this->advId->Sortable = TRUE; // Allow sort
		$this->advId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['advId'] = &$this->advId;

		// userId
		$this->_userId = new DbField('adverts', 'adverts', 'x__userId', 'userId', '`userId`', '`userId`', 20, -1, FALSE, '`userId`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_userId->IsForeignKey = TRUE; // Foreign key field
		$this->_userId->Nullable = FALSE; // NOT NULL field
		$this->_userId->Required = TRUE; // Required field
		$this->_userId->Sortable = TRUE; // Allow sort
		switch ($CurrentLanguage) {
			case "en":
				$this->_userId->Lookup = new Lookup('userId', 'userprofiles', FALSE, 'userId', ["firstName","lastName","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->_userId->Lookup = new Lookup('userId', 'userprofiles', FALSE, 'userId', ["firstName","lastName","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->_userId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['userId'] = &$this->_userId;

		// title
		$this->title = new DbField('adverts', 'adverts', 'x_title', 'title', '`title`', '`title`', 200, -1, FALSE, '`title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->title->Nullable = FALSE; // NOT NULL field
		$this->title->Required = TRUE; // Required field
		$this->title->Sortable = TRUE; // Allow sort
		$this->fields['title'] = &$this->title;

		// description
		$this->description = new DbField('adverts', 'adverts', 'x_description', 'description', '`description`', '`description`', 201, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Nullable = FALSE; // NOT NULL field
		$this->description->Required = TRUE; // Required field
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// categoryId
		$this->categoryId = new DbField('adverts', 'adverts', 'x_categoryId', 'categoryId', '`categoryId`', '`categoryId`', 20, -1, FALSE, '`categoryId`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->categoryId->IsForeignKey = TRUE; // Foreign key field
		$this->categoryId->Nullable = FALSE; // NOT NULL field
		$this->categoryId->Required = TRUE; // Required field
		$this->categoryId->Sortable = TRUE; // Allow sort
		$this->categoryId->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->categoryId->PleaseSelectText = $Language->phrase("PleaseSelect"); // PleaseSelect text
		switch ($CurrentLanguage) {
			case "en":
				$this->categoryId->Lookup = new Lookup('categoryId', 'categories', FALSE, 'categoryId', ["name","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->categoryId->Lookup = new Lookup('categoryId', 'categories', FALSE, 'categoryId', ["name","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->categoryId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['categoryId'] = &$this->categoryId;

		// locationId
		$this->locationId = new DbField('adverts', 'adverts', 'x_locationId', 'locationId', '`locationId`', '`locationId`', 20, -1, FALSE, '`locationId`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->locationId->IsForeignKey = TRUE; // Foreign key field
		$this->locationId->Nullable = FALSE; // NOT NULL field
		$this->locationId->Required = TRUE; // Required field
		$this->locationId->Sortable = TRUE; // Allow sort
		$this->locationId->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->locationId->PleaseSelectText = $Language->phrase("PleaseSelect"); // PleaseSelect text
		switch ($CurrentLanguage) {
			case "en":
				$this->locationId->Lookup = new Lookup('locationId', 'locations', FALSE, 'locationId', ["title","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->locationId->Lookup = new Lookup('locationId', 'locations', FALSE, 'locationId', ["title","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->locationId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['locationId'] = &$this->locationId;

		// validity
		$this->validity = new DbField('adverts', 'adverts', 'x_validity', 'validity', '`validity`', '`validity`', 3, -1, FALSE, '`validity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->validity->Nullable = FALSE; // NOT NULL field
		$this->validity->Required = TRUE; // Required field
		$this->validity->Sortable = TRUE; // Allow sort
		$this->validity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['validity'] = &$this->validity;

		// contactPerson
		$this->contactPerson = new DbField('adverts', 'adverts', 'x_contactPerson', 'contactPerson', '`contactPerson`', '`contactPerson`', 200, -1, FALSE, '`contactPerson`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->contactPerson->Nullable = FALSE; // NOT NULL field
		$this->contactPerson->Required = TRUE; // Required field
		$this->contactPerson->Sortable = TRUE; // Allow sort
		$this->fields['contactPerson'] = &$this->contactPerson;

		// contactNumber
		$this->contactNumber = new DbField('adverts', 'adverts', 'x_contactNumber', 'contactNumber', '`contactNumber`', '`contactNumber`', 200, -1, FALSE, '`contactNumber`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->contactNumber->Nullable = FALSE; // NOT NULL field
		$this->contactNumber->Required = TRUE; // Required field
		$this->contactNumber->Sortable = TRUE; // Allow sort
		$this->fields['contactNumber'] = &$this->contactNumber;

		// date
		$this->date = new DbField('adverts', 'adverts', 'x_date', 'date', '`date`', CastDateFieldForLike('`date`', 0, "DB"), 135, 0, FALSE, '`date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date->Sortable = TRUE; // Allow sort
		$this->date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['date'] = &$this->date;

		// cost
		$this->cost = new DbField('adverts', 'adverts', 'x_cost', 'cost', '`cost`', '`cost`', 200, -1, FALSE, '`cost`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cost->Sortable = TRUE; // Allow sort
		$this->fields['cost'] = &$this->cost;
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
		if ($this->getCurrentMasterTable() == "categories") {
			if ($this->categoryId->getSessionValue() <> "")
				$masterFilter .= "`categoryId`=" . QuotedValue($this->categoryId->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "locations") {
			if ($this->locationId->getSessionValue() <> "")
				$masterFilter .= "`locationId`=" . QuotedValue($this->locationId->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
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
		if ($this->getCurrentMasterTable() == "categories") {
			if ($this->categoryId->getSessionValue() <> "")
				$detailFilter .= "`categoryId`=" . QuotedValue($this->categoryId->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "locations") {
			if ($this->locationId->getSessionValue() <> "")
				$detailFilter .= "`locationId`=" . QuotedValue($this->locationId->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "users") {
			if ($this->_userId->getSessionValue() <> "")
				$detailFilter .= "`userId`=" . QuotedValue($this->_userId->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $detailFilter;
	}

	// Master filter
	public function sqlMasterFilter_categories()
	{
		return "`categoryId`=@categoryId@";
	}

	// Detail filter
	public function sqlDetailFilter_categories()
	{
		return "`categoryId`=@categoryId@";
	}

	// Master filter
	public function sqlMasterFilter_locations()
	{
		return "`locationId`=@locationId@";
	}

	// Detail filter
	public function sqlDetailFilter_locations()
	{
		return "`locationId`=@locationId@";
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

	// Current detail table name
	public function getCurrentDetailTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_DETAIL_TABLE];
	}
	public function setCurrentDetailTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	public function getDetailUrl()
	{

		// Detail url
		$detailUrl = "";
		if ($this->getCurrentDetailTable() == "media") {
			$detailUrl = $GLOBALS["media"]->getListUrl() . "?" . TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$detailUrl .= "&fk_advId=" . urlencode($this->advId->CurrentValue);
		}
		if ($detailUrl == "")
			$detailUrl = "advertslist.php";
		return $detailUrl;
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom <> "") ? $this->SqlFrom : "`adverts`";
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
			$this->advId->setDbValue($conn->insert_ID());
			$rs['advId'] = $this->advId->DbValue;
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

		// Cascade Update detail table 'media'
		$cascadeUpdate = FALSE;
		$rscascade = array();
		if ($rsold && (isset($rs['advId']) && $rsold['advId'] <> $rs['advId'])) { // Update detail field 'advId'
			$cascadeUpdate = TRUE;
			$rscascade['advId'] = $rs['advId']; 
		}
		if ($cascadeUpdate) {
			if (!isset($GLOBALS["media"]))
				$GLOBALS["media"] = new media();
			$rswrk = $GLOBALS["media"]->loadRs("`advId` = " . QuotedValue($rsold['advId'], DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'mediaId';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$success = $GLOBALS["media"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($success)
					$success = $GLOBALS["media"]->update($rscascade, $rskey, $rswrk->fields);
				if (!$success)
					return FALSE;

				// Call Row_Updated event
				$GLOBALS["media"]->Row_Updated($rsdtlold, $rsdtlnew);
				$rswrk->moveNext();
			}
		}
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
			if (array_key_exists('advId', $rs))
				AddFilter($where, QuotedName('advId', $this->Dbid) . '=' . QuotedValue($rs['advId'], $this->advId->DataType, $this->Dbid));
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

		// Cascade delete detail table 'media'
		if (!isset($GLOBALS["media"]))
			$GLOBALS["media"] = new media();
		$rscascade = $GLOBALS["media"]->loadRs("`advId` = " . QuotedValue($rs['advId'], DATATYPE_NUMBER, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->getRows() : array();

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$success = $GLOBALS["media"]->Row_Deleting($dtlrow);
			if (!$success)
				break;
		}
		if ($success) {
			foreach ($dtlrows as $dtlrow) {
				$success = $GLOBALS["media"]->delete($dtlrow); // Delete
				if (!$success)
					break;
			}
		}

		// Call Row Deleted event
		if ($success) {
			foreach ($dtlrows as $dtlrow)
				$GLOBALS["media"]->Row_Deleted($dtlrow);
		}
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
		$this->advId->DbValue = $row['advId'];
		$this->_userId->DbValue = $row['userId'];
		$this->title->DbValue = $row['title'];
		$this->description->DbValue = $row['description'];
		$this->categoryId->DbValue = $row['categoryId'];
		$this->locationId->DbValue = $row['locationId'];
		$this->validity->DbValue = $row['validity'];
		$this->contactPerson->DbValue = $row['contactPerson'];
		$this->contactNumber->DbValue = $row['contactNumber'];
		$this->date->DbValue = $row['date'];
		$this->cost->DbValue = $row['cost'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`advId` = @advId@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		$val = is_array($row) ? (array_key_exists('advId', $row) ? $row['advId'] : NULL) : $this->advId->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@advId@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "advertslist.php";
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
		if ($pageName == "advertsview.php")
			return $Language->phrase("View");
		elseif ($pageName == "advertsedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "advertsadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "advertslist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("advertsview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("advertsview.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm <> "")
			$url = "advertsadd.php?" . $this->getUrlParm($parm);
		else
			$url = "advertsadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("advertsedit.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("advertsedit.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
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
		if ($parm <> "")
			$url = $this->keyUrl("advertsadd.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("advertsadd.php", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
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
		return $this->keyUrl("advertsdelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		if ($this->getCurrentMasterTable() == "categories" && !ContainsString($url, TABLE_SHOW_MASTER . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_categoryId=" . urlencode($this->categoryId->CurrentValue);
		}
		if ($this->getCurrentMasterTable() == "locations" && !ContainsString($url, TABLE_SHOW_MASTER . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_locationId=" . urlencode($this->locationId->CurrentValue);
		}
		if ($this->getCurrentMasterTable() == "users" && !ContainsString($url, TABLE_SHOW_MASTER . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_ID=" . urlencode($this->_userId->CurrentValue);
		}
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "advId:" . JsonEncode($this->advId->CurrentValue, "number");
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
		if ($this->advId->CurrentValue != NULL) {
			$url .= "advId=" . urlencode($this->advId->CurrentValue);
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
			if (Param("advId") !== NULL)
				$arKeys[] = Param("advId");
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
			$this->advId->CurrentValue = $key;
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
		$this->advId->setDbValue($rs->fields('advId'));
		$this->_userId->setDbValue($rs->fields('userId'));
		$this->title->setDbValue($rs->fields('title'));
		$this->description->setDbValue($rs->fields('description'));
		$this->categoryId->setDbValue($rs->fields('categoryId'));
		$this->locationId->setDbValue($rs->fields('locationId'));
		$this->validity->setDbValue($rs->fields('validity'));
		$this->contactPerson->setDbValue($rs->fields('contactPerson'));
		$this->contactNumber->setDbValue($rs->fields('contactNumber'));
		$this->date->setDbValue($rs->fields('date'));
		$this->cost->setDbValue($rs->fields('cost'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
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

		// advId
		$this->advId->LinkCustomAttributes = "";
		if (!EmptyValue($this->title->CurrentValue)) {
			$this->advId->HrefValue = ((!empty($this->title->ViewValue) && !is_array($this->title->ViewValue)) ? RemoveHtml($this->title->ViewValue) : $this->title->CurrentValue); // Add prefix/suffix
			$this->advId->LinkAttrs["target"] = ""; // Add target
			if ($this->isExport()) $this->advId->HrefValue = FullUrl($this->advId->HrefValue, "href");
		} else {
			$this->advId->HrefValue = "";
		}
		$this->advId->TooltipValue = "";

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

		// validity
		$this->validity->LinkCustomAttributes = "";
		$this->validity->HrefValue = "";
		$this->validity->TooltipValue = "";

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

		// advId
		$this->advId->EditAttrs["class"] = "form-control";
		$this->advId->EditCustomAttributes = "";
		$this->advId->EditValue = $this->advId->CurrentValue;
		$this->advId->ViewCustomAttributes = "";

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
		} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
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
		$this->_userId->EditValue = $this->_userId->CurrentValue;
		$this->_userId->PlaceHolder = RemoveHtml($this->_userId->caption());
		}

		// title
		$this->title->EditAttrs["class"] = "form-control";
		$this->title->EditCustomAttributes = "";
		$this->title->EditValue = $this->title->CurrentValue;
		$this->title->PlaceHolder = RemoveHtml($this->title->caption());

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
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
		}

		// locationId
		$this->locationId->EditAttrs["class"] = "form-control";
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
		}

		// validity
		$this->validity->EditAttrs["class"] = "form-control";
		$this->validity->EditCustomAttributes = "";
		$this->validity->EditValue = $this->validity->CurrentValue;
		$this->validity->PlaceHolder = RemoveHtml($this->validity->caption());

		// contactPerson
		$this->contactPerson->EditAttrs["class"] = "form-control";
		$this->contactPerson->EditCustomAttributes = "";
		$this->contactPerson->EditValue = $this->contactPerson->CurrentValue;
		$this->contactPerson->PlaceHolder = RemoveHtml($this->contactPerson->caption());

		// contactNumber
		$this->contactNumber->EditAttrs["class"] = "form-control";
		$this->contactNumber->EditCustomAttributes = "";
		$this->contactNumber->EditValue = $this->contactNumber->CurrentValue;
		$this->contactNumber->PlaceHolder = RemoveHtml($this->contactNumber->caption());

		// date
		$this->date->EditAttrs["class"] = "form-control";
		$this->date->EditCustomAttributes = "";
		$this->date->EditValue = FormatDateTime($this->date->CurrentValue, 8);
		$this->date->PlaceHolder = RemoveHtml($this->date->caption());

		// cost
		$this->cost->EditAttrs["class"] = "form-control";
		$this->cost->EditCustomAttributes = "";
		$this->cost->EditValue = $this->cost->CurrentValue;
		$this->cost->PlaceHolder = RemoveHtml($this->cost->caption());

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
					$doc->exportCaption($this->advId);
					$doc->exportCaption($this->_userId);
					$doc->exportCaption($this->title);
					$doc->exportCaption($this->description);
					$doc->exportCaption($this->categoryId);
					$doc->exportCaption($this->locationId);
					$doc->exportCaption($this->validity);
					$doc->exportCaption($this->contactPerson);
					$doc->exportCaption($this->contactNumber);
					$doc->exportCaption($this->date);
					$doc->exportCaption($this->cost);
				} else {
					$doc->exportCaption($this->advId);
					$doc->exportCaption($this->_userId);
					$doc->exportCaption($this->title);
					$doc->exportCaption($this->categoryId);
					$doc->exportCaption($this->locationId);
					$doc->exportCaption($this->validity);
					$doc->exportCaption($this->contactPerson);
					$doc->exportCaption($this->contactNumber);
					$doc->exportCaption($this->date);
					$doc->exportCaption($this->cost);
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
						$doc->exportField($this->advId);
						$doc->exportField($this->_userId);
						$doc->exportField($this->title);
						$doc->exportField($this->description);
						$doc->exportField($this->categoryId);
						$doc->exportField($this->locationId);
						$doc->exportField($this->validity);
						$doc->exportField($this->contactPerson);
						$doc->exportField($this->contactNumber);
						$doc->exportField($this->date);
						$doc->exportField($this->cost);
					} else {
						$doc->exportField($this->advId);
						$doc->exportField($this->_userId);
						$doc->exportField($this->title);
						$doc->exportField($this->categoryId);
						$doc->exportField($this->locationId);
						$doc->exportField($this->validity);
						$doc->exportField($this->contactPerson);
						$doc->exportField($this->contactNumber);
						$doc->exportField($this->date);
						$doc->exportField($this->cost);
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
		$sql = "SELECT " . $masterfld->Expression . " FROM `adverts`";
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
