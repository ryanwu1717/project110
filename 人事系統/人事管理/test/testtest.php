<?php
	$dbhost = 'localhost';
	$dbuser = 'postgres';
	$dbpasswd = '880817';
	$dbname = 'ryanDB';
	$dsn = "pgsql:host=".$dbhost.";dbname=".$dbname;
	 
	try
	{
	    
	    $conn = new PDO($dsn,$dbuser,$dbpasswd);
	    $conn->exec("SET CHARACTER SET utf8");
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    echo "Connected Successfully";
	    $sql = "SELECT * FROM `users` WHERE sn > :sn AND name = :name";
		$sth = $conn->prepare($sql);
		$sn = 1;
		$sth->bindParam(':sn',$sn);
		$sth->execute();
		$row = $sth->fetch();
		echo ($row);
	}
	catch(PDOException $e)
	{
	    echo "Connection failed: ".$e->getMessage();
	}
	
?>