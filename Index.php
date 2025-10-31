<?PHP 

include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Template_Filestart.php"; 

if(session_status() !== PHP_SESSION_ACTIVE){session_start();}
?>
<br><br>Hello world 