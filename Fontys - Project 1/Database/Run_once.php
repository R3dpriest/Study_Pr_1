<?PHP
// Reference = w3schools

/* SQL */
$SQL_Server = "10.0.1.101";
$SQL_Username = "admin@10.0.1.101";
$SQL_Password = "i572944";
$SQL_DB1 = "NGO_Foodbank";
$SQL_File = 'Create_database.sql';
$SQL_Commands = file_get_contents($SQL_File);

try{//esteblish & create
	$SQL_Con = new PDO("mysql:host=$SQL_Server", $SQL_Username, $SQL_Password);
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
	$SQL_Con->exec("CREATE DATABASE IF NOT EXISTS $SQL_DB1");
	echo "Database: '$SQL_DB1' scripted succesfully.";
	
	//connect
	$SQL_Con = new PDO("mysql:host=$SQL_Server;dbname=$SQL_DB1", $SQL_Username, $SQL_Password);
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$SQL_Con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	if(file_exists($SQL_File)){
		$SQL_Con->exec($sqlCommands);
		echo "SQL file '$SQL_File' executed successfully.<br>";
	} else {
		echo "SQL file '$SQL_File' not found.<br>";
	}

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