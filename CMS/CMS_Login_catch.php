<?php
session_start();
/* Info
$_SESSION['CMS_1'] = User id
$_SESSION['CMS_2'] = User Name
$_SESSION['CMS_3'] = Rights
$_SESSION['CMS_4'] = User language
$_SESSION['CMS_5'] = Current Lan
*/

//Globals

public const CMS_Username = '/^\p{L}+$/u';
public const CMS_Email = '/^(?:(?:[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*)|(?:"(?:\\[\x00-\x7F]|[^\x00-\x08\x0A-\x1F\x7F"])*"))@(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[A-Za-z]{2,}|\\[(?:(?:25[0-5]|2[0-4]\d|[01]?\d?\d)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d?\d)\])$/';
public const CMS_PwLength  = '/^.{8,20}$/u';
public const CMS_PwLow   = '/\p{Ll}/u';
public const CMS_PwUp   = '/\p{Lu}/u';
public const CMS_PwDig   = '/\p{Nd}/u';
public const CMS_PwSpe = '/[\p{P}\p{S}]/u'; 

//Functions 

function CMS_Log_GrabRights(RiId){
	$CMS_Qry3a  = 'SELECT right_id FROM Prof_right_profiles WHERE right_names_id = :right_names_id';
	$CMS_Qry3b = $SQL_Con->prepare($CMS_Qry3a);
	$CMS_Qry3b->execute([':right_names_id' => $RiId]);
	$CMS_Qry3c = $CMS_Qry3b->fetchAll();
	$_SESSION['CMS_1'] = CMS_Qry1c['id'];
	$_SESSION['CMS_2'] = CMS_Qry1c['username'];
	$_SESSION['CMS_3'] = $CMS_Qry3c;
}

//Sequence

if($_GET['s'] === 1){
	$Usr1 = $_POST['Log_username'];
	$Pw11 = $_POST['Log_password'];
	
	$CMS_Qry1a = "SELECT * FROM Prof_Users WHERE Usr_name = :PDO_username";
	$CMS_Qry1b = $SQL_Con->prepare($sql);
	$CMS_Qry1b->execute([':PDO_username' => $Usr1]);
	$CMS_Qry1c = $CMS_Qry1b->fetch();

	if($CMS_Qry1c['hashed_password']){
		if (password_verify($_POST['password'], $CMS_Qry1c['hashed_password'])){
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
			//Check if account is enabled
			if($CMS_Qry1c === 1){
				CMS_Log_GrabRights($[CMS_Qry1c['right_names_id']]);
			} else { header('Location: /CMS/CMS_Login.html?M='.urlencode('Error: User inactive'); exit(); }
		} else { header('Location: /CMS/CMS_Login.html?M='.urlencode('Error: User/Password.'); exit(); }
	} else { header('Location: /CMS/CMS_Login.html?M='.urlencode('Error: L1'); exit(); }
}

if($_GET['s'] === 2){
	// create account.
	$Usr1 = $_POST['username'];
	$Mai1 = $_POST['email'];
	$Pw11 = $_POST['password1'];
	$Pw21 = $_POST['password2'];
	$Error = []; $E = 0;
	
	if(!strlen($Pw11 === 0) || !strlen($Pw21 === 0) || !strlen($Usr1 === 0) || !strlen($Mai1 === 0){
		//username
		if(!preg_match(self::CMS_Username, $User1)){ array_push($Error, "Only letters A–Z allowed."); $E++;}
		$CMS_Qry1a = "SELECT COUNT(*) AS total FROM Prof_Users WHERE Usr_name = :PDO_username";
		$CMS_Qry1b = $SQL_Con->prepare($sql);
		$CMS_Qry1b->execute(['PDO_username' => $Usr1]);
		$CMS_Qry1_count = $CMS_Qry1b->fetchColumn();
		if($CMS_Qry1_count !== 0){array_push($Error, "A user with this name exists"); $E++;}
		//email
		if(!preg_match(self::CMS_Email, $Mai1)){ array_push($Error, "Only letters A–Z allowed."); $E++;}
		//password
		if(!preg_match(self::CMS_PwLength, $Pw11)){ array_push($Error, "Password must be 8–20 characters long."); $E++;}
		if(!preg_match(self::CMS_PwLength, $Pw21)){ array_push($Error, "Password must be 8–20 characters long."); $E++;}
		if(!preg_match(self::CMS_PwLow, $Pw11)){ array_push($Error, "Password must include at least one lowercase letter"); $E++;}
		if(!preg_match(self::CMS_PwLow, $Pw21)){ array_push($Error, "Password must include at least one lowercase letter"); $E++;}
		if(!preg_match(self::CMS_PwUp, $Pw11)){ array_push($Error, "Password must include at least one uppercase letter"); $E++;}
		if(!preg_match(self::CMS_PwUp, $Pw21)){ array_push($Error, "Password must include at least one uppercase letter"); $E++;}
		if(!preg_match(self::CMS_PwDig, $Pw11)){ array_push($Error, "Password must include at least one digit"); $E++;}
		if(!preg_match(self::CMS_PwDig, $Pw21)){ array_push($Error, "Password must include at least one digit"); $E++;}
		if(!preg_match(self::CMS_PwSpe, $Pw11)){ array_push($Error, "Password must include at least one special character"); $E++;}
		if(!preg_match(self::CMS_PwSpe, $Pw21)){ array_push($Error, "Password must include at least one special character"); $E++;}
		if($Pw11 !== $Pw21){ array_push($Error, "Password must match"); $E++;}
	} else {
		array_push($Error, "An empty field was detected"); $E++;
	}
	if($E === 0){
		//hashpassword
		$PwHs = password_hash($Pw11, PASSWORD_DEFAULT, ['cost' => 12]);
		//escaped insert
		$Default_Prof = 2;
		$CMS_Ins1a = "INSERT INTO Prof_Users (username, email, hashed_password, right_names_id, enabled) VALUES (':PDO_username' ,':PDO_email' ,':PDO_password' ,:PDO_DefRi ,1)";
		$CMS_Ins1b = $SQL_Con->prepare($CMS_Ins1a);
		$CMS_Ins1b->execute([':PDO_username' => $Usr1, ':PDO_email' => $Mai1, ':PDO_password' => $PwHs], ':PDO_DefRi' => $Default_Prof);
		CMS_Log_GrabRights($Default_Prof);
		
		
	} else { header('Location: /CMS/CMS_Login.html?N='.urlencode($Error); exit(); }
}
?>