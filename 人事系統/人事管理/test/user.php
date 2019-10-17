<?php
	session_start();
	Class User{
		var $result;   
		function login()
		{ 
			global $conn;
			$_POST=json_decode($_POST['data'],true);
		   	// var_dump($_POST);
		   	$loginStaffId = $_POST['loginStaffId'];
			$loginPassword = $_POST['loginPassword'];
			 	
			$sql ="SELECT  staff_password FROM staff.staff WHERE staff_id = :staff_id;";
			$sth = $conn->prepare($sql);
		   	$sth->bindParam(':staff_id',$loginStaffId);
		   	$sth->execute();
			$row = $sth->fetch();
			$jsonStr=json_encode($row);
			$myArr=json_decode($jsonStr, true);
			$correctPassword=$myArr['staff_password'];
			 	
				
			if($loginPassword == $correctPassword){
				// echo "same";
				$sql = "SELECT  staff_name FROM staff.staff WHERE staff_id = :staff_id;";
				$sth = $conn->prepare($sql);
			   	$sth->bindParam(':staff_id',$loginStaffId);
			   	$sth->execute();
				$row = $sth->fetchColumn(0);
				//echo $row;
				
				$_SESSION['user']=$row;
				//$_SESSION['login']=ture;
				
				return $row;
				
			}else{
				echo"else";
				header("Location: http://localhost/test/login.html"); 
			}
			
			//return $row;

		} 

		function get(){ 
			//$_SESSION['user'] = 'USER';
			$result = $_SESSION['user'];				
			return $result;

		} 

		function initial(){
			$_SESSION['user'] = 'USER';
			$result = $_SESSION['user'];		
			return $result;
		}
		
		
	}

	Class Staff{
		var $result;   
		
		function getDepartment()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_information.department;';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		}

		function getPosition()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_information.position;';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		} 

		function getGender()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_information.gender;';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		} 

		function getMarriage()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_information.marriage;';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		} 

		function getInsuredcompany()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_salary.insuredcompany;';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		} 

		function getWorkStatue()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_salary."workStatue";';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		} 

		function getStaffType()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_salary."staffType";';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		} 

		function getEducationCondition()
		{ 
			global $conn;
			 	
			$sql ='SELECT * from staff_education.condition;';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		} 

		function getStaffNum()
		{
			global $conn;
			 	
			$sql ='SELECT COUNT (*) as num FROM staff.staff;';	
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchColumn(0);
			
			return $row;
		}

		function register(){
			global $conn;
			try
				{
					

					$sql = 'INSERT INTO staff.staff("staff_id","staff_department","staff_position","staff_name",
													  "staff_birthday","staff_gender","staff_marriage","staff_TWid",
													  "contact_homeNumber","contact_phoneNumber","contact_companyNumber",
													  "contact_homeAddress","contact_contactAddress",
													  "seniority_insuredCompany","seniority_workStatue","seniority_staffType",
													  "seniority_endDate","seniority_leaveDate",
													  "contactPerson_name","contactPerson_homeNumber","contactPerson_phone",
													  "contactPerson_relation","contactPerson_more",
													  "education_time","education_type","education_school",
													  "education_department","education_statue","staff_password"
													 )  
							VALUES (:staff_id, :staff_department, :staff_position, :staff_name,
							 		:staff_birthday, :staff_gender, :staff_marriage, :staff_TWid,
							 		:contact_homeNumber, :contact_phoneNumber, :contact_companyNumber,
							 		:contact_homeAddress, :contact_contactAddress,
							 		:seniority_insuredCompany, :seniority_workStatue, :seniority_staffType,
							 		:seniority_endDate, :seniority_leaveDate,
							 		:contactPerson_name, :contactPerson_homeNumber, :contactPerson_phone,
							 		:contactPerson_relation, :contactPerson_more,
							 		:education_time, :education_type, :education_school,
							 		:education_department, :education_statue, :staff_password
							 		) ';
					$sth = $conn->prepare($sql);

					//var_dump($_POST);
			   		//require_once('dbconnect.php');//引入資料庫連結設定檔
			   		$_POST=json_decode($_POST['data'],true);
			   		//var_dump($_POST);
			        
					$staff_id = $_POST['staff_id'];//取得id值
					$staff_department = $_POST['staff_department'];
					$staff_position = $_POST['staff_position'];
					$staff_name = $_POST['staff_name'];
					$staff_birthday = $_POST['staff_birthday'];
					$staff_gender = $_POST['staff_gender'];
					$staff_marriage = $_POST['staff_marriage'];
					$staff_TWid = $_POST['staff_TWid'];	

					$contact_homeNumber = $_POST['contact_homeNumber'];
					$contact_phoneNumber = $_POST['contact_phoneNumber'];
					$contact_companyNumber = $_POST['contact_companyNumber'];
					$contact_homeAddress = $_POST['contact_homeAddress'];
					$contact_contactAddress = $_POST['contact_contactAddress'];

					$seniority_insuredCompany = $_POST['seniority_insuredCompany'];
					$seniority_workStatue = $_POST['seniority_workStatue'];
					$seniority_staffType = $_POST['seniority_staffType'];
					$seniority_endDate = $_POST['seniority_endDate'];
					$seniority_leaveDate = $_POST['seniority_leaveDate'];

					$contactPerson_name = $_POST['contactPerson_name'];
					$contactPerson_homeNumber = $_POST['contactPerson_homeNumber'];
					$contactPerson_phone = $_POST['contactPerson_phone'];
					$contactPerson_relation = $_POST['contactPerson_relation'];
					$contactPerson_more = $_POST['contactPerson_more'];

					$education_time = $_POST['education_time'];
					$education_type = $_POST['education_type'];
					$education_school = $_POST['education_school'];
					$education_department = $_POST['education_department'];
					$education_statue = $_POST['education_statue'];

					$staff_password = $_POST['staff_password'];

					$sth->bindParam(':staff_id',$staff_id);
					$sth->bindParam(':staff_department',$staff_department);
					$sth->bindParam(':staff_position',$staff_position);
					$sth->bindParam(':staff_name',$staff_name);
					$sth->bindParam(':staff_birthday',$staff_birthday);
					$sth->bindParam(':staff_gender',$staff_gender);
					$sth->bindParam(':staff_marriage',$staff_marriage);
					$sth->bindParam(':staff_TWid',$staff_TWid);

					$sth->bindParam(':contact_homeNumber',$contact_homeNumber);
					$sth->bindParam(':contact_phoneNumber',$contact_phoneNumber);
					$sth->bindParam(':contact_companyNumber',$contact_companyNumber);
					$sth->bindParam(':contact_homeAddress',$contact_homeAddress);
					$sth->bindParam(':contact_contactAddress',$contact_contactAddress);

					$sth->bindParam(':seniority_insuredCompany',$seniority_insuredCompany);
					$sth->bindParam(':seniority_workStatue',$seniority_workStatue);
					$sth->bindParam(':seniority_staffType',$seniority_staffType);
					$sth->bindParam(':seniority_endDate',$seniority_endDate);
					$sth->bindParam(':seniority_leaveDate',$seniority_leaveDate);

					$sth->bindParam(':contactPerson_name',$contactPerson_name);
					$sth->bindParam(':contactPerson_homeNumber',$contactPerson_homeNumber);
					$sth->bindParam(':contactPerson_phone',$contactPerson_phone);
					$sth->bindParam(':contactPerson_relation',$contactPerson_relation);
					$sth->bindParam(':contactPerson_more',$contactPerson_more);

					$sth->bindParam(':education_time',$education_time);
					$sth->bindParam(':education_type',$education_type);
					$sth->bindParam(':education_school',$education_school);
					$sth->bindParam(':education_department',$education_department);
					$sth->bindParam(':education_statue',$education_statue);

					$sth->bindParam(':staff_password',$staff_password);

					$sth->execute();
				}
				catch(PDOException $e)
				{
					echo "Connection failed: ".$e->getMessage();
				}
		}
	}

	Class Table{
		var $result; 
		function getTable(){
			global $conn;

			$sql =' SELECT DISTINCT s."staff_name" as name ,x."position_name" as position,
   									d."department_name" as department,s."contact_phoneNumber" as phonenumber,
   									s."seniority_endDate" as enddate,s."seniority_staffType" as stafftype,
   									s."staff_id" 
					from staff.staff as s,staff_information.department as d,staff_information.position as x
					where s."staff_position" = x."position_id" and s."staff_department" = d."department_id"
					ORDER BY position DESC;';
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		}
	}
?>