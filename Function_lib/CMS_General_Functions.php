<<<<<<< HEAD
<?PHP 
function LoadPrevPage($Msge){
	if(isset($Msge)){
		$Ex = '?Msg=';
	} else { $Ex = ''; }
	if(isset($_SESSION['Pre_Page'])){
		header('Location: '.$_SESSION['Pre_Page'] . $Ex . urlencode($Msge));
		exit;
	}
}
function StorePage(){
	$Pro = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
	$Hos = $_SERVER['HTTP_HOST'];
	$Pag = $_SERVER['REQUEST_URI'];
	$_SESSION['Pre_Page'] = $Pro . $Hos . $Pag;
}
function CMS_GrabRawTranslations($P_id, $L_id){
	global $CMS_ExTrans3; 
    $CMS_ExTrans1 = "SELECT handle_tag, text FROM cms_translations_other WHERE page_id = :P_id AND lang_id = :L_id";
    $CMS_ExTrans2 = $GLOBALS["SQL_Con"]->prepare($CMS_ExTrans1);
    $CMS_ExTrans2->execute([':P_id' => $P_id, ':L_id' => $L_id]);
    $CMS_ExTrans3 = $CMS_ExTrans2->fetchAll(PDO::FETCH_KEY_PAIR);
    return $CMS_ExTrans3;
}
/* */
function CMS_User_id($Usr1){
	global $CMS_User, $CMS_Prof_Data;
	if (is_int($Usr1)){
		$CMS_Qry1a = "SELECT PU.id, PU.username, PU.right_names_id, PU.enabled, PU.hashed_password, PP.users_id, PP.loc_id FROM prof_users PU JOIN Prof_profiles PP WHERE PP.users_id = PU.id AND PP.users_id = :PDO_username";
	//	$CMS_Qry1a = "SELECT * FROM Prof_Users WHERE id = :PDO_username";
	} else {
		$CMS_Qry1a = "SELECT PU.id, PU.username, PU.right_names_id, PU.enabled, PU.hashed_password, PP.users_id, PP.loc_id FROM prof_users PU JOIN Prof_profiles PP WHERE PP.users_id = PU.id AND PU.username = :PDO_username";
	//	$CMS_Qry1a = "SELECT * FROM Prof_Users WHERE username = :PDO_username";
	}
	$CMS_Qry1b = $GLOBALS["SQL_Con"]->prepare($CMS_Qry1a);
	$CMS_Qry1b->execute([':PDO_username' => $Usr1]);
	$CMS_Prof_Data = $CMS_Qry1b->fetch(PDO::FETCH_ASSOC);
	$CMS_User = $CMS_Prof_Data['id'];
//	print_r($CMS_Prof_Data);
}
/* Language */
function CMS_GrabLang(){
	global $CMS_Lang; global $CMS_GetLang3;
	$CMS_GetLang1 = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$CMS_GetLang2 = preg_replace('~/+~', '/', $CMS_GetLang1); 
	$CMS_GetLang3 = explode('/', trim($CMS_GetLang2, '/'));
	if(Isset($CMS_GetLang3) && count($CMS_GetLang3) >= 2 ){
		$CMS_GetLang4 = $CMS_GetLang3[count($CMS_GetLang3) - 2];
		if(preg_match('/^[A-z]{2}$/', $CMS_GetLang4)){
			$CMS_GetLang5 = strtoupper($CMS_GetLang4);
		}
		$CMS_GrabLang6 = "SELECT id FROM CMS_Lang WHERE lang_key = ':CMS_Lang'";
		$CMS_GrabLang7 = $GLOBALS["SQL_Con"]->prepare($CMS_GrabLang6);
		$CMS_GrabLang7->execute([':CMS_Lang' => $CMS_GrabLang5]);
		$CMS_Lang = $CMS_GrabLang7->fetch(PDO::FETCH_ASSOC);
	} else { 
		if(isset($_SESSION['CMS_4'])){ $CMS_Lang = $_SESSION['CMS_4']; } else { $CMS_Lang = 0;}
	}
}
/* Rights */
function CMS_GrabRights(){
	global $CMS_Rights;
	$CMS_Rights1 = $GLOBALS["CMS_GetLang3"][count($GLOBALS["CMS_GetLang3"]) - 1];
	$CMS_Rights2 = pathinfo($CMS_Rights1);
	$CMS_Rights_name = $CMS_Rights2['filename'];
	$CMS_Rights_In = '.' . $CMS_Rights2['extension'];
	$CMS_Rights_Ex = explode('?', $CMS_Rights_In, 2);
	$CMS_Trim1 = $_SERVER['REQUEST_URI'];
	function extractQParam($CMS_Trim1) {
		if(preg_match('/\?Q=\d{1,2}$/', $CMS_Trim1, $CMS_Match)){
			return $CMS_Match[0];
		} else {
			return '';
		}
	}
	$CMS_Trim2 = extractQParam($CMS_Trim1);
	$CMS_Rights_ext  = $CMS_Rights_Ex[0];
	try {
		$CMS_Rights3 = "SELECT * FROM CMS_Pages WHERE page_opt = :page_opt AND page_name = :CMS_P_Name AND page_ext = :CMS_P_ext AND lang_id = :CMS_P_Lid";
		$CMS_Rights4 = $GLOBALS["SQL_Con"]->prepare($CMS_Rights3);
		$CMS_Rights4->execute([':CMS_P_Name' => $CMS_Rights_name, ':CMS_P_ext' => $CMS_Rights_ext, ':CMS_P_Lid' => $_SESSION['CMS_5'], ':page_opt' => $CMS_Trim2]);
		$CMS_Rights = $CMS_Rights4->fetch(PDO::FETCH_ASSOC);
		if($CMS_Rights === false){
			$CMS_Rights = ['page_head' => 'Oopsie...', 'read_write_id' => -99];
		}
	} catch(Exception $e) { $CMS_Rights = ['page_head' => 'Oopsie...', 'read_write_id' => -99];}
}
/* Stay Logged in cookie */
function CMS_Log_SetCookie(){
	$CMS_tok_selector = bin2hex(random_bytes(8));
	$CMS_tok_tok = bin2hex(random_bytes(32));
	$CMS_tok_hash = hash('sha256', $CMS_tok_tok);
	$CMS_tok_fingpr = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
	$CMS_tok_Idb1 = 'INSERT INTO Prof_Login_Handle (prof_id, tok_selector ,tok_hash, tok_usera_hash, tok_created, tok_expires) VALUES (:p_id, :p_sel, :p_th, :p_uah, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY))';
	$CMS_tok_Idb2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_Idb1);
	$CMS_tok_Idb2->execute([':p_id' => $GLOBALS['CMS_User'], ':p_sel' => $CMS_tok_selector, ':p_th' => $CMS_tok_hash, ':p_uah' => $CMS_tok_fingpr]);
	$CMS_Val = $CMS_tok_selector . ':' . $CMS_tok_tok;
	$CMS_Param = ['expires' => time() + 60 * 60 * 24 * 30, 'path' => '/', 'domain' => $GLOBALS['Domain'], 'secure'   => true, 'httponly' => true, 'samesite' => 'Lax', ];
	setcookie('CMS_Remember_me', $CMS_Val, $CMS_Param);
}
/* Log off */
function CMS_Log_remove(){
	if(isset($_COOKIE['CMS_Remember_me'])){
	$CMS_tok_rev1 = "UPDATE Prof_Login_Handle SET tok_revoked = 1 WHERE prof_id = :p_id";
	$CMS_tok_rev2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_rev1);
	$CMS_tok_rev2->execute([':p_id' => $GLOBALS['CMS_User']]);
	setcookie('CMS_Remember_me', '', ['expires' => time() - 3600, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
	}
}

/* Log Sessions */
function CMS_Log_Auth(){
	if(password_needs_rehash($GLOBALS['CMS_Prof_Data']['hashed_password'], PASSWORD_DEFAULT, ['cost' => 12])){	$newHash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]); 
		$CMS_Qry2a = $GLOBALS["SQL_Con"]->prepare("UPDATE Prof_Users SET hashed_password = :hashed_password WHERE Prof_Users = :prof_user");
		$CMS_Qry2a->bindParam(':hashed_password', $hashedPassword);
		$CMS_Qry2a->bindParam(':prof_user',      $profUserKey);
		try{ $CMS_Qry2a->execute();
			if($stmt->rowCount()){
			// set update in db if needed
			} else {  echo "CMS.Log.Error 1"; } 
		} catch (PDOException $e){ echo "CMS.Log.Error 2: " . $e->getMessage(); }
	}
	$_SESSION['CMS_1'] = $GLOBALS['CMS_Prof_Data']['id'];
	$_SESSION['CMS_2'] = $GLOBALS['CMS_Prof_Data']['username'];
	$_SESSION['CMS_7'] = $GLOBALS['CMS_Prof_Data']['loc_id'];

	//Select Rights
	$CMS_Qry3a = "SELECT r.id FROM Prof_Users u INNER JOIN Prof_right_profiles rp ON u.right_names_id = rp.right_names_id INNER JOIN Prof_Rights r ON rp.rights_id = r.id WHERE u.id = :P_id";
	$CMS_Qry3b = $GLOBALS["SQL_Con"]->prepare($CMS_Qry3a);
	$CMS_Qry3b->execute([':P_id' => $GLOBALS['CMS_Prof_Data']['id']]);
	$CMS_Qry3C = $CMS_Qry3b->fetchAll(PDO::FETCH_COLUMN);

	//Select Language					
	$CMS_Qry4a = "SELECT prof.lang_id FROM Prof_profiles prof INNER JOIN Prof_Users user ON prof.users_id = user.id WHERE user.id = :P_id";
	$CMS_Qry4b = $GLOBALS["SQL_Con"]->prepare($CMS_Qry4a);
	$CMS_Qry4b->execute([':P_id' => $GLOBALS['CMS_Prof_Data']['id']]);
	$CMS_Qry4C = $CMS_Qry3b->fetch(PDO::FETCH_COLUMN);
	$_SESSION['CMS_3'] = $CMS_Qry3C;
	$_SESSION['CMS_4'] = $CMS_Qry4C;
	$_SESSION['CMS_5'] = $CMS_Qry4C;
}

/* Auto Login */
function CMS_Log_Auto(){
	if(empty($_SESSION['CMS_1'])){
		$CMS_Cookie = $_COOKIE['CMS_Remember_me'] ?? '';
		if($CMS_Cookie && strpos($CMS_Cookie, ':') !== false){
			[$CMS_tok_selector, $CMS_tok_tok] = explode(':', $CMS_Cookie, 2);
			if(!ctype_xdigit($CMS_tok_selector) || !ctype_xdigit($CMS_tok_tok)){ return;
			} else {  echo $CMS_tok_selector;
				$CMS_tok_AL1 = "SELECT id, prof_id, tok_hash, tok_usera_hash, tok_expires, tok_revoked FROM Prof_Login_Handle WHERE tok_selector = :tok_selector LIMIT 1";
				$CMS_tok_AL2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_AL1);
				$CMS_tok_AL2->execute([':tok_selector' => $CMS_tok_selector]);
				$CMS_tok_AL3 = $CMS_tok_AL2->fetch(PDO::FETCH_ASSOC);
				CMS_User_id($CMS_tok_AL3['prof_id']);
				if($CMS_tok_AL3 && !$CMS_tok_AL3['tok_revoked']){
					if(strtotime($CMS_tok_AL3['tok_expires']) < time()){
						$CMS_tok_AL_del1 = "DELETE FROM Prof_Login_Handle WHERE id = :id";
						$CMS_tok_AL_del2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_AL_del1);
						$CMS_tok_AL_del2->execute([':id' => $CMS_tok_AL3['id']]);
						setcookie('CMS_Remember_me', '', ['expires' => time() - 3600, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
						return;					
					}
					if($NM_chk){ echo "marco";
						if(!$UA_chk){
							//strictmode
							return;
						}
						session_regenerate_id(true);
						CMS_Log_Auth();
						$CMS_tok_ntok = bin2hex(random_bytes(32));
						$CMS_tok_nhash = hash('sha256', $CMS_tok_tok);
						$CMS_tok_AL_upd1 = "UPDATE Prof_Login_Handle SET tok_hash = :tok_hash, tok_last_use = NOW() WHERE id = :id";
						$CMS_tok_AL_upd2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_AL_upd1);
						$CMS_tok_AL_upd2->execute([':id' => $CMS_tok_AL3['id'], ':tok_hash' => $CMS_tok_nhash]);
						$CMS_Val = $CMS_tok_selector . ':' . $CMS_tok_ntok;
						$CMS_Param = ['expires' => time() + 60 * 60 * 24 * 30, 'path' => '/', 'domain' => $GLOBALS['Domain'], 'secure'   => true, 'httponly' => true, 'samesite' => 'Lax', ];
						setcookie('CMS_Remember_me', $CMS_Val, $CMS_Param);
					} else { return; }
				} else { return; }
			}
		} else { return; }
	} else { return;}	
}


=======
<?PHP 
function LoadPrevPage($Msge){
	if(isset($Msge)){
		$Ex = '?Msg=';
	} else { $Ex = ''; }
	if(isset($_SESSION['Pre_Page'])){
		header('Location: '.$_SESSION['Pre_Page'] . $Ex . urlencode($Msge));
		exit;
	}
}
function StorePage(){
	$Pro = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
	$Hos = $_SERVER['HTTP_HOST'];
	$Pag = $_SERVER['REQUEST_URI'];
	$_SESSION['Pre_Page'] = $Pro . $Hos . $Pag;
}
function CMS_GrabRawTranslations($P_id, $L_id){
	global $CMS_ExTrans3; 
    $CMS_ExTrans1 = "SELECT handle_tag, text FROM cms_translations_other WHERE page_id = :P_id AND lang_id = :L_id";
    $CMS_ExTrans2 = $GLOBALS["SQL_Con"]->prepare($CMS_ExTrans1);
    $CMS_ExTrans2->execute([':P_id' => $P_id, ':L_id' => $L_id]);
    $CMS_ExTrans3 = $CMS_ExTrans2->fetchAll(PDO::FETCH_KEY_PAIR);
    return $CMS_ExTrans3;
}
/* */
function CMS_User_id($Usr1){
	global $CMS_User, $CMS_Prof_Data;
	if (is_int($Usr1)){
		$CMS_Qry1a = "SELECT PU.id, PU.username, PU.right_names_id, PU.enabled, PU.hashed_password, PP.users_id, PP.loc_id FROM prof_users PU JOIN Prof_profiles PP WHERE PP.users_id = PU.id AND PP.users_id = :PDO_username";
	//	$CMS_Qry1a = "SELECT * FROM Prof_Users WHERE id = :PDO_username";
	} else {
		$CMS_Qry1a = "SELECT PU.id, PU.username, PU.right_names_id, PU.enabled, PU.hashed_password, PP.users_id, PP.loc_id FROM prof_users PU JOIN Prof_profiles PP WHERE PP.users_id = PU.id AND PU.username = :PDO_username";
	//	$CMS_Qry1a = "SELECT * FROM Prof_Users WHERE username = :PDO_username";
	}
	$CMS_Qry1b = $GLOBALS["SQL_Con"]->prepare($CMS_Qry1a);
	$CMS_Qry1b->execute([':PDO_username' => $Usr1]);
	$CMS_Prof_Data = $CMS_Qry1b->fetch(PDO::FETCH_ASSOC);
	$CMS_User = $CMS_Prof_Data['id'];
//	print_r($CMS_Prof_Data);
}
/* Language */
function CMS_GrabLang(){
	global $CMS_Lang; global $CMS_GetLang3;
	$CMS_GetLang1 = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$CMS_GetLang2 = preg_replace('~/+~', '/', $CMS_GetLang1); 
	$CMS_GetLang3 = explode('/', trim($CMS_GetLang2, '/'));
	if(Isset($CMS_GetLang3) && count($CMS_GetLang3) >= 2 ){
		$CMS_GetLang4 = $CMS_GetLang3[count($CMS_GetLang3) - 2];
		if(preg_match('/^[A-z]{2}$/', $CMS_GetLang4)){
			$CMS_GetLang5 = strtoupper($CMS_GetLang4);
		}
		$CMS_GrabLang6 = "SELECT id FROM CMS_Lang WHERE lang_key = ':CMS_Lang'";
		$CMS_GrabLang7 = $GLOBALS["SQL_Con"]->prepare($CMS_GrabLang6);
		$CMS_GrabLang7->execute([':CMS_Lang' => $CMS_GrabLang5]);
		$CMS_Lang = $CMS_GrabLang7->fetch(PDO::FETCH_ASSOC);
	} else { 
		if(isset($_SESSION['CMS_4'])){ $CMS_Lang = $_SESSION['CMS_4']; } else { $CMS_Lang = 0;}
	}
}
/* Rights */
function CMS_GrabRights(){
	global $CMS_Rights;
	$CMS_Rights1 = $GLOBALS["CMS_GetLang3"][count($GLOBALS["CMS_GetLang3"]) - 1];
	$CMS_Rights2 = pathinfo($CMS_Rights1);
	$CMS_Rights_name = $CMS_Rights2['filename'];
	$CMS_Rights_In = '.' . $CMS_Rights2['extension'];
	$CMS_Rights_Ex = explode('?', $CMS_Rights_In, 2);
	$CMS_Trim1 = $_SERVER['REQUEST_URI'];
	function extractQParam($CMS_Trim1) {
		if(preg_match('/\?Q=\d{1,2}$/', $CMS_Trim1, $CMS_Match)){
			return $CMS_Match[0];
		} else {
			return '';
		}
	}
	$CMS_Trim2 = extractQParam($CMS_Trim1);
	$CMS_Rights_ext  = $CMS_Rights_Ex[0];
	try {
		$CMS_Rights3 = "SELECT * FROM CMS_Pages WHERE page_opt = :page_opt AND page_name = :CMS_P_Name AND page_ext = :CMS_P_ext AND lang_id = :CMS_P_Lid";
		$CMS_Rights4 = $GLOBALS["SQL_Con"]->prepare($CMS_Rights3);
		$CMS_Rights4->execute([':CMS_P_Name' => $CMS_Rights_name, ':CMS_P_ext' => $CMS_Rights_ext, ':CMS_P_Lid' => $_SESSION['CMS_5'], ':page_opt' => $CMS_Trim2]);
		$CMS_Rights = $CMS_Rights4->fetch(PDO::FETCH_ASSOC);
		if($CMS_Rights === false){
			$CMS_Rights = ['page_head' => 'Oopsie...', 'read_write_id' => -99];
		}
	} catch(Exception $e) { $CMS_Rights = ['page_head' => 'Oopsie...', 'read_write_id' => -99];}
}
/* Stay Logged in cookie */
function CMS_Log_SetCookie(){
	$CMS_tok_selector = bin2hex(random_bytes(8));
	$CMS_tok_tok = bin2hex(random_bytes(32));
	$CMS_tok_hash = hash('sha256', $CMS_tok_tok);
	$CMS_tok_fingpr = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
	$CMS_tok_Idb1 = 'INSERT INTO Prof_Login_Handle (prof_id, tok_selector ,tok_hash, tok_usera_hash, tok_created, tok_expires) VALUES (:p_id, :p_sel, :p_th, :p_uah, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY))';
	$CMS_tok_Idb2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_Idb1);
	$CMS_tok_Idb2->execute([':p_id' => $GLOBALS['CMS_User'], ':p_sel' => $CMS_tok_selector, ':p_th' => $CMS_tok_hash, ':p_uah' => $CMS_tok_fingpr]);
	$CMS_Val = $CMS_tok_selector . ':' . $CMS_tok_tok;
	$CMS_Param = ['expires' => time() + 60 * 60 * 24 * 30, 'path' => '/', 'domain' => $GLOBALS['Domain'], 'secure'   => true, 'httponly' => true, 'samesite' => 'Lax', ];
	setcookie('CMS_Remember_me', $CMS_Val, $CMS_Param);
}
/* Log off */
function CMS_Log_remove(){
	if(isset($_COOKIE['CMS_Remember_me'])){
	$CMS_tok_rev1 = "UPDATE Prof_Login_Handle SET tok_revoked = 1 WHERE prof_id = :p_id";
	$CMS_tok_rev2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_rev1);
	$CMS_tok_rev2->execute([':p_id' => $GLOBALS['CMS_User']]);
	setcookie('CMS_Remember_me', '', ['expires' => time() - 3600, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
	}
}

/* Log Sessions */
function CMS_Log_Auth(){
	if(password_needs_rehash($GLOBALS['CMS_Prof_Data']['hashed_password'], PASSWORD_DEFAULT, ['cost' => 12])){	$newHash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]); 
		$CMS_Qry2a = $GLOBALS["SQL_Con"]->prepare("UPDATE Prof_Users SET hashed_password = :hashed_password WHERE Prof_Users = :prof_user");
		$CMS_Qry2a->bindParam(':hashed_password', $hashedPassword);
		$CMS_Qry2a->bindParam(':prof_user',      $profUserKey);
		try{ $CMS_Qry2a->execute();
			if($stmt->rowCount()){
			// set update in db if needed
			} else {  echo "CMS.Log.Error 1"; } 
		} catch (PDOException $e){ echo "CMS.Log.Error 2: " . $e->getMessage(); }
	}
	$_SESSION['CMS_1'] = $GLOBALS['CMS_Prof_Data']['id'];
	$_SESSION['CMS_2'] = $GLOBALS['CMS_Prof_Data']['username'];
	$_SESSION['CMS_7'] = $GLOBALS['CMS_Prof_Data']['loc_id'];

	//Select Rights
	$CMS_Qry3a = "SELECT r.id FROM Prof_Users u INNER JOIN Prof_right_profiles rp ON u.right_names_id = rp.right_names_id INNER JOIN Prof_Rights r ON rp.rights_id = r.id WHERE u.id = :P_id";
	$CMS_Qry3b = $GLOBALS["SQL_Con"]->prepare($CMS_Qry3a);
	$CMS_Qry3b->execute([':P_id' => $GLOBALS['CMS_Prof_Data']['id']]);
	$CMS_Qry3C = $CMS_Qry3b->fetchAll(PDO::FETCH_COLUMN);

	//Select Language					
	$CMS_Qry4a = "SELECT prof.lang_id FROM Prof_profiles prof INNER JOIN Prof_Users user ON prof.users_id = user.id WHERE user.id = :P_id";
	$CMS_Qry4b = $GLOBALS["SQL_Con"]->prepare($CMS_Qry4a);
	$CMS_Qry4b->execute([':P_id' => $GLOBALS['CMS_Prof_Data']['id']]);
	$CMS_Qry4C = $CMS_Qry3b->fetch(PDO::FETCH_COLUMN);
	$_SESSION['CMS_3'] = $CMS_Qry3C;
	$_SESSION['CMS_4'] = $CMS_Qry4C;
	$_SESSION['CMS_5'] = $CMS_Qry4C;
}

/* Auto Login */
function CMS_Log_Auto(){
	if(empty($_SESSION['CMS_1'])){
		$CMS_Cookie = $_COOKIE['CMS_Remember_me'] ?? '';
		if($CMS_Cookie && strpos($CMS_Cookie, ':') !== false){
			[$CMS_tok_selector, $CMS_tok_tok] = explode(':', $CMS_Cookie, 2);
			if(!ctype_xdigit($CMS_tok_selector) || !ctype_xdigit($CMS_tok_tok)){ return;
			} else {  echo $CMS_tok_selector;
				$CMS_tok_AL1 = "SELECT id, prof_id, tok_hash, tok_usera_hash, tok_expires, tok_revoked FROM Prof_Login_Handle WHERE tok_selector = :tok_selector LIMIT 1";
				$CMS_tok_AL2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_AL1);
				$CMS_tok_AL2->execute([':tok_selector' => $CMS_tok_selector]);
				$CMS_tok_AL3 = $CMS_tok_AL2->fetch(PDO::FETCH_ASSOC);
				CMS_User_id($CMS_tok_AL3['prof_id']);
				if($CMS_tok_AL3 && !$CMS_tok_AL3['tok_revoked']){
					if(strtotime($CMS_tok_AL3['tok_expires']) < time()){
						$CMS_tok_AL_del1 = "DELETE FROM Prof_Login_Handle WHERE id = :id";
						$CMS_tok_AL_del2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_AL_del1);
						$CMS_tok_AL_del2->execute([':id' => $CMS_tok_AL3['id']]);
						setcookie('CMS_Remember_me', '', ['expires' => time() - 3600, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
						return;					
					}
					if($NM_chk){ echo "marco";
						if(!$UA_chk){
							//strictmode
							return;
						}
						session_regenerate_id(true);
						CMS_Log_Auth();
						$CMS_tok_ntok = bin2hex(random_bytes(32));
						$CMS_tok_nhash = hash('sha256', $CMS_tok_tok);
						$CMS_tok_AL_upd1 = "UPDATE Prof_Login_Handle SET tok_hash = :tok_hash, tok_last_use = NOW() WHERE id = :id";
						$CMS_tok_AL_upd2 = $GLOBALS["SQL_Con"]->prepare($CMS_tok_AL_upd1);
						$CMS_tok_AL_upd2->execute([':id' => $CMS_tok_AL3['id'], ':tok_hash' => $CMS_tok_nhash]);
						$CMS_Val = $CMS_tok_selector . ':' . $CMS_tok_ntok;
						$CMS_Param = ['expires' => time() + 60 * 60 * 24 * 30, 'path' => '/', 'domain' => $GLOBALS['Domain'], 'secure'   => true, 'httponly' => true, 'samesite' => 'Lax', ];
						setcookie('CMS_Remember_me', $CMS_Val, $CMS_Param);
					} else { return; }
				} else { return; }
			}
		} else { return; }
	} else { return;}	
}


>>>>>>> 236a705ea03f897fdff7b98c7f9240fd984e414b
?>