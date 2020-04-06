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
			$sql = "SELECT account as staff_name FROM management.\"user\" WHERE id = :id;";
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':id',$staff_id,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		} 
	}

	Class Tables{
		var $result;   
		var $conn;
		function __construct($db){
			$this->conn = $db;
		}
		function deleteStaff()
		{ 
			try{
				$_POST=json_decode($_POST['data'],true);		 	
				$sql ="UPDATE staff.staff
						SET staff_delete = true
						WHERE staff_id= :staff;";
				$sth = $this->conn->prepare($sql);
			   	$sth->bindParam(':staff',$_POST['staff_id']);
				$sth->execute();
				$row = $sth->fetchAll();
				$ack = array(
					'status' => 'success'
				);
			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed', 
					'message'=> $e
				);
			}	
			return $ack;
		} 
	}

	Class Work{
		var $conn;
		var $result; 
		function __construct($db){
			$this->conn = $db;
		}
		function check($todaydate){
			try{	 	
				$staff_id = $_SESSION['id'];
				$sql ="SELECT checkin
						FROM staff.checkin
						WHERE staff_id= :staff AND checkindate = :checkinDate;";
				$sth = $this->conn->prepare($sql);
			    $sth->bindParam(':staff',$staff_id);
			    $sth->bindParam(':checkinDate',$todaydate);
				$sth->execute();
				$row = $sth->fetchColumn(0);
				$ack = array(
					'status' => 'success', 
					'checkin'=> $row
				);
			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed', 
					'checkin'=> false
				);
			}	
			return $ack;
		} 
		function checkAll($todaydate){
			try{	 
				$staff_id = $_SESSION['id'];	
				$sql ="SELECT checkout
						FROM staff.checkin
						WHERE staff_id= :staff AND checkindate = :checkinDate AND checkin = true;";
				$sth = $this->conn->prepare($sql);
			    $sth->bindParam(':staff',$staff_id);
			    $sth->bindParam(':checkinDate',$todaydate);
				$sth->execute();
				$row = $sth->fetchColumn(0);
				$ack = array(
					'status' => 'success', 
					'checkin'=> $row
				);
			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed', 
					'checkin'=> false
				);
			}	
			return $ack;
		} 

		function checkinToday(){
			$_POST=json_decode($_POST['data'],true);
			$staff_id = $_SESSION['id'];	
			switch($_POST['type']){
				case 'start':
					try{	
						if($_POST['hours']+8>=24)
						{
							$eightHours = "00:00:00";
						}else {
							$eightHours =  ($_POST['hours']+8).":".$_POST['minutes'].":".$_POST['seconds']; 
						}
						if($_POST['hours']+9>=24)
						{
							$ninesHours = "00:00:00";
						}else {
							$ninesHours =  ($_POST['hours']+9).":".$_POST['minutes'].":".$_POST['seconds']; 
						}
						$sql ="INSERT INTO staff.checkin(staff_id, checkintime, checkin, checkout, checkindate,checkinlocation,eight,nine )
								VALUES (:staff, :checkinTime, true , false, :checkinDate,:checkinlocation,:eight,:nine);";
						$sth = $this->conn->prepare($sql);
					   $sth->bindParam(':staff',$staff_id);
					    $sth->bindParam(':checkinTime',$_POST['checkinTime']);
					    $sth->bindParam(':checkinDate',$_POST['checkinDate']);
					    $sth->bindParam(':checkinlocation',$_POST['location']);
					    $sth->bindParam(':eight',$eightHours);
					    $sth->bindParam(':nine',$ninesHours);
						$sth->execute();
						$row = $sth->fetchAll();
						$ack = array(
							'status' => 'success', 
						);
					}catch(PDOException $e){
						$ack = array(
							'status' => 'failed', 
							'checkout' => false,
							'message'=> $e
						);
					}
					return $ack;	
				case 'finish':
					try{	 	
						$sql ="UPDATE staff.checkin
								SET checkouttime=:checkoutTime, checkout = true, checkoutlocation=:checkoutlocation
								WHERE staff_id= :staff AND checkindate = :checkindate;";
						$sth = $this->conn->prepare($sql);
					   $sth->bindParam(':staff',$staff_id);
					   $sth->bindParam(':checkoutTime',$_POST['checkinTime']);
					   $sth->bindParam(':checkindate',$_POST['checkinDate']);
					   $sth->bindParam(':checkoutlocation',$_POST['location']);
						$sth->execute();
						$row = $sth->fetchAll();
						$ack = array(
							'status' => 'success', 
						);
					}catch(PDOException $e){
						$ack = array(
							'status' => 'failed', 
							'checkout' => false,
							'message'=> $e
						);
					}
					return $ack;
				default :
					$ack = array(
						'status' => 'failed', 
						'checkout' => "default",
					);
					return $ack;
			}

			
		} 
	}

	Class CheckinList{
		var $conn;
		var $result; 
		function __construct($db){
			$this->conn = $db;
		}
		function getlist(){
			$sql ="SELECT staff_name as name,staff_id as id FROM staff.staff ;";
			$sth = $this->conn->prepare($sql);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}
		function getCheckin($staff_id,$checkDate,$type){
			try{	 	
				$sql ="SELECT checkintime,checkouttime,checkinlocation,checkoutlocation,staff_name,eight,nine 
				FROM staff.checkin NATURAL JOIN staff.staff where staff_id = :id AND checkindate = :checkindate;";
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':id',$staff_id);
				$sth->bindParam(':checkindate',$checkDate);
				$sth->execute();
				$row = $sth->fetchAll();
				$tmpjson = json_encode($row);
				if(empty($row)  ){
					$ack = array(
						'status' => 'failed', 
					);
				}else{
					if($type == '8H'){
						if($row[0]["eight"]=="00:00:00"){
							$ack = array(
								'status' => 'success', 
								'data' => $row,
								'correspond' => "未滿八小時"
							);
							return $ack;
						}
						if((strtotime($row[0]["checkouttime"])-strtotime($row[0]["eight"]))>0){
							$condition = "上滿八小時";
						}else{
							$condition = "未滿八小時";
						}
					}else if ($type == '9H'){
						if($row[0]["nine"]=="00:00:00"){
							$ack = array(
								'status' => 'success', 
								'data' => $row,
								'correspond' => "未滿九小時"
							);
							return $ack;
						}
						if((strtotime($row[0]["checkouttime"])-strtotime($row[0]["nine"]))>0){
							$condition = "上滿九小時";
						}else{
							$condition = "未滿九小時";
						}
					}
					$ack = array(
						'status' => 'success', 
						'data' => $row,
						'correspond' => $condition
					);
				}
				return $ack;
			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed', 
					'checkout' => false,
					'message'=> $e
				);
				return $ack;
			}	
		}
	}

	Class ChatManage{
		var $result;   
		var $conn;
		function __construct($db){
			$this->conn = $db;
		}
		function deleteChat(){
			$_POST=json_decode($_POST['data'],true);
			// var_dump($_POST['time']);
			try{
				$sql = 'DELETE FROM staff_chat."chatContent"
						WHERE "sentTime" < :deleteTime';
				$statement = $this->conn->prepare($sql);
				$statement->bindParam(':deleteTime',$_POST['time']);
				$statement->execute();
				$ack = array(
					'status' => 'success', 
					'message' => '成功'
				);

			}catch(PDOException $e)
			{
				$ack = array(
					'status' => 'failed'
				);
			}	
			return $ack;
		}
	}

	Class Add{
		var $conn;
		var $result; 
		function __construct($db){
			$this->conn = $db;
		}
		function deleteItem(){
			$_POST=json_decode($_POST['data'],true);
			switch($_POST['type']){
				case 'department':
					try{
						$sql = 'DELETE FROM staff_information.department
									WHERE department_name=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case 'position':
					try{
						$sql = 'DELETE FROM staff_information.position
									WHERE position_name=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case 'gender':
					try{
						$sql = 'DELETE FROM staff_information.gender
									WHERE type=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case 'marriage':
					try{
						$sql = 'DELETE FROM staff_information.marriage
									WHERE type=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case 'insuredcompany':
					try{
						$sql = 'DELETE FROM staff_salary.insuredcompany
									WHERE "companyName"=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case 'workStatus':
					try{
						$sql = 'DELETE FROM staff_salary."workStatus"
									WHERE status=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case 'staffType':
					try{
						$sql = 'DELETE FROM staff_salary."staffType"
									WHERE type=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case 'educationCondition':
					try{
						$sql = 'DELETE FROM staff_education.condition
									WHERE type=:deleteItem; ';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':deleteItem',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);

					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				default:
       			$ack = array(
							'status' => 'failed', 
							'message'=> $e
						);	
					return $ack;
			}
		}
		function addItem(){
			$_POST=json_decode($_POST['data'],true);
			switch ($_POST['type']){
				case '部門':
					try{
						$newId = 'A';
						for($i=0;$i<=26;$i++){
							++$newId . PHP_EOL;
							$sql ='SELECT EXISTS(SELECT 1 FROM staff_information.department WHERE department_id=:id)';
							$sth = $this->conn->prepare($sql);
						   $sth->bindParam(':id',$newId);
							$sth->execute();
							$row = $sth->fetchColumn(0);
							if($i==26){
								$ack = array(
									'status' => 'failed', 
									'message' => '多餘10筆資料'
								);
								return $ack;
							}
							if(!$row){
								$addsql = 'INSERT INTO staff_information.department(department_id,department_name)
										VALUES (:id,:name);';
								$statement = $this->conn->prepare($addsql);
								$statement->bindParam(':id',$newId);
								$statement->bindParam(':name',$_POST['item']);
								$statement->execute();
								$ack = array(
									'status' => 'success', 
									'message' => '新增成功'
								);		
								return $ack;
							}
						}
					}catch(PDOException $e){
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);			
					}					
					return $ack;

				case '職位':
					try{
						for($i=1;$i<=10;$i++){
							$sql ='SELECT EXISTS(SELECT 1 FROM staff_information.position WHERE position_id=:id)';
							$sth = $this->conn->prepare($sql);
						   $sth->bindParam(':id',$i);
							$sth->execute();
							$row = $sth->fetchColumn(0);
							if($i==10){
								$ack = array(
									'status' => 'failed', 
									'message' => '多餘10筆資料'
								);
								return $ack;
							}
							if(!$row){
								$addsql = 'INSERT INTO staff_information.position(position_id,position_name)
										VALUES (:id,:name);';
								$statement = $this->conn->prepare($addsql);
								$statement->bindParam(':id',$i);
								$statement->bindParam(':name',$_POST['item']);
								$statement->execute();
								$ack = array(
									'status' => 'success', 
									'message' => '新增成功'
								);		
								return $ack;
							}
						}
					}catch(PDOException $e){
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);			
					}					
					return $ack;

				case '性別':
					try{			
						$sql = 'INSERT INTO staff_information.gender(type)
									VALUES (:name);';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':name',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);
					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case '婚姻狀態':
					try{			
						$sql = 'INSERT INTO staff_information.marriage(type)
									VALUES (:name);';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':name',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);
					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case '投保公司':
					try{			
						$sql = 'INSERT INTO staff_salary.insuredcompany("companyName")
									VALUES (:name);';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':name',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);
					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case '在職狀態':
					try{			
						$sql = 'INSERT INTO staff_salary."workStatus"(status)
									VALUES (:name);';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':name',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);
					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=>'資料重複'
						);
					}	
					return $ack;
				case '員工類型':
					try{			
						$sql = 'INSERT INTO staff_salary."staffType"(type)
									VALUES (:name);';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':name',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);
					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				case '就學狀態':
					try{				
						$sql = 'INSERT INTO  staff_education.condition(type)
									VALUES (:name);';
						$statement = $this->conn->prepare($sql);
						$statement->bindParam(':name',$_POST['item']);
						$statement->execute();
						$ack = array(
							'status' => 'success', 
							'message' => '新增成功'
						);
					}catch(PDOException $e)
					{
						$ack = array(
							'status' => 'failed', 
							'message'=> '資料重複'
						);
					}	
					return $ack;
				default:
       			$ack = array(
							'status' => 'failed', 
							'message'=> $e
						);
					}	
					return $ack;		
		}
	}
?>