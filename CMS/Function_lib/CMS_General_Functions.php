<?PHP 
function LoadPrevPage(Msge){
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