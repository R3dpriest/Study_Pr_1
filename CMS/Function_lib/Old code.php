/*	$CMS_Rights1      = $_SERVER['REQUEST_URI'];
	$CMS_Rights_parts = explode('?', $CMS_Rights1, 2);
	$CMS_Rights2      = pathinfo($CMS_Rights_parts[0]);
	$CMS_Rights_name  = $CMS_Rights2['filename'];
	$CMS_Rights_ext   = '.' . $CMS_Rights2['extension'];
	if (isset($CMS_Rights_parts[1])) {
		$CMS_Rights_ext .= '?' . $CMS_Rights_parts[1];
	}
	$CMS_Rights3 = "SELECT * FROM CMS_Pages WHERE page_name = :CMS_P_Name AND page_ext = :CMS_P_ext AND lang_id = :CMS_P_Lid";
	$CMS_Rights4 = $GLOBALS["SQL_Con"]->prepare($CMS_Rights3);
	$CMS_Rights4->execute([':CMS_P_Name' => $CMS_Rights_name, ':CMS_P_ext' => $CMS_Rights_ext, ':CMS_P_Lid' => $GLOBALS["CMS_Lang"]]);
	$CMS_Rights = $CMS_Rights4->fetch(PDO::FETCH_ASSOC);*/
	
	//if(isset($_SESSION['CMS_3']) && $GLOBALS["CMS_Rights"]['read_write_id'] === $_SESSION['CMS_3']){ $CMS_Write = 1; include_once __dir__ . "/CMS/Function_lib/CMS_Head.html"; } else { $CMS_Write = 0; }
	//if(in_array($GLOBALS["CMS_Rights"]['read_id'] === $_SESSION['CMS_3']) || $GLOBALS["CMS_Rights"]['read_write_id'] === $_SESSION['CMS_3']) || $GLOBALS["CMS_Rights"]['read_id'] === 0){ 