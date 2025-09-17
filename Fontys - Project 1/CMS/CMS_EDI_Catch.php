<?PHP
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
			$CMS_Sel_Fo1_data = '<div class="CMS_EDI_Sub_item"><div class="CMS_EDI_Sub_item_Txt"><div>Key: '.$U1a['field_key'].'</div><div><input type="number" id="CMS_EDI_Sort'.$U1a['id'].'" value="'.$U1a['sort_order'].'"></div></div><div class="CMS_EDI_Sub_item_In"><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">ID</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['id'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Fofi'.$U1a['id'].'">ID of linked form</div><div id="CMS_EDI_Eofi'.$U1a['id'].'">'.$U1a['form_id'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Field Name</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_key'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Field type</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_type'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">ID field</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_anker'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Description</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_description'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Required?</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['field_required'].'</div></div><div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">sort</div><div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['sort_order'].'</div></div></div>';
		}
		echo $CMS_Sel_Fo1_data;
	}
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['CMS_EDI_E1']) && strlen($_POST['CMS_EDI_E1']) >= 1){
	$CMS_EDI_E1 = $_POST['CMS_EDI_E1'] ?? '';	
    $CMS_EDI_E2 = $_POST['CMS_EDI_E2'] ?? '';
    $CMS_EDI_E3 = $_POST['CMS_EDI_E3'] ?? '';
    $CMS_EDI_E4 = $_POST['CMS_EDI_E4'] ?? '';

    // Example: just echo back the values
    echo "Received: CMS_EDI_E1 = $CMS_EDI_E1, CMS_EDI_E2 = $CMS_EDI_E2, CMS_EDI_E3 = $CMS_EDI_E3, CMS_EDI_E4 = $CMS_EDI_E4";
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
		$CMS_Sel_Fo2_data .= $CMS_Content1c['id'] . "»" . $CMS_Content1c['form_id'] . "»" . $CMS_Content1c['field_key'] . "»" . $CMS_Content1c['field_type'] . "»" . $CMS_Content1c['field_anker'] . "»" . $CMS_Content1c['field_description'] . "»" . $CMS_Content1c['field_required'] . "»" . $CMS_Content1c['sort_order'] . "»";
		
		$CMS_Content4a = "SELECT * FROM CMS_Form_field_translation WHERE field_id = :CMS_Sel_Fo2 ORDER BY sort_order ASC;";
		$CMS_Content4b = $SQL_Con->prepare($CMS_Content4a);
		$CMS_Content4b->execute([':CMS_Sel_Fo2' => $CMS_Sel_Fo2]);
		$CMS_Content4c = $CMS_Content2b->fetchAll(PDO::FETCH_ASSOC);
		foreach($CMS_Content4c as $U1a){
			$CMS_Sel_Fo2_data = '<div class="CMS_EDI_Sub_item"><div class="CMS_EDI_Sub_item_Txt"><div>Label: '.$U1a['lang_label'].'</div></div>
			<div class="CMS_EDI_Sub_item_In">
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">ID</div>
			<div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['id'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Fofi'.$U1a['id'].'">This form</div>
			<div id="CMS_EDI_Eofi'.$U1a['id'].'">'.$U1a['field_id'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Language</div>
			<div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['lang_id'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Word used as a background text</div>
			<div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['lang_placeholder'].'</div></div>
			<div class="CMS_Lo"><div id="CMS_EDI_Foi'.$U1a['id'].'">Text seen inside buttons</div>
			<div id="CMS_EDI_Eoi'.$U1a['id'].'">'.$U1a['lang_center'].'</div></div></div>';
		}
		echo $CMS_Sel_Fo2_data;
	}
}



?>