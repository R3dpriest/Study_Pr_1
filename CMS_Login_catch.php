<?php
session_start();
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_Sec_Extra.php';
 
CMS_TOK();

include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Connection.php";	
include_once __dir__ . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'CMS_Config.php';
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_General_Functions.php';

//Globals
global $CMS_ExTrans3;
global $SQL_Con;
class CMS_Validation {
	public string $CMS_Username = '/^\p{L}+$/u';
	public string $CMS_Email = '/^(?:(?:[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*)|(?:"(?:\\[\x00-\x7F]|[^\x00-\x08\x0A-\x1F\x7F"])*"))@(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[A-Za-z]{2,}|\\[(?:(?:25[0-5]|2[0-4]\d|[01]?\d?\d)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d?\d)\])$/';
	public string $CMS_PwLength  = '/^.{8,20}$/u';
	public string $CMS_PwLow   = '/\p{Ll}/u';
	public string $CMS_PwUp   = '/\p{Lu}/u';
	public string $CMS_PwDig   = '/\p{Nd}/u';
	public string $CMS_PwSpe = '/[\p{P}\p{S}]/u'; 
}

//Functions 
function CMS_IsolateLanguage($RiId){
	
	$CMS_Qry3a  = 'SELECT right_id FROM Prof_right_profiles WHERE right_names_id = :right_names_id';
	$CMS_Qry3b = $GLOBALS["SQL_Con"]->prepare($CMS_Qry3a);
	$CMS_Qry3b->execute([':right_names_id' => $RiId]);
	$CMS_Qry3c = $CMS_Qry3b->fetchAll();
	$_SESSION['CMS_1'] = $CMS_Qry1c['id'];
	$_SESSION['CMS_2'] = $CMS_Qry1c['username'];
	$_SESSION['CMS_3'] = $CMS_Qry3c;
}

// handles login.
if($_GET['Q'] == 1){
	if(!isset($_SESSION['CMS_1'])){
		CMS_GrabLang();
		CMS_GrabRights();
		CMS_GrabRawTranslations($GLOBALS["CMS_Rights"]['id'], $_SESSION['CMS_5']);
		if(isset($_POST['Log_username']) && $_POST['Log_password']){
			$Usr1 = $_POST['Log_username'];
			$Pw11 = $_POST['Log_password'];
			CMS_User_id($Usr1);
			if($GLOBALS['CMS_Prof_Data'] && $GLOBALS['CMS_Prof_Data']['hashed_password']){
				if(password_verify($Pw11, $GLOBALS['CMS_Prof_Data']['hashed_password'])){
					if($GLOBALS['CMS_Prof_Data']['enabled'] === 1){
						CMS_Log_Auth();
						if(isset($_POST['Log_stay'])){ 
							CMS_Log_SetCookie();
						} else {
							setcookie('CMS_Remember_me', '', ['expires' => time() - 3600, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
						}
						header('Location: Index.php'); exit();
					} else { header('Location: CMS_Login.php?M='.urlencode($CMS_ExTrans3['CMS_Log_Er2'])); exit(); }
				} else { header('Location: CMS_Login.php?M='.urlencode($CMS_ExTrans3['CMS_Log_Er1'])); exit(); }
			} else { header('Location: CMS_Login.php?M='.urlencode("1".$CMS_ExTrans3['CMS_Log_Er1'])); exit();  }
		} else { header('Location: CMS_Login.php'); exit(); }
	}
}
// handles account creation
if($_GET['Q'] == 2){
	CMS_GrabLang();
	CMS_GrabRights();
	if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password1']) || !isset($_POST['password2'])){ header('Location: CMS_Login.php'); exit();}
	$CMS_Validator = new CMS_Validation();
	// create account.
	$Usr1 = $_POST['username'];
	$Mai1 = $_POST['email'];
	$Pw11 = $_POST['password1'];
	$Pw21 = $_POST['password2'];
	$Error = []; $E = 0;
	
	if(!strlen($Pw11) == 0 || !strlen($Pw21) == 0 || !strlen($Usr1) == 0 || !strlen($Mai1) == 0) {
		//username
		if(!preg_match($CMS_Validator->CMS_Username, $Usr1)){ array_push($Error, "Only letters A–Z allowed."); $E++;}
		$CMS_Qry1a = "SELECT COUNT(*) AS total FROM Prof_Users WHERE username = :PDO_username";
		$CMS_Qry1b = $SQL_Con->prepare($CMS_Qry1a);
		$CMS_Qry1b->execute([':PDO_username' => $Usr1]);
		$CMS_Qry1_count = $CMS_Qry1b->fetchColumn();
		if($CMS_Qry1_count !== 0){array_push($Error, $CMS_ExTrans3['CMS_Log_0Au']); $E++;}
		$CMS_Qry2a = "SELECT COUNT(*) AS total FROM Prof_Users WHERE email = :PDO_email";
		$CMS_Qry2b = $SQL_Con->prepare($CMS_Qry2a);
		$CMS_Qry2b->execute([':PDO_email' => $Mai1]);
		$CMS_Qry2_count = $CMS_Qry2b->fetchColumn();
		if($CMS_Qry2_count !== 0){array_push($Error, $CMS_ExTrans3['CMS_Log_0Ae']); $E++;}
		
		if(!preg_match($CMS_Validator->CMS_Email, $Mai1)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Nm']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwLength, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw1']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwLength, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw1']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwLow, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw2']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwLow, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw2']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwUp, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw3']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwUp, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw3']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwDig, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw4']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwDig, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw4']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwSpe, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw5']); $E++;}
		if(!preg_match($CMS_Validator->CMS_PwSpe, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw5']); $E++;}
		if($Pw11 !== $Pw21){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw6']); $E++;}
	} else {
		array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw7']); $E++;
	}
	if($E == 0){
		//hashpassword
		try { 
		$PwHs = password_hash($Pw11, PASSWORD_DEFAULT, ['cost' => 12]);
		//Create Basic Account
		$Default_Prof = 2;
		$CMS_Ins1a = "INSERT INTO Prof_Users (username, email, hashed_password, right_names_id, enabled) VALUES (:PDO_username, :PDO_email, :PDO_password, :PDO_DefRi, 1)";
		$CMS_Ins1b = $SQL_Con->prepare($CMS_Ins1a);
		$CMS_Ins1b->execute([':PDO_username' => $Usr1, ':PDO_email' => $Mai1, ':PDO_password' => $PwHs, ':PDO_DefRi' => $Default_Prof]);
		$CMS_Ins2a = "SELECT id FROM Prof_Users WHERE username = :PDO_username";
		$CMS_Ins2b = $SQL_Con->prepare($CMS_Ins2a);
		$CMS_Ins2b->execute([':PDO_username' => $Usr1]);
		$CMS_Ins2c = $CMS_Ins2b->fetch(PDO::FETCH_ASSOC);
		$CMS_Ins3a = "INSERT INTO Prof_profiles (users_id, first_name, last_name, street, city, donor, client, staff, vegetarian, lang_id) VALUES(:P_id, '', '', '', '', false, false, false, false, 0)";
		$CMS_Ins3b = $SQL_Con->prepare($CMS_Ins3a);
		$CMS_Ins3b->execute([':P_id' => $CMS_Ins2c['id']]);
		
		CMS_Log_GrabRights($Default_Prof);
		header('Location: CMS_Login.php?M=' . urlencode($CMS_ExTrans3['CMS_Log_LSu'])); exit();
		} catch(PDOException $SQL_Error) {
			echo "There was a database[0] error: " . $SQL_Error->getMessage(); exit;
		}
		 
	} else {
	echo "<html><head>";
	include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html';
	echo "<title>" . $GLOBALS["CMS_Rights"]['page_head'] . "</title></head><body>";
	
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Top.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Menu.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Sub_items.php";
	echo "<div class='CMS_DisFlex CMS_JuCen CMS_AlCen CMS_80vh'><div class=''><h2>".$CMS_ExTrans3['CMS_Log_Erd']."</h2><div class='CMS_DisFlex'>";
	foreach($Error as $Err){
		echo "<div class='CMS_LB_E CMS_DisBox CMS_m_R_5'>" . $Err . "</div>";	
	}
	echo "</div>
	<div class='CMS_m_T_11'><a href='CMS_Login.php' class='CMS_But CMS_But_a'>".$CMS_ExTrans3['CMS_Log_Erb']."</a></div></div></div>"; 

	}
}
if($_GET['Q'] == 3){
	$CMS_User = $_SESSION['CMS_1'];
	CMS_Log_remove();
	session_destroy();
	header('Location: CMS_Login.php'); exit();
}
if($_GET['Q'] == 4){
	$CMS_User = $_SESSION['CMS_1'];
	CMS_Log_remove();
	session_destroy();
	header('Location: CMS_Login.php'); exit();
}
?>