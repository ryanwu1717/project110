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

       function checkString($strings, $standard){
       		// echo "inCheck";
           if(preg_match($standard, $strings, $hereArray)) {
           		// echo "1";
            	return 1;

           } else {
           		// echo "0";
           		return 0;

           }

       }

       public function check($field,$input){
       		// echo $input;
       		if(empty($input)){
       			return $field."不得為空";
       			
       		}
       		$inputLen = strlen($input);
       		
       		//A. 檢查是不是數字
	        $standard_A = "/^([0-9]+)$/"; 
	        //B. 檢查是不是小寫英文
	        $standard_B = "/^([a-z]+)$/";
	        //C. 檢查是不是大寫英文
	        $standard_C = "/^([A-Z]+)$/";
	        //D. 檢查是不是全為英文字串
	        $standard_D = "/^([A-Za-z]+)$/"; 
	        //E. 檢查是不是英數混和字串
	        $standard_E = "/^([0-9A-Za-z]+)$/";
	        //F. 檢查是不是中文
	        $standard_F = "/^([\x7f-\xff]+)$/"; 
	        //G. 檢查是不是電子信箱格式
	        //$standard_G_1 這組正則允許 "stanley.543-ok@myweb.com" 
	        //但 $standard_G_2 僅允許 "stanley543ok@myweb.com" ，字串內不包含 .(點)和 -(中線) 
	        $standard_G_1 = "/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/";
	        $standard_G_2 = "/^[\w]*@[\w-]+(\.[\w-]+)+$/" ;
	        //下面則是個簡單的範例，大家可以嘗試看看
	        $standard_G_1 = "/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/";

	        $standard_G_2 = "/^[\w]*@[\w-]+(\.[\w-]+)+$/" ;
	        //echo ($this -> checkString($input, $standard_F));
       		switch ($field) {
       			case '中文名字':
       				$name_len = mb_strlen($input);
       				// echo $name_len;
       				if(($this -> checkString($input, $standard_F)) == 0){
						return $field."含非法字元";
						
					}
					if (($name_len > 4) or ($name_len < 2 )){
						return  $field."請輸入2~4字元";
					}
       				return "success";
       				break;
       			case '身分證號碼':
       				$arrTWid = str_split($input);
       				// echo $arrTWid[1];
       				if($inputLen != 10){
						return "請輸入正確".$field;
					}else if(($this -> checkString($arrTWid[0], $standard_C)) == 0){
						return $field."含非法字元";
					}else if(!(($arrTWid[1] == "1") or ($arrTWid[1] == "2"))){
						return $field."含非法字元2";
					}
					for ( $i=2 ; $i<10 ; $i++ ) {
						if(($this -> checkString($arrTWid[$i], $standard_A))==0){
							return  $field."含非法字元3";
						}
					}
					return "success";
       				break;
       			case '住家電話':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '手機':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '公司聯絡電話':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '戶籍地址':
					$name_len = mb_strlen($input);
       				if($name_len > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '通訊地址':
					$name_len = mb_strlen($input);
       				if($name_len > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '緊急聯絡人中文名子':
       				$name_len = mb_strlen($input);
       				if(($this -> checkString($input, $standard_F)) == 0){
						return $field."含非法字元";
						
					}else if (($name_len > 4) or ($name_len < 2 )){
						return $field."請輸入2~4字元";
					}
       				return "success";
					break;
				case '緊急聯絡人電話':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '緊急聯絡人手機':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '緊急聯絡人關係':
       				if($inputLen > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '緊急聯絡人備註':
       				if($inputLen > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '就學期間':
       				if($inputLen > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '學制':
       				if($inputLen > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '學校':
       				if($inputLen > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '科系':
       				if($inputLen > 20){
						return $field."含非法字元";
					}
					return "success";
					break;
				case '密碼':
       				if(($this -> checkString($input, $standard_E)) == 0){
						return $field."含非法字元";
					}else if($inputLen < 8){
						return $field."至少8位元";
					}
					return "success";
					break;
       			default:
       				return "success";
       				break;
       		}
       	
       }

		public function checkRegister(){

			$_POST=json_decode($_POST['data'],true);
		
			$_SESSION['checkDepartment'] = $this -> check('部門',$_POST['staff_department']);
			$_SESSION['checkPosition'] = $this -> check('職位',$_POST['staff_position']);
			$_SESSION['checkName'] = $this -> check('中文名字',$_POST['staff_name']);
			$_SESSION['checkPassword'] = $this -> check("密碼",$_POST['staff_password']);
			$_SESSION['checkBirthday'] = $this -> check('生日',$_POST['staff_birthday']);
			$_SESSION['checkGender'] = $this -> check('性別',$_POST['staff_gender']);
			$_SESSION['checkMarriage'] = $this -> check('婚姻狀況',$_POST['staff_marriage']);
			$_SESSION['checkTWid'] = $this-> check('身分證號碼',$_POST['staff_TWid']);

			$_SESSION['checkContactCompanyNumber'] = $this -> check("公司聯絡電話",$_POST['contact_companyNumber']);
			$_SESSION['checkContactPhoneNumber'] = $this -> check("手機",$_POST['contact_phoneNumber']);
			$_SESSION['checkContactHomeNumber'] = $this -> check("住家電話",$_POST['contact_homeNumber']);
			$_SESSION['checkContactHomeAddress'] = $this -> check("戶籍地址",$_POST['contact_homeAddress']);
			$_SESSION['checkContactContactAddress'] = $this -> check("通訊地址",$_POST['contact_contactAddress']);

			$_SESSION['checkInsuredCompany'] = $this -> check("投保公司",$_POST['seniority_insuredCompany']);
			$_SESSION['checkWorkStatue'] = $this -> check("在職狀態",$_POST['seniority_workStatue']);
			$_SESSION['checkStaffType'] = $this -> check("員工類型",$_POST['seniority_staffType']);
			$_SESSION['checkEndDate'] = $this -> check("到職日期",$_POST['seniority_endDate']);
			$_SESSION['checkLeaveDate'] = $this -> check("離職日期",$_POST['seniority_leaveDate']);

			$_SESSION['checkContactPersonName'] = $this -> check("緊急聯絡人姓名",$_POST['contactPerson_name']);
			$_SESSION['checkContactPersonHomeNumber'] = $this -> check("緊急聯絡人電話",$_POST['contactPerson_homeNumber']);
			$_SESSION['checkContactPersonPhone'] = $this -> check("緊急聯絡人手機",$_POST['contactPerson_phone']);
			$_SESSION['checkContactPersonRelation'] = $this -> check("緊急聯絡人關係",$_POST['contactPerson_relation']);
			$_SESSION['checkContactPersonMore'] = $this -> check("緊急聯絡人備註",$_POST['contactPerson_more']);

			$_SESSION['checkEducationTime'] = $this -> check("就學期間",$_POST['education_time']);
			$_SESSION['checkEducationType'] = $this -> check("學制",$_POST['education_type']);
			$_SESSION['checkEducationSchool'] = $this -> check("學校",$_POST['education_school']);
			$_SESSION['checkEducationDepartment'] = $this -> check("科系",$_POST['education_department']);
			
			$check = array(
				'checkDepartment'=>$_SESSION['checkDepartment'],
				'checkPosition'=>$_SESSION['checkPosition'],
				'checkName'=> $_SESSION['checkName'],
				'checkPassword' => $_SESSION['checkPassword'],
				'checkTWid' => $_SESSION['checkTWid'],
				'checkGender' => $_SESSION['checkGender'],
				'checkMarriage' => $_SESSION['checkMarriage'],
				'checkBirthday' => $_SESSION['checkBirthday'],
				'checkContactHomeNumber' => $_SESSION['checkContactHomeNumber'],
				'checkContactHomeNumber' => $_SESSION['checkContactHomeNumber'],
				'checkContactPhoneNumber' => $_SESSION['checkContactPhoneNumber'],
				'checkContactCompanyNumber' => $_SESSION['checkContactCompanyNumber'],
				'checkContactHomeAddress' => $_SESSION['checkContactHomeAddress'],
				'checkContactContactAddress' => $_SESSION['checkContactContactAddress'],
				'checkInsuredCompany' => $_SESSION['checkInsuredCompany'],
				'checkWorkStatue' => $_SESSION['checkWorkStatue'],
				'checkStaffType' => $_SESSION['checkStaffType'],
				'checkEndDate' => $_SESSION['checkEndDate'],
				'checkLeaveDate' => $_SESSION['checkLeaveDate'],
				'checkContactPersonName' => $_SESSION['checkContactPersonName'],
				'checkContactPersonHomeNumber' => $_SESSION['checkContactPersonHomeNumber'],
				'checkContactPersonPhone' => $_SESSION['checkContactPersonPhone'],
				'checkContactPersonRelation' => $_SESSION['checkContactPersonRelation'],
				'checkContactPersonMore' => $_SESSION['checkContactPersonMore'],
				'checkEducationTime' => $_SESSION['checkEducationTime'],
				'checkEducationType' => $_SESSION['checkEducationType'],		
				'checkEducationSchool' => $_SESSION['checkEducationSchool'],
				'checkEducationDepartment' => $_SESSION['checkEducationDepartment']
			);
			$_SESSION['checkArr'] = $check;
			return $check;
		}

		function finalCheck(){
			$ack = array(
				'statue' => true,
				'content' => '確認新增此帳號'	
			);
			foreach($_SESSION['checkArr'] as $ch){
				// echo $ch;
				if($ch != 'success'){

					if($ack['statue']){
						$ack['content'] = $ch;
						$ack['statue'] = false;
					}else{
						$ack['content'] =  $ack['content']." ".$ch;
					}
					
					
				}
			}

			return $ack;
			
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
   									s."staff_id" as id
					from staff.staff as s,staff_information.department as d,staff_information.position as x
					where s."staff_position" = x."position_id" and s."staff_department" = d."department_id"
					ORDER BY position DESC;';
			$statement = $conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		}
		function allInfo(){
			global $conn;
			$_POST=json_decode($_POST['data'],true);

			$sql =' SELECT 
					from staff.staff 
					where "staff_id" = :staffId;';
			$statement = $conn->prepare($sql);
			$sth->bindParam(':staffId',$_POST['staff_id']);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		}
	}
?>