<?php
/* Read file (ignore this) OR Write file (process and output to file) OR Process (just echo as normal) */

function CMS_Content_Generation($Page){
	
	global $SQL_Con;//grab items attached to page
	$CMS_Content1a = "SELECT * FROM CMS_Page_content WHERE Pages_id = :CMS_P_id ORDER BY sort ASC;";
	$CMS_Content1b = $SQL_Con->prepare($CMS_Content1a);
	$CMS_Content1b->execute([':CMS_P_id' => $Page]);
	$CMS_Content1c = $CMS_Content1b->fetchAll(PDO::FETCH_ASSOC);
	foreach($CMS_Content1c as $CMS_L1){
		switch($CMS_L1['Page_types_id']){
			case 0: // Raw text
				$CMS_Content2a = "SELECT * FROM CMS_content_raw WHERE id = :CMS_C_id;";
				$CMS_Content2b = $SQL_Con->prepare($CMS_Content2a);
				$CMS_Content2b->execute([':CMS_C_id' => $CMS_L1['Content_id']]);
				$CMS_Content2c = $CMS_Content2b->fetch(PDO::FETCH_ASSOC);
				echo htmlentities($CMS_Content2c['content']);
				break;
			case 1:
				$CMS_Content3a = "SELECT * FROM CMS_Forms WHERE id = :CMS_C_id";
				$CMS_Content3b = $SQL_Con->prepare($CMS_Content3a);
				$CMS_Content3b->execute([':CMS_C_id' => $CMS_L1['Content_id']]);
				$CMS_Content3c = $CMS_Content3b->fetch(PDO::FETCH_ASSOC);?>
				<form id="CMS_Fe_<?PHP echo $CMS_Content3c['id']; ?>" name="CMS_Fe_<?PHP echo $CMS_Content3c['name']; ?>" action="<?PHP echo $CMS_Content3c['location']; ?>" method="POST">
	<?PHP		$CMS_Content4a = "SELECT * FROM CMS_Form_fields WHERE form_id = :CMS_C_id";
				$CMS_Content4b = $SQL_Con->prepare($CMS_Content4a);
				$CMS_Content4b->execute([':CMS_C_id' => $CMS_L1['id']]);
				$CMS_Content4c = $CMS_Content4b->fetchAll(PDO::FETCH_ASSOC);
				foreach($CMS_Content4c as $CMS_L2){
					$CMS_Content6a = "SELECT * FROM CMS_content_raw WHERE id = :CMS_C_id;";
					$CMS_Content6b = $SQL_Con->prepare($CMS_Content6a);
					$CMS_Content6b->execute([':CMS_C_id' => $CMS_L1['Content_id']]);
					$CMS_Content6c = $CMS_Content6b->fetch(PDO::FETCH_ASSOC);					
					if(isset($CMS_Content6c['lang_label'])){?><label for="CMS_I_<?PHP echo $CMS_L2['field_key']; ?>"><?PHP echo $CMS_Content6c['lang_label']; ?></label><?PHP } 
					switch($CMS_L2['field_type']){
						case "text": case "email": case "checkbox": case "radio": case "number": ?>
						<input type="<?PHP echo $CMS_L2['field_type']; ?>" id="CMS_I_<?PHP echo $CMS_L2['field_anker']; ?>" name="CMS_I_<?PHP echo $CMS_L2['field_key']; ?>" placeholder="<?PHP /*echo $CMS_Content6c['lang_placeholder']; ?>"*/ ?>">
	<?PHP				break;
						case "textarea":  ?>
						<textarea id="CMS_I_<?PHP echo $CMS_L2['field_anker']; ?>" name="CMS_I_<?PHP echo $CMS_L2['field_key']; ?>" placeholder="<?PHP /*echo $CMS_Content6c['lang_placeholder'];*/ ?>"></textarea>
	<?PHP				break;
						case "select":
						echo "Not implemented";
						break;
						case "button": ?>
						<button type="submit" id="CMS_I_<?PHP echo $CMS_L2['field_anker']; ?>"><?PHP /*echo $CMS_Content6c['lang_center'];*/ ?></button>
	<?PHP				break;
					}			
				}?>
				</form>
	<?PHP		break;
			case 2: // Raw that that allows code
				$CMS_Content5a = "SELECT * FROM CMS_content_raw WHERE id = :CMS_F_id;";
				$CMS_Content5b = $SQL_Con->prepare($CMS_Content5a);
				$CMS_Content5b->execute([':CMS_F_id' => $CMS_L1['Content_id']]);
				$CMS_Content5c = $CMS_Content5b->fetch(PDO::FETCH_ASSOC);
				echo CMS_Content4c['content'];
				break;
			case 3: //Override exit
			break 2; 
			default:
				echo "This item has not yet been added to the logic\n";
		}
	}
}
?>