<?PHP
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_Sec_Extra.php';

//CMS_TOK();

include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Connection.php";
if (isset($_POST['roster'])) {
    $WMS_Update_decoded = json_decode($_POST['roster'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Invalid JSON in roster");
    }
//   print_r($WMS_Update_decoded);
} else {
    die("No roster data received");
}

foreach($WMS_Update_decoded as $Item){
	try{
		$SQL_Update1a = "INSERT INTO WMS_Roster (role_id, weeks_id, prof_id, loc_id, day_mon, day_tue, day_wed, day_thu, day_fri, day_sat, day_sun ) VALUES (:role, :week, :user, :loc, :mon, :tue, :wed, :thu, :fri, :sat, :sun) ON DUPLICATE KEY UPDATE loc_id = VALUES(loc_id), day_mon = VALUES(day_mon), day_tue = VALUES(day_tue), day_wed = VALUES(day_wed), day_thu = VALUES(day_thu), day_fri = VALUES(day_fri), day_sat = VALUES(day_sat), day_sun = VALUES(day_sun);";
		$SQL_Update1b = $GLOBALS['SQL_Con']->prepare($SQL_Update1a);
		$SQL_Update1b->execute(['role' => $Item['role_id'], 'week' => $Item['weeks_id'], 'user' => $Item['prof_id'], 'loc'  => $Item['loc_id'], 'mon'  => $Item['day_mon'], 'tue'  => $Item['day_tue'], 'wed'  => $Item['day_wed'], 'thu'  => $Item['day_thu'], 'fri'  => $Item['day_fri'], 'sat'  => $Item['day_sat'], 'sun' => $Item['day_sun']]);
	} catch (PDOException $e) {
		echo "Database error: " . $e->getMessage();
	}
}?>