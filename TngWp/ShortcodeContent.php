<?php
class TngWp_ShortcodeContent
{

    private static $instance = null;
    protected $db;
    protected $currentPerson;
    protected $tables = array();
    protected $sortBy = null;
    protected $tree;
    protected $TngWp;
  

    /**
     * @var TngWp_Shortcode_AbstractShortcode[]
     */
    protected $shortcodes = array();
    protected $domain;
    private $tngUser;

    protected function __construct()
    {

    }

    public static function instance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

/**
 * Add shortcodes
*/

    public function addShortcode(TngWp_Shortcode_AbstractShortcode $shortcode)
    {
        $this->shortcodes[] = $shortcode;
    }

    /**
     * Init Variables
    */    
    public function initPlugin()
    {
        $templates = new TngWp_Templates();
        foreach ($this->shortcodes as $shortcode) {
            $shortcode->init($this, $templates);
        }
    }

    public function getConfigPath() {
        $configPath = ($this->getTngPath()) . DIRECTORY_SEPARATOR . "config.php";
        //$configPath = $tngPath . DIRECTORY_SEPARATOR . "config.php";
        if (!file_exists($configPath)) {
        //throw new DomainException('Could not find TNG config file');
        $e = new DomainException('TNG Path not found');
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
        echo "TNG Path not found (" . __LINE__ . ") - ";
    //  Display admin message if tng path not specified
        add_action( 'admin_notices', array($this, 'pathNotSpecified') );
        return;
        }
    return $configPath;
    }

    public function initTables()
    {
        $configPath = $this->getConfigPath();
            if (!file_exists($configPath)) {
            //throw new DomainException('Could not find TNG config file');
            $e = new DomainException('TNG Path not found');
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            echo "TNG Path not found (" . __LINE__ . ")";
            //Display admin message if tng path not specified
            add_action( 'admin_notices', array($this, 'pathNotSpecified') );
            return;
            }
        include $configPath;
        $vars = get_defined_vars();
        foreach ($vars as $name => $value) {
            if (preg_match('/_table$/', $name)) {
                $this->tables[$name] = $value;
            }
            if (preg_match('/tngdomain$/', $name)) {
                $this->domain = $value;
            }
        }
    }

    public function initVariables()
        {
            //check for TNG Path
            $configPath = $this->getConfigPath();
            if (!file_exists($configPath)) {
                $e = new Exception('TNG Path not found');
                error_log($e->getMessage());
                error_log($e->getTraceAsString());
                echo "TNG Path not Specified";
            //  Display admin message if tng path not specified
                add_action( 'admin_notices', array($this, 'pathNotSpecified') );
                return;
            }
            include $configPath;
            //check Database
            try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  //DB error reporting
            $db = @mysqli_connect($database_host, $database_username, $database_password, $database_name );
            } catch (exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            echo "DB not configured. Please contact the administrator (80)";
            add_action( 'admin_notices', array($this, 'dbNotSpecified') );
            return;
            } 
    
    }

    /** Restrict Access to tree REMOVE ****/
    function treeAccess() {
        $configPath = $this->getConfigPath();
        include $configPath;
        if ($requirelogin == "1")
        return $treerestrict;
    }
    
    public function getTngTables()
    {
        return $this->tables;
    }

    /*** Initialize *****/
    public function init()
    {
        if ($this->db) { 
            return $this;
        }

        if ($this->currentPerson) {
            return $this;
        }

        // get_currentuserinfo();
        $configPath = $this->getConfigPath();
        include $configPath;
            try {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  //DB error reporting
                $db = mysqli_connect($database_host, $database_username, $database_password);
                mysqli_select_db($db, $database_name);
            } catch (exception $e) {
                error_log($e->getMessage());
                error_log($e->getTraceAsString());
                echo "DB not configured. Please contact the administrator (203)";
                add_action( 'admin_notices', array($this, 'dbNotSpecified') );
                return;
                } 
        // mysqli_select_db($db, $dbName);
            $this->db = $db; // added
            $this->initTables(); 

            if (!isset($this->tables['users_table'])) { 
                return $this;
            }

            
            $tng_user_name = $this->getTngUserName();
            $query = "SELECT * FROM {$this->tables['users_table']} WHERE username='{$tng_user_name}'";
            $result = mysqli_query($db, $query);
            if (!$result) {
            //   throw new RuntimeException(mysqli_error($this->db));
            }
            $row = $result->fetch_assoc();
            if (isset($row['personID'])) $this->currentPerson = $row['personID'];
            $this->db = $db;
            return $this;

        
    }
    
    /** tng root path *****/
    public function getTngPath()
    {
        $rootPath = esc_attr(get_option('tng-api-tng-path'));
        if (!file_exists($rootPath)) {
            add_action( 'admin_notices', array($this, 'pathNotSpecified'));
        }
        return $rootPath;
    }

    /**TNG URL ****/
    public function getTngUrl()
    {
        $configPath = $this->getConfigPath();
        include $configPath;
        return $tngdomain;
    }

    /**TNG WP Integration Path ****/
    public function getTngIntegrationPath()
    {
        return esc_attr(get_option('tng-base-tng-path'));
    }

    /**TNG Photo Folder ****/
    public function getTngPhotoFolder()
    {
        $configPath = $this->getConfigPath();
        include $configPath;
        return $photopath;
    }

    /** Show optional Buttons in Family Page ****/
    public function getTngShowButtons()
    {
        return esc_attr(get_option('tng-api-display-buttons'));
    }

    public function query($sql)
    {
        if (!$this->db) {
            
            throw new RuntimeException("No DB configured please contact the administrator (" . __LINE__ . ") - ");
        }
        $result = mysqli_query($this->db, $sql);
        if (!$result) {
            throw new RuntimeException(mysqli_error($this->db));
        }
        return $result;
    }

    /**
     * @return mysqli
    */

    public function getDbLink()
    {
        return $this->db;
    }

    /** Get TNG User Table */    
    public function getTngUser()
    {
        if ($this->tngUser) {
            return $this->tngUser;
        }
		
		$currentUser = wp_get_current_user(); 
        
		$userName = $currentUser->user_login;
         
        if (!$userName) return;
        
       $query = "SELECT * FROM {$this->tables['users_table']} WHERE username='{$userName}'";
        //$result = $conn->query($query);
        

       $result = $this->query($query);
    if (!$result) return;
        $row = $result->fetch_assoc();
        if ($row) {
            $this->tngUser = $row;
            return $row;
        }
        throw new Upavadi_WpOnlyException('User ' . $userName . ' not found in TNG (or donot have access (" . __LINE__ . ") - '); //mu - change from wp_die
    }

    /** Get TNG User Name ****/
    public function getTngUserName()
    {
        $user = $this->getTngUser();
        if (isset($user['username'])) return $user['username'];
    }

    public function getCurrentPersonId()
    {
        return $this->currentPerson;
    }

    public function getPersonName($personId)
    {
        static $name;
        $person = $this->getPerson($personId);
        if(isset($person)) $name = $person['firstname'] . $person['lastname'];

        return $name;
    }
    
    /*** Birthdays ******/   
    public function getBirthdays($month, $tree = null)
    {
        static $gedcom;
        $user = $this->getTngUser();
       if (isset($user)) $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
        if ($tree) {
            $gedcom = $tree;
        }
        $treeWhere = null;
        if ($gedcom) {
            $treeWhere = ' AND gedcom = "' . $gedcom . '"';
        }

        $sql = <<<SQL
    SELECT personid,
        firstname,
        lastname,
        birthdate,
        birthplace,
        private,
        famc,
        prefix,
        suffix,
        gedcom
        FROM   {$this->tables['people_table']}
    WHERE  Month(birthdatetr) = {$month}
           AND living = 1 {$treeWhere}
    ORDER BY Day(birthdatetr), lastname
SQL;
    $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
			$rows[] = $row;
        }
		return $rows;
    }
    
    public function getFamily($personId = null, $tree = null)
    {

        if (!$personId) {
            $personId = $this->currentPerson;
        }
        $user = $this->getTngUser();
        if (isset($user)) 
        $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
        if ($tree) {
            $gedcom = $tree;
        }

        $treeWhere = null;
        if ($gedcom) {
            $treeWhere = ' AND gedcom = "' . $gedcom . '"';
        }
        $sql = <<<SQL
SELECT *
FROM {$this->tables['families_table']}
WHERE (husband = '{$personId}' or wife = '{$personId}') {$treeWhere}

SQL;
        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }

    public function getFamilyUser($personId = null, $tree = null, $sortBy = null)    {

        if (!$personId) {
            $personId = $this->currentPerson;
        }
        $user = $this->getTngUser();
        $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
        if ($tree) {
            $gedcom = $tree;
        }
        $treeWhere = null;
        if ($gedcom) {
            $treeWhere = ' AND gedcom = "' . $gedcom . '"';
        }

        $sql = <<<SQL
SELECT*


FROM {$this->tables['families_table']}

WHERE (husband = '{$personId}' {$treeWhere}) or (wife = '{$personId}' {$treeWhere})
SQL;
        $result = $this->query($sql);
        $rows = array();

        while ($row = $result->fetch_assoc()) {
			$userPrivate = $user['allow_private'];
			$familyPrivate = $row['private'];
			if ($familyPrivate > $userPrivate) {
				$row['marrdate'] = 'Private';
				$row['marrplace'] = ' Private';
			}

			if ($sortBy) {
				$this->sortBy = $sortBy;
				usort($rows, array($this, 'sortRows'));
			}
			$rows[] = $row;
		}
		return $rows;
    }

    
    public function getPerson($personId = null, $tree = null)
    {
        if (!$personId) {
            $personId = $this->currentPerson;
        }
        static $gedcom;
        $user = $this->getTngUser();

        if(isset($user)) $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
        if ($tree) {
            $gedcom = $tree;
        }

        if ($gedcom == '' && $tree) {
            $gedcom = $tree;
        }
        $treeWhere = null;
        if ($gedcom) {
            $treeWhere = ' AND gedcom = "' . $gedcom . '"';
        }

        $sql = <<<SQL
SELECT *
FROM {$this->tables['people_table']}
WHERE personID = '{$personId}'
{$treeWhere}
SQL;
        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }
    public function getFamilyById($familyId = null, $tree = null)
    {
        $user = $this->getTngUser();
        if (isset($user)) 
        $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
        if ($tree) {
            $gedcom = $tree;
        }
        $treeWhere = null;
        if (isset($user['gedcom'])) {
            $treeWhere = ' AND gedcom = "' . $gedcom . '"';
        }
        $sql = <<<SQL
SELECT *
FROM {$this->tables['families_table']}
WHERE familyID = '{$familyId}' {$treeWhere}
SQL;

        $result = $this->query($sql);
        $row = $result->fetch_assoc();

        return $row;
    }

    public function getChildFamily($personId, $familyId, $tree = null)
    {
        $user = $this->getTngUser();
        $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
        if ($tree) {
            $gedcom = $tree;
        }
        $treeWhere = null;
        if ($gedcom) {
            $treeWhere = ' AND gedcom = "' . $gedcom . '"';
        }

        $sql = <<<SQL
SELECT *
FROM {$this->tables['children_table']}
WHERE personID = '{$personId}' AND familyID = '{$familyId}' {$treeWhere}
SQL;

        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }

/**** *********************Media ************************* */
public function getDefaultMedia($personId = null, $tree = null)
    {
static $gedcom;
        if (!$personId) {
            $personId = $this->currentPerson;
        }
        $user = $this->getTngUser();
        //$userPrivate = $user['allow_private'];
        if (isset($user)) $gedcom = $user['gedcom'];
        $treeWhere = null;
        if (($gedcom)) {
            $treeWhere = ' AND m.gedcom = "' . $gedcom . '"';
        }
	$sql = <<<SQL
SELECT *
FROM   {$this->tables['media_table']} as ml
    LEFT JOIN {$this->tables['medialinks_table']} AS m
              ON ml.mediaID = m.mediaID
where personID = '{$personId}' AND m.defphoto = "1" {$treeWhere}
SQL;
        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }

    public function getProfileMedia($personId = null, $tree = null)
    {
        //get default media
        $defaultmedia = $this->getdefaultmedia($personId);
        $photos = $this->getTngPhotoFolder();
        $url = $this->getTngUrl();
        $photosPath = $url. $photos;
        $person = $this->getPerson($personId);
        $mediaID ="";

        if ($defaultmedia['thumbpath'] == null AND $person['sex'] == "M") {
             $mediaID = "./". $tngDirectory. "/img/male.jpg";
        }
        if ($defaultmedia['thumbpath'] == null AND $person['sex'] == "F") {
             $mediaID = "./". $tngDirectory. "/img/female.jpg";
        }
        if ($defaultmedia['thumbpath'] !== null) {
            $mediaID = $photosPath. "/" . $defaultmedia['thumbpath'];
        }
        return $mediaID;
    }


/***
 * Death Anniversaries
 * 
 */
public function getDeathAnniversaries($month, $tree = null)
    {
        $user = $this->getTngUser();
        $gedcom = "";
        if(isset($user['gedcom'])) $gedcom = $user['gedcom'];
        // If we are searching, enter $tree value
        if ($tree) {
            $gedcom = $tree;
        }
        $treeWhere = null;
        if ($gedcom) {
            $treeWhere = ' AND gedcom = "' . $gedcom . '"';
        }

        $sql = <<<SQL
SELECT personid,
       firstname,
       lastname,
       birthdate,
	   birthdatetr,
	   deathdate,
       deathdatetr,
	   deathplace,
       gedcom,
       Year(Now()) - Year(deathdatetr) AS Years
FROM   {$this->tables['people_table']}
WHERE  Month(deathdatetr) = {$month}
       AND living = 0 {$treeWhere}
ORDER  BY Day(deathdatetr),
          lastname
SQL;
        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
/***
 * Marriage Anniversaries
 * 
 */
public function getMarriageAnniversaries($month, $tree = null)
{
    $user = $this->getTngUser();
    $gedcom = $user['gedcom'];
    // If we are searching, enter $tree value
    if ($tree) {
        $gedcom = $tree;
    }
    $treeWhere = null;
    if ($gedcom) {
        $treeWhere = ' AND f.gedcom = "' . $gedcom . '"';
    }
    $sql = <<<SQL
SELECT
h.gedcom,
h.private AS private1,
h.personid AS personid1,
h.firstname AS firstname1,
h.lastname AS lastname1,
w.personid AS personid2,
w.firstname AS firstname2,
w.lastname AS lastname2,
w.private AS private2,
w.gedcom,
f.gedcom,
f.living,
f.private,
f.familyID,
f.marrdate,
f.marrplace,
f.divdate,
Year(Now()) - Year(marrdatetr) AS Years
FROM {$this->tables['families_table']} as f
LEFT JOIN {$this->tables['people_table']} AS h
ON (f.husband = h.personid AND f.gedcom = h.gedcom)
LEFT JOIN {$this->tables['people_table']} AS w
ON (f.wife = w.personid AND f.gedcom = w.gedcom)
WHERE  Month(f.marrdatetr) = {$month}
{$treeWhere}
ORDER  BY Day(f.marrdatetr)

SQL;
    $result = $this->query($sql);
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

/*****************
 * Get current birthdays, 
 * marriage anniversaries
 * death anniversaries
 *******************/
public function getCurrentBirthday()
    {
        $tables = $this->getTngTables();

        $sql = <<<SQL
SELECT personid,
       firstname,
       lastname,
       birthdate,
       birthplace,
       private,
       famc,
       gedcom,
       Year(Now()) - Year(birthdatetr) AS Age
FROM   {$tables['people_table']}
WHERE
    DATE(CONCAT(YEAR(CURDATE()), RIGHT(birthdatetr, 6)))
        BETWEEN 
            DATE_SUB(CURDATE(), INTERVAL 1 DAY)
        AND
            DATE_ADD(CURDATE(), INTERVAL 1 DAY)
       AND living = 1
ORDER BY
    month(birthdatetr),
    Day(birthdatetr),
    lastname
SQL;

        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

public function getCurrentMAnniversaries()
    {
        $tables = $this->getTngTables();
        $sql = <<<SQL
SELECT h.gedcom,
	   h.personid AS personid1,
       h.firstname AS firstname1,
       h.lastname AS lastname1,
       w.personid AS personid2,
       w.firstname AS firstname2,
       w.lastname AS lastname2,
	   f.familyID,
       f.marrdate,
       f.marrplace,
       f.private,
       f.divdate,
       Year(Now()) - Year(marrdatetr) AS Years
FROM   {$tables['families_table']} as f
    LEFT JOIN {$tables['people_table']} AS h
              ON f.husband = h.personid
       LEFT JOIN {$tables['people_table']} AS w
              ON f.wife = w.personid
# WHERE  Month(f.marrdatetr) = MONTH(ADDDATE(now(), INTERVAL 3 month))
  WHERE  DATE(CONCAT(YEAR(CURDATE()), RIGHT(f.marrdatetr, 6)))
          BETWEEN 
              DATE_SUB(CURDATE(), INTERVAL 1 DAY)
          AND
              DATE_ADD(CURDATE(), INTERVAL 1 DAY)     
ORDER  BY Day(f.marrdatetr)
          
SQL;
        $result = $this->query($sql);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

public function getCurrentDAnniversaries()
{
    $tables = $this->getTngTables();
    $sql = <<<SQL
SELECT personid,
   firstname,
   lastname,
   deathdate,
   deathplace,
   gedcom,
   Year(Now()) - Year(deathdatetr) AS Years
FROM   {$tables['people_table']}
WHERE  DATE(CONCAT(YEAR(CURDATE()), RIGHT(deathdatetr, 6)))
      BETWEEN 
          DATE_SUB(CURDATE(), INTERVAL 1 DAY)
      AND
          DATE_ADD(CURDATE(), INTERVAL 1 DAY)
   AND living = 0
ORDER  BY month(deathdatetr),
        Day(deathdatetr),
      lastname
SQL;
    $result = $this->query($sql);

    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

public function getYesterdayTodayTomorrow() 
{
    $tables = $this->getTngTables();

    $sql = "SELECT
    personid,
    firstname,
    lastname,
    gedcom,
    sex,
    birthdate,
    birthdatetr,
    deathdate,
    deathdatetr,
    FLOOR(DATEDIFF(CURDATE(), birthdatetr)/365.25) AS BirthAge,
    FLOOR(DATEDIFF(deathdatetr, birthdatetr)/365.25) AS DeathAge,
    FLOOR(DATEDIFF(deathdatetr, birthdatetr)/365.25) AS DeathYears
    FROM   {$tables['people_table']}

WHERE
( DATE_FORMAT(birthdatetr, '%m-%d') IN (
    DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%m-%d'), 
    DATE_FORMAT(CURDATE(), '%m-%d'), 
    DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '%m-%d')
    )
AND
living = 0)
OR
( DATE_FORMAT(deathdatetr, '%m-%d') IN (
    DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%m-%d'), 
    DATE_FORMAT(CURDATE(), '%m-%d'), 
    DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY), '%m-%d')
    )
AND
living = 0)
";
$result = $this->query($sql);
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
return $rows;

}



/***
public function guessVersion()
{
    $sql = 'describe ' . $this->tables['people_table'];
    $sql2 = 'describe ' . $this->tables['users_table'];
    if ($this->tables['image_tags_table']) {
    $sql3 = 'describe ' . $this->tables['image_tags_table'];
    $result3 = $this->query($sql3); 
    }
    $result = $this->query($sql);
    $result2 = $this->query($sql2);
    
    $version = 9;
    while ($row = $result->fetch_assoc()) {
        if ($row['Field'] == 'burialtype') {
            $version = 10;
            break;
        }
    }
    while ($row = $result2->fetch_assoc()) {	
        if ($row['Field'] == 'languageID') {
            $version = 11;
            break;
        }
    }

    while ($row = $result2->fetch_assoc()) {	
        if ($row['Field'] == 'dt_consented') {
            $version = 12;
            break;
        }

    }

    if(isset($result3)) {
    while ($row = $result3->fetch_assoc()) {	
        if ($row['Field'] == 'ID') {
            $version = 13;
            break;
        }
    }

    }

    return $version;
}
**/ 
} //End class