<?php
//$_SESSION['CMS_5'] == language
UpGrabLangData($_POST['WMS_Page_name']);

/* Grabs Ajax Interactions */
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if($_POST['WMS_Select'] === 'WMS_Inv_Catch'){
		
		GrabPage($_POST['WMS_Page_name']);
		UpdStock($UpPage3['id']);
		UpdUsers($UpPage3['id']);
	}
	if($_POST['WMS_Inv_Resel'] === 'WMS_Inv_Resel'){
		$Outp = "";
		switch($_POST['WMS_Inv_Resel']){
			case "0":
				$Outp .= "Donations: ";
				$UpEx = "<thead><tr><th></th></tr></thead><tbody>";
				GrabDonations($_POST['WMS_Location'], $_POST['WMS_Inv_ID']);
				$UpEx .= "</tbody>";
			break;
			case "1":
				$Outp .= "Processed: ";
				$UpEx = "<thead><tr><th>Open</th><th>Volume</th><th>Delivery location</th><th>Delivery date</th><th>Deliverd</th></tr></thead><tbody>";
				GrabTransfers($_POST['WMS_Location'], $_POST['WMS_Inv_ID']);
				$UpEx .= "</tbody>";
			break;
			case "2":
				$Outp .= "Transferred: ";
				$UpEx = "<thead><tr><th></th></tr></thead><tbody>";
				GrabProcessed($_POST['WMS_Location'], $_POST['WMS_Inv_ID']);
				$UpEx .= "</tbody>";
			break;
		}
	}
}
function GrabDonations(loc_id, ingredient_id){
	$UpDon1 = "SELECT * FROM WMS_Donations WHERE loc_id = :loc_id AND ingredient_id = :ingredient_id";
	$UpDon2 = $SQL_Con-prepare($UpDon1);
	$UpDon2->execute([':loc_id' => $loc_id, ':ingredient_id' => $ingredient_id);
	$UpEx .= $UpDon2->fetchAll(PDO::FETCH_ASSOC);
}
function GrabTransfers(loc_id, ingredient_id){
	$UpDon1 = "SELECT wt.*, wfp.u_type_id, wut.unit_type FROM WMS_Transfer wt JOIN WMS_Food_products wfp ON wt.ingredient_id = wfp.id JOIN WMS_Unit_type wut ON wfp.u_type_id = wut.id WHERE wt.loc_recieving_id = :loc_id AND wt.ingredient_id = :ingredient_id";
	//$UpDon1 = "SELECT * FROM WMS_Transfer WHERE loc_id = :loc_id AND ingredient_id = :ingredient_id";
	$UpDon2 = $SQL_Con-prepare($UpDon1);
	$UpDon2->execute([':loc_id' => $loc_id, ':ingredient_id' => $ingredient_id);
	$UpEx .= $UpDon2->fetchAll(PDO::FETCH_ASSOC);
}
function GrabProcessed(loc_id, ingredient_id){
	//$UpDon1 = "SELECT * FROM WMS_Process WHERE loc_recieving_id = :loc_id AND ingredient_id = :ingredient_id";
	$UpDon1 = "SELECT wp.*, wfp.u_type_id, wut.unit_type FROM WMS_Process wp JOIN WMS_Food_products wfp ON wp.ingredient_id = wfp.id JOIN WMS_Unit_type wut ON wfp.u_type_id = wut.id WHERE wp.loc_id = :loc_id AND wp.ingredient_id = :ingredient_id";
	$UpDon2 = $SQL_Con-prepare($UpDon1);
	$UpDon2->execute([':loc_id' => $loc_id, ':ingredient_id' => $ingredient_id);
	$UpDon3 = $UpDon2->fetchAll(PDO::FETCH_ASSOC);
	foreach($UpDon3 as $It1){
		$UpEx .= "<tr><td><a href='".$It1['id']."'>ℹ️</a></td><td>".$It1['volume']." ".$It1['unit_type']."</td><td>".."</td><td>".$It1['']."</td><td>".$It1['']."</td></tr>";
	}
}

// Isolate what page is needed
function GrabPage(PaData){
	$UpPage1 = "SELECT * FROM CMS_Pages WHERE lang_id = :lang_id AND page_name = :page_name";
	$UpPage2 = $SQL_Con-prepare($UpPage1);
	$UpPage2->execute([':page_name' => $PaData, ':lang_id' => $_SESSION['CMS_5']);
	$UpPage3 = $UpPage2->fetch(PDO::FETCH_ASSOC);
}
// Update the stock
function UpdStock(LoData){
//	$UpStock1 = "SELECT * FROM WMS_Stock WHERE loc_id = :loc_id";
	$UpStock1 = "SELECT s.*, ft.name AS ingredient_name, fp.shelflife, tm.Time_type FROM WMS_Stock s JOIN WMS_Food_products fp ON s.ingredient_id = fp.id JOIN WMS_Food_translations ft ON ft.f_product_id = fp.id LEFT JOIN WMS_Time_Measure tm ON fp.t_type_id = tm.id WHERE s.loc_id = :loc_id AND ft.lang_id = :lang_id";
	$UpStock2 = $SQL_Con->prepare($UpStock1);
	$UpStock2->execute([':loc_id' => $LoData, ':lang_id' => $_SESSION['CMS_5']]);
	$UpStock3 = $UpStock2->fetchAll(PDO::FETCH_ASSOC);
	$StOutp = "<thead><tr><th></th><th>" . $LangSel3['WMS_inv_sto_1'] . "</th><th>" . $LangSel3['WMS_inv_sto_2'] . "</th><th>" . $LangSel3['WMS_inv_sto_3'] . "</th><th>" . $LangSel3['WMS_inv_sto_4'] . "</th><th>" . $LangSel3['WMS_inv_sto_5'] . "</th></tr></thead><tbody>";
	foreach($StOutp as $Item){
		$StOutp .= "<tr class='WMS_Inv_Handle'  id='WMS_Inv_I_".$Item['id']."'><td>".$Item['ingredient_name']."</td><td>".$Item['stockpile_new']."</td><td>".$Item['stockpile_pre']."</td><td>".$Item['last_update']."</td><td>"$Item['shelflife']." ".$Item['Time_type']."</td><td><a href='Random#".$Item['id']."'>".$LangSel3['WMS_inv_sto_6']."</td></td>";
	}
	$StOutp = "</tbody>";
}
// Update the data regarding the location
function UpdUsers(UsDat){
	$UpUsers1 = "SELECT COUNT(CASE WHEN vegetarian = TRUE THEN 1 END) AS vegetarian_count, COUNT(CASE WHEN staff = TRUE THEN 1 END) AS staff_count, COUNT(CASE WHEN client = TRUE THEN 1 END) AS client_count FROM Prof_profles WHERE loc_id = :loc_id";
	$UpUsers2 = $SQL_Con->prepare($UpUsers1);
	$UpUsers2->execute([':loc_id' => $UsDat]);
	$UpUsers3 = $UpUsers2->fetchAll(PDO::FETCH_ASSOC); 
	$UpOutp = "<thead></thead><tbody><tr><td>" . $LangSel3['WMS_inv_sta_1'] . "</td><td>" . $UpUsers3['staff_count'] . "</td><td><a href='WMS_Inventory' target='_SELF'>ℹ️</a></td></tr><tr><td>" .  $LangSel3['WMS_inv_sta_2'] . "</td><td>" . $UpUsers3['client_count'] . "</td><td><a href='WMS_Inventory' target='_SELF'>ℹ️</a></td></tr><tr><td>" .  $LangSel3['WMS_inv_sta_3'] . "</td><td>" . $UpUsers3['vegetarian_count'] . "</td><td><a href='WMS_Inventory' target='_SELF'>ℹ️</a></td></tr></tbody>";
}

?>