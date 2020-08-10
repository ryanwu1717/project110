<?php
use Slim\Http\UploadedFile;
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

		function getCheckin(){
			$sql ='SELECT "checkin".id,"checkin"."UID","checkin"."checkinTime","checkin"."latitude",
				"checkin"."longitude",
				"out".id,"out"."checkoutTime","out"."latitude" as "outlatitude",
				"out"."longitude" as "outlongitude",
				case when "checkin"."checkinDate" is NULL 
					then "out"."checkoutDate"
					else "checkin"."checkinDate"
				end as "checkinDate",
				case when "checkin"."checkinTime" is NULL 
					then \'未打卡\'
					else  to_char("checkin"."checkinTime"::time, \'HH:MI:SS\')
				end as "inTime",
				case when "out"."checkoutTime" is NULL 
					then \'未打卡\'
					else to_char("out"."checkoutTime"::time, \'HH:MI:SS\')
				end as "outTime"
		FROM staff."employeeCheckin" as "checkin",(
			SELECT  "UID","checkinDate", MIN("checkinTime") as "checkinTime"
			FROM staff."employeeCheckin" 
			GROUP BY  "UID","checkinDate"
		) as "tmpCheckin"
		FULL OUTER JOIN (
			SELECT "checkout".id,"checkout"."UID","checkout"."checkoutDate","checkout"."checkoutTime","checkout"."latitude",
				"checkout"."longitude"
			FROM staff."employeeCheckout" as "checkout",(
				SELECT  "UID","checkoutDate", MAX("checkoutTime") as "checkoutTime"
				FROM staff."employeeCheckout" 
				GROUP BY  "UID","checkoutDate"
			) as "tmpCheckout"
			WHERE "tmpCheckout"."checkoutDate" = "checkout"."checkoutDate" 
					and "tmpCheckout"."checkoutTime" = "checkout"."checkoutTime" 
					and "checkout"."UID" = :UID
			order by "checkout"."checkoutDate"
		)as "out" ON "out"."checkoutDate"="tmpCheckin"."checkinDate"
		WHERE "tmpCheckin"."checkinDate" = "checkin"."checkinDate" 
				and "tmpCheckin"."checkinTime" = "checkin"."checkinTime" 
				and "checkin"."UID" = :UID
		order by "checkin"."checkinDate"'
		;
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':UID',$_SESSION['id']);
			$sth->execute();
			$row = $sth->fetchAll();
			foreach ($row as $key => $value) {
				// var_dump($key.'=>'.$value);
			}
			$ack = array(
				'info' => $row
			);
			return $ack;
		}

		function checkin($date,$time,$location,$latitude,$longitude){
			$sql ="INSERT INTO staff.\"employeeCheckin\"(
						 \"checkinDate\", \"checkinTime\", \"location\", \"UID\", \"latitude\", \"longitude\")
		 					VALUES (:checkinDate, :checkinTime, :location, :UID,:latitude,:longitude);";
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':checkinDate',$date);
		   	$sth->bindParam(':checkinTime',$time);
		   	$sth->bindParam(':location',$location);
		   	$sth->bindParam(':latitude',$latitude);
		   	$sth->bindParam(':longitude',$longitude);
		   	$sth->bindParam(':UID',$_SESSION['id']);
			$sth->execute();
			$row = $sth->fetchAll();
		}
		function checkout($date,$time,$location,$latitude,$longitude){
			$sql ="INSERT INTO staff.\"employeeCheckout\"(
						 \"checkoutDate\", \"checkoutTime\", \"location\", \"UID\", \"latitude\", \"longitude\")
		 					VALUES (:checkoutDate, :checkoutTime, :location, :UID,:latitude,:longitude);";
			$sth = $this->conn->prepare($sql);
	   	$sth->bindParam(':checkoutDate',$date);
	   	$sth->bindParam(':checkoutTime',$time);
	   	$sth->bindParam(':location',$location);
	   	$sth->bindParam(':latitude',$latitude);
	   	$sth->bindParam(':longitude',$longitude);
	   	$sth->bindParam(':UID',$_SESSION['id']);
			$sth->execute();
			$row = $sth->fetchAll();
		}

		function makeup(){
			$_POST=json_decode($_POST['data'],true);
			$sql ='INSERT INTO staff."makeUpCheckin"(
				 "UID", "time", "date", type, latitude, longitude, cause)
				VALUES ( :UID, :tmpTime, :tmpDate, :type, :latitude, :longitude, :cause);';
			$sth = $this->conn->prepare($sql);
	   		$sth->bindParam(':UID',$_SESSION['id']);
	   		$sth->bindParam(':tmpTime',$_POST['time']);
	   		$sth->bindParam(':tmpDate',$_POST['date']);
	   		$sth->bindParam(':type',$_POST['type']);
	   		$sth->bindParam(':latitude',$_POST['latitude']);
	   		$sth->bindParam(':longitude',$_POST['longitude']);
	   		$sth->bindParam(':cause',$_POST['cause']);

			$sth->execute();
			$ack = array(
				'status' => 'success'
			);
			return $ack;
		}

		function checkMakeup(){
			$_POST=json_decode($_POST['data'],true);
			$ack = array(
					'status' => 'success',
					'content' => '確認申請補卡？'
				);
			$date = strtotime("day");
			$checkDate =  date('Y-m-d', $date);
			if(empty($_POST['type'])){
				$ack = array(
					'status' => 'failed',
					'content' => '選項不得為空'
				);
       		}else if(empty($_POST['time'])){
				$ack = array(
					'status' => 'failed',
					'content' => '補卡時間不得為空'
				);
       		}else if(($_POST['time'])>$checkDate){
				$ack = array(
					'status' => 'failed',
					'content' => '補卡時間不在有效時間'
				);
       		}else if ($_POST['cause'] == ""){
       			$ack = array(
					'status' => 'failed',
					'content' => '原因不得為空'
				);
       		}
       		return $ack;
		}

		function employeeCheckin(){
			$_POST=json_decode($_POST['data'],true);
			try{
				if($_POST['type']=="onWork"){
					// var $boolCheckin=false;
					$sql ='SELECT  "checkinTime"
							FROM staff."employeeCheckin"
							WHERE "checkinDate"=:checkinDate AND "UID"=:UID
							order by "checkinTime" desc;';
					$sth = $this->conn->prepare($sql);
			   		$sth->bindParam(':checkinDate',$_POST['date']);
			   		$sth->bindParam(':UID',$_SESSION['id']);
					$sth->execute();
					$row = $sth->fetchAll();
					if(count($row)==0){
						$this->checkin($_POST['date'],$_POST['time'],$_POST['location'],$_POST['latitude'],$_POST['longitude']);	
						$ack = array(
							'status' => 'success'
						);
					}else{
						if($_POST['time']>date('H:i:s',strtotime('+30 minutes',strtotime($row[0]["checkinTime"])))){
								// var_dump(date('H:i:s',strtotime('+30 minutes',strtotime($row[0]["checkinTime"]))));
							$this->checkin($_POST['date'],$_POST['time'],$_POST['location'],$_POST['latitude'],$_POST['longitude']);		
							$ack = array(
								'status' => 'success'
							);
						}else{
							$tmpTime = date('H:i:s',strtotime('+30 minutes',strtotime($row[0]["checkinTime"])));
							$ack = array(
								'status' => 'toQuick',
								'time'=> $tmpTime
							
							);
						}
					}
				}else if($_POST['type']=="offWork"){
					$sql ="SELECT  \"checkoutTime\"
							FROM staff.\"employeeCheckout\"
							WHERE \"checkoutDate\"=:checkoutDate AND \"UID\"=:UID
							order by \"checkoutTime\" desc;";
					$sth = $this->conn->prepare($sql);
			   	$sth->bindParam(':checkoutDate',$_POST['date']);
			   	$sth->bindParam(':UID',$_SESSION['id']);
					$sth->execute();
					$row = $sth->fetchAll();

					// var_dump($row[0]["nextCheckinTime"]>$_POST['time']);

					if(count($row)==0){
						$this->checkout($_POST['date'],$_POST['time'],$_POST['location'],$_POST['latitude'],$_POST['longitude']);	
						$ack = array(
							'status' => 'success'
						);
					}else{
						if($_POST['time']>date('H:i:s',strtotime('+30 minutes',strtotime($row[0]["checkoutTime"])))){
							// var_dump($_POST['time'],date('H:i:s',strtotime('+30 minutes',strtotime($row[0]["checkoutTime"]))));
							$this->checkout($_POST['date'],$_POST['time'],$_POST['location'],$_POST['latitude'],$_POST['longitude']);	
							$ack = array(
								'status' => 'success'
							);
						}else{
							$tmpTime = date('H:i:s',strtotime('+30 minutes',strtotime($row[0]["checkoutTime"])));
							$ack = array(
								'status' => 'toQuick',
								'time'=> $tmpTime
							);
						}
					}
				}

			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed', 
					'message'=> $e
				);
			}
			return $ack;	
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

		function holidayAsk(){
			$_POST=json_decode($_POST['data'],true);
			$staff_id=$_SESSION['id'];
			if(strpos($_POST["startTime"],"請")!= false || strpos($_POST["endTime"],"請")!= false || mb_strlen($_POST["startTime"]) < 10 || mb_strlen($_POST["endTime"]) < 10){
				$ack = array(
					'status' => 'fail', 
					'reason' => "時間輸入正確"
				);
			}else{
				$dteStart = new DateTime($_POST["startTime"]);
	   			$dteEnd = new DateTime($_POST["endTime"]);
				$dteDiff = $dteStart->diff($dteEnd);
				if($dteDiff->format("%R") == "+"){
					$sql2 = 'SELECT staff_department FROM staff.staff WHERE staff.staff.staff_id = :staff_id';
					$sth2 = $this->conn->prepare($sql2);
					$sth2->bindParam(":staff_id", $staff_id);
					$sth2->execute();
					$row2 = $sth2->fetchAll();
					$sql ='INSERT INTO holiday.form("startTime", "endTime", reason, type, now, staff_id, "isCheck", department)
						VALUES (:startTime, :endTime, :reason, :type, now(), :staff_id, 1, :department);';
					$sth = $this->conn->prepare($sql);
					$sth->bindParam(":startTime", $_POST["startTime"]);
					$sth->bindParam(":endTime", $_POST["endTime"]);
					$sth->bindParam(":reason", $_POST["reason"]);
					$sth->bindParam(":type", $_POST["type"]);
					$sth->bindParam(":staff_id", $staff_id);
					$sth->bindParam(":department", $row2[0]['staff_department']);
					$sth->execute();
					$row = $sth->fetchAll();
					$ack = $row2;
				}else{
					$ack = array(
						'status' => 'fail', 
						'reason' => "時間輸入正確"
					);
				}
				return $ack;
				
			}


		}

		function record(){
			$_POST=json_decode($_POST['data'],true);
			$sql2 = 'SELECT holiday.form.id, holiday.level.level, staff.staff_department
					FROM staff.staff
					LEFT JOIN holiday.level
					on staff.staff.staff_id=holiday.level.id
					LEFT JOIN holiday.form
					ON staff.staff.staff_id=holiday.form.staff_id
					WHERE staff.staff.staff_id = :id and staff.staff.staff_department = :department
					ORDER BY holiday.form.id DESC
					LIMIT 1;';
			$sth2 = $this->conn->prepare($sql2);
			$sth2->bindParam(":id", $_SESSION['id']);
			$sth2->bindParam(":department", $_POST['department']);
			$sth2->execute();
			$row2 = $sth2->fetchAll();
			if(!$row2[0]['level']){
				$sql3 = 'SELECT level
						FROM holiday.level
						WHERE department=:department
						ORDER BY level DESC
						LIMIT 1;';
				$sth3 = $this->conn->prepare($sql3);
				$sth3->bindParam(":department", $row2[0]['staff_department']);
				$sth3->execute();
				$row3 = $sth3->fetchAll();
				$level = $row3[0]['level'];
			}else{
				$level = $row2[0]['level'] - 1;
			}
			$sql ='INSERT INTO "holiday"."reviewRecord"(id, department, level)
				VALUES (:id, :department, :level);';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(":id", $row2[0]['id']);
			$sth->bindParam(":department", $_POST['department']);
			$sth->bindParam(":level", $level);
			$sth->execute();
			return [];
		}

		function recordData($id, $ischeck){
			$staff_id=$_SESSION['id'];
			$sql ='INSERT INTO holiday."checkLevel"(id, staff_id, "time", ischeck)
				VALUES (:id, :staff_id, now(), :ischeck);';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(":id", $id);
			$sth->bindParam(":staff_id", $staff_id);
			$sth->bindParam(":ischeck", $ischeck);
			$sth->execute();
		}

		function getlist($department){
			$sql ='SELECT * 
					FROM holiday.level
					LEFT JOIN staff_information.department
					on holiday.level.department = staff_information.department.department_id
					where department = :department
					ORDER BY level;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(":department", $department);
			$sth->execute();
			$response = $sth->fetchAll(PDO::FETCH_ASSOC);

			return $response;
		}

		function getPerson($department){
			if($department != null){
				$sql ='SELECT id
						FROM holiday.level
						where department = :department
						ORDER BY level;
				';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(":department", $department);
				$sth->execute();
				$response = $sth->fetchAll(PDO::FETCH_ASSOC);
			}else{
				$response = array(
				);
			}
			return $response;
		}

		function levelAdd(){
			$_POST=json_decode($_POST['data'],true);
			$name = 'SELECT staff_name
						FROM staff.staff
						where staff_id = :UID;
					';
			$sth = $this->conn->prepare($name);
			$sth->bindParam(":UID", $_POST["UID"]);
			$sth->execute();
			$row = $sth->fetch();
			if($row){
				$dep ='SELECT department_name
					FROM staff_information.department
					where department_id = :department;';
				$sth4 = $this->conn->prepare($dep);
				$sth4->bindParam(":department", $_POST["department"]);
				$sth4->execute();
				$getDep = $sth4->fetch();
				$max = 'SELECT MAX(level)
						FROM holiday.level
						WHERE department = :department;
						';
				$sth3 = $this->conn->prepare($max);
				$sth3->bindParam(":department", $_POST["department"]);
				$sth3->execute();
				$big = $sth3->fetch();
				if($big[0] == null){
					$big[0] = 1;
				}else{
					$big[0] += 1;
				}
				
				$ack = array(
					'name' => $row[0],
					'level'=> $big[0],
					'department' => $getDep[0]
				);
			}else{
				$ack = array(
					'name' => null
				);
			}
			return $ack;
		}
		//把level先複製在檢查level(未實做)
		function levelTable(){
			$_POST=json_decode($_POST['data'],true);
			$dep = (int)$_POST["tableList"][0]["department"];
			$del ='DELETE FROM holiday.level
					WHERE department=:department;
					';
			$sth = $this->conn->prepare($del);
			$sth->bindParam(":department", $dep);
			$sth->execute();
			for($i=0;$i<count($_POST["tableList"]);$i++){
				$named = $_POST["tableList"][$i]["named"];
				$level = (int)$_POST["tableList"][$i]["level"];
				$num = $_POST["tableList"][$i]["num"];
				$sql ='INSERT INTO holiday.level(name, level, id, department)
					VALUES (:name, :level, :UID, :department);
					';
				$sth2 = $this->conn->prepare($sql);
				$sth2->bindParam(":name", $named);
				$sth2->bindParam(":department", $dep);
				$sth2->bindParam(":UID", $num);
				$sth2->bindParam(":level", $level);
				$sth2->execute();
			}
		}

		function checkingData(){
			try{	 
				$sql ='SELECT form.id, form."startTime", form."endTime", form.reason, form.now, type.name, form.staff_id, form."isCheck" ,department_name
						FROM holiday.form
						inner join staff_information.department
						on staff_information.department.department_id = holiday.form.department
						INNER JOIN holiday.type
						on holiday.form.type = holiday.type.id
						LEFT JOIN holiday."reviewRecord"
						on holiday.form.id = holiday."reviewRecord".id
						LEFT JOIN holiday.level
						on holiday.level.level = holiday."reviewRecord".level
						WHERE holiday.level.id =:id;';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(":id", $_SESSION['id']);
				$sth->execute(); 
			    $response = $sth->fetchAll();
			}catch(PDOException $e){
				$response = array(
					'status' => 'failed', 
					'checkin'=> false
				);
			}	
			return $response;

		}

		function checkedData(){
			try{	 
				$sql ='SELECT form.id, form."startTime", form."endTime", form.reason, form.now, type.name, form.staff_id, form."isCheck" ,department_name
						FROM holiday.form
						inner join staff_information.department
						on staff_information.department.department_id = holiday.form.department
						INNER JOIN holiday.type
						on holiday.form.type = holiday.type.id
						INNER JOIN holiday."reviewRecord"
						on holiday."reviewRecord".id = holiday.form.id
						INNER JOIN holiday.level
						on holiday."reviewRecord".level = holiday.level.level
						WHERE holiday.level.id = :id
						;';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(":id", $_SESSION['id']);
				$sth->execute(); 
			    $response = $sth->fetchAll();
			}catch(PDOException $e){
				$response = array(
					'status' => 'failed', 
					'checkin'=> false
				);
			}	
			return $response;

		}

		function agreeApply($dataID){
			$_POST=json_decode($_POST['data'],true);
			$id = $_POST['id'];
			$ischeck = $_POST['ischeck'];
			$sql ='UPDATE holiday.form SET "isCheck"=2 WHERE id = :id';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(":id", $dataID);
			$sth->execute();
			$this->recordData($id,$ischeck);
		}

		function refuseApply($dataID){
			$sql ='UPDATE holiday.form SET "isCheck"=3 WHERE id = :id';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(":id", $dataID);
			$sth->execute();
		}



		function uploadFile($directory,$uploadedFiles,$isPicture){
			// handle single input with single file upload
		    $uploadedFile = $uploadedFiles['inputFile'];
		    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
		        $filename = $this->moveUploadedFile($directory, $uploadedFile);
		        $UID = $_SESSION['id'];
		        $clientName = $uploadedFile->getClientFilename();
				$sql = 'INSERT INTO holiday.file("fileName", "UID", "fileNameClient") VALUES (:fileName, :UID, :fileNameClient);';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':fileName',$filename,PDO::PARAM_STR);
				$sth->bindParam(':fileNameClient',$clientName,PDO::PARAM_STR);
				$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
				$sth->execute();
				$id = $this->conn->lastInsertId();
				// $uploadedFile->getClientFilename()
				$result = array(
			    	'fileID' => $id,
			    	'fileNameClient' => $clientName,
			    );
				
		    }else{
			    $result = array(
			    	'status' => 'failed'
			    );
		    }
		    return $result;
		}
		private function moveUploadedFile($directory, UploadedFile $uploadedFile)
		{
		    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
		    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
		    $filename = sprintf('%s.%0.8s', $basename, $extension);
		    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
		    return $filename;
		}

		function downloadFile($fileID){	
			$sql = '
				SELECT id, "fileName", "fileNameClient", "uploadTime", "UID"
				FROM holiday.file
				WHERE id = :fileID;
			';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':fileID',$fileID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			if(count($row)==1){	
			    $result = array(
			    	'status' => 'success',
			    	'data' => $row[0]
			    );
		    }else{
			    $result = array(
			    	'status' => 'failed'
			    );
		    }
		    return $result;
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