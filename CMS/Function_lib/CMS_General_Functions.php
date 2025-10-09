<?PHP 
function LoadPrevPage($Msge){
	if(isset($Msge)){
		$Ex = '?Msg=';
	} else { $Ex = ''; }
	if(isset($_SESSION['Pre_Page'])){
		header('Location: '.$_SESSION['Pre_Page'] . $Ex . urlencode($Msge));
		exit;
	}
}
function StorePage(){
	$Pro = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
	$Hos = $_SERVER['HTTP_HOST'];
	$Pag = $_SERVER['REQUEST_URI'];
	$_SESSION['Pre_Page'] = $Pro . $Hos . $Pag;
}
function CMS_GrabRawTranslations($P_id, $L_id){
	global $SQL_Con, $CMS_ExTrans3; 
    $CMS_ExTrans1 = "SELECT handle_tag, text FROM cms_translations_other WHERE page_id = :P_id AND lang_id = :L_id";
    $CMS_ExTrans2 = $SQL_Con->prepare($CMS_ExTrans1);
    $CMS_ExTrans2->execute([':P_id' => $P_id, ':L_id' => $L_id]);
    $CMS_ExTrans3 = $CMS_ExTrans2->fetchAll(PDO::FETCH_KEY_PAIR);
    return $CMS_ExTrans3;
}
?>