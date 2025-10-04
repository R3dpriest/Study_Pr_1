<?PHP 
function CMS_GrabAllForms(Inp1){
	$GAF = "<select id='".$Inp1."' form='".$Inp1."'>";
	$CMS_Content1a = "SELECT * FROM CMS_Forms";
	$CMS_Content1b = $SQL_Con->prepare($CMS_Content1a);
	$CMS_Content1b->execute();
	$CMS_Content1c = $CMS_Content1b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content1c as $I1a){
		$GAF .= "<option value='". echo $I1a['id'] ."'>". echo $I1a['name']."</option>";		
	}
	$GAF .= "</select>";
}
function CMS_GrabAllForm_Fields(Inp2){
	$GEF = "<select id='".$Inp2."' form='".$Inp2."'>";
	$CMS_Content2a = "SELECT * FROM CMS_Form_fields";
	$CMS_Content2b = $SQL_Con->prepare($CMS_Content2a);
	$CMS_Content2b->execute();
	$CMS_Content2c = $CMS_Content2b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content2c as $I2a){
		$GEF .= "<option value='". echo $I2a['id'] ."'>". echo $I2a['field_description']."</option>";		
	}
	$GEF .= "</select>";
}
function CMS_GrabAllpages(Inp3){
	$GZF = "<select id='".$Inp3."' form='".$Inp3."'>";
	$CMS_Content3a = "SELECT * FROM CMS_Pages";
	$CMS_Content3b = $SQL_Con->prepare($CMS_Content3a);
	$CMS_Content3b->execute();
	$CMS_Content3c = $CMS_Content3b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content3c as $I3a){
		$GZF .= "<option value='". echo $I3a['id'] ."'>". echo $I3a['page_name'].$I3a['page_ext']."[".$I3a['lang_Tx']."]</option>";
	}
	$GZF .= "</select>";
}
/* function CMS_Page_content(Inp4){
	$GpF = "<select id='CMS_Page_content' form='".$Inp4."'>";
	$CMS_Content4a = "SELECT * FROM CMS_Pages";
	$CMS_Content4b = $SQL_Con->prepare($CMS_Content4a);
	$CMS_Content4b->execute([':CMS_P_id' => $Page]);
	$CMS_Content4c = $CMS_Content3b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content4c as $I4a){
		$GpF .= "<option value='". echo $I4a['id'] ."'>". echo $I4a['page_name'].$I3a['page_ext']."[".$I3a['lang_Tx']."]</option>";
	}
	$GpF .= "</select>";
}*/
function CMS_Page_types(Inp5){
	$GxF = "<select id='".$Inp5."' form='".$Inp5."'>";
	$CMS_Content5a = "SELECT * FROM CMS_Pages";
	$CMS_Content5b = $SQL_Con->prepare($CMS_Content5a);
	$CMS_Content5b->execute();
	$CMS_Content5c = $CMS_Content5b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content5c as $I5a){
		$GxF .= "<option value='". echo $I5a['id'] ."'>". echo $I5a['option_type'] ."</option>";
	}
	$GxF .= "</select>";
}
function CMS_Grab_Lang(Inp6){
	$GxZ = "<select id='".$Inp6."' form='".$Inp6."'>";
	$CMS_Content6a = "SELECT * FROM CMS_Lang";
	$CMS_Content6b = $SQL_Con->prepare($CMS_Content6a);
	$CMS_Content6b->execute();
	$CMS_Content6c = $CMS_Content6b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content6c as $I6a){
		$GxZ .= "<option value='". echo $I6a['id'] ."'>". echo $I6a['lang_description'] ."[".echo $I6a['lang_key']."]</option>";
	}
	$GxZ .= "</select>";
}
function CMS_Rights_Labels(Inp7){
	$GxQ = "<select id='".$Inp7."' form='".$Inp7."'>";
	$CMS_Content7a = "SELECT * FROM Prof_Rights";
	$CMS_Content7b = $SQL_Con->prepare($CMS_Content7a);
	$CMS_Content7b->execute();
	$CMS_Content7c = $CMS_Content7b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content7c as $I7a){
		$GxQ .= "<option placeholder='" . echo $I7a['description'] . "' value='". echo $I7a['id'] ."'>". echo $I7a['title'] . "</option>";
	}
	$GxQ .= "</select>";
}
function WMS_GrabAllLocations(Inp8){
	$Gxe = "<select id='".$Inp8."' form='".$Inp8."'>";
	$CMS_Content8a = "SELECT * FROM WMS_Locations WHERE loc_enabled = true";
	$CMS_Content8b = $SQL_Con->prepare($CMS_Content8a);
	$CMS_Content8b->execute();
	$CMS_Content8c = $CMS_Content8b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content8c as $I8a){
		$Gxe .= "<option placeholder='" . echo $I8a['loc_city'] . " - ".$I8a['loc_street']."' value='". echo $I8a['id'] ."'>". echo $I8a['loc_name'] . "</option>";
	}
	$Gxe .= "</select>";
}