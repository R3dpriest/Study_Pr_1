<?php
// Reference = w3schools

/* SQL */
$SQL_Server="";
$SQL_Username="";
$SQL_Password="";
$SQL_DB1="";

try{
	$SQL_Con=new PDO("mysql:host=$SQL_Server;dbname=$SQL_DB1",$SQL_Username,$SQL_Password);
	// I know it's default, but I want to know if and or what the error is
	$SQL_Con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$SQL_Con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_COLUMN);
}catch(PDOException $SQL_Error){
	echo "There was a database[0] error: ".$SQL_Error->getMessage();
}

/* MongoDB */
$MONGO_Server="";
$MONGO_Username="";
$MONGO_Password="";
$MONGO_DB1="";
$MONGO_Options=['ssl'=>true,'authSource'=>'admin'];
$MONGO_STR="mongodb+srv://$MONGO_Username:$MONGO_Password@$MONGO_Server/$MONGO_DB1?".http_build_query($MONGO_Options);

try{
	$MONGO_Client=new MongoDB\Client($MONGO_STR);
	$MONGO_CL1=$MONGO_Client->$MONGO_DB1->AppVoedselbank;
}catch(Exception $MONGO_Error){
	echo "There was a database[1] error: ".$MONGO_Error->getMessage();
}
?>
