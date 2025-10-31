<?PHP
// Reference = w3schools

global $SQL_Con;

/* SQL */
/*$SQL_Server = "10.0.1.100";
$SQL_Username = "admin@10.0.1.100";
$SQL_Password = "i572944";
*/
$SQL_Server = "localhost";
$SQL_Username = "Admin";
$SQL_Password = "i572944";
$SQL_DB1 = "NGO_Foodbank";

try { 
	$SQL_Con = new PDO("mysql:host=$SQL_Server;dbname=$SQL_DB1;charset=utf8mb4", $SQL_Username, $SQL_Password);
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$SQL_Con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);	
} catch(PDOException $SQL_Error) {
	echo "There was a database[0] error: " . $SQL_Error->getMessage(); exit;
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
?>