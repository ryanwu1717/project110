<?php
	Class User{
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
			$sql ="SELECT * FROM staff.staff WHERE staff_id = :staff_id and staff_password = :staff_password and staff_delete=false;";
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':staff_id',$loginStaffId);
		   	$sth->bindParam(':staff_password',$loginPassword);
			$sth->execute();
			$row = $sth->fetchAll();
			if(count($row)==1){
				$_SESSION['id']=$loginStaffId;
				$ack = array(
					'status' => 'success', 
				);
			}else{
				$ack = array(
					'status' => 'failed'
				);
			}
			return $ack;
		} 

		function getName(){ 
			$staff_id = $_SESSION['id'];
			$sql ="SELECT staff_name FROM staff.staff WHERE staff_id = :staff_id;";
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		} 
		function changePassword(){
			$_POST=json_decode($_POST['data'],true);
			if($_POST['inputPasswordNew']!=$_POST['inputPasswordNewCheck']){
				$ack = array(
					'status' => 'failed',
					'input' => 'inputPasswordNewCheck',
					'message' => '密碼不一致'
				);	
			}else{
				$staff = new Staff($this->conn);
				if($staff -> check("密碼",$_POST['inputPasswordNew'])!='success'){
					$ack = array(
						'status' => 'failed',
						'input' => 'inputPasswordNew',
						'message' => '密碼格式不符'
					);	
				}else{
					$sql ="SELECT * FROM staff.staff WHERE staff_id = :staff_id and staff_password = :staff_password and staff_delete=false;";
					$sth = $this->conn->prepare($sql);
				   	$sth->bindParam(':staff_id',$_SESSION['id']);
				   	$sth->bindParam(':staff_password',$_POST['inputPasswordOrg']);
					$sth->execute();
					$row = $sth->fetchAll();
					if(count($row)!=1){
						$ack = array(
							'status' => 'failed',
							'input' => 'inputPasswordOrg',
							'message' => '原密碼錯誤'
						);	
					}else{
						$sql ="UPDATE staff.staff SET staff_password = :staff_password WHERE staff_id = :staff_id;";
						$sth = $this->conn->prepare($sql);
					   	$sth->bindParam(':staff_id',$_SESSION['id']);
					   	$sth->bindParam(':staff_password',$_POST['inputPasswordNew']);
						$sth->execute();
						$ack = array(
							'status' => 'success'
						);		
					}
				}
			}
			return $ack;
		}
	}

	Class Staff{
		var $result;   
		var $conn;
		function __construct($db){
			$this->conn = $db;
		}
		function getDepartment()
		{  	
			$sql ='SELECT * from staff_information.department ORDER BY department_id;';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		}

		function getPosition()
		{ 			 	
			$sql ='SELECT * from staff_information.position ORDER BY position_id;';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		} 

		function getGender()
		{ 
			$sql ='SELECT * from staff_information.gender;';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		} 

		function getMarriage()
		{ 
			$sql ='SELECT * from staff_information.marriage;';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		} 

		function getInsuredcompany()
		{ 	 	
			$sql ='SELECT * from staff_salary.insuredcompany;';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		} 

		function getWorkStatus()
		{  	
			$sql ='SELECT * from staff_salary."workStatus";';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		} 

		function getStaffType()
		{ 	 	
			$sql ='SELECT * from staff_salary."staffType";';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		} 

		function getEducationCondition()
		{ 	
			$sql ='SELECT * from staff_education.condition;';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();			
			return $row;
		} 

		function getStaffNum()
		{
			$sql ='SELECT COUNT (*) as num FROM staff.staff;';	
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchColumn(0);			
			return $row;
		}

        function paddingLeft($str,$strLenght){
            $len = strlen($str);
            if($len >= $strLenght)
              return $str;
            else
              return $this->paddingLeft("0".$str,$strLenght);
        }
        function staffId($staff_department,$staff_position)
        {   
            $dp = $staff_department.$staff_position.'%';         
            $sql ='SELECT COUNT (*) as num FROM staff.staff WHERE staff_id LIKE :dp;';    
            $statement = $this->conn->prepare($sql);
            $statement->bindParam(':dp',$dp);
            $statement->execute();
            $row = $statement->fetchColumn(0);
            $row += 1;
            $row = (string)$row;
            $newId = $this->paddingLeft($row,4);
            $newId = $staff_department.$staff_position.$newId;
            // echo $newId;    
            return $newId;
        }

       	function checkString($strings, $standard){
       		// echo "inCheck";
           if(preg_match($standard, $strings, $hereArray)) {
            	return 1;
           } else {
           		return 0;
           }
       	}

       public function check($field,$input){
       		if(empty($input)&&$field!='離職日期'){
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
	        $standard_E = "/^(?=.*\d)(?=.*[a-zA-Z]).{8,30}$/";
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
						return $field."不符合格式";
						
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
						return $field."不符合格式";
					}else if(!(($arrTWid[1] == "1") or ($arrTWid[1] == "2"))){
						return $field."不符合格式";
					}
					for ( $i=2 ; $i<10 ; $i++ ) {
						if(($this -> checkString($arrTWid[$i], $standard_A))==0){
							return  $field."不符合格式";
						}
					}
					return "success";
       				break;
       			case '住家電話':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '手機':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '公司聯絡電話':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '戶籍地址':
					$name_len = mb_strlen($input);
       				if($name_len > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '通訊地址':
					$name_len = mb_strlen($input);
       				if($name_len > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '緊急聯絡人中文名子':
       				$name_len = mb_strlen($input);
       				if(($this -> checkString($input, $standard_F)) == 0){
						return $field."不符合格式";
						
					}
					// else if (($name_len > 4) or ($name_len < 2 )){
					// 	return $field."請輸入2~4個字";
					// }
       				return "success";
					break;
				case '緊急聯絡人電話':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '緊急聯絡人手機':
       				if($this -> checkString($input, $standard_A) == 0){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '緊急聯絡人關係':
       				if($inputLen > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '緊急聯絡人備註':
       				if($inputLen > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '就學期間':
       				if($inputLen > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '學制':
       				if($inputLen > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '學校':
       				if($inputLen > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '科系':
       				if($inputLen > 20){
						return $field."不符合格式";
					}
					return "success";
					break;
				case '密碼':
       				if(($this -> checkString($input, $standard_E)) == 0){
						return $field."至少8個英數混合";
					}else if($inputLen < 8){
						return $field."至少8個英數混合";
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

			$check = array();
			$check['checkDepartment'] = $this -> check('部門',$_POST['buttonDepartment']);
			$check['checkPosition'] = $this -> check('職位',$_POST['buttonPosition']);
			$check['checkName'] = $this -> check('中文名字',$_POST['staffName']);
			$check['checkPassword'] = $this -> check("密碼",$_POST['password']);
			$check['checkBirthday'] = $this -> check('生日',$_POST['staffBirthday']);
			$check['checkGender'] = $this -> check('性別',$_POST['buttonGender']);
			$check['checkMarriage'] = $this -> check('婚姻狀況',$_POST['buttonMarriage']);
			$check['checkTWid'] = $this-> check('身分證號碼',$_POST['TWid']);

			$check['checkContactCompanyNumber'] = $this -> check("公司聯絡電話",$_POST['homeNumber']);
			$check['checkContactPhoneNumber'] = $this -> check("手機",$_POST['phoneNumber']);
			$check['checkContactHomeNumber'] = $this -> check("住家電話",$_POST['companyNumber']);
			$check['checkContactHomeAddress'] = $this -> check("戶籍地址",$_POST['homeAddress']);
			$check['checkContactContactAddress'] = $this -> check("通訊地址",$_POST['contactAddress']);

			$check['checkInsuredCompany'] = $this -> check("投保公司",$_POST['buttonInsuredCompany']);
			$check['checkWorkStatus'] = $this -> check("在職狀態",$_POST['buttonWorkstatus']);
			$check['checkStaffType'] = $this -> check("員工類型",$_POST['buttonStafftype']);
			$check['checkEndDate'] = $this -> check("到職日期",$_POST['endDate']);
			$check['checkLeaveDate'] = $this -> check("離職日期",$_POST['leaveDate']);

			$check['checkContactPersonName'] = $this -> check("緊急聯絡人姓名",$_POST['contactPersonName']);
			$check['checkContactPersonHomeNumber'] = $this -> check("緊急聯絡人電話",$_POST['contactPersonHomeNumber']);
			$check['checkContactPersonPhone'] = $this -> check("緊急聯絡人手機",$_POST['contactPersonPhone']);
			$check['checkContactPersonRelation'] = $this -> check("緊急聯絡人關係",$_POST['contactPersonRelation']);
			$check['checkContactPersonMore'] = $this -> check("緊急聯絡人備註",$_POST['contactPersonMore']);

			$check['checkEducationTime'] = $this -> check("就學期間",$_POST['educationTime']);
			$check['checkEducationType'] = $this -> check("學制",$_POST['educationType']);
			$check['checkEducationSchool'] = $this -> check("學校",$_POST['schoolName']);
			$check['checkEducationDepartment'] = $this -> check("科系",$_POST['schoolDepartment']);
			if(empty($_POST['staff_id']))
				$ack = array(
					'status' => true,
					'content' => '確認新增此帳號'	
				);
			else
				$ack = array(
					'status' => true,
					'content' => '確認修改此帳號'	
				);
			foreach($check as $ch){
				// echo $ch;
				if($ch != 'success'){

					if($ack['status']){
						$ack['content'] = $ch;
						$ack['status'] = false;
					}else{
						$ack['content'] =  $ack['content']." ".$ch;
					}
				}
			}
			return $ack;	
		}

		function register(){
			try{
				$sql = 'INSERT INTO staff.staff("staff_id","staff_department","staff_position","staff_name",
													  "staff_birthday","staff_gender","staff_marriage","staff_TWid",
													  "contact_homeNumber","contact_phoneNumber","contact_companyNumber",
													  "contact_homeAddress","contact_contactAddress",
													  "seniority_insuredCompany","seniority_workStatus","seniority_staffType",
													  "seniority_endDate","seniority_leaveDate",
													  "contactPerson_name","contactPerson_homeNumber","contactPerson_phone",
													  "contactPerson_relation","contactPerson_more",
													  "education_time","education_type","education_school",
													  "education_department","education_status","staff_password"
													 )  
							VALUES (:staff_id, :staff_department, :staff_position, :staff_name,
							 		:staff_birthday, :staff_gender, :staff_marriage, :staff_TWid,
							 		:contact_homeNumber, :contact_phoneNumber, :contact_companyNumber,
							 		:contact_homeAddress, :contact_contactAddress,
							 		:seniority_insuredCompany, :seniority_workStatus, :seniority_staffType,
							 		:seniority_endDate, :seniority_leaveDate,
							 		:contactPerson_name, :contactPerson_homeNumber, :contactPerson_phone,
							 		:contactPerson_relation, :contactPerson_more,
							 		:education_time, :education_type, :education_school,
							 		:education_department, :education_status, :staff_password
							 		) ';
				$sth = $this->conn->prepare($sql);

				//var_dump($_POST);
		   		//require_once('dbconnect.php');//引入資料庫連結設定檔
		   		$_POST=json_decode($_POST['data'],true);
		   		//var_dump($_POST);
		   		$staff_id = $this->staffId($_POST['buttonDepartment'],$_POST['buttonPosition']);
				$sth->bindParam(':staff_id',$staff_id);
				$sth->bindParam(':staff_department',$_POST['buttonDepartment']);
				$sth->bindParam(':staff_position',$_POST['buttonPosition']);
				$sth->bindParam(':staff_name',$_POST['staffName']);
				$sth->bindParam(':staff_birthday',$_POST['staffBirthday']);
				$sth->bindParam(':staff_gender',$_POST['buttonGender']);
				$sth->bindParam(':staff_marriage',$_POST['buttonMarriage']);
				$sth->bindParam(':staff_TWid',$_POST['TWid']);
				$sth->bindParam(':staff_password',$_POST['password']);


				$sth->bindParam(':contact_homeNumber',$_POST['homeNumber']);
				$sth->bindParam(':contact_phoneNumber',$_POST['phoneNumber']);
				$sth->bindParam(':contact_companyNumber',$_POST['companyNumber']);
				$sth->bindParam(':contact_homeAddress',$_POST['homeAddress']);
				$sth->bindParam(':contact_contactAddress',$_POST['contactAddress']);

				$sth->bindParam(':seniority_insuredCompany',$_POST['buttonInsuredCompany']);
				$sth->bindParam(':seniority_workStatus',$_POST['buttonWorkstatus']);
				$sth->bindParam(':seniority_staffType',$_POST['buttonStafftype']);
				$sth->bindParam(':seniority_endDate',$_POST['endDate']);
				$sth->bindParam(':seniority_leaveDate',$_POST['leaveDate']==''?null:$_POST['leaveDate']);

				$sth->bindParam(':contactPerson_name',$_POST['contactPersonName']);
				$sth->bindParam(':contactPerson_homeNumber',$_POST['contactPersonHomeNumber']);
				$sth->bindParam(':contactPerson_phone',$_POST['contactPersonPhone']);
				$sth->bindParam(':contactPerson_relation',$_POST['contactPersonRelation']);
				$sth->bindParam(':contactPerson_more',$_POST['contactPersonMore']);

				$sth->bindParam(':education_time',$_POST['educationTime']);
				$sth->bindParam(':education_type',$_POST['educationType']);
				$sth->bindParam(':education_school',$_POST['schoolName']);
				$sth->bindParam(':education_department',$_POST['schoolDepartment']);
				$sth->bindParam(':education_status',$_POST['buttonEducationCondition']);

				$sth->execute();
				$ack = array(
					'status' => 'success', 
					'staff_id' => $staff_id
				);
			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed', 
				);
			}
			return $ack;
		}
		function modify(){
			try{
				$sql = 'UPDATE staff.staff
							SET staff_department = :staff_department, staff_position = :staff_position, staff_name = :staff_name,
								 staff_birthday=:staff_birthday, staff_gender = :staff_gender, staff_marriage = :staff_marriage,
								 "staff_TWid" = :staff_TWid,
								 "contact_homeNumber" = :contact_homeNumber, "contact_phoneNumber" = :contact_phoneNumber,
								 "contact_companyNumber" = :contact_companyNumber, "contact_homeAddress" = :contact_homeAddress,
								 "contact_contactAddress" = :contact_contactAddress,
								 "seniority_insuredCompany"= :seniority_insuredCompany, "seniority_workStatus"= :seniority_workStatus,
								 "seniority_staffType"= :seniority_staffType, "seniority_endDate"= :seniority_endDate, 
								 "seniority_leaveDate" = :seniority_leaveDate,
								 "contactPerson_name" = :contactPerson_name, "contactPerson_homeNumber" = :contactPerson_homeNumber,
								 "contactPerson_phone" = :contactPerson_phone, "contactPerson_relation" = :contactPerson_relation,
								 "contactPerson_more" = :contactPerson_more,
								 education_time = :education_time, education_type = :education_type,
								 education_school = :education_school, education_department = :education_department,
								 education_status = :education_status, staff_password = :staff_password
							WHERE "staff_id" = :staff_id;';
				$sth = $this->conn->prepare($sql);

				//var_dump($_POST);
		   		//require_once('dbconnect.php');//引入資料庫連結設定檔
		   		$_POST=json_decode($_POST['data'],true);
		   		//var_dump($_POST);

				$sth->bindParam(':staff_id',$_POST['staff_id']);
				$sth->bindParam(':staff_department',$_POST['buttonDepartment']);
				$sth->bindParam(':staff_position',$_POST['buttonPosition']);
				$sth->bindParam(':staff_name',$_POST['staffName']);
				$sth->bindParam(':staff_birthday',$_POST['staffBirthday']);
				$sth->bindParam(':staff_gender',$_POST['buttonGender']);
				$sth->bindParam(':staff_marriage',$_POST['buttonMarriage']);
				$sth->bindParam(':staff_TWid',$_POST['TWid']);
				$sth->bindParam(':staff_password',$_POST['password']);


				$sth->bindParam(':contact_homeNumber',$_POST['homeNumber']);
				$sth->bindParam(':contact_phoneNumber',$_POST['phoneNumber']);
				$sth->bindParam(':contact_companyNumber',$_POST['companyNumber']);
				$sth->bindParam(':contact_homeAddress',$_POST['homeAddress']);
				$sth->bindParam(':contact_contactAddress',$_POST['contactAddress']);

				$sth->bindParam(':seniority_insuredCompany',$_POST['buttonInsuredCompany']);
				$sth->bindParam(':seniority_workStatus',$_POST['buttonWorkstatus']);
				$sth->bindParam(':seniority_staffType',$_POST['buttonStafftype']);
				$sth->bindParam(':seniority_endDate',$_POST['endDate']);
				$sth->bindParam(':seniority_leaveDate',$_POST['leaveDate']);

				$sth->bindParam(':contactPerson_name',$_POST['contactPersonName']);
				$sth->bindParam(':contactPerson_homeNumber',$_POST['contactPersonHomeNumber']);
				$sth->bindParam(':contactPerson_phone',$_POST['contactPersonPhone']);
				$sth->bindParam(':contactPerson_relation',$_POST['contactPersonRelation']);
				$sth->bindParam(':contactPerson_more',$_POST['contactPersonMore']);

				$sth->bindParam(':education_time',$_POST['educationTime']);
				$sth->bindParam(':education_type',$_POST['educationType']);
				$sth->bindParam(':education_school',$_POST['schoolName']);
				$sth->bindParam(':education_department',$_POST['schoolDepartment']);
				$sth->bindParam(':education_status',$_POST['buttonEducationCondition']);


				$sth->execute();
				$ack = array(
					'status' => 'success', 
				);
			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed', 
					'message'=>$e
				);
			}
			return $ack;
		}
	}

	Class Table{
		var $result; 
		var $conn;
		function __construct($db){
			$this->conn = $db;
		}
		function getTable(){
			$sql =' SELECT DISTINCT s."staff_name" as name ,x."position_name" as position,
   									d."department_name" as department,s."contact_phoneNumber" as phonenumber,
   									s."seniority_endDate" as enddate,s."seniority_staffType" as stafftype,
   									s."staff_id" as id
					from staff.staff as s,staff_information.department as d,staff_information.position as x
					where s."staff_position" = x."position_id" and s."staff_department" = d."department_id" and s."staff_delete"=false
					ORDER BY position DESC;';
			$statement = $this->conn->prepare($sql);
			$statement->execute();
			$row = $statement->fetchAll();
			
			return $row;
		}
		function allInfo($staff_id){
			$sql ='SELECT staff_id, department.department_name as staff_department, staff_name, staff_birthday, "staff_TWid", "contact_homeNumber", "contact_phoneNumber", "contact_companyNumber", "contact_homeAddress", "contact_contactAddress", "seniority_endDate", "seniority_leaveDate", "contactPerson_name", "contactPerson_homeNumber", "contactPerson_phone", "contactPerson_relation", "contactPerson_more", education_time, education_type, education_school, education_department, staff_delete, gender.type as staff_gender, marriage.type as staff_marriage, insuredcompany."companyName" as "seniority_insuredCompany","workStatus"."status" as "seniority_workStatus", "staffType"."type" as "seniority_staffType",condition.type as education_status,position.position_name as staff_position
				FROM staff.staff as s
				LEFT JOIN staff_information.department on s.staff_department=staff_information.department.department_id
				LEFT JOIN staff_information.position on s.staff_position=staff_information.position.position_id
				LEFT JOIN staff_information.gender on s.staff_gender=staff_information.gender.id
				LEFT JOIN staff_information.marriage on s.staff_marriage=staff_information.marriage.id
				LEFT JOIN staff_education.condition on s.education_status=staff_education.condition.id
				LEFT JOIN staff_salary.insuredcompany on s."seniority_insuredCompany"=staff_salary.insuredcompany."companyId"
				LEFT JOIN staff_salary."staffType" on s."seniority_staffType"=staff_salary."staffType"."id"
				LEFT JOIN staff_salary."workStatus" on s."seniority_workStatus"=staff_salary."workStatus"."id"
				WHERE "staff_id" = :staff_id;';
			$statement = $this->conn->prepare($sql);
			$statement->bindParam(':staff_id',$staff_id);
			$statement->execute();
			$row = $statement->fetchAll();
			return $row;
		}
		function getProfile($staff_id){
			$profile = $this->allInfo($staff_id);
			if(count($profile)==1){
				$data = array();
				foreach ($profile[0] as $key => $value) {
					if($key=='staff_department') $data['部門']=$value;
					else if($key=='staff_id') $data['職員編號']=$value;
					else if($key=='staff_position') $data['職位']=$value;
					else if($key=='staff_name') $data['中文名字']=$value;
					else if($key=='staff_password') $data['密碼']=$value;
					else if($key=='staff_birthday') $data['生日']=$value;
					else if($key=='staff_gender') $data['性別']=$value;
					else if($key=='staff_marriage') $data['婚姻狀況']=$value;
					else if($key=='staff_TWid') $data['身分證號碼']=$value;
					else if($key=='contact_companyNumber') $data['公司聯絡電話']=$value;

					else if($key=='contact_phoneNumber') $data['手機']=$value;
					else if($key=='contact_homeNumber') $data['住家電話']=$value;
					else if($key=='contact_homeAddress') $data['戶籍地址']=$value;
					else if($key=='contact_contactAddress') $data['通訊地址']=$value;

					else if($key=='seniority_insuredCompany') $data['投保公司']=$value;
					else if($key=='seniority_workStatus') $data['在職狀態']=$value;
					else if($key=='seniority_staffType') $data['員工類型']=$value;
					else if($key=='seniority_endDate') $data['到職日期']=$value;
					else if($key=='seniority_leaveDate') $data['離職日期']=$value;

					else if($key=='contactPerson_name') $data['緊急聯絡人姓名']=$value;
					else if($key=='contactPerson_homeNumber') $data['緊急聯絡人電話']=$value;
					else if($key=='contactPerson_phone') $data['緊急聯絡人手機']=$value;
					else if($key=='contactPerson_relation') $data['緊急聯絡人關係']=$value;
					else if($key=='contactPerson_more') $data['緊急聯絡人備註']=$value;

					else if($key=='education_time') $data['就學期間']=$value;
					else if($key=='education_type') $data['學制']=$value;
					else if($key=='education_school') $data['學校']=$value;
					else if($key=='education_department') $data['科系']=$value;
				}
				$ack = array(
					'status'=>'successs',
					'data'=>$data
				);
			}else{
				$ack = array(
					'status'=>'failed'
				);
			}
			return $ack;
		}
	}
	Class Chat{
		var $conn;
		function __construct($db){
			$this->conn = $db;
		}
		function getChatroomTitle($chatID){
			$sql = 'SELECT "chatName" FROM staff_chat."chatHistory" LEFT JOIN staff_chat."chatroomInfo" on "chatroomInfo"."chatID" = "chatHistory"."chatID" WHERE "chatroomInfo"."chatID"=:chatID and "UID" = :UID';
			$sth = $this->conn->prepare($sql);
			$UID =$_SESSION['id'];
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}
		function getChatroom(){
			$sql = 'SELECT "receiverList"."chatID","chatToWhom",to_char("LastTime",\'MM-DD\')as "LastTime","content","chatName","staff_name","LastTime" as "LastTime1","CountUnread"
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
												where "chatHistory"."UID"=:UID and "chatContent"."UID" != :UID) as "countUnread"
											group by "chatID","UID") as "countUnread" on "receiverList"."chatID"="countUnread"."chatID"
								order by "LastTime1" desc;';
			$sth = $this->conn->prepare($sql);
			$UID =$_SESSION['id'];
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}
		function getMember($chatID){
			$sql = 'SELECT staff_name as name,"UID" as id FROM staff_chat."chatHistory" left join "staff"."staff" on staff.staff_id="chatHistory"."UID" WHERE "chatID"= :chatID;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();

			return $row;
		}
		function getChatContent($chatID){
			$sql = 'SELECT content, to_char( "sentTime",\'MM-DD HH24:MI:SS\' )as "sentTime", "UID",(CASE "UID" WHEN :UID THEN \'me\' ELSE \'other\' END)
					as "diff",staff_name FROM staff_chat."chatContent" left join "staff"."staff" on staff.staff_id="chatContent"."UID" WHERE "chatID"= :chatID order by "sentTime" asc;';
			$sth = $this->conn->prepare($sql);
			$UID =$_SESSION['id'];
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();

			$body = array('chatID'=>$chatID);
			$this->updateLastReadTime($body);

			return $row;
		}
		function updateMessage($body){
			$sql = 'INSERT INTO staff_chat."chatContent"(	content, "UID", "sentTime", "chatID")
					VALUES ( :Msg , :UID , NOW(), :chatID );';
			$sth = $this->conn->prepare($sql);
			$UID =$_SESSION['id'];
			$chatID=$body['chatID'];
			$Msg=$body['Msg'];
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->bindParam(':Msg',$Msg,PDO::PARAM_INT);
			$sth->execute();
			
			$ack = array(
				'status'=>'success'
			);
			return $ack;
		}
		function updateLastReadTime($body){
			$sql = 'UPDATE staff_chat."chatHistory" SET "time"= NOW() WHERE "chatHistory"."chatID"= :chatID AND "chatHistory"."UID"= :UID ;';
			$sth = $this->conn->prepare($sql);
			$UID =$_SESSION['id'];
			$chatID=$body['chatID'];
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();
			
			$ack = array(
				'status'=>'success'
			);
			return $ack;
		}
		function createChatroom($body){
			$body=json_decode($body['data'],true);
			$sql = 'INSERT INTO staff_chat."chatroomInfo"( "chatName") VALUES (:chatName);';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':chatName',$body['title'],PDO::PARAM_STR);
			$sth->execute();
			
			$chatID=$this->conn->lastInsertId();
			array_push(
				$body['member'], array('UID'=>$_SESSION['id'])
			);
			foreach ($body['member'] as $key => $value) {
				$sql = 'INSERT INTO staff_chat."chatHistory"("chatID", "time", "UID") VALUES (:chatID, NOW(), :UID);';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$value['UID'],PDO::PARAM_STR);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
				$sth->execute();
			}

			$ack = array(
				'status'=>'success'
			);
			return $ack;

		}
		function updateChatroom($body){
			$body=json_decode($body['data'],true);
			$chatID=$body['chatID'];
			$sql = 'UPDATE staff_chat."chatroomInfo" SET "chatName"=:chatName WHERE "chatID"=:chatID;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':chatName',$body['title'],PDO::PARAM_STR);
			$sth->bindParam(':chatID',$body['chatID'],PDO::PARAM_INT);
			$sth->execute();

			foreach ($body['member'] as $key => $value) {
				$sql = 'INSERT INTO staff_chat."chatHistory"("chatID", "time", "UID") VALUES (:chatID, NOW(), :UID);';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$value['UID'],PDO::PARAM_STR);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
				$sth->execute();
			}

			$ack = array(
				'status'=>'success'
			);
			return $ack;
		}
		function deleteChatroom($body){
			$body=json_decode($body['data'],true);
			$chatID=$body['chatID'];
			$sql = 'DELETE FROM staff_chat."chatHistory" WHERE "chatID"=:chatID and "UID" = :staff_id;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':staff_id',$_SESSION['id'],PDO::PARAM_STR);
			$sth->bindParam(':chatID',$body['chatID'],PDO::PARAM_INT);
			$sth->execute();

			$ack = array(
				'status'=>'success'
			);
			return $ack;
		}

		function getList($chatID=null){
			if(is_null($chatID)){
				$sql ="SELECT staff_name as name,staff_id as id FROM staff.staff WHERE staff_id != :staff_id;";
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':staff_id',$_SESSION['id'],PDO::PARAM_STR);
				$sth->execute();
				$row = $sth->fetchAll();	
			}else{
				$sql = 'SELECT staff_name as name,staff_id as id FROM staff.staff LEFT JOIN staff_chat."chatHistory" on staff_chat."chatHistory"."UID" = staff.staff.staff_id and "chatID"=:chatID WHERE "chatID" is null and staff_id != :staff_id;';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':staff_id',$_SESSION['id'],PDO::PARAM_STR);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
				$sth->execute();
				$row = $sth->fetchAll();	
			}
			return $row;
		}
	}
?>