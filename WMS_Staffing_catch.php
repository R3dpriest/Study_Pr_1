<?PHP
$WMS_Update = file_get_contents('php://input');
$WMS_Update_decoded = json_decode($WMS_Update, true);
print_r($WMS_Update_decoded);
/*
// Haal de 'Data'-tag eruit
if(isset($WMS_Update_decoded['Data'])) {
	$dataArray = $WMS_Update_decoded['Data'];
} else {
	$dataArray = [];
}
try{
	$SQL_Update1a = "INSERT INTO your_table_name (role_id, weeks_id, prof_id, loc_id, day_mon, day_tue, day_wed, day_thu, day_fri, day_sat, day_sun ) VALUES (:role, :week, :user, :loc, :mon, :tue, :wed, :thu, :fri, :sat, :sun) ON DUPLICATE KEY UPDATE loc_id = VALUES(loc_id), day_mon = VALUES(day_mon), day_tue = VALUES(day_tue), day_wed = VALUES(day_wed), day_thu = VALUES(day_thu), day_fri = VALUES(day_fri), day_sat = VALUES(day_sat), day_sun = VALUES(day_sun);";
	$SQL_Update1b = $GLOBALS['SQL_Con']->prepare($SQL_Update1a);
	$SQL_Update1b->execute(['role' => $role_id, 'week' => $weeks_id, 'user' => $prof_id, 'loc'  => $loc_id, 'mon'  => $day_mon, 'tue'  => $day_tue, 'wed'  => $day_wed, 'thu'  => $day_thu, 'fri'  => $day_fri, 'sat'  => $day_sat, 'sun' => $day_sun]);
} catch (PDOException $e) {
	echo "Database error: " . $e->getMessage();
}
 
print_r($dataArray);*/
?>