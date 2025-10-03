<?PHP
function CMS_GrabPageTypes(){
	$GrabTypes1 = "SELECT * FROM CMS_Page_types";
	$GrabTypes2 = $SQL_Con->prepare($GrabTypes1);
	$GrabTypes2->execute();
	$GrabTypes3 = $GrabTypes2->fetchAll(PDO::FETCH_ASSOC);
}
//update scripts
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['CMS_YF']) && strlen($_POST['CMS_YF']) >= 1){
		switch($_POST['CMS_YF']){
			case "1":
			$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
			$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
			$CMS_Upd_Dat1a = "UPDATE CMS_Forms SET name = :CMS_EDI_E2, description = :CMS_EDI_E3, location = :CMS_EDI_E4 WHERE id = :CMS_EDI_E1";
			$CMS_Upd_Dat1b = $SQL_Con->prepare($CMS_Upd_Dat1a);
			$CMS_Upd_Dat1b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4]);
			break;
			case "2":
			$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
			$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
			$CMS_EDI_E5 = $_POST['CMS_EDI_E5'] ?? ''; $CMS_EDI_E6 = $_POST['CMS_EDI_E6'] ?? '';
			$CMS_EDI_E7 = $_POST['CMS_EDI_E7'] ?? ''; $CMS_EDI_E8 = $_POST['CMS_EDI_E8'] ?? '';
			$CMS_Upd_Dat2a = "UPDATE CMS_Form_fields SET form_id = :CMS_EDI_E2, field_key = :CMS_EDI_E3, field_type = :CMS_EDI_E4, field_anker = :CMS_EDI_E5, field_description = :CMS_EDI_E6, field_required = :CMS_EDI_E7 , sort_order = :CMS_EDI_E8 WHERE id = :CMS_EDI_E1";
			$CMS_Upd_Dat2b = $SQL_Con->prepare($CMS_Upd_Dat2a);
			$CMS_Upd_Dat2b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4, ':CMS_EDI_E5' => $CMS_EDI_E5, ':CMS_EDI_E6' => $CMS_EDI_E6, ':CMS_EDI_E7' => $CMS_EDI_E7, ':CMS_EDI_E8' => $CMS_EDI_E8]);
			break;
			case "3":
			$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? ''; $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
			$CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? ''; $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';
			$CMS_EDI_E5 = $_POST['CMS_EDI_E5'] ?? ''; $CMS_EDI_E6 = $_POST['CMS_EDI_E6'] ?? '';
			$CMS_EDI_E7 = $_POST['CMS_EDI_E7'] ?? ''; $CMS_EDI_E8 = $_POST['CMS_EDI_E8'] ?? '';
			$CMS_EDI_E9 = $_POST['CMS_EDI_E9'] ?? '';
			$CMS_Upd_Dat3a = "UPDATE CMS_Pages SET page_name = :CMS_EDI_E2, page_ext = :CMS_EDI_E3, lang_id = :CMS_EDI_E4, lang_Tx = :CMS_EDI_E5, read_id = :CMS_EDI_E6, read_write_id = :CMS_EDI_E7, page_head = :CMS_EDI_E8, page_load_options = :CMS_EDI_E9 WHERE id = :CMS_EDI_E1";
			$CMS_Upd_Dat3b = $SQL_Con->prepare($CMS_Upd_Dat3a);
			$CMS_Upd_Dat3b->execute([':CMS_EDI_E1' => $CMS_EDI_E1, ':CMS_EDI_E2' => $CMS_EDI_E2, ':CMS_EDI_E3' => $CMS_EDI_E3, ':CMS_EDI_E4' => $CMS_EDI_E4, ':CMS_EDI_E5' => $CMS_EDI_E5, ':CMS_EDI_E6' => $CMS_EDI_E6, ':CMS_EDI_E7' => $CMS_EDI_E7, ':CMS_EDI_E8' => $CMS_EDI_E8]);
			break;
		}
    echo "Succes";
	}
}
//form fields 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['CMS_Sel_Fo1']) && strlen($_POST['CMS_Sel_Fo1']) >= 1){
		$CMS_Sel_Fo1_data = "";
		$CMS_Sel_Fo1 = $_POST['CMS_Sel_Fo1'];	
		$CMS_Content1a = "SELECT * FROM CMS_Forms WHERE id = :CMS_Sel_Fo1";
		$CMS_Content1b = $SQL_Con->prepare($CMS_Content1a);
		$CMS_Content1b->execute([':CMS_Sel_Fo1' => $CMS_Sel_Fo1]);
		$CMS_Content1c = $CMS_Content1b->fetchAll(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo1_data .= $CMS_Content1c['id'] . "»" . $CMS_Content1c['name'] . "»" . $CMS_Content1c['desciption'] . "»" . $CMS_Content1c['location'] . "»" . $CMS_Content1c['created_on'] . "»";
		
		$CMS_Content2a = "SELECT * FROM CMS_Form_fields WHERE form_id = :CMS_Sel_Fo1 ORDER BY sort_order ASC;";
		$CMS_Content2b = $SQL_Con->prepare($CMS_Content2a);
		$CMS_Content2b->execute([':CMS_Sel_Fo1' => $CMS_Sel_Fo1]);
		$CMS_Content2c = $CMS_Content2b->fetchAll(PDO::FETCH_ASSOC);
		foreach($CMS_Content2c as $U1a){
			$CMS_Sel_Fo1_data .= '<div class="CMS_EDI_Sub_item"><div class="CMS_EDI_Sub_item_Txt"><div>Key: '.$U1a['field_key'].'</div><div><input type="number" id="CMS_EDI_Sort'.$U1a['id'].'" value="'.$U1a['sort_order'].'"></div></div><div class="CMS_EDI_Sub_item_In"><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">ID</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['id'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Fofi'.$U1a['id'].'">ID of linked form</div><div id="CMS_EDI_Eofi'.$U1a['id'].'">'.$U1a['form_id'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Field Name</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_key'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Field type</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_type'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">ID field</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_anker'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Description</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_description'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Required?</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_required'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">sort</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['sort_order'].'</div></div></div>';
		}
		echo $CMS_Sel_Fo1_data;
	}
}
//form subfields
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['CMS_Sel_Fo2']) && strlen($_POST['CMS_Sel_Fo2']) >= 1){
		$CMS_Sel_Fo2_data = "";
		$CMS_Sel_Fo2 = $_POST['CMS_Sel_Fo2'];	
		$CMS_Content3a = "SELECT * FROM CMS_Form_fields WHERE id = :CMS_Sel_Fo2";
		$CMS_Content3b = $SQL_Con->prepare($CMS_Content3a);
		$CMS_Content3b->execute([':CMS_Sel_Fo2' => $CMS_Sel_Fo2]);
		$CMS_Content3c = $CMS_Content3b->fetchAll(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo2_data .= $CMS_Content3c['id'] . "»" . $CMS_Content3c['form_id'] . "»" . $CMS_Content3c['field_key'] . "»" . $CMS_Content3c['field_type'] . "»" . $CMS_Content3c['field_anker'] . "»" . $CMS_Content3c['field_description'] . "»" . $CMS_Content3c['field_required'] . "»" . $CMS_Content3c['sort_order'] . "»";
		
		$CMS_Content4a = "SELECT * FROM CMS_Form_field_translation WHERE field_id = :CMS_Sel_Fo2 ORDER BY sort_order ASC;";
		$CMS_Content4b = $SQL_Con->prepare($CMS_Content4a);
		$CMS_Content4b->execute([':CMS_Sel_Fo2' => $CMS_Sel_Fo2]);
		$CMS_Content4c = $CMS_Content4b->fetchAll(PDO::FETCH_ASSOC);
		foreach($CMS_Content4c as $U1b){
			$CMS_Sel_Fo2_data .= '<div class="CMS_EDI_Sub_item"><div class="CMS_EDI_Sub_item_Txt"><div>Label: '.$U1b['lang_label'].'</div></div>
			<div class="CMS_EDI_Sub_item_In">
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1b['id'].'">ID</div>
			<div id="CMS_EDI_Eoi'.$U1b['id'].'">'.$U1b['id'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Fofi'.$U1b['id'].'">This form</div>
			<div id="CMS_EDI_Eofi'.$U1b['id'].'">'.$U1b['field_id'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1b['id'].'">Language</div>
			<div id="CMS_EDI_Eoi'.$U1b['id'].'">'.$U1b['lang_id'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1b['id'].'">Word used as a background text</div>
			<div id="CMS_EDI_Eoi'.$U1b['id'].'">'.$U1b['lang_placeholder'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1b['id'].'">Text seen inside buttons</div>
			<div id="CMS_EDI_Eoi'.$U1b['id'].'">'.$U1b['lang_center'].'</div></div></div>';
		}
		echo $CMS_Sel_Fo2_data;
	}
}
//form subfields
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['CMS_Sel_Fo3']) && strlen($_POST['CMS_Sel_Fo3']) >= 1){
		$CMS_Sel_Fo3_data = "";
		$CMS_Sel_Fo3 = $_POST['CMS_Sel_Fo3'];	
		$CMS_Content5a = "SELECT * FROM CMS_Pages WHERE id = :CMS_Sel_Fo3";
		$CMS_Content5b = $SQL_Con->prepare($CMS_Content5a);
		$CMS_Content5b->execute([':CMS_Sel_Fo3' => $CMS_Sel_Fo3]);
		$CMS_Content5c = $CMS_Content3b->fetchAll(PDO::FETCH_ASSOC);
		$CMS_Sel_Fo3_data .= $CMS_Content5c['id'] . "»" . $CMS_Content5c['page_name'] . "»" . $CMS_Content5c['page_ext'] . "»" . $CMS_Content5c['lang_id'] . "»" . $CMS_Content5c['lang_Tx'] . "»" . $CMS_Content5c['read_id'] . "»" . $CMS_Content5c['read_write_id'] . "»" . $CMS_Content5c['page_head'] . "»" . $CMS_Content5c['page_load_options'] . "»" . $CMS_Content5c['created_on'] . "»";
		
		$CMS_Content6a = "SELECT * FROM CMS_Page_content WHERE Pages_id = :CMS_Sel_Fo3 ORDER BY sort ASC;";
		$CMS_Content6b = $SQL_Con->prepare($CMS_Content6a);
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
}
?>