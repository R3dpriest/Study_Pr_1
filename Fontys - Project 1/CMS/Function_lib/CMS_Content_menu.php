<?PHP 
function CMS_GrabAllForms(Inp1){
	$GAF = "<select id='CMS_GrabAllForms' form='".$Inp1."'>";
	$CMS_Content1a = "SELECT * FROM CMS_Forms sort ASC;";
	$CMS_Content1b = $SQL_Con->prepare($CMS_Content1a);
	$CMS_Content1b->execute([':CMS_P_id' => $Page]);
	$CMS_Content1c = $CMS_Content1b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content1c){
		$GAF .= <option 
		
	}
}