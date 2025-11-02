<?PHP
include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Template_Filestart.php"; 



global $CSY, $CSA, $CSB, $CSC, $CSD, $CSE, $CSF, $CSG, $CGY, $CGA, $CGB, $CGC, $CGD, $CGE, $CGF, $CGG, $CYY, $CLY;
$CSY = []; $CGY = "";	$CYY = []; $CLY = "";
$CSA = []; $CGA = ""; 	$CSB = []; $CGB = "";
$CSC = []; $CGC = "";	$CSD = []; $CGD = "";
$CSE = []; $CGE = "";	$CSF = []; $CGF = "";
$CSG = []; $CGG = "";
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
	foreach($GLOBALS['JobArray'] as $Day){
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
if(!isset($_GET['L'])){
	$CMS_Target = $_SESSION['CMS_7'];
} else {
	if(is_numeric($_GET['L'])){
		$CMS_Target = $_GET['L'];
	} else { $CMS_Target = $_SESSION['CMS_7']; }
}
global $WMS_Gr_Week3;
if(isset($_GET['X'])){
	$WMS_Gr_Week1 = "SELECT id FROM wms_weeks WHERE :date BETWEEN start_date AND end_date;";
	$WMS_Gr_Week2 = $GLOBALS['SQL_Con']->prepare($WMS_Gr_Week1);
	$WMS_Gr_Week2->execute([':date' => $_GET['X']]);
	$WMS_Gr_Week3 = $WMS_Gr_Week2->fetch(PDO::FETCH_ASSOC);
} else {
	$WMS_Gr_Week1 = "SELECT id FROM wms_weeks WHERE DATE_FORMAT(NOW(), '%Y-%m-%d') BETWEEN start_date AND end_date;";
	$WMS_Gr_Week2 = $GLOBALS['SQL_Con']->prepare($WMS_Gr_Week1);
	$WMS_Gr_Week2->execute();
	$WMS_Gr_Week3 = $WMS_Gr_Week2->fetch(PDO::FETCH_ASSOC);
}

echo "<Script> const Param = new URLSearchParams(window.location.search);
const URLParse = new URLSearchParams(window.location.search);
const URLParse_L = URLParse.get('L');
if (URLParse_L !== null && URLParse_L !== ''){ window.loc_id = URLParse_L; } else { window.loc_id = ".$_SESSION['CMS_7']."; } window.WMS_SelWeek = ".$WMS_Gr_Week3['id']." ; </script> ";
echo '<script src="Javascript/WMS_General.js" defer></script>';
/*$WMS_QRY1a = "SELECT WS.day_mon, WS.day_tue, WS.day_wed, WS.day_thu, WS.day_fri, WS.day_sat, WS.day_sun, WR.id AS role_id, WR.name AS role_name, PU.id AS user_id, PU.username, PP.date_gone_start, PP.date_gone_end, PP.first_name, PP.last_name, PP.roles_id, PT.start_TiO, PT.end_TiO FROM Prof_Users PU JOIN Prof_Time_off PT JOIN Prof_profiles PP JOIN WMS_Roles WR JOIN WMS_Roster WS WHERE WS.loc_id = PP.loc_id AND PP.loc_ID = :loc_id AND PU.enabled = true AND PP.staff = true"; */
$WMS_QRY1a = "SELECT PU.id AS user_id, PU.username, PP.first_name, PP.last_name, PP.date_gone_start, PP.date_gone_end, pp.roles_id, WR.id AS role_id, WR.name AS role_name FROM Prof_profiles PP LEFT JOIN prof_users PU ON PU.id = PP.users_id LEFT JOIN WMS_Locations WL ON PP.loc_id = WL.id LEFT JOIN WMS_Roles WR ON WR.id = PP.roles_id WHERE PU.enabled = TRUE AND PP.staff = TRUE AND PP.loc_id =  :loc_id; ";
$WMS_QRY1b = $GLOBALS['SQL_Con']->prepare($WMS_QRY1a);
$WMS_QRY1b->execute([':loc_id' => $CMS_Target]);
$WMS_QRY1c = $WMS_QRY1b->fetchAll(PDO::FETCH_ASSOC);
foreach ($WMS_QRY1c as $ReIndex) {
	$CYY[$ReIndex['user_id']] = $ReIndex;
	WMS_CreateSelectList('Mo'.$ReIndex['user_id'], $ReIndex['roles_id']);
	$CLY .= '<li data-id="'.$ReIndex['user_id'].'"><div><div>'.$ReIndex['first_name'].' '.$ReIndex['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
	array_push($CSY, $ReIndex['user_id']);
}

$WMS_QRY2a = "SELECT * FROM WMS_Roster WHERE loc_id = :loc_id AND weeks_id = :week";
$WMS_QRY2b = $GLOBALS['SQL_Con']->prepare($WMS_QRY2a);
$WMS_QRY2b->execute([':loc_id' => $CMS_Target, ':week' => $WMS_Gr_Week3['id']]);
$WMS_QRY2c = $WMS_QRY2b->fetchAll(PDO::FETCH_ASSOC);

foreach($WMS_QRY2c as $STF){
	if($STF['day_mon']) { $CSA[] = [$STF['prof_id'], $STF['role_id']]; }
	if($STF['day_tue']) { $CSB[] = [$STF['prof_id'], $STF['role_id']]; }
	if($STF['day_wed']) { $CSC[] = [$STF['prof_id'], $STF['role_id']]; }
	if($STF['day_thu']) { $CSD[] = [$STF['prof_id'], $STF['role_id']]; }
	if($STF['day_fri']) { $CSE[] = [$STF['prof_id'], $STF['role_id']]; }
	if($STF['day_sat']) { $CSF[] = [$STF['prof_id'], $STF['role_id']]; }
	if($STF['day_sat']) { $CSG[] = [$STF['prof_id'], $STF['role_id']]; }
}

foreach($CSA as $A){
	WMS_CreateSelectList('Mon'.$A[0].'-'.$CYY[$A[0]]['role_id'], $A[1]);
	$CGA .= '<li data-id="'.$A[0].'"><div><div>'.$CYY[$A[0]]['first_name'].' '.$CYY[$A[0]]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSB as $B){
	WMS_CreateSelectList('Tue'.$B[0].'-'.$CYY[$B[0]]['role_id'], $B[1]);
	$CGB .= '<li data-id="'.$B[0].'"><div><div>'.$CYY[$B[0]]['first_name'].' '.$CYY[$B[0]]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSC as $C){
	WMS_CreateSelectList('Wed'.$C[0].'-'.$CYY[$C[0]]['role_id'], $C[1]);
	$CGC .= '<li data-id="'.$C[0].'"><div><div>'.$CYY[$C[0]]['first_name'].' '.$CYY[$C[0]]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSD as $D){
	WMS_CreateSelectList('Thu'.$D[0].'-'.$CYY[$D[0]]['role_id'], $D[1]);
	$CGD .= '<li data-id="'.$D[0].'"><div><div>'.$CYY[$D[0]]['first_name'].' '.$CYY[$D[0]]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSE as $E){
	WMS_CreateSelectList('Fri'.$E[0].'-'.$CYY[$E[0]]['role_id'], $E[1]);
	$CGE .= '<li data-id="'.$E[0].'"><div><div>'.$CYY[$E[0]]['first_name'].' '.$CYY[$E[0]]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSF as $F){
	WMS_CreateSelectList('Sat'.$F[0].'-'.$CYY[$F[0]]['role_id'], $F[1]);
	$CGF .= '<li data-id="'.$F[0].'"><div><div>'.$CYY[$F[0]]['first_name'].' '.$CYY[$F[0]]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
foreach($CSG as $G){ 
	WMS_CreateSelectList('Sun'.$G[0].'-'.$CYY[$G[0]]['role_id'], $G[1]);
	$CGG .= '<li data-id="'.$G[0].'"><div><div>'.$CYY[$G[0]]['first_name'].' '.$CYY[$G[0]]['last_name'].'</div><div>'.$CSL.'<button class="CMS_Dup">+</button></div></div></li>';
}
$CSY = array_unique($CSY);
foreach($CSY as $Y){
	$CGY .= '<input type="hidden" class="WMS_Stf_grp" value="'.$Y.'">';
}
?>
<div class="WMS_Cal_Container"><div class="WMS_Cal_Top CMS_DisFlex">

<div class="WMS_Cal_TLeft CMS_DisBox">
	<h3>Monday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr" id="WMS_Mon"><?PHP echo $CGA; ?></ul>
	<h3>Tuesday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr" id="WMS_Tue"><?PHP echo $CGB; ?></ul>
	<h3>Wednesday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr" id="WMS_Wed"><?PHP echo $CGC; ?></ul>
	<h3>Thursday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr" id="WMS_Thu"><?PHP echo $CGD; ?></ul>
</div>
<div class="WMS_Cal_Center CMS_DisBox">
	<h3>Friday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr" id="WMS_Fri"><?PHP echo $CGE; ?></ul>
	<h3>Saterday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr" id="WMS_Sat"><?PHP echo $CGF; ?></ul>
	<h3>Sunday</h3>
	<ul class="WMS_Roster_Active WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr" id="WMS_Sun"><?PHP echo $CGG; ?></ul>
</div>
<div id="WMS_Ro_All"><?PHP echo $CGY; ?></div>



<div class="WMS_Cal_TRight"><div class="WMS_Cal_Loc"><h2>Locations</h2><?PHP WMS_GrabAllLocations('WMS_Ros_loc'); echo $GLOBALS['Gxe']; ?>

</div><div class="WMS_Cal_Cal"><h2>Calander</h2><div class="CMS_Cal_Header CMS_DisFlex"><div class="CMS_DisBox CMS_FlNstr CMS_DisFlex CMS_AlCen"><button onclick="CMS_Cal_CM(-1)">←</button></div><div class="CMS_DisBox CMS_TaCe"><h2 id="CMS_Mo_Ye"></h2></div><div class="CMS_DisBox CMS_FlNstr CMS_DisFlex CMS_AlCen"><button onclick="CMS_Cal_CM(1)">→</button></div></div><div class="CMS_Cal_Week" id="CMS_Cal_Week"></div><div class="CMS_Cal_Grid" id="CMS_Cal_Grid"></div></div><div><h2>Options:</h2><button class="CMS_But" type="button" id="WMS_UpD">Update</button></div></div></div>
<div class="WMS_Cal_Bot CMS_DisFlex"><div class="staff WMS_Cal_BLeft CMS_DisBox" id="WMS_Mo_AvSt"><h2>Available Staff</h2><ul id="WMS_Cal_Ava" class="WMS_Roster_Available WMS_Cal_Sort CMS_SL_N CMS_Cu_Gr">
<?PHP echo $CLY; ?>
</ul></div><div class="staff WMS_Cal_BRight CMS_DisBox" id="unWMS_Mo_AvSt"><h2>[not implemented]Unavailable Staff</h2><ul id="WMS_Cal_Una" class="WMS_Roster_Unav CMS_SL_N">
<?PHP /* echo $CSY; */ ?>

</ul></div></div></div>