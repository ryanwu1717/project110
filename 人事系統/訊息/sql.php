<?php
	session_start();
	$id = $_GET['ID'];
	if($id == '1'){
		$_SESSION['id'] = '1';
	}else if($id=='2'){
		$_SESSION['id'] = '2';
	}else if($id=='3'){
		echo($_SESSION['id']);
	}else if($id=='4'){
		$dbuser='browser';
		$dbpassword='880721';
		$dbhost='localhost';
		$dbname="work";
		$dsn = "pgsql:host=".$dbhost.";dbname=".$dbname;
		$conn=new PDO($dsn,$dbuser,$dbpassword);

		// $sql = 'SELECT * FROM "public"."testTable" WHERE (name= :name OR "from"=:name) order by "time";';
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
						order by "LastTime" desc;';
		$sth = $conn->prepare($sql);
		$UID =$_SESSION['id'];
		$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
		$sth->execute();
		$row = $sth->fetchAll();
		echo(json_encode($row));
		
		header("Content-Type: application/json");
	}
	else if($id=='5'){
		$dbuser='browser';
		$dbpassword='880721';
		$dbhost='localhost';
		$dbname="work";
		$dsn = "pgsql:host=".$dbhost.";dbname=".$dbname;
		$conn=new PDO($dsn,$dbuser,$dbpassword);

		
		$sql='SELECT content, to_char( "sentTime",\'MON DD HH24:MI:SS\' )as "sentTime", "UID",(CASE "UID" WHEN :UID THEN \'me\' ELSE \'other\' END)as "diff"
			FROM public."chatContent"
			WHERE "chatID"= :chatID ;';

		$sth = $conn->prepare($sql);
		$UID =$_SESSION['id'];
		$chatID=$_GET['chatID'];
		$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
		$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
		$sth->execute();
		$row = $sth->fetchAll();
		echo(json_encode($row));
		
		header("Content-Type: application/json");
	}
?>