<<<<<<< HEAD
<?PHP 
// https://en.wikipedia.org/wiki/Cross-site_request_forgery
Function CMS_TOK(){
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$token = $_POST['CMS_TOK'] ?? '';
		if (!hash_equals($_SESSION['CMS_CHK_TKN'] ?? '', $token)) {
			echo '<html><head><link rel="stylesheet" href="../Css/CMS_Main.css"></head><body>';
			http_response_code(403);
			exit("<div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><div class=''><img class='CMS_ER_I CMS_I_C' src='Images\blocked.png'></div></div><div></div><div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><h2></h2>Error 403-S-01</div></body>");
		}
	}
}
Function CMS_TOK2($token){
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!hash_equals($_SESSION['CMS_CHK_TKN'] ?? '', $token)) {
			http_response_code(403);
			exit("Error 403-S-01");
		}
	}
}
// Generic Denied
Function CMS_Den(){
	exit("<div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><div class=''><img class='CMS_ER_I CMS_I_C CMS_MW_700' src='Images\wrongway.png'></div></div><div></div><div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><h2></h2>Error 403-S-02</div></body>");
}
// Generic Not Found
Function CMS_NotFound(){
	exit("<div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><div class=''><img class='CMS_ER_I CMS_I_C CMS_MW_700' src='Images\IsNotFound.png'></div></div><div></div><div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><h2></h2>Error 403-S-03</div></body>");
}
=======
<?PHP 
// https://en.wikipedia.org/wiki/Cross-site_request_forgery
Function CMS_TOK(){
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$token = $_POST['CMS_TOK'] ?? '';
		if (!hash_equals($_SESSION['CMS_CHK_TKN'] ?? '', $token)) {
			echo '<html><head><link rel="stylesheet" href="../Css/CMS_Main.css"></head><body>';
			http_response_code(403);
			exit("<div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><div class=''><img class='CMS_ER_I CMS_I_C' src='Images\blocked.png'></div></div><div></div><div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><h2></h2>Error 403-S-01</div></body>");
		}
	}
}
Function CMS_TOK2($token){
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!hash_equals($_SESSION['CMS_CHK_TKN'] ?? '', $token)) {
			http_response_code(403);
			exit("Error 403-S-01");
		}
	}
}
// Generic Denied
Function CMS_Den(){
	exit("<div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><div class=''><img class='CMS_ER_I CMS_I_C CMS_MW_700' src='Images\wrongway.png'></div></div><div></div><div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><h2></h2>Error 403-S-02</div></body>");
}
// Generic Not Found
Function CMS_NotFound(){
	exit("<div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><div class=''><img class='CMS_ER_I CMS_I_C CMS_MW_700' src='Images\IsNotFound.png'></div></div><div></div><div class='CMS_DisFlex CMS_JuCen CMS_AlCen'><h2></h2>Error 403-S-03</div></body>");
}
>>>>>>> 236a705ea03f897fdff7b98c7f9240fd984e414b
?>