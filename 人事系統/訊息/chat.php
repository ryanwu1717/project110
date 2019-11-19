<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

session_start();
$container = $app->getContainer();
$container['db'] = function($c) {
$dbuser='minlab';
$dbpassword='970314970314';
$dbhost='140.127.40.40';
$port='25432';
$dbname="humanresource";
$dsn = "pgsql:host=".$dbhost.";port=".$port.";dbname=".$dbname;
$conn=new PDO($dsn,$dbuser,$dbpassword);
return $conn;
};
$app->get('/session_id', function (Request $request, Response $response, array $args) {
	
$_SESSION['id'] = 'A10000';
    return $response;
});
$app->get('/session_id2', function (Request $request, Response $response, array $args) {
	
$_SESSION['id'] = 'A10001';
    return $response;
});
$app->get('/list/get', function (Request $request, Response $response, array $args) {

	$sql = 'SELECT "receiverList"."chatID","chatToWhom",to_char("LastTime",\'DD MON\')as "LastTime","content","chatName","staff_name","LastTime" as "LastTime1","CountUnread"
				FROM(
					SELECT "chatWith"."chatID","chatToWhom"
					FROM(
						SELECT "chatID", "time", "UID"
						FROM staff_chat."chatHistory"
						where "UID"= :UID
						)as "chatWith" 
						LEFT JOIN (
									SELECT "cH3"."chatID","UID" as "chatToWhom"
									FROM(
										SELECT "couUID","chatID","time"
										FROM(
											SELECT "chatID" as "cID", COUNT("UID")as "couUID"
											FROM staff_chat."chatHistory"
											group by "chatID") as "cUID"
											LEFT JOIN staff_chat."chatHistory" as "cH2"
											on "cUID"."cID"="cH2"."chatID" AND "cH2"."UID"= :UID AND "couUID"=2)as "check"
									LEFT join staff_chat."chatHistory" as "cH3"
									on "check"."chatID"="cH3"."chatID"
									where "UID"!= :UID
									)as "receiver" on "chatWith"."chatID"="receiver"."chatID")as "receiverList"
						LEFT JOIN (
									SELECT "cILT"."chatID","LastTime","content","UID" as "sender"
									FROM(
										SELECT "chatID",MAX("sentTime")as "LastTime"
										FROM staff_chat."chatContent"
										Group by "chatID")as "cILT" 
						LEFT JOIN staff_chat."chatContent" as "cC2" on "cILT"."chatID"="cC2"."chatID" 
						where "LastTime"="sentTime")as "searchResault" on "receiverList"."chatID"="searchResault"."chatID"	
						LEFT JOIN staff_chat."chatroomInfo" on "receiverList"."chatID"="chatroomInfo"."chatID"
						LEFT JOIN staff."staff" on "receiverList"."chatToWhom"=staff."staff"."staff_id"
						LEFT JOIN (SELECT "chatID","UID",COUNT("c")as "CountUnread"
									FROM(SELECT "chatHistory"."chatID",  "chatHistory"."UID",(case when "time"<"sentTime" then \'1\' else null end) as "c"
										FROM staff_chat."chatHistory"
										join staff_chat."chatContent" on "chatHistory"."chatID"="chatContent"."chatID"
										where "chatHistory"."UID"=:UID) as "countUnread"
									group by "chatID","UID") as "countUnread" on "receiverList"."chatID"="countUnread"."chatID"
						order by "LastTime1" desc;';
		$sth = $this->db->prepare($sql);
		$UID =$_SESSION['id'];
		$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
		$sth->execute();
		$row = $sth->fetchAll();
		echo(json_encode($row));
		
		header("Content-Type: application/json");
    return $response;
});
$app->get('/content/get', function (Request $request, Response $response, array $args) {

	$sql = 'SELECT content, to_char( "sentTime",\'MON DD HH24:MI:SS\' )as "sentTime", "UID",(CASE "UID" WHEN :UID THEN \'me\' ELSE \'other\' END)as "diff"
			FROM staff_chat."chatContent"
			WHERE "chatID"= :chatID ;';
		$sth = $this->db->prepare($sql);
		$UID =$_SESSION['id'];
		$chatID=$_GET['chatID'];
		$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
		$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
		$sth->execute();
		$row = $sth->fetchAll();
		echo(json_encode($row));
		
		header("Content-Type: application/json");
    return $response;
});
$app->post('/sendMsg', function (Request $request, Response $response, array $args) {

	$sql = 'INSERT INTO staff_chat."chatContent"(	content, "UID", "sentTime", "chatID")
	VALUES ( :Msg , :UID , NOW(), :chatID );';
		$sth = $this->db->prepare($sql);
		$UID =$_SESSION['id'];
		$chatID=$_POST['chatID'];
		$Msg=$_POST['Msg'];
		$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
		$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
		$sth->bindParam(':Msg',$Msg,PDO::PARAM_INT);
		$sth->execute();
		
		header("Content-Type: application/json");
    return $response;
});
$app->post('/updateLastReadTime', function (Request $request, Response $response, array $args) {

	$sql = 'UPDATE staff_chat."chatHistory"
	SET "time"= NOW()
	WHERE "chatHistory"."chatID"= :chatID AND "chatHistory"."UID"= :UID ;';
		$sth = $this->db->prepare($sql);
		$UID =$_SESSION['id'];
		$chatID=$_POST['chatID'];
		$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
		$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
		$sth->execute();
		
		header("Content-Type: application/json");
    return $response;
});
$app->run();
