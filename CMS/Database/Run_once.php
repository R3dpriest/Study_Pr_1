<?PHP
// Reference = w3schools

/* SQL */
$SQL_Server = "10.0.1.101";
$SQL_Username = "admin";
$SQL_Password = "i572944";
$SQL_DB1 = "NGO_Foodbank";
$SQL_File = 'Create_database.sql';
$SQL_Commands = file_get_contents($SQL_File);

try{//esteblish & create
	$SQL_Con = new PDO("mysql:host=$SQL_Server", $SQL_Username, $SQL_Password);
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$SQL_Con->exec("CREATE DATABASE IF NOT EXISTS $SQL_DB1");
	echo "Database: '$SQL_DB1' scripted succesfully.";
	
	//connect
	$SQL_Con = new PDO("mysql:host=$SQL_Server;dbname=$SQL_DB1", $SQL_Username, $SQL_Password);
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$SQL_Con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$SQL_Con->exec("SET GLOBAL event_scheduler = ON;");
	if(file_exists($SQL_File)){
		$SQL_Con->exec($SQL_Commands);
		echo "SQL file '$SQL_File' executed successfully.<br>";
	} else {
		echo "SQL file '$SQL_File' not found.<br>";
	}

} catch(PDOException $SQL_Error) {
	echo "There was a database[0] error: " . $SQL_Error->getMessage();
}


require __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

// --- Config (Atlas example with SRV) ---
$MONGO_Server   = "";  // e.g. cluster0.xxxxx.mongodb.net
$MONGO_Username = "";
$MONGO_Password = "";
$MONGO_DB1      = "wms_rosters"; // your DB name

// SRV URIs already imply TLS. Add options you need:
$MONGO_Options = [
    'retryWrites' => 'true',
    'w'           => 'majority',
    // 'authSource' => 'admin', // only if your user authenticates against 'admin'
];
$MONGO_STR = "mongodb+srv://{$MONGO_Username}:{$MONGO_Password}@{$MONGO_Server}/?" . http_build_query($MONGO_Options);

try {
    $MONGO_Client = new Client($MONGO_STR);
    $db = $MONGO_Client->selectDatabase($MONGO_DB1); // <-- this is your DB handle
} catch (\Throwable $e) {
    die("There was a MongoDB connection error: " . $e->getMessage());
}


$uri = escapeshellarg(getenv('MONGODB_URI'));
$cmd = "DB_NAME=wms_rosters mongosh $uri --file " . escapeshellarg(__DIR__ . '/create_database_mongodb.js');
echo shell_exec($cmd);

?>