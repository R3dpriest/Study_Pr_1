<?PHP
// Reference = w3schools

/* SQL */
$SQL_Server = "10.0.1.100";
$SQL_Username = "admin@10.0.1.100";
$SQL_Password = "i572944";
$SQL_DB1 = "NG)_Foodbank";

try { 
	$SQL_Con = new PDO("mysql:host=$SQL_Server;dbname=$SQL_DB1, $SQL_Username, $SQL_Password");
	// I know its dafault, but i want to know if and or what the error is
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXEPTION);
	$SQL_Con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_COLUMN);
} catch(PDOExeption $SQL_Error) {
	echo "There was a database[0] error: " . $SQL_Error->getMessage();
}

/* MongoDB */
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
}
?>