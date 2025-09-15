<?PHP // $_SESSION['Pre_Page_Id'] = previous page --- 	$_SESSION['Wr_Next'] --> Says there might be a write up ahead
session_start();
include_once __dir__ . "/CMS_Connection.php";	
include_once __dir__ . '/Function_lib/CMS_General_Functions.php';

// Language Preset
if(!isset($_SESSION['Lang'])){ $_SESSION['Lang'] = 0; }

// Language URL
$CMS_GetLang1 = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$CMS_GetLang2 = preg_replace('~/+~', '/', $CMS_GetLang1); // Suggestion form Co-pilot - implementing regular expression
$CMS_GetLang3 = explode('/', trim($CMS_GetLang2, '/'));
if(Isset($CMS_GetLang3) && count($CMS_GetLang3) >= 2 ){
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

// Check rights (page identification)
$CMS_Rights1 = $CMS_GetLang3[count($CMS_GetLang3) - 1];
$CMS_Rights2 = pathinfo($CMS_Rights1);
$CMS_Rights_name = $CMS_Rights2['filename'];
$CMS_Rights_ext = '.' . $CMS_Rights['extention'];
$CMS_Rights3 = "SELECT * FROM CMS_Pages WHERE page_name = ':CMS_P_Name' AND page_ext = ':CMS_P_ext' AND lang_id = ':CMS_P_Lid'";
$CMS_Rights4 = $SQL_Con->prepare($CMS_Rights3);
$CMS_Rights4->execute([':CMS_P_Name' => $CMS_Rights_name, ':CMS_P_ext' => $CMS_Rights_ext, ':CMS_P_Lid' => $CMS_GrabLang8]);
$CMS_Rights5 = $CMS_Rights4->fetch(PDO::FETCH_ASSOC);

if($CMS_Rights5['read_write_id'], $_SESSION['CMS_3']){$CMS_Write = 1; include_once __dir__ . "/CMS/Function_lib/CMS_Head.html"; } else { $CMS_Write = 0 }
if(in_array($CMS_Rights5['read_id'], $_SESSION['CMS_3']) || $CMS_Rights5['read_write_id'], $_SESSION['CMS_3']) || $CMS_Rights5['read__id'] === 0){
 ?>
<html lang="en">
<head>
	<?PHP include_once __dir__ . "/CMS/CMS_Head.html";?>
	<title><?PHP echo CMS_Rights5['page_head']; ?></title>
</head>
<body>
<?PHP
include_once __dir__ . "/CMS_Generate_Top.php";
include_once __dir__ . "/CMS_Generate_Menu.php";
include_once __dir__ . "/CMS_Generate_Sub_items.php";
// Check what is needed on the page
if(isset($CMS_Rights5['page_load_options'])){
	switch ($CMS_Rights5['page_load_options']){
		case "read":
		break;
		case "write":
			$_SESSION['Wr_Next'] = 1;
			$_SESSION['Pre_Page_Id'] = $CMS_Rights5['id'];
			header('Location: '. __dir__ .''); exit();
		break;
		case "process":
			CMS_Content_Generation($CMS_Rights3['id']);
		break;
		default:
			CMS_Content_Generation($CMS_Rights3['id']);
		break;
	}
} else {
	CMS_Content_Generation();
	break;
}

} else { header('Location: Index.php?E=R1'); exit(); }
?>