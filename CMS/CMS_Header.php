<?php
session_start();
include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Connection.php";	
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_General_Functions.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_Content_menu.php';

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
$CMS_GetLang1 = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$CMS_GetLang2 = preg_replace('~/+~', '/', $CMS_GetLang1); // Suggestion form Co-pilot - implementing regular expression
$CMS_GetLang3 = explode('/', trim($CMS_GetLang2, '/'));
if(Isset($CMS_GetLang3) && count($CMS_GetLang3) >= 2 ){ echo "a";
	$CMS_GetLang4 = $CMS_GetLang3[count($CMS_GetLang3) - 2];
	if(preg_match('/^[A-z]{2}$/', $CMS_GetLang4)){
		$CMS_GetLang5 = strtoupper($CMS_GetLang4); // ^[A-z]{2}$ <== start | small or big alphabet 2x | end
    }
	$CMS_GrabLang6 = "SELECT id FROM CMS_Lang WHERE lang_key = ':CMS_Lang'";
	$CMS_GrabLang7 = $SQL_Con->prepare($CMS_GrabLang6);
	$CMS_GrabLang7->execute([':CMS_Lang' => $CMS_GrabLang5]);
	$CMS_GrabLang8 = $CMS_GrabLang7->fetch(PDO::FETCH_ASSOC);
} else { 
	if(isset($_SESSION['CMS_4'])){ $CMS_GrabLang8 = $_SESSION['CMS_4']; } else { $CMS_GrabLang8 = 0;}
}

$CMS_Rights1      = $_SERVER['REQUEST_URI'];
$CMS_Rights_parts = explode('?', $CMS_Rights1, 2);
$CMS_Rights2      = pathinfo($CMS_Rights_parts[0]);
$CMS_Rights_name  = $CMS_Rights2['filename'];
$CMS_Rights_ext   = '.' . $CMS_Rights2['extension'];
if (isset($CMS_Rights_parts[1])) {
    $CMS_Rights_ext .= '?' . $CMS_Rights_parts[1];
}
$CMS_Rights3 = "SELECT * FROM CMS_Pages WHERE page_name = :CMS_P_Name AND page_ext = :CMS_P_ext AND lang_id = :CMS_P_Lid";
$CMS_Rights4 = $SQL_Con->prepare($CMS_Rights3);
$CMS_Rights4->execute([':CMS_P_Name' => $CMS_Rights_name, ':CMS_P_ext' => $CMS_Rights_ext, ':CMS_P_Lid' => $CMS_GrabLang8]);
$CMS_Rights5 = $CMS_Rights4->fetch(PDO::FETCH_ASSOC);


//if(isset($_SESSION['CMS_3']) && $CMS_Rights5['read_write_id'] === $_SESSION['CMS_3']){ $CMS_Write = 1; include_once __dir__ . "/CMS/Function_lib/CMS_Head.html"; } else { $CMS_Write = 0; }

if(isset($_SESSION['CMS_3']) && in_array($CMS_Rights5['read_write_id'], $_SESSION['CMS_3'], true)){ $CMS_Write = 1; include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html'; } else { $CMS_Write = 0; }
//if(in_array($CMS_Rights5['read_id'] === $_SESSION['CMS_3']) || $CMS_Rights5['read_write_id'] === $_SESSION['CMS_3']) || $CMS_Rights5['read_id'] === 0){ 
if(isset($_SESSION['CMS_3'],$CMS_Rights5['read_id'],$CMS_Rights5['read_write_id']) &&( in_array($CMS_Rights5['read_id'], $_SESSION['CMS_3'], true) || in_array($CMS_Rights5['read_write_id'], $_SESSION['CMS_3'], true) || $CMS_Rights5['read_id'] === 0)){	
	echo "<html><head>";
	include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html';
	echo "<title>" . $CMS_Rights5['page_head'] . "</title></head><body>";
	
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Top.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Menu.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Sub_items.php";
	CMS_GrabRawTranslations($CMS_Rights5['id'], $CMS_GrabLang8);
	if(isset($CMS_Rights5['page_load_options'])){
		switch ($CMS_Rights5['page_load_options']){
			case "read":
			break;
			case "lock":
			break;
			case "write":
				$_SESSION['Wr_Next'] = 1;
				$_SESSION['Pre_Page_Id'] = $CMS_Rights5['id'];
			header('Location: '. __dir__ .''); exit();
			break;
			case "process":
				CMS_Content_Generation($CMS_Rights5['id']);
			break;
			default:
				CMS_Content_Generation($CMS_Rights5['id']);
			break;
		}
	} else { CMS_Content_Generation(); }
} else { 
	include_once __dir__ . DIRECTORY_SEPARATOR . 'CMS_Head.html';
	echo "<title>" . $CMS_Rights5['page_head'] . "</title></head><body>";
	
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Top.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Menu.php";
	include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Generate_Sub_items.php";
	echo "<div class='CMS_DisFlex CMS_JuCen CMS_AlCen CMS_80vh'><div class=''><img class='CMS_ER_I' src='Images\blocked.png'></div></div></body></html>"; exit();
}

?>