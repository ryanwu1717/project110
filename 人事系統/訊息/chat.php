<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

session_start();

$container = $app->getContainer();
$container['db'] = function($c) {
    $dbuser='browser';
	$dbpassword='880721';
	$dbhost='localhost';
	$dbname="work";
	$dsn = "pgsql:host=".$dbhost.";dbname=".$dbname;
	$conn=new PDO($dsn,$dbuser,$dbpassword);
    return $conn;
};

$app->get('/list/get', function (Request $request, Response $response, array $args) {

	$sql = 'SELECT "receiverList"."chatID","chatToWhom",to_char("LastTime",\'DD MON\')as "LastTime","content","chatName","UserName"
				FROM(
					SELECT "chatWith"."chatID","chatToWhom"
					FROM(
						SELECT "chatID", "time", "UID"
						FROM public."chatHistory"
						where "UID"= :UID
						)as "chatWith" 
						LEFT JOIN (
									SELECT "cH3"."chatID","UID" as "chatToWhom"
									FROM(
										SELECT "couUID","chatID","time"
										FROM(
											SELECT "chatID" as "cID", COUNT("UID")as "couUID"
											FROM "chatHistory"
											group by "chatID") as "cUID"
											LEFT JOIN "chatHistory" as "cH2"
											on "cUID"."cID"="cH2"."chatID" AND "cH2"."UID"= :UID AND "couUID"=2)as "check"
									LEFT join "chatHistory" as "cH3"
									on "check"."chatID"="cH3"."chatID"
									where "UID"!= :UID
									)as "receiver" on "chatWith"."chatID"="receiver"."chatID")as "receiverList"
						LEFT JOIN (
									SELECT "cILT"."chatID","LastTime","content","UID" as "sender"
									FROM(
										SELECT "chatID",MAX("sentTime")as "LastTime"
										FROM "chatContent"
										Group by "chatID")as "cILT" 
						LEFT JOIN "chatContent" as "cC2" on "cILT"."chatID"="cC2"."chatID" 
						where "LastTime"="sentTime")as "searchResault" on "receiverList"."chatID"="searchResault"."chatID"	
						LEFT JOIN "chatroomInfo" on "receiverList"."chatID"="chatroomInfo"."chatID"
						LEFT JOIN"userInfo" on "receiverList"."chatToWhom"="userInfo"."UID"
						order by "LastTime" asc;';
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
			FROM public."chatContent"
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
$app->get('/sendMsg', function (Request $request, Response $response, array $args) {

	$sql = 'INSERT INTO public."chatContent"(	content, "UID", "sentTime", "chatID")
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
$app->run();
