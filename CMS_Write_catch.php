<?PHP session_start();
include_once __DIR__ . "/CMS_Connection.php";
include_once __DIR__ . "/Function_lib/CMS_General_Functions.php";
include_once __DIR__ . "/CMS_Generate_Sub_items.php";
 
if(isset($_SESSION['Wr_New'])){
	//Generate CMS_Pages_Etc
	//set Wr_Next
	unset($_SESSION['Wr_New']);
}

if(isset($_SESSION['Wr_Next'], $_SESSION['Pre_Page_Id']) && $_SESSION['Wr_Next'] === 1){
	$CMS_Write_Qr1 = "SELECT * FROM cms_pages WHERE id = :CMS_Pre_id";
	$CMS_Write_Qr2 = $SCL_Con->prepare($CMS_Write_Qr1);
	$CMS_Write_Qr2->execute([':CMS_Pre_id' => $_SESSION['Pre_Page_Id']]);
	$CMS_Write_Qr3 = $CMS_Write_Qr2->fetch(PDO::FETCH_ASSOC);
	if($CMS_Write_Qr3['page_load_options']){
		$CMS_Path = $_SERVER['DOCUMENT_ROOT'] . "/" . $CMS_Write_Qr3['lang_Tx'] . "/" . $CMS_Write_Qr3['page_name'] . $CMS_Write_Qr3['page_ext'];
		$CMS_SET = fopen($CMS_Path, 'c');
		if($CMS_SET){
			$CMS_Content_Buffer = file_get_contents(__DIR__ . '/CMS_Template_Filestart.php');
			ob_start();
			CMS_Content_Generation($_SESSION['Pre_Page_Id']);
			$CMS_Content_Buffer .= ob_get_clean();
			$CMS_Content_Buffer .= file_get_contents(__DIR__ . '/CMS_Template_Fileend.php');
			fwrite($CMS_SET, $CMS_Content_Buffer);
			fclose($CMS_SET);
			$CMS_Write_Qr4 = "UPDATE cms_pages SET page_load_options = read WHERE id = :CMS_id";
			$CMS_Write_Qr5 = $SQL_Con->prepare($CMS_Write_Qr4);
			$CMS_Write_Qr5->execute([':CMS_id' => $_SESSION['Pre_Page_Id']]);
	} else {}
	
	unset($_SESSION['Wr_Next']); unset($_SESSION['Pre_Page_Id']);
}
?>