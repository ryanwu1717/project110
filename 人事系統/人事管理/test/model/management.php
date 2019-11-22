<?php
	Class Management{
		var $result;   
		var $conn;
		function __construct($db){
			$this->conn = $db;
		}
		function login()
		{ 
			$_POST=json_decode($_POST['data'],true);
		   	$loginStaffId = $_POST['loginStaffId'];
			$loginPassword = $_POST['loginPassword'];		 	
			$sql ="SELECT * FROM management.\"user\" WHERE account = :account and password = :password;";
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':account',$loginStaffId);
		   	$sth->bindParam(':password',$loginPassword);
			$sth->execute();
			$row = $sth->fetchAll();
			if(count($row)==1){
				$_SESSION['management']['id']=$row[0]['id'];
				$ack = array(
					'status' => 'success', 
				);
			}else{
				$ack = array(
					'status' => 'failed',
					'row'=>$row
				);
			}
			return $ack;
		} 

		function getName(){ 
			$staff_id = $_SESSION['management']['id'];
			$sql ="SELECT account as staff_name FROM management.\"user\" WHERE id = :id;";
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':account',$staff_id,PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		} 
	}
?>