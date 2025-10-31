<?PHP

session_start();
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_Sec_Extra.php';

//CMS_TOK();

include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Connection.php";
include_once __dir__ . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'CMS_Config.php';
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_General_Functions.php';


function CMS_GrabPageTypes($GLO){
	$GrabTypes1 = "SELECT * FROM CMS_Page_types";
	$GrabTypes2 = $GLOBALS['SQL_Con']->prepare($GrabTypes1);
	$GrabTypes2->execute();
	$GrabTypes3 = $GrabTypes2->fetchAll(PDO::FETCH_ASSOC);
	return $GrabTypes3;
}
$CMS_Ck_Id = '/^[A-Za-z][A-Za-z0-9\-_:.]*$/';
$CMS_Ck_Discr = '/^[A-Za-z0-9 .,!?]+$/';

//update scripts
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['CMS_YF']) && strlen($_POST['CMS_YF']) >= 1){
		switch($_POST['CMS_YF']){
			case "1":
	//		print_r($_POST);
				CMS_TOK2($_POST['CMS_EDI_E0']);
				if(is_numeric($_POST['CMS_EDI_E1']) && strlen($_POST['CMS_EDI_E2']) >= 1 && parse_url($_POST['CMS_EDI_E4'])){
					
					$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
					$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
					$CMS_Upd_Dat1a = "UPDATE CMS_Forms SET name = :CMS_EDI_E2, description = :CMS_EDI_E3, location = :CMS_EDI_E4 WHERE id = :CMS_EDI_E1";
					$CMS_Upd_Dat1b = $GLOBALS['SQL_Con']->prepare($CMS_Upd_Dat1a);
					$CMS_Upd_Dat1b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4]);
				}
			break;
			case "2":
				$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
				$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
				$CMS_EDI_E5 = $_POST['CMS_EDI_E5'] ?? ''; $CMS_EDI_E6 = $_POST['CMS_EDI_E6'] ?? '';
				$CMS_EDI_E7 = $_POST['CMS_EDI_E7'] ?? ''; $CMS_EDI_E8 = $_POST['CMS_EDI_E8'] ?? '';
				$CMS_Upd_Dat2a = "UPDATE CMS_Form_fields SET form_id = :CMS_EDI_E2, field_key = :CMS_EDI_E3, field_type = :CMS_EDI_E4, field_anker = :CMS_EDI_E5, field_description = :CMS_EDI_E6, field_required = :CMS_EDI_E7 , sort_order = :CMS_EDI_E8 WHERE id = :CMS_EDI_E1";
				$CMS_Upd_Dat2b = $GLOBALS['SQL_Con']->prepare($CMS_Upd_Dat2a);
				$CMS_Upd_Dat2b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4, ':CMS_EDI_E5' => $CMS_EDI_E5, ':CMS_EDI_E6' => $CMS_EDI_E6, ':CMS_EDI_E7' => $CMS_EDI_E7, ':CMS_EDI_E8' => $CMS_EDI_E8]);
			break;
			case "3":
				$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
				$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
				$CMS_EDI_E5 = $_POST['CMS_EDI_E5'] ?? ''; $CMS_EDI_E6 = $_POST['CMS_EDI_E6'] ?? '';
				$CMS_EDI_E7 = $_POST['CMS_EDI_E7'] ?? ''; $CMS_EDI_E8 = $_POST['CMS_EDI_E8'] ?? '';
				$CMS_EDI_E9 = $_POST['CMS_EDI_E9'] ?? '';
				$CMS_Upd_Dat3a = "UPDATE CMS_Pages SET page_name = :CMS_EDI_E2, page_ext = :CMS_EDI_E3, lang_id = :CMS_EDI_E4, lang_Tx = :CMS_EDI_E5, read_id = :CMS_EDI_E6, read_write_id = :CMS_EDI_E7, page_head = :CMS_EDI_E8, page_load_options = :CMS_EDI_E9 WHERE id = :CMS_EDI_E1";
				$CMS_Upd_Dat3b = $GLOBALS['SQL_Con']->prepare($CMS_Upd_Dat3a);
				$CMS_Upd_Dat3b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4, ':CMS_EDI_E5' => $CMS_EDI_E5, ':CMS_EDI_E6' => $CMS_EDI_E6, ':CMS_EDI_E7' => $CMS_EDI_E7, ':CMS_EDI_E8' => $CMS_EDI_E8, ':CMS_EDI_E9' => $CMS_EDI_E9]);
			break;
		}
	}
	if(isset($_POST['CMS_YFA']) && strlen($_POST['CMS_YFA']) >= 1){
		switch($_POST['CMS_YFA']){
			case "1":
	//		print_r($_POST);
				CMS_TOK2($_POST['CMS_EDI_E0']);
				if(is_numeric($_POST['CMS_EDI_E1']) && is_numeric($_POST['CMS_EDI_E2']) && strlen($_POST['CMS_EDI_E3']) >= 1 && ctype_alpha($_POST['CMS_EDI_E4']) && preg_match($CMS_Ck_Id, $_POST['CMS_EDI_E5']) && (preg_match($CMS_Ck_Discr, $_POST['CMS_EDI_E6']) || strlen($_POST['CMS_EDI_E6']) === 0) && is_numeric($_POST['CMS_EDI_E7']) && is_numeric($_POST['CMS_EDI_E8'])){
					$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
					$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
					$CMS_EDI_E5 = $_POST['CMS_EDI_E5'] ?? ''; $CMS_EDI_E6 = $_POST['CMS_EDI_E6'] ?? '';
					$CMS_EDI_E7 = $_POST['CMS_EDI_E7'] ?? ''; $CMS_EDI_E8 = $_POST['CMS_EDI_E8'] ?? '';
					$CMS_Upd_Dat1a = "UPDATE CMS_Form_fields SET form_id = :CMS_EDI_E2, field_key = :CMS_EDI_E3, field_type = :CMS_EDI_E4, field_anker = :CMS_EDI_E5, field_description = :CMS_EDI_E6, field_required = :CMS_EDI_E7 , sort_order = :CMS_EDI_E8 WHERE id = :CMS_EDI_E1";
					$CMS_Upd_Dat1b = $GLOBALS['SQL_Con']->prepare($CMS_Upd_Dat1a);
					$CMS_Upd_Dat1b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4, ':CMS_EDI_E5' => $CMS_EDI_E5, ':CMS_EDI_E6' => $CMS_EDI_E6, ':CMS_EDI_E7' => $CMS_EDI_E7, ':CMS_EDI_E8' => $CMS_EDI_E8]);
				}
			break;
			case "2":
				$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
				$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
				$CMS_EDI_E5 = $_POST['CMS_EDI_E5'] ?? ''; $CMS_EDI_E6 = $_POST['CMS_EDI_E6'] ?? '';
				$CMS_EDI_E7 = $_POST['CMS_EDI_E7'] ?? ''; $CMS_EDI_E8 = $_POST['CMS_EDI_E8'] ?? '';
				$CMS_Upd_Dat2a = "UPDATE CMS_Form_fields SET form_id = :CMS_EDI_E2, field_key = :CMS_EDI_E3, field_type = :CMS_EDI_E4, field_anker = :CMS_EDI_E5, field_description = :CMS_EDI_E6, field_required = :CMS_EDI_E7 , sort_order = :CMS_EDI_E8 WHERE id = :CMS_EDI_E1";
				$CMS_Upd_Dat2b = $GLOBALS['SQL_Con']->prepare($CMS_Upd_Dat2a);
				$CMS_Upd_Dat2b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4, ':CMS_EDI_E5' => $CMS_EDI_E5, ':CMS_EDI_E6' => $CMS_EDI_E6, ':CMS_EDI_E7' => $CMS_EDI_E7, ':CMS_EDI_E8' => $CMS_EDI_E8]);
			break;
			case "3":
				$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
				$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
				$CMS_EDI_E5 = $_POST['CMS_EDI_E5'] ?? ''; $CMS_EDI_E6 = $_POST['CMS_EDI_E6'] ?? '';
				$CMS_EDI_E7 = $_POST['CMS_EDI_E7'] ?? ''; $CMS_EDI_E8 = $_POST['CMS_EDI_E8'] ?? '';
				$CMS_EDI_E9 = $_POST['CMS_EDI_E9'] ?? '';
				$CMS_Upd_Dat3a = "UPDATE CMS_Pages SET page_name = :CMS_EDI_E2, page_ext = :CMS_EDI_E3, lang_id = :CMS_EDI_E4, lang_Tx = :CMS_EDI_E5, read_id = :CMS_EDI_E6, read_write_id = :CMS_EDI_E7, page_head = :CMS_EDI_E8, page_load_options = :CMS_EDI_E9 WHERE id = :CMS_EDI_E1";
				$CMS_Upd_Dat3b = $GLOBALS['SQL_Con']->prepare($CMS_Upd_Dat3a);
				$CMS_Upd_Dat3b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4, ':CMS_EDI_E5' => $CMS_EDI_E5, ':CMS_EDI_E6' => $CMS_EDI_E6, ':CMS_EDI_E7' => $CMS_EDI_E7, ':CMS_EDI_E8' => $CMS_EDI_E8, ':CMS_EDI_E9' => $CMS_EDI_E9]);
			break;
		}
	}
	//Q=1
	if(isset($_POST['CMS_Sel_Fo1']) && strlen($_POST['CMS_Sel_Fo1']) >= 1){
		$CMS_Sel_Fo1_data = "";
		$CMS_Sel_Fo1 = $_POST['CMS_Sel_Fo1'];
		$CMS_Content1a = "SELECT * FROM CMS_Forms WHERE id = :CMS_Sel_Fo1";
		$CMS_Content1b = $GLOBALS['SQL_Con']->prepare($CMS_Content1a);
		$CMS_Content1b->execute([':CMS_Sel_Fo1' => $CMS_Sel_Fo1]);
		$CMS_Content1c = $CMS_Content1b->fetch(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo1_data .= $CMS_Content1c['id'] . "»" . $CMS_Content1c['name'] . "»" . $CMS_Content1c['description'] . "»" . $CMS_Content1c['location'] . "»" . $CMS_Content1c['created_on'] . "»";
		$CMS_Content2a = "SELECT * FROM CMS_Form_fields WHERE form_id = :CMS_Sel_Fo1";
		$CMS_Content2b = $GLOBALS['SQL_Con']->prepare($CMS_Content2a);
		$CMS_Content2b->execute([':CMS_Sel_Fo1' => $CMS_Sel_Fo1]);
		$CMS_Content2c = $CMS_Content2b->fetchAll(PDO::FETCH_ASSOC);
		foreach($CMS_Content2c as $U1a){
			$CMS_Sel_Fo1_data .= "<option value='".$U1a['id']."' placeholder='".$U1a['field_description']."'>".$U1a['field_key']."</option>";
		}
		echo $CMS_Sel_Fo1_data;
	}
	if(isset($_POST['CMS_Sel_FoE1']) && strlen($_POST['CMS_Sel_FoE1']) >= 1){
		$CMS_Sel_FoE1 = $_POST['CMS_Sel_FoE1'];
		$CMS_Content21a = "SELECT * FROM CMS_Form_fields WHERE id = :CMS_Sel_FoE1";
		$CMS_Content21b = $GLOBALS['SQL_Con']->prepare($CMS_Content21a);
		$CMS_Content21b->execute([':CMS_Sel_FoE1' => $CMS_Sel_FoE1]);
		$CMS_Content21c = $CMS_Content21b->fetch(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo1_data = [
			'CMS_SUB_ID' => $CMS_Content21c['id'],
			'CMS_SUB_FID' => $CMS_Content21c['form_id'],
			'CMS_SUB_Key' => $CMS_Content21c['field_key'],
			'CMS_SUB_Typ' => $CMS_Content21c['field_type'],
			'CMS_SUB_Ank' => $CMS_Content21c['field_anker'],
			'CMS_SUB_Dis' => $CMS_Content21c['field_description'],
			'CMS_SUB_Req' => $CMS_Content21c['field_required'],
			'CMS_SUB_Ord' => $CMS_Content21c['sort_order'],
		];
		header('Content-Type: application/json');
		echo json_encode($CMS_Sel_Fo1_data);
	}

	//Q=2
	if(isset($_POST['CMS_Sel_Fo2']) && strlen($_POST['CMS_Sel_Fo2']) >= 1){
		$CMS_Sel_Fo2 = $_POST['CMS_Sel_Fo2'];
		$CMS_Content3a = "SELECT * FROM CMS_Form_fields WHERE id = :CMS_Sel_Fo2";
		$CMS_Content3b = $GLOBALS['SQL_Con']->prepare($CMS_Content3a);
		$CMS_Content3b->execute([':CMS_Sel_Fo2' => $CMS_Sel_Fo2]);
		$CMS_Content3c = $CMS_Content3b->fetch(PDO::FETCH_ASSOC);
		$CMS_Content31a = "SELECT lang_id FROM CMS_Form_field_translation WHERE field_id = :CMS_Sel_Fo2";
		$CMS_Content31b = $GLOBALS['SQL_Con']->prepare($CMS_Content31a);
		$CMS_Content31b->execute([':CMS_Sel_Fo2' => $CMS_Sel_Fo2]);
		$CMS_Content31c = $CMS_Content31b->fetchAll(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo2_data = [
			'CMS_EDI_E1' => $CMS_Content3c['id'],
			'CMS_EDI_E2' => $CMS_Content3c['form_id'],
			'CMS_EDI_E3' => $CMS_Content3c['field_key'],
			'CMS_EDI_E4' => $CMS_Content3c['field_type'],
			'CMS_EDI_E5' => $CMS_Content3c['field_anker'],
			'CMS_EDI_E6' => $CMS_Content3c['field_description'],
			'CMS_EDI_E7' => $CMS_Content3c['field_required'],
			'CMS_EDI_E8' => $CMS_Content3c['sort_order'],
			'CMS_Lang_Sel' => $CMS_Content31c,
		];
		header('Content-Type: application/json');
		echo json_encode($CMS_Sel_Fo2_data);
	}
	//Q=2
	
	if(isset($_POST['CMS_Sel_FoE2']) && strlen($_POST['CMS_Sel_FoE2']) && isset($_POST['CMS_Sel_FoA2']) && strlen($_POST['CMS_Sel_FoA2']) >= 1){
		$CMS_Sel_FoE2 = $_POST['CMS_Sel_FoE2'];	$CMS_Sel_FoA2 = $_POST['CMS_Sel_FoA2'];
		$CMS_Content32a = "SELECT * FROM CMS_Form_field_translation WHERE field_id = :CMS_Sel_FoA2 AND lang_id = :CMS_Sel_FoE2";
		$CMS_Content32b = $GLOBALS['SQL_Con']->prepare($CMS_Content32a);
		$CMS_Content32b->execute([':CMS_Sel_FoE2' => $CMS_Sel_FoE2, ':CMS_Sel_FoA2' => $CMS_Sel_FoA2]);
		$CMS_Content32c = $CMS_Content32b->fetch(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo2A_data = [
			'CMS_EDI_F1' => $CMS_Content32c['id'],
			'CMS_EDI_F2' => $CMS_Content32c['field_id'],
			'CMS_EDI_F3' => $CMS_Content32c['lang_id'],
			'CMS_EDI_F4' => $CMS_Content32c['lang_label'],
			'CMS_EDI_F5' => $CMS_Content32c['lang_placeholder'],
			'CMS_EDI_F6' => $CMS_Content32c['lang_center'],
		];
		header('Content-Type: application/json');
		echo json_encode($CMS_Sel_Fo2A_data);
	}


//form subfields

	if(isset($_POST['CMS_Sel_Fo3']) && strlen($_POST['CMS_Sel_Fo3']) >= 1){
		$CMS_Sel_Fo3_data = "";
		$CMS_Sel_Fo3 = $_POST['CMS_Sel_Fo3'];	
		$CMS_Content5a = "SELECT * FROM CMS_Pages WHERE id = :CMS_Sel_Fo3";
		$CMS_Content5b = $GLOBALS['SQL_Con']->prepare($CMS_Content5a);
		$CMS_Content5b->execute([':CMS_Sel_Fo3' => $CMS_Sel_Fo3]);
		$CMS_Content5c = $CMS_Content5b->fetchAll(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo3_data .= $CMS_Content5c['id'] . "»" . $CMS_Content5c['page_name'] . "»" . $CMS_Content5c['page_ext'] . "»" . $CMS_Content5c['lang_id'] . "»" . $CMS_Content5c['lang_Tx'] . "»" . $CMS_Content5c['read_id'] . "»" . $CMS_Content5c['read_write_id'] . "»" . $CMS_Content5c['page_head'] . "»" . $CMS_Content5c['page_load_options'] . "»" . $CMS_Content5c['created_on'] . "»";
		
		$CMS_Content6a = "SELECT * FROM CMS_Page_content WHERE Pages_id = :CMS_Sel_Fo3 ORDER BY sort ASC;";
		$CMS_Content6b = $GLOBALS['SQL_Con']->prepare($CMS_Content6a);
		$CMS_Content6b->execute([':CMS_Sel_Fo3' => $CMS_Sel_Fo3]);
		$CMS_Content6c = $CMS_Content6b->fetchAll(PDO::FETCH_ASSOC);
		CMS_GrabPageTypes();
		foreach($CMS_Content6c as $U3a){
			foreach($GrabTypes3 as $PageType){
				if($PageType['id'] === $U3a['Page_types_id']){
					$Type = $PageType['option_type'];
					$Type_Desc = $PageType['option_description'];
				}
			}
			$CMS_Sel_Fo3_data .= '<div class="CMS_EDI_Sub_item"><div class="CMS_EDI_Sub_item_Txt"><div placeholder="'.$Type_Desc.'">Type: '.$Type.'</div><div><input type="number" id="CMS_EDI_Sort'.$U1a['id'].'" value="'.$U1a['sort'].'"></div></div>';
			switch($U3a['Page_types_id']){
				case "0": case "2":
				$CMS_Deep_Grab1a = "SELECT * FROM CMS_content_raw WHERE id = :CMS_Raw_Id";
				$CMS_Deep_Grab1b = $SQL-Con->prepare($CMS_Deep_Grab1a);
				$CMS_Deep_Grab1b->execute([':CMS_Raw_Id' => $U3a['Content_id']]);
				$CMS_Deep_Grab1c = $CMS_Deep_Grab1b->fetch(PDO::FETCH_ASSOC);
				$CMS_Sel_Fo3_data .= '<div class="CMS_EDI_Sub_item_In"><div class="CMS_Lo"><textarea id="CMS_Raw_Con_'.$U3a['Page_types_id'].'_'.$U3a['Content_id'].'"/></div></div>';
				break;
				case "1":
				$CMS_Deep_Grab2a = "SELECT * FROM CMS_Forms WHERE id = :CMS_Form_Id";
				$CMS_Deep_Grab2b = $SQL-Con->prepare($CMS_Deep_Grab2a);
				$CMS_Deep_Grab2b->execute([':CMS_Form_Id' => $U3a['Content_id']]);
				$CMS_Deep_Grab2c = $CMS_Deep_Grab2b->fetch(PDO::FETCH_ASSOC);
				$CMS_Sel_Fo3_data .= '<div class="CMS_EDI_Sub_item_In"><div class="CMS_Lo"><div>ID</div><div>'.$U3a['id'].'</div>
				<div>Name</div><div><input type="text" id="CMS_Na_'.$U3a['Page_types_id'].'_'.$U3a['Content_id'].'" value="'.$U3a['name'].'"></div>
				<div>Description</div><div><input type="text" id="CMS_Na_'.$U3a['Page_types_id'].'_'.$U3a['Content_id'].'" value="'.$U3a['description'].'"></div>
				<div>Location</div><div><input type="text" id="CMS_Na_'.$U3a['Page_types_id'].'_'.$U3a['Content_id'].'" value="'.$U3a['location'].'"></div>
				<div>Created on</div><div>'.$U3a['created_on'].'</div>
				</div>';
				break;
			}
			$CMS_Sel_Fo3_data .= "</div>";
		}
		echo $CMS_Sel_Fo3_data;
	}
} else {
	echo json_encode(['error' => 'No data found.']);
}
?>