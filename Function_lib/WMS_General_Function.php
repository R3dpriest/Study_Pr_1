<?PHP 
function UpGrabLangData(P_Name){
	$GrabPage1 = "SELECT * FROM CMS_Pages WHERE page_name = :page_name AND lang_id = :lang_id";
	$GrabPage2 = $SQL_Con->prepare($GrabPage1);
	$GrabPage2->execute([':page_name' => $P_Name, ':lang_id' => $_SESSION['CMS_5']]);
	$GrabPage3 = $GrabPage3->fetchAll(PDO::FETCH_ASSOC);
	$LangSel1 = "SELECT * FROM CMS_Translations_Other WHERE page_id = :page_id";
	$LangSel2 = $SQL_Con->prepare($LangSel1);
	$LangSel2->execute(['page_id' => $GrabPage3['id']])
	$LangSel3 = $LangSel2->fetchAll(PDO::FETCH_ASSOC);
}
?>