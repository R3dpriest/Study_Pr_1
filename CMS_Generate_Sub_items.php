<?php 
/* Read file (ignore this) OR Write file (process and output to file) OR Process (just echo as normal) */

function cms_Content_Generation($Page){

	global $SQL_Con;//grab items attached to page
	$cms_Content1a = "SELECT * FROM cms_page_content WHERE Pages_id = :cms_p_id ORDER BY sort ASC;";
	$cms_Content1b = $SQL_Con->prepare($cms_Content1a);
	$cms_Content1b->execute([':cms_p_id' => $Page]);
	$cms_Content1c = $cms_Content1b->fetchAll(PDO::FETCH_ASSOC);
	foreach($cms_Content1c as $cms_L1){
		switch($cms_L1['Page_types_id']){
			case 0: // Raw text
				$cms_Content2a = "SELECT * FROM cms_content_raw WHERE id = :cms_C_id;";
				$cms_Content2b = $SQL_Con->prepare($cms_Content2a);
				$cms_Content2b->execute([':cms_C_id' => $cms_L1['Content_id']]);
				$cms_Content2c = $cms_Content2b->fetch(PDO::FETCH_ASSOC);
				echo $cms_Content2c['content'];
				break;
			case 1:
				$cms_Content3a = "SELECT * FROM cms_forms WHERE id = :cms_C_id";
				$cms_Content3b = $SQL_Con->prepare($cms_Content3a);
				$cms_Content3b->execute([':cms_C_id' => $cms_L1['Content_id']]);
				$cms_Content3c = $cms_Content3b->fetch(PDO::FETCH_ASSOC);?>
				<form id="cms_fe_<?PHP echo $cms_Content3c['id']; ?>" name="cms_fe_<?PHP echo $cms_Content3c['name']; ?>" action="<?PHP echo $cms_Content3c['location']; ?>" method="POST">
	<?PHP		$cms_Content4a = "SELECT * FROM cms_form_fields WHERE form_id = :cms_C_id";
				$cms_Content4b = $SQL_Con->prepare($cms_Content4a);
				$cms_Content4b->execute([':cms_C_id' => $cms_L1['id']]);
				$cms_Content4c = $cms_Content4b->fetchAll(PDO::FETCH_ASSOC);
				foreach($cms_Content4c as $cms_L2){
					$cms_Content6a = "SELECT * FROM cms_content_raw WHERE id = :cms_C_id;";
					$cms_Content6b = $SQL_Con->prepare($cms_Content6a);
					$cms_Content6b->execute([':cms_C_id' => $cms_L1['Content_id']]);
					$cms_Content6c = $cms_Content6b->fetch(PDO::FETCH_ASSOC);					
					if(isset($cms_Content6c['lang_label'])){?><label for="cms_I_<?PHP echo $cms_L2['field_key']; ?>"><?PHP echo $cms_Content6c['lang_label']; ?></label><?PHP } 
					switch($cms_L2['field_type']){
						case "text": case "email": case "checkbox": case "radio": case "number": ?>
						<input type="<?PHP echo $cms_L2['field_type']; ?>" id="cms_I_<?PHP echo $cms_L2['field_anker']; ?>" name="cms_I_<?PHP echo $cms_L2['field_key']; ?>" placeholder="<?PHP /*echo $cms_Content6c['lang_placeholder']; ?>"*/ ?>">
	<?PHP				break;
						case "textarea":  ?>
						<textarea id="cms_I_<?PHP echo $cms_L2['field_anker']; ?>" name="cms_I_<?PHP echo $cms_L2['field_key']; ?>" placeholder="<?PHP /*echo $cms_Content6c['lang_placeholder'];*/ ?>"></textarea>
	<?PHP				break;
						case "select":
						echo "Not implemented";
						break;
						case "button": ?>
						<button type="submit" id="cms_I_<?PHP echo $cms_L2['field_anker']; ?>"><?PHP /*echo $cms_Content6c['lang_center'];*/ ?></button>
	<?PHP				break;
					}			
				}?>
				</form>
	<?PHP		break;
			case 2: // Raw that that allows code
				$cms_Content5a = "SELECT * FROM cms_content_raw WHERE id = :cms_f_id;";
				$cms_Content5b = $SQL_Con->prepare($cms_Content5a);
				$cms_Content5b->execute([':cms_f_id' => $cms_L1['Content_id']]);
				$cms_Content5c = $cms_Content5b->fetch(PDO::FETCH_ASSOC);
				echo cms_Content4c['content'];
				break;
			case 3: //Override exit
			break 2; 
			default:
				echo "This item has not yet been added to the logic\n";
		}
	}
}
?>