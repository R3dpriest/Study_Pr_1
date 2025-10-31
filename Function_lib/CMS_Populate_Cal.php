<?PHP
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "CMS_Connection.php";

if(!isset($_SESSION['Check_calander'])){

	$targetDate=new DateTimeImmutable('+3 months');
	$week=(int)$targetDate->format('W');
	$year=(int)$targetDate->format('o');
	$CMS_Cal5 = "SELECT count(*) AS cnt FROM WMS_Weeks WHERE week=:week AND year=:year";
	$CMS_Cal6 = $GLOBALS["SQL_Con"]->prepare($CMS_Cal5);
	$CMS_Cal6->execute([':week'=>$week,':year'=>$year]);
	$result = $CMS_Cal6->fetch(PDO::FETCH_ASSOC);
	if($result['cnt'] === 0){
		CMS_Populate();
	}
	$_SESSION['Check_event_scheduler'] = "set";
}

function CMS_Populate(){
	$start=new DateTimeImmutable();
	$end=$start->modify('+6 months');
	for($d=$start;$d<=$end;$d=$d->modify('+7 days')){
		$week=(int)$d->format('W');
		$year=(int)$d->format('o');
		$monday=$d->modify('monday this week');
		$sunday=$monday->modify('+6 days');
		$CMS_Cal1="SELECT 1 FROM WMS_Weeks WHERE week=:weeks AND year=:years";
		$CMS_Cal2=$GLOBALS["SQL_Con"]->prepare($CMS_Cal1);
		$CMS_Cal2->execute([':weeks'=>$week,':years'=>$year]);
		$CMS_CalResult=$CMS_Cal2->fetch(PDO::FETCH_ASSOC);
		if(!$CMS_CalResult){
			$CMS_Cal3="INSERT INTO WMS_Weeks (week, year, start_date, end_date) VALUES (:week, :year, :monday, :sunday)";
			$CMS_Cal4=$GLOBALS["SQL_Con"]->prepare($CMS_Cal3);
			$CMS_Cal4->execute([':week'=>$week,':year'=>$year,':monday'=>$monday->format('Y-m-d'),':sunday'=>$sunday->format('Y-m-d')]);
		}
	}
}

?>