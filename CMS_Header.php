<!DOCTYPE html><?php
session_start();
include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Connection.php";
include_once __dir__ . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'CMS_Config.php';
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_General_Functions.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_Content_menu.php';

if(!isset($_SESSION['CMS_0'])){
	$_SESSION['CMS_0'] = '1';
	CMS_Log_Auto();
}


// Language Preset
if(!isset($_SESSION['Lang'])){ $_SESSION['Lang'] = 0; }
if(!isset($_SESSION['CMS_3'])){
	$profile = 0;
	$PreA = "SELECT rights_id FROM `prof_right_profiles` WHERE `right_names_id` = :profile";
	$PreB = $SQL_Con->prepare($PreA);
	$PreB->execute([':profile' => $profile]);
	$PreC = $PreB->fetchAll(PDO::FETCH_COLUMN);
	$_SESSION['CMS_3'] = $PreC;
	$_SESSION['CMS_4'] = 0; $_SESSION['CMS_5'] = 0;
}

// Language URL
CMS_GrabLang();
CMS_GrabRights();

if(isset($_SESSION['CMS_3']) && in_array($GLOBALS["CMS_Rights"]['read_write_id'], $_SESSION['CMS_3'], true)){ $CMS_Write = 1; include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html'; } else { $CMS_Write = 0; }
if(isset($_SESSION['CMS_3'],$GLOBALS["CMS_Rights"]['read_id'],$GLOBALS["CMS_Rights"]['read_write_id']) &&( in_array($GLOBALS["CMS_Rights"]['read_id'], $_SESSION['CMS_3'], true) || in_array($GLOBALS["CMS_Rights"]['read_write_id'], $_SESSION['CMS_3'], true) || $GLOBALS["CMS_Rights"]['read_id'] === 0)){	
	echo "<!doctype html><html><head>";
	include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html';
	echo "<title>" . $GLOBALS["CMS_Rights"]['page_head'] . "</title></head><body>";
	
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Top.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Menu.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Sub_items.php";
	CMS_GrabRawTranslations($GLOBALS["CMS_Rights"]['id'], $GLOBALS["CMS_Lang"]);
	if(isset($GLOBALS["CMS_Rights"]['page_load_options'])){
		switch ($GLOBALS["CMS_Rights"]['page_load_options']){
			case "read":
			break;
			case "lock":
			break;
			case "write":
				$_SESSION['Wr_Next'] = 1;
				$_SESSION['Pre_Page_Id'] = $GLOBALS["CMS_Rights"]['id'];
			header('Location: '. __dir__ .''); exit();
			break;
			case "process":
				CMS_Content_Generation($GLOBALS["CMS_Rights"]['id']);
			break;
			default:
				CMS_Content_Generation($GLOBALS["CMS_Rights"]['id']);
			break;
		}
	} else { CMS_Content_Generation(); }
} else { 
	include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html';
	echo "<title>" . $GLOBALS["CMS_Rights"]['page_head'] . "</title></head><body>";
	
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Top.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Menu.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Sub_items.php";
	echo "<div class='CMS_DisFlex CMS_JuCen CMS_AlCen CMS_80vh'><div class=''><img class='CMS_ER_I' src='Images\blocked.png'></div></div></body></html>"; exit();
}

?>