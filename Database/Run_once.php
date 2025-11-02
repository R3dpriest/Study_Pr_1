<?PHP
// Reference = w3schools
 
/* SQL */
//$SQL_Server = "10.0.2.201";
$SQL_Server = "localhost";
$SQL_Username = "root";
$SQL_Password = "";
//$SQL_Password = "i572944";
$SQL_DB1 = "ngo_foodbank";
$SQL_File1 = 'Create_database.sql';
$SQL_Commands1 = file_get_contents($SQL_File1);

try{//esteblish & create
	$SQL_Con = new PDO("mysql:host=$SQL_Server", $SQL_Username, $SQL_Password);
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$SQL_Con->exec("CREATE DATABASE IF NOT EXISTS $SQL_DB1");
	$SQL_Con->exec("SET GLOBAL event_scheduler = ON");
	echo "<b>Database</b>:<br> Primary database script '$SQL_DB1' executed successfully.<br>";
	
	//connect
	$SQL_Con = new PDO("mysql:host=$SQL_Server;dbname=$SQL_DB1", $SQL_Username, $SQL_Password);
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$SQL_Con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	if(file_exists($SQL_File1)){
		$SQL_Con->exec($SQL_Commands1);
		echo "Database file '$SQL_File1' executed successfully.<br>";
	} else {
		echo "Database file '$SQL_File1' not found.<br>";
	}
	include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "Function_lib" . DIRECTORY_SEPARATOR . "CMS_Populate_Cal.php";

} catch(PDOException $SQL_Error) {
	echo "<br>There was a database[0] error: <br>" . $SQL_Error->getMessage();
}

/* MongoDB 
$MONGO_Server = "";
$MONGO_Username = "";
$MONGO_Password = "";
$MONGO_DB1 = "";
$MONGO_Options = ['ssl' => true, 'authSource' => 'admin'];
$MONGO_STR = "mongodb+srv://$MONGO_Username:$MONGO_Password@$MONGO_Server/$MONGO_DB1?" . http_build_query($MONGO_Options); 

try {
	$MONGO_Client = new MongoDB\client($MONGO_STR);
	$MONGO_CL1 = $MONGO_Client->$MONGO_DB1->AppVoedselbank;
} catch (Exeption $MONGO_Error){
	echo "There was a database[1] error:" . $MONGO_Error->getMessage();
}*/

echo "<br><br><b>For your safety read the following:</b> Manually inspect the website, see if it executed correctly. Now move the following files off the webhost; '<u>Run_once.php</u>'. These can all be found in the '<u>Database</u>' directory.";
?>