<?php
$CSM_Reg_txt255s = '/^[\p{L}\p{N}\s]+$/u';
$CSM_Reg_txt255ns = '/^[^\s]+$/';
$CSM_Reg_txt60 = '/^.{0,60}$/u';
$CSM_Reg_id = '/^\d+$/';
$CMS_Reg_Bool = '/^(true|false)$/i';
$CMS_Reg_Sel = '/^(text|textarea|email|checkbox|radio|button|number)$/i';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	//CMS_Form_field_translation
	if($_POST['CMS_Task'] === 'CMS_Form_field_translation'){
		if(isset($_POST['CMS_Field_Lang_5'])){
			$field_id = $_POST['CMS_Field_Lang_5'];
			$txt_button = $_POST['CMS_Field_Lang_4'];
			$txt_hover = $_POST['CMS_Field_Lang_3'];
			$txt_label = $_POST['CMS_Field_Lang_2'];
			$lan_id = $_POST['CMS_Field_Lang_1'];
			if(preg_match($CSM_Reg_id, $lan_id) && preg_match($CSM_Reg_id, $field_id) && preg_match($CSM_Reg_txt60, $txt_button) && preg_match($CSM_Reg_txt255s, $txt_hover) && preg_match($CSM_Reg_txt255ns, $txt_label)) {
				try{
				$CMS_InsCon1a = "INSERT INTO CMS_Form_field_translation (field_id, lang_id, lang_label, lang_placeholder, lang_center) VALUES (:field_id, :lan_id, :txt_label, :txt_hover, :txt_button)";
				$CMS_InsCon1b = $SQL_Con->prepare($CMS_InsCon1a);
				$CMS_InsCon1c = $CMS_InsCon1b->execute([':lan_id' => $lan_id, ':field_id' => $field_id, ':txt_button' => $txt_button, ':txt_hover' => $txt_hover, ':txt_label' => $txt_label]);
				if($CMS_InsCon1c){
					header("Location: success.php");
					exit;
				} else { echo "❌ Fail: Database record not inserted."; }
				} catch (PDOException $CMS_error) {
					echo "❌ Fail: " . $CMS_error->getMessage();
				}
			}
		}
	}
	//
	if($_POST['CMS_Task'] === 'CMS_Form_fields'){
		if(isset($_POST['CMS_Form_field_6'])){
			$field_id = $_POST['CMS_Form_field_1'];
			$For_ID = $_POST['CMS_Form_field_2']; 
			$For_Des = $_POST['CMS_Form_field_3'];
			$For_Req = $_POST['CMS_Form_field_4'];
			$For_Ord = $_POST['CMS_Form_field_5'];
			$Form_Id = $_POST['CMS_Form_field_6'];
			$For_Nam = $_POST['CMS_Form_field_7'];
			$For_Typ = $_POST['CMS_Form_field_8'];
			if(preg_match($CMS_Reg_id, $field_id) && preg_match($CSM_Reg_txt255ns, $For_Nam) && preg_match($CMS_Reg_txt255s, $For_Des) && preg_match($CMS_Reg_Bool, $For_Req) && preg_match($CMS_Reg_id, $Form_Id) && preg_match($CMS_Reg_Ord, $Form_Id) && preg_match($CMS_Reg_Sel, $For_Typ)){
				try{
				$CMS_InsCon2a = "INSERT INTO CMS_Form_fields (form_id, field_key, field_type, field_anker, field_description, field_required, sort_order) VALUES (:form_id, :field_key, :field_type, :field_anker, :field_description, :field_required, :sort_order)";
				$CMS_InsCon2b = $SQL_Con->prepare($CMS_InsCon2a);
				$CMS_InsCon2c = $CMS_InsCon2b->execute([':form_id' => $field_id, ':field_key' => $For_Nam, ':field_type' => $For_Typ, ':field_anker' => $For_ID, ':field_description' => $For_Des, ':field_required' => $For_Req, ':sort_order' => $For_Ord]);
				if($CMS_InsCon1c){
					header("Location: success.php");
					exit;
				} else { echo "❌ Fail: Database record not inserted."; }
				} catch (PDOException $CMS_error) {
					echo "❌ Fail: " . $CMS_error->getMessage();
				}
			}
		}
	}
}
?>