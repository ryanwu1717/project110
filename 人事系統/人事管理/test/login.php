<?php
	session_start();
	$dbhost = 'localhost';
	$dbuser = 'postgres';
	$dbpasswd = '880817';
	$dbname = 'ryanDB';
	$dsn = "pgsql:host=".$dbhost.";dbname=".$dbname;
	try{
		$conn = new PDO($dsn,$dbuser,$dbpasswd);
		$conn->exec("SET CHARACTER SET utf8");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// echo "Connected Successfully";

		// var_dump($_POST);
	   	$_POST=json_decode($_POST['data'],true);
	   	// var_dump($_POST);
	   	$loginStaffId = $_POST['loginStaffId'];
		$loginPassword = $_POST['loginPassword'];

		// echo ($loginStaffId);
		// echo ($loginPassword);
		
		$sql = "SELECT  staff_password FROM staff.staff WHERE staff_id = :staff_id;";
		$sth = $conn->prepare($sql);
	   	$sth->bindParam(':staff_id',$loginStaffId);
	   	$sth->execute();
		$row = $sth->fetch();
		$jsonStr=json_encode($row);
		$myArr=json_decode($jsonStr, true);
		$correctPassword=$myArr['staff_password'];
		// echo ($correctPassword);
		// var_dump($loginPassword);
		// var_dump($correctPassword);
		if($loginPassword == $correctPassword){
			// echo "same";
			$_SESSION['id']=$loginStaffId;
			$ack = array(
				'status'=>'success',
				'user'=>$loginStaffId
			);
			echo json_encode($ack);
			header("Content-Type: application/json");
		}else{
			echo"else";
			header("Location: http://localhost/test/login.html"); 
		}

	}catch(PDOException $e)
	{
		echo "Connection failed: ".$e->getMessage();
	}   
	
		
		
	
?>