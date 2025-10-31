<?PHP include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Template_Filestart.php"; if(session_status() !== PHP_SESSION_ACTIVE){session_start();}
include_once __dir__ . DIRECTORY_SEPARATOR . 'Function_lib' . DIRECTORY_SEPARATOR . 'CMS_Sec_Extra.php';
$CMS_Prof_Dis3 = [];
$CMS_Prof_Inp = preg_replace('/\D/', '', $_GET['u']);
$CMS_Prof_Dis1 = "SELECT Ac.id, Ac.username, Ac.email, Ac.enabled, Ac.created_at, Pr.first_name, Pr.last_name, Pr.street, Pr.city, Pr.phone, Pr.donor, Pr.client, Pr.staff, Pr.lang_id, Pr.vegetarian, Lo.loc_name AS location, Lo.loc_city, Lo.loc_street, Lo.id AS loc_id, Ri.name AS right_name FROM prof_users Ac JOIN prof_profiles Pr ON Pr.users_id = Ac.id JOIN prof_right_names Ri ON Ri.id = Ac.right_names_id JOIN wms_locations Lo ON Pr.loc_id = Lo.id WHERE Ac.id = :p_id"; 
$CMS_Prof_Dis2 = $GLOBALS['SQL_Con']->prepare($CMS_Prof_Dis1);
$CMS_Prof_Dis2->execute([':p_id' => $CMS_Prof_Inp]);
$CMS_Prof_Dis3 = $CMS_Prof_Dis2->fetch(PDO::FETCH_ASSOC);
if(!empty($CMS_Prof_Dis3)){
	if(isset($_SESSION['CMS_3'])){?>
	<div class="CMS_URPR_Window CMS_St_bc CMS_m_20 CMS_p_5">
		<div class="CMS_URPR CMS_DisFlex"><div class="CMS_DisBox CMS_FlNstr CMS_p_3"><img class="CMS_S_100x100" src="\Images\SiteAdmin.png"></div>
		<div class="CMS_DisBox CMS_p_3"><div class=""><h2><?PHP echo $CMS_Prof_Dis3['username']; ?></h2></div><div class=""><?PHP echo $CMS_Prof_Dis3['right_name']; ?></div></div></div>
		<?PHP 
		if($_SESSION['CMS_1'] == $CMS_Prof_Dis3['id']){ echo "mine"; 
		if(empty($_SESSION['CMS_CHK_TKN'])){$_SESSION['CMS_CHK_TKN'] = bin2hex(random_bytes(32));} 
		WMS_GrabAllLocations('CMS_Prof_Lo');
		$Opt1 = '<option value="1" SELECTED>✔</option><option value="0">❌</option>';
		$Opt2 = '<option value="1">✔</option><option value="0" SELECTED>❌</option>';
		if($CMS_Prof_Dis3['vegetarian'] == 1){ $Ve = $Opt1; } else {$Ve = $Opt2; }
		if($CMS_Prof_Dis3['enabled'] == 1){ $En = $Opt1; } else {$En = $Opt2; }
		
		echo '<form>
		<input type="hidden" name="CMS_TOK" value="'.$_SESSION['CMS_CHK_TKN'].'">
		<div class="CMS_URPR_Dat CMS_DisFlex CMS_FlWra_w">
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_1eN'].'</div><div>'.$CMS_Prof_Dis3['first_name'].'</div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_2eN'].'</div><div>'.$CMS_Prof_Dis3['last_name'].'</div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>📧 e-mail</div><div><input Name="CMS_Prof_Em" type="email" value="'.$CMS_Prof_Dis3['email'].'" placeholder="'.$CMS_Prof_Dis3['email'].'"></div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_ENA'].'</div><div><select name="CMS_Prof_En">'.$En.'</select></div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CRE'].'</div><div>'.$CMS_Prof_Dis3['created_at'].'</div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CIT'].'</div><div><input type="text" name="CMS_Prof_Ci" placeholder="'.$CMS_Prof_Dis3['city'].'" value="'.$CMS_Prof_Dis3['city'].'"></div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_STR'].'</div><div><input type="text" name="CMS_Prof_St" placeholder="'.$CMS_Prof_Dis3['street'].'" value="'.$CMS_Prof_Dis3['street'].'"></div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_PHO'].'</div><div><input type="tel" name="CMS_Prof_Ph" placeholder="e.g. +31 6 12345678" pattern="^\+?[0-9\s\-]{7,15}$" value="'.$CMS_Prof_Dis3['phone'].'"></div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_VEG'].'</div><div><select name="CMS_Prof_Ve">'.$Ve.'</select></div></div>
		<div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_DEF'].'</div><div placeholder="city: '.$CMS_Prof_Dis3['loc_city'].' Street: '.$CMS_Prof_Dis3['loc_street'].'">'.$Gxe.'</div></div>
		</div></form><script>$(function(){ var phpValue = "'.htmlspecialchars($CMS_Prof_Dis3['loc_id']).'";		$("#CMS_Prof_Lo").val(phpValue);}); </script>';
		
		} else { 
			if($CMS_Prof_Dis3['enabled'] === 1){ $En = "✔";} else { $En="❌";}
			if($CMS_Prof_Dis3['vegetarian'] === 1){ $Ve = "✔";} else { $Ve="❌";}
			$I = 0;
			if(in_array($GLOBALS['CMS_Donors'], $_SESSION['CMS_3'], true)){
				if($CMS_Prof_Dis3['donor'] == "1" && $I == 0){ $I++; echo '<div class="CMS_URPR_Dat CMS_DisFlex CMS_FlWra_w"><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CoN'].'</div><div>'.$CMS_Prof_Dis3['first_name'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_ENA'].'</div><div>'.$En.'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CRE'].'</div><div>'.$CMS_Prof_Dis3['created_at'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CIT'].'</div><div>'.$CMS_Prof_Dis3['city'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_STR'].'</div><div>'.$CMS_Prof_Dis3['street'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_PHO'].'</div><div>'.$CMS_Prof_Dis3['phone'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_DEF'].'</div><div placeholder="city: '.$CMS_Prof_Dis3['loc_city'].' Street: '.$CMS_Prof_Dis3['loc_street'].'">'.$CMS_Prof_Dis3['location'].'</div></div></div>'; }
			} else { CMS_Den(); }
			if(in_array($GLOBALS['CMS_Clients'], $_SESSION['CMS_3'], true)){
				if($CMS_Prof_Dis3['client'] == "1" && $I == 0){ $I++; echo '<div class="CMS_URPR_Dat CMS_DisFlex CMS_FlWra_w"><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_1eN'].'</div><div>'.$CMS_Prof_Dis3['first_name'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_2eN'].'</div><div>'.$CMS_Prof_Dis3['last_name'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_ENA'].'</div><div>'.$En.'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CRE'].'</div><div>'.$CMS_Prof_Dis3['created_at'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CIT'].'</div><div>'.$CMS_Prof_Dis3['city'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_STR'].'</div><div>'.$CMS_Prof_Dis3['street'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_PHO'].'</div><div>'.$CMS_Prof_Dis3['phone'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_VEG'].'</div><div>'.$Ve.'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_DEF'].'</div><div placeholder="city: '.$CMS_Prof_Dis3['loc_city'].' Street: '.$CMS_Prof_Dis3['loc_street'].'">'.$CMS_Prof_Dis3['location'].'</div></div></div>'; }
			} else { CMS_Den(); }
			if(in_array($GLOBALS['CMS_Staff'], $_SESSION['CMS_3'], true)){
				if($CMS_Prof_Dis3['staff'] == "1"  && $I == 0){ $I++; echo '<div class="CMS_URPR_Dat CMS_DisFlex CMS_FlWra_w"><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_1eN'].'</div><div>'.$CMS_Prof_Dis3['first_name'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_2eN'].'</div><div>'.$CMS_Prof_Dis3['last_name'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_ENA'].'</div><div>'.$En.'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CRE'].'</div><div>'.$CMS_Prof_Dis3['created_at'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_CIT'].'</div><div>'.$CMS_Prof_Dis3['city'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_STR'].'</div><div>'.$CMS_Prof_Dis3['street'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_PHO'].'</div><div>'.$CMS_Prof_Dis3['phone'].'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_VEG'].'</div><div>'.$Ve.'</div></div><div class="CMS_DisFlex CMS_Prof_R CMS_BS_BX"><div>'.$CMS_ExTrans3['CMS_Pro_DEF'].'</div><div placeholder="city: '.$CMS_Prof_Dis3['loc_city'].' Street: '.$CMS_Prof_Dis3['loc_street'].'">'.$CMS_Prof_Dis3['location'].'</div></div></div>'; }
			} else { CMS_Den(); }
			echo "</div>";
		}
	} else {}
} else { CMS_NotFound(); } ?>