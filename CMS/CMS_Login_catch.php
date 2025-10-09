<?php
session_start();
include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Connection.php";	
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_General_Functions.php';

/* Info
$_SESSION['CMS_1'] = User id
$_SESSION['CMS_2'] = User Name
$_SESSION['CMS_3'] = Rights
$_SESSION['CMS_4'] = User language
$_SESSION['CMS_5'] = Current Lan
*/

//Globals
global $CMS_ExTrans3;
global $SQL_Con;
global $CMS_Rights5;
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
	$_SESSION['CMS_1'] = CMS_Qry1c['id'];
	$_SESSION['CMS_2'] = CMS_Qry1c['username'];
	$_SESSION['CMS_3'] = $CMS_Qry3c;
}
 
/* isolate language */
function CMS_Define_Page(){
	$CMS_GetLang1 = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$CMS_GetLang2 = preg_replace('~/+~', '/', $CMS_GetLang1);
	$CMS_GetLang3 = explode('/', trim($CMS_GetLang2, '/'));
	$CMS_Rights1 = $CMS_GetLang3[count($CMS_GetLang3) - 1];
	$CMS_Rights2 = pathinfo($CMS_Rights1);
	$CMS_Rights_name = $CMS_Rights2['filename'];
	//$CMS_Rights_ext = '.' . $CMS_Rights2['extension'];
	$CMS_Rights_In = '.' . $CMS_Rights2['extension'];
	$CMS_Rights_Ex = explode('?', $CMS_Rights_In, 2);
	$CMS_Rights_ext  = $CMS_Rights_Ex[0];
	$CMS_Rights3 = "SELECT * FROM CMS_Pages WHERE page_name = :CMS_P_Name AND page_ext = :CMS_P_ext AND lang_id = :CMS_P_Lid";
	$CMS_Rights4 = $GLOBALS["SQL_Con"]->prepare($CMS_Rights3);
	$CMS_Rights4->execute([':CMS_P_Name' => $CMS_Rights_name, ':CMS_P_ext' => $CMS_Rights_ext, ':CMS_P_Lid' => $_SESSION['CMS_5']]);
	$CMS_Rights5 = $CMS_Rights4->fetch(PDO::FETCH_ASSOC);
	$CMS_GrabLang8 = $_SESSION['CMS_5'];
}

if($_GET['s'] == 1){
	if(!isset($_SESSION['CMS_1'])){
		CMS_Define_Page();
		CMS_GrabRawTranslations($CMS_Rights5['id'], $_SESSION['CMS_5']);
		if(isset($_POST['Log_username']) && $_POST['Log_password']){
			$Usr1 = $_POST['Log_username'];
			$Pw11 = $_POST['Log_password'];
			
			$CMS_Qry1a = "SELECT * FROM Prof_Users WHERE username = :PDO_username";
			$CMS_Qry1b = $SQL_Con->prepare($CMS_Qry1a);
			$CMS_Qry1b->execute([':PDO_username' => $Usr1]);
			$CMS_Qry1c = $CMS_Qry1b->fetch(PDO::FETCH_ASSOC);

			if($CMS_Qry1c && $CMS_Qry1c['hashed_password']) {
				if(password_verify($Pw11, $CMS_Qry1c['hashed_password'])){
					if($CMS_Qry1c['enabled'] === 1){
						// Recrommended Rehash Check
						if(password_needs_rehash($CMS_Qry1c['hashed_password'], PASSWORD_DEFAULT, ['cost' => 12])){	$newHash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]); 
							$CMS_Qry2a = $SQL_Con->prepare("UPDATE Prof_Users SET hashed_password = :hashed_password WHERE Prof_Users = :prof_user");
							$CMS_Qry2a->bindParam(':hashed_password', $hashedPassword);
							$CMS_Qry2a->bindParam(':prof_user',      $profUserKey);
							try{ $CMS_Qry2a->execute();
								if($stmt->rowCount()){
									// set update in db if needed
								} else {  echo "CMS.Log.Error 1"; } 
							} catch (PDOException $e){ echo "CMS.Log.Error 2: " . $e->getMessage(); }
						} 
							$_SESSION['CMS_1'] = $CMS_Qry1c['id'];
							$_SESSION['CMS_2'] = $CMS_Qry1c['username'];
							
							//Select Rights
							$CMS_Qry3a = "SELECT r.id FROM Prof_Users u INNER JOIN Prof_right_profiles rp ON u.right_names_id = rp.right_names_id INNER JOIN Prof_Rights r ON rp.rights_id = r.id WHERE u.id = :P_id";
							$CMS_Qry3b = $SQL_Con->prepare($CMS_Qry3a);
							$CMS_Qry3b->execute([':P_id' => $CMS_Qry1c['id']]);
							$CMS_Qry3C = $CMS_Qry3b->fetchAll(PDO::FETCH_COLUMN);
							
							//Select Language					
							$CMS_Qry4a = "SELECT prof.lang_id FROM Prof_profiles prof INNER JOIN Prof_Users user ON prof.users_id = user.id WHERE user.id = :P_id";
							$CMS_Qry4b = $SQL_Con->prepare($CMS_Qry4a);
							$CMS_Qry4b->execute([':P_id' => $CMS_Qry1c['id']]);
							$CMS_Qry4C = $CMS_Qry3b->fetch(PDO::FETCH_COLUMN);
							$_SESSION['CMS_3'] = $CMS_Qry3C;
							$_SESSION['CMS_4'] = $CMS_Qry4C;
							$_SESSION['CMS_5'] = $CMS_Qry4C;
							header('Location: Index.php'); exit();
						} else { header('Location: CMS_Login.php?M='.urlencode($CMS_ExTrans3['CMS_Log_Er2'])); exit(); }
				} else { header('Location: CMS_Login.php?M='.urlencode($CMS_ExTrans3['CMS_Log_Er1'])); exit(); }
			} else { header('Location: CMS_Login.php?M='.urlencode($CMS_ExTrans3['CMS_Log_Er1'])); exit(); }
		} else { header('Location: CMS_Login.php'); exit(); }
	}
}

if($_GET['s'] == 2){
	CMS_Define_Page();
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
		
		if(!preg_match($CMS_Validator->CMS_Email, $Mai1)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Nm']); $E++; echo "1";}
		if(!preg_match($CMS_Validator->CMS_PwLength, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw1']); $E++; echo "2";}
		if(!preg_match($CMS_Validator->CMS_PwLength, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw1']); $E++; echo "3";}
		if(!preg_match($CMS_Validator->CMS_PwLow, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw2']); $E++; echo "4";}
		if(!preg_match($CMS_Validator->CMS_PwLow, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw2']); $E++; echo "5";}
		if(!preg_match($CMS_Validator->CMS_PwUp, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw3']); $E++; echo "6";}
		if(!preg_match($CMS_Validator->CMS_PwUp, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw3']); $E++; echo "7";}
		if(!preg_match($CMS_Validator->CMS_PwDig, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw4']); $E++; echo "9";}
		if(!preg_match($CMS_Validator->CMS_PwDig, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw4']); $E++; echo "0";}
		if(!preg_match($CMS_Validator->CMS_PwSpe, $Pw11)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw5']); $E++; echo "10";}
		if(!preg_match($CMS_Validator->CMS_PwSpe, $Pw21)){ array_push($Error, $CMS_ExTrans3['CMS_Log_0Pw5']); $E++; echo "11";}
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
		
	//	CMS_Log_GrabRights($Default_Prof);
		header('Location: CMS_Login.php?M=' . urlencode($CMS_ExTrans3['CMS_Log_LSu'])); exit();
		} catch(PDOException $SQL_Error) {
			echo "There was a database[0] error: " . $SQL_Error->getMessage(); exit;
		}
		 
	} else {
	echo "<html><head>";
	include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html';
	echo "<title>" . $CMS_Rights5['page_head'] . "</title></head><body>";
	
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
if($_GET['s'] == 3){
	session_destroy();
	header('Location: CMS_Login.php'); exit();
}
?>