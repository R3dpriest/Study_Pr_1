<?PHP
	
global $CSY, $CSA, $CSB, $CSC, $CSD, $CSE, $CSF, $CSG, $CGY, $CGA, $CGB, $CGC, $CGD, $CGE, $CGF, $CGG, $CYY, $CLY, $CSH;
$CSY = []; $CGY = "";	$CYY = []; $CLY = "";
$CSA = []; $CGA = ""; 	$CSB = []; $CGB = "";
$CSC = []; $CGC = "";	$CSD = []; $CGD = "";
$CSE = []; $CGE = "";	$CSF = []; $CGF = "";
$CSG = []; $CGG = "";	$CSH = "";
function WMS_CreateJobList(){
	global $JobArray;
	static $WMS_RosterCheck = false;
	if($WMS_RosterCheck){return;}
	$WMS_RosterCheck = true;
	$JobArray = [];
	$WMS_QRY2a = "SELECT id, name FROM WMS_Roles";
	$WMS_QRY2b = $GLOBALS['SQL_Con']->prepare($WMS_QRY2a);
	$WMS_QRY2b->execute();
	$WMS_QRY2c = $WMS_QRY2b->fetchAll(PDO::FETCH_ASSOC);
	foreach($WMS_QRY2c as $Item){
		$JobArray[] = ['id' => $Item['id'], 'name' => $Item['name']];
	}
}
function WMS_CreateSelectList($Id, $Default){
	WMS_CreateJobList();
	global $CSL;	$CSL = "";
	$CSL .= "<select id='".htmlspecialchars($Id)."' name='".htmlspecialchars($Id)."'>";
	if($Default === null){
		$CSL .= "<option value='99999' hidden selected>Select</option>";
	}
	foreach($JobArray as $Day){
		$CSL.= "<option value='".htmlspecialchars($Day['id'])."'";
		if($Day['id'] == $Default){
			$CSL.= " selected";
		}
		$CSL.= ">".htmlspecialchars($Day['name'])."</option>";
	}
	$CSL .= "</select>";
	return $CSL;
}
function CMS_DateCheck($date_start, $date_end){
	$CMS_CurDate = date('Y-m-d');
	if($CMS_CurDate >= $date_start && $CMS_CurDate >= $date_end){
	}
}
/*$WMS_QRY1a = "SELECT WS.day_mon, WS.day_tue, WS.day_wed, WS.day_thu, WS.day_fri, WS.day_sat, WS.day_sun, WR.id AS role_id, WR.name AS role_name, PU.id AS user_id, PU.username, PP.date_gone_start, PP.date_gone_end, PP.first_name, PP.last_name, PP.roles_id, PT.start_TiO, PT.end_TiO FROM Prof_Users PU JOIN Prof_Time_off PT JOIN Prof_profiles PP JOIN WMS_Roles WR JOIN WMS_Roster WS WHERE WS.loc_id = PP.loc_id AND PP.loc_ID = :loc_id AND PU.enabled = true AND PP.staff = true"; */
$WMS_QRY1a = "SELECT PU.id AS user_id, PU.username, PP.first_name, PP.last_name,
PP.date_gone_start, PP.date_gone_end, WR.id AS role_id, WR.name AS role_name,
WS.day_mon, WS.day_tue, WS.day_wed, WS.day_thu, WS.day_fri, WS.day_sat, WS.day_sun
FROM Prof_Users PU JOIN Prof_profiles PP ON PU.id = PP.users_id LEFT JOIN WMS_Roles WR ON PP.roles_id = WR.id JOIN WMS_Roster WS ON WS.prof_id = PU.id AND WS.loc_id = PP.loc_id
WHERE PU.enabled = TRUE AND PP.staff = TRUE AND PP.loc_id = :loc_id;";
$WMS_QRY1b = $GLOBALS['SQL_Con']->prepare($WMS_QRY1a);
$WMS_QRY1b->execute([':loc_id' => $lan_id]);
$WMS_QRY1c = $WMS_QRY1b->fetchAll(PDO::FETCH_ASSOC);
foreach ($WMS_QRY1c as $ReIndex) {
	
	if (!empty($ReIndex['date_gone_start']) && !empty($ReIndex['date_gone_end'])) {
		$WMS_Gone = strtotime($ReIndex['date_gone_start'] . ' ' . $ReIndex['date_gone_end']);
		$WMS_Now = time();
		if ($WMS_Now <= $WMS_Gone) {
			$WMS_Gone = true;
		}
	}

	if($WMS_Gone){
		$CSH .= '<li data-id="'.$ReIndex['user_id'].'"><div><div>'.$ReIndex['first_name'].' '.$ReIndex['last_name'].'</div><div><select><option>-</option></select><button class="CMS_Dup">x</button></div></div></li>';
	} else {
		$CYY[$ReIndex['user_id']] = $ReIndex;
		WMS_CreateSelectList('Mo'.$ReIndex['user_id'], $ReIndex['roles_id']);
		$CLY .= '<li data-id="'.$ReIndex['user_id'].'"><div><div>'.$ReIndex['first_name'].' '.$ReIndex['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
	}
}

$WMS_QRY2a = "SELECT * FROM WMS_Roster WHERE loc_id = :loc_id";
$WMS_QRY2b = $GLOBALS['SQL_Con']->prepare($WMS_QRY2a);
$WMS_QRY2b->execute([':loc_id' => $lan_id]);
$WMS_QRY2c = $WMS_QRY2b->fetchAll(PDO::FETCH_ASSOC);
foreach($WMS_QRY2c as $STF){
	if($STF['day_mon'] === true){ $CSA = $STF['user_id']; $CSY = $STF['user_id'];}
	if($STF['day_tue'] === true){ $CSB = $STF['user_id']; $CSY = $STF['user_id'];}
	if($STF['day_wed'] === true){ $CSC = $STF['user_id']; $CSY = $STF['user_id'];}
	if($STF['day_thu'] === true){ $CSD = $STF['user_id']; $CSY = $STF['user_id'];}
	if($STF['day_fri'] === true){ $CSE = $STF['user_id']; $CSY = $STF['user_id'];}
	if($STF['day_sat'] === true){ $CSF = $STF['user_id']; $CSY = $STF['user_id'];}
	if($STF['day_sat'] === true){ $CSG = $STF['user_id']; $CSY = $STF['user_id'];}
}
foreach($CSA as $A){
	WMS_CreateSelectList('Mo'.$A, $ReIndex[$A]['roles_id']);
	$CGA .= '<li data-id="'.$A.'"><div><div>'.$ReIndex[$A]['first_name'].' '.$ReIndex[$A]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSB as $B){
	WMS_CreateSelectList('Mo'.$B, $ReIndex[$B]['roles_id']);
	$CGB .= '<li data-id="'.$B.'"><div><div>'.$ReIndex[$B]['first_name'].' '.$ReIndex[$B]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSC as $C){
	WMS_CreateSelectList('Mo'.$C, $ReIndex[$C]['roles_id']);
	$CGC .= '<li data-id="'.$C.'"><div><div>'.$ReIndex[$C]['first_name'].' '.$ReIndex[$C]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSD as $D){
	WMS_CreateSelectList('Mo'.$D, $ReIndex[$D]['roles_id']);
	$CGD .= '<li data-id="'.$D.'"><div><div>'.$ReIndex[$D]['first_name'].' '.$ReIndex[$D]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSE as $E){
	WMS_CreateSelectList('Mo'.$E, $ReIndex[$E]['roles_id']);
	$CGE .= '<li data-id="'.$E.'"><div><div>'.$ReIndex[$E]['first_name'].' '.$ReIndex[$E]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSF as $F){
	WMS_CreateSelectList('Mo'.$F, $ReIndex[$F]['roles_id']);
	$CGF .= '<li data-id="'.$F.'"><div><div>'.$ReIndex[$F]['first_name'].' '.$ReIndex[$F]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSG as $G){
	WMS_CreateSelectList('Mo'.$G, $ReIndex[$G]['roles_id']);
	$CGG .= '<li data-id="'.$G.'"><div><div>'.$ReIndex[$G]['first_name'].' '.$ReIndex[$G]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
$CSY = array_unique($CSY);
foreach($CSY as $Y){
	$CGY .= '<input type="hidden" class="WMS_Stf_grp" value="'.$Y.'">';
}
?>
<div class="WMS_Cal_Container"><div class="WMS_Cal_Top CMS_DisFlex">

<div class="WMS_Cal_TLeft CMS_DisBox">
	<h3>Monday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr"><?PHP echo $CSA; ?></ul>
	<h3>Tuesday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr"><?PHP echo $CSB; ?></ul>
	<h3>Wednesday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr"><?PHP echo $CSC; ?></ul>
	<h3>Thursday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr"><?PHP echo $CSD; ?></ul>
</div>
<div class="WMS_Cal_Center CMS_DisBox">
	<h3>Friday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr"><?PHP echo $CSE; ?></ul>
	<h3>Saterday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr"><?PHP echo $CSF; ?></ul>
	<h3>Sunday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr"><?PHP echo $CSG; ?></ul>
</div>
<div id="WMS_Ro_All"><?PHP echo $CSY; ?></div>



<div class="WMS_Cal_TRight"><div class="WMS_Cal_Loc"><h2>Locations</h2><?PHP GrabAllLocations('WMS_Ros_loc'); echo $GLOBALS['Gxe']; ?>

</div><div class="WMS_Cal_Cal"><h2>Calander</h2><div class="CMS_Cal_Header CMS_DisFlex"><div class="CMS_DisBox CMS_FlNstr CMS_DisFlex CMS_AlCen"><button onclick="CMS_Cal_CM(-1)">←</button></div><div class="CMS_DisBox CMS_TaCe"><h2 id="CMS_Mo_Ye"></h2></div><div class="CMS_DisBox CMS_FlNstr CMS_DisFlex CMS_AlCen"><button onclick="CMS_Cal_CM(1)">→</button></div></div><div class="CMS_Cal_Week" id="CMS_Cal_Week"></div><div class="CMS_Cal_Grid" id="CMS_Cal_Grid"></div></div></div></div>
<div class="WMS_Cal_Bot CMS_DisFlex"><div class="staff WMS_Cal_BLeft CMS_DisBox" id="WMS_Mo_AvSt"><h2>Available Staff</h2><ul id="WMS_Cal_Ava" class="WMS_Roster_Available WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr">
<? echo $CSY; ?>
</ul></div><div class="staff WMS_Cal_BRight CMS_DisBox" id="unWMS_Mo_AvSt"><h2>Unavailable Staff</h2><ul id="WMS_Cal_Una" class="WMS_Roster_Unav CMS_SL_N">
<?PHP echo $CSH; ?>
</ul></div></div></div>