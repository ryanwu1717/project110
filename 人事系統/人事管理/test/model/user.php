<?php
use Slim\Http\UploadedFile;
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
			$sql ="SELECT * FROM staff.staff WHERE staff_id = :staff_id and staff_password = :staff_password and staff_delete=false and \"seniority_workStatus\" =1;";
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



// $app->group('/notification',function () use ($app){
// 	$app->post('/tag', function (Request $request, Response $response, array $args) {
// 	    $notification = new Notification($this->db);
// 	    $result = $notification->tag();
// 	    $response = $response->withHeader('Content-type', 'application/json' );
// 		$response = $response->withJson($result);
// 	    return $response;

// 	});
// });
// $app->get('/name/{id}}', function (Request $request, Response $response, array $args) {
	//     $staff = new Staff($this->db);
	//     $result = $staff->getDepartment();
	//     $response = $response->withHeader('Content-type', 'application/json' );
	// 	$response = $response->withJson($result);
	//     return $response;
	// });

	Class Staff{
		var $result;
		var $conn;
		function __construct($db){
			$this->conn = $db;
		}

		// function getStaffName($id,$type){
		// 	if($type == 'department'){
		// 		$sql ='SELECT staff_name,staff_id
		// 			FROM staff.staff
		// 			WHERE staff_department = :staff_department;';	
		// 		$statement = $this->conn->prepare($sql);
		// 		$statement->bindParam(':staff_department',$id);
		// 	}else if($type == 'departmentMember'){
		// 		$sql ='SELECT staff_name,staff_id
		// 			FROM staff.staff
		// 			WHERE staff_department = :staff_department;';	
		// 		$statement = $this->conn->prepare($sql);
		// 		$statement->bindParam(':staff_department',$id);
		// 	}else{
		// 		$sql ='SELECT staff_name
		// 			FROM staff.staff
		// 			WHERE staff_id = :staff_id;';	
		// 		$statement = $this->conn->prepare($sql);
		// 		$statement->bindParam(':staff_id',$id);
		// 	}
			
		// 	$statement->execute();
		// 	$row = $statement->fetchAll();			
		// 	return $row;
		// }

		function getStaffName($id,$type,$chatID = null){
			if(is_null($chatID)){
				if($type == 'department'){
					$sql ='SELECT staff_name,staff_id
						FROM staff.staff
						WHERE staff_department = :staff_department;';	
					$statement = $this->conn->prepare($sql);
					$statement->bindParam(':staff_department',$id);
				}else{
					$sql ='SELECT staff_name
						FROM staff.staff
						WHERE staff_id = :staff_id;';	
					$statement = $this->conn->prepare($sql);
					$statement->bindParam(':staff_id',$id);
				}
			}else{
				$sql ='SELECT "staff".staff_id AS id ,"staff".staff_name AS name
						FROM staff.staff AS staff
						WHERE staff_department = :id 
							AND staff.staff_id 
								IN(SELECT "UID" as staff_id 
									FROM staff_chat."chatHistory" 
									left join "staff"."staff" 
										on staff.staff_id="chatHistory"."UID" 
									WHERE "chatID"= :chatID and staff_delete=false and "seniority_workStatus" =1
									);
						';	
				$statement = $this->conn->prepare($sql);
				$statement->bindParam(':id',$id);
				$statement->bindParam(':chatID',$chatID);
			}
			
			

			$statement->execute();
			$row = $statement->fetchAll();
			return $row;
		}

		function getDepartment($id)
		{  	
			if($id == 'get'){
				$sql ='SELECT * from staff_information.department ORDER BY department_id;';	
				$statement = $this->conn->prepare($sql);
				$statement->execute();
				$row = $statement->fetchAll();	
			}else{
				$sql ='SELECT department_name from staff_information.department WHERE department_id = :id;';	
				$statement = $this->conn->prepare($sql);
				$statement->bindParam(':id',$id);
				$statement->execute();
				$row = $statement->fetchAll();	
			}
					

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
       		if(empty($input)){
       			return $field."不得為空";
       		}
       		$inputLen = strlen($input);

       		//A. 檢查是不是數字
	        $standard_A = "/^([0-9]+)$/";
       		//A. 檢查是不是分機符號
	        $standard_A_1 = "/^([0-9]+)*(#([0-9]+))?$/";
       		//A. 檢查是不是就學期間
	        $standard_A_2 = "/^([0-9]{2,3}-[0-9]{2,3})$/";
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
       				if($this -> checkString($input, $standard_A_1) == 0){
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
       				if($this -> checkString($input, $standard_A_2) == 0){
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

			$check['checkContactCompanyNumber'] = $this -> check("公司聯絡電話",$_POST['companyNumber']);
			$check['checkContactPhoneNumber'] = $this -> check("手機",$_POST['phoneNumber']);
			$check['checkContactHomeNumber'] = $this -> check("住家電話",$_POST['homeNumber']);
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
				if($_POST['leaveDate']==''){
					$sth->bindValue(':seniority_leaveDate',null,PDO::PARAM_INT);
				}else{
					$sth->bindParam(':seniority_leaveDate',$_POST['leaveDate']);
				}

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
		function tmpmodify(){
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
                if($_POST['buttonDepartment']==''){
                    $sth->bindValue(':staff_department',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':staff_department',$_POST['buttonDepartment']);
                }
                if($_POST['buttonPosition']==''){
                    $sth->bindValue(':staff_position',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':staff_position',$_POST['buttonPosition']);
                }
                if($_POST['staffName']==''){
                    $sth->bindValue(':staff_name',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':staff_name',$_POST['staffName']);
                }
                if($_POST['staffBirthday']==''){
                    $sth->bindValue(':staff_birthday',null,PDO::PARAM_INT);
                }else{
                    $sth->bindParam(':staff_birthday',$_POST['staffBirthday']);
                }
                if($_POST['buttonGender']==''){
                    $sth->bindValue(':staff_gender',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':staff_gender',$_POST['buttonGender']);
                }
                if($_POST['buttonMarriage']==''){
                    $sth->bindValue(':staff_marriage',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':staff_marriage',$_POST['buttonMarriage']);
                }
                if($_POST['TWid']==''){
                    $sth->bindValue(':staff_TWid',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':staff_TWid',$_POST['TWid']);
                }
                if($_POST['password']==''){
                    $sth->bindValue(':staff_password',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':staff_password',$_POST['password']);
                }

                if($_POST['homeNumber']==''){
                    $sth->bindValue(':contact_homeNumber',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contact_homeNumber',$_POST['homeNumber']);
                }
                if($_POST['phoneNumber']==''){
                    $sth->bindValue(':contact_phoneNumber',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contact_phoneNumber',$_POST['phoneNumber']);
                }
                if($_POST['companyNumber']==''){
                    $sth->bindValue(':contact_companyNumber',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contact_companyNumber',$_POST['companyNumber']);
                }
                if($_POST['homeAddress']==''){
                    $sth->bindValue(':contact_homeAddress',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contact_homeAddress',$_POST['homeAddress']);
                }
                if($_POST['contactAddress']==''){
                    $sth->bindValue(':contact_contactAddress',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contact_contactAddress',$_POST['contactAddress']);
                }

                if($_POST['buttonInsuredCompany']==''){
                    $sth->bindValue(':seniority_insuredCompany',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':seniority_insuredCompany',$_POST['buttonInsuredCompany']);
                }
                if($_POST['buttonWorkstatus']==''){
                    $sth->bindValue(':seniority_workStatus',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':seniority_workStatus',$_POST['buttonWorkstatus']);
                }
                if($_POST['buttonStafftype']==''){
                    $sth->bindValue(':seniority_staffType',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':seniority_staffType',$_POST['buttonStafftype']);
                }
                if($_POST['endDate']==''){
                    $sth->bindValue(':seniority_endDate',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':seniority_endDate',$_POST['endDate']);
                }
                if($_POST['leaveDate']==''){
                    $sth->bindValue(':seniority_leaveDate',null,PDO::PARAM_INT);
                }else{
                    $sth->bindParam(':seniority_leaveDate',$_POST['leaveDate']);
                }

                if($_POST['contactPersonName']==''){
                    $sth->bindValue(':contactPerson_name',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contactPerson_name',$_POST['contactPersonName']);
                }
                if($_POST['contactPersonHomeNumber']==''){
                    $sth->bindValue(':contactPerson_homeNumber',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contactPerson_homeNumber',$_POST['contactPersonHomeNumber']);
                }
                if($_POST['contactPersonPhone']==''){
                    $sth->bindValue(':contactPerson_phone',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contactPerson_phone',$_POST['contactPersonPhone']);
                }
                if($_POST['contactPersonRelation']==''){
                    $sth->bindValue(':contactPerson_relation',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contactPerson_relation',$_POST['contactPersonRelation']);
                }
                if($_POST['contactPersonMore']==''){
                    $sth->bindValue(':contactPerson_more',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':contactPerson_more',$_POST['contactPersonMore']);
                }

                if($_POST['educationTime']==''){
                    $sth->bindValue(':education_time',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':education_time',$_POST['educationTime']);
                }
                if($_POST['educationType']==''){
                    $sth->bindValue(':education_type',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':education_type',$_POST['educationType']);
                }
                if($_POST['schoolName']==''){
                    $sth->bindValue(':education_school',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':education_school',$_POST['schoolName']);
                }
                if($_POST['schoolDepartment']==''){
                    $sth->bindValue(':education_department',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':education_department',$_POST['schoolDepartment']);
                }
                if($_POST['buttonEducationCondition']==''){
                    $sth->bindValue(':education_status',null,PDO::PARAM_STR);
                }else{
                    $sth->bindParam(':education_status',$_POST['buttonEducationCondition']);
                }

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
			// echo $row.staff_department;
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
		var $change = false;
		var $firstCheck = false;
		function __construct($db){
			$this->conn = $db;
			session_write_close();
		}

		function getStar($type = null){
			if(is_null($type)){
				$sql = 'SELECT star.id, star."UID", star."chatID", star."sentTime" AS "fullsendTime", star."detail",to_char( star."sentTime",\'MON DD , HH24:MI\' )as "sentTime",chatroomInfo."chatName"
					FROM staff.star as star
					LEFT JOIN ( SELECT *
								FROM staff_chat."chatroomInfo") AS chatroomInfo on chatroomInfo."chatID" = star."chatID"
					WHERE "UID"= :UID
					order by "fullsendTime"desc;';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			}else if($type == 'num'){
				$sql = 'SELECT count(id)
						FROM staff.star
						WHERE "UID" = :UID;';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			}else{
				$sql = 'SELECT "sentTime",id
						FROM staff.star
						WHERE "UID" = :UID AND "chatID" = :chatID;';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
				$sth->bindParam(':chatID',$type,PDO::PARAM_STR);
			}
			
			$sth->execute();	
			$row = $sth->fetchAll();
			// $ack = array(
			// 	'status'=>'success',
			// );
			return $row;
		}

		function deleteStar(){
			$_POST=json_decode($_POST['data'],true);

			$sql = 'DELETE FROM staff.star
					WHERE "UID" =:UID  AND "chatID"=:chatID AND "sentTime"=:sentTime;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			$sth->bindParam(':chatID',$_POST['chatID'],PDO::PARAM_INT);
			$sth->bindParam(':sentTime',$_POST['time'],PDO::PARAM_STR);
			$sth->execute();	
			// $row = $sth->fetchAll();
			$ack = array(
				'status'=>'success',
			);
			return $ack;
		}

		function addStar(){
			$_POST=json_decode($_POST['data'],true);
			if(is_null($_POST['starPerson'])){
				$sql = 'INSERT INTO staff.star(
					"UID", "chatID", "sentTime", detail)
					VALUES (:UID, :chatID, :sentTime, :detail)';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			}else {
				$sql = 'INSERT INTO staff.star(
					"UID", "chatID", "sentTime", detail)
					VALUES (:UID, :chatID, :sentTime, :detail)';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_POST['starPerson'],PDO::PARAM_STR);
			}
			
			$sth->bindParam(':chatID',$_POST['chatID'],PDO::PARAM_INT);
			$sth->bindParam(':sentTime',$_POST['time'],PDO::PARAM_STR);
			$sth->bindParam(':detail',$_POST['content'],PDO::PARAM_STR);
			$sth->execute();	
			// $row = $sth->fetchAll();
			$ack = array(
				'status'=>'successs',
			);
			return $ack;
		}


		function readNotification($id){
			$sql = 'UPDATE staff.notification
					SET unread=false
					WHERE id=:id;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':id',$id,PDO::PARAM_STR);
			$sth->execute();
			// $row = $sth->fetchAll();
			$ack = array(
				'status'=>'successs',
			);
			return $ack;
		}

		function getNotificationNum(){
			$sql = 'SELECT COUNT (id)
					FROM staff.notification
					WHERE unread = true AND "UID"=:UID ;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}

		function getNotification(){
			$sql = 'SELECT notification.detail, notification.unread, to_char( notification."sendtime",\'MON DD , HH24:MI\' )as "sendtime", notification.sendtime AS "fullsendTime",notification.type, chatroomInfo."chatName",chatroomInfo."chatID",notification.id
					FROM staff.notification AS notification
				LEFT JOIN ( SELECT *
				FROM staff_chat."chatroomInfo") AS chatroomInfo
				on chatroomInfo."chatID" = CAST(notification."tagChatRoom" AS INT)
					WHERE "UID"= :UID
					order by "fullsendTime"desc;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}

		function tag(){
			$_POST=json_decode($_POST['data'],true);

			$sql ="SELECT staff_name FROM staff.staff WHERE staff_id = :staff_id;";
			$sth = $this->conn->prepare($sql);
		   	$sth->bindParam(':staff_id',$_SESSION['id'],PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetchColumn(0);
			var_dump($row);
			$tmpName = '你被 '.$row.' 標註在一則訊息';
			// var_dump($_POST);
			try{
				$sql = 'INSERT INTO staff.notification("UID","detail", sendtime, unread, "tagChatRoom","type")VALUES (:UID,:message,:tmpFullTime,\'true\',:chatID,\'tag\');';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_POST['id'],PDO::PARAM_STR);
				$sth->bindParam(':message',$tmpName,PDO::PARAM_STR);
				$sth->bindParam(':tmpFullTime',$_POST['tmpTime'],PDO::PARAM_STR);
				$sth->bindParam(':chatID',$_POST['chatID'],PDO::PARAM_INT);
				// $sth->bindParam(':msgID',$_POST['msgID'],PDO::PARAM_STR);
				$sth->execute();
				// $row = $sth->fetchAll();
				$ack = array(
					'status'=>'success'

				);
			}catch(PDOException $e){
				$ack = array(
					'status' => 'failed',
					'message'=>$e
				);
			}

			return $ack;

		}

		function init(){
			$class = $this->getClass();
			$chatroom = $this->getChatroom();
			$notification = $this->getNotificationNum();
			$starNum = $this->getStar('num');
			$star=array(
				'num'=>$starNum,
				'info'=>'',
				'chatID'=>'-1'
			);
			// unset($chatroom[0]);
			// $chat = $this->getChat();
			$ack = array(
				'status'=>'success',
				'notification'=>$notification,
				'star'=>$star,
				'class'=>$class,
				'chatroom'=>$chatroom,
				'chat'=>array(),
				'readCount'=>array(),
				'like'=>array(),
				'result'=>array(
					'class'=>array(),
					'chatroom'=>array(),
					'chat'=>array(
						'chatID'=>0,
						'comchatID'=>0,
						'count'=>-1,
						'new'=>array()
					),
					'like'=>array(
						'new'=>array(),
						'change'=>array()
					),
					'readCount'=>array(
						'new'=>array(),
						'delete'=>array(),
						'change'=>array()
					)
				)
			);
			return $ack;
		}
		function routine($timestamp,$chatID){
			$sleepRoutine = 1000000;
			$data = $_SESSION['last'][$timestamp];
			$start = new DateTime( 'NOW' );
			$now = new DateTime( 'NOW' );
			while($now->getTimestamp() - $start->getTimestamp()<45 && !$this->change){

				if($this->firstCheck){
					usleep($sleepRoutine);
					$sleepRoutine+=1000000;
					if($sleepRoutine>5000000){
						$sleepRoutine=5000000;
					}
					$data = $_SESSION['last'][$timestamp];
				}
				$this->firstCheck=true;
				$like = $this->getLike($chatID);
				$class = $this->getClass();
				$notification = $this->getNotificationNum();
				$starNum = $this->getStar('num');
				$star = $this->getStar($chatID);
				$newstar=array(
					'num'=>$starNum,
					'info'=>$star,
					'chatID'=>$chatID
				);
				// unset($class[0]);
				// $new = $class[0];
				// $new['id'] = 3;
				// array_push($class,$new);
				// $class[0]['id']=14;
				$result = array();
				$result['notification'] = $this->checkNotification($data['notification'], $notification);
				$result['star'] = $this->checkStar($data['star'], $newstar,$chatID);
				$result['class'] = $this->checkClass($data['class'], $class);
				$chatroom = $this->getChatroom();
				// unset($chatroom[0]);
				// $new = $chatroom[0];
				// $chatroom[0]['chatID'] = 99;
				// $chatroom[0]['classId'] = null;
				// array_push($chatroom,$new);
				// $chat = $this->getChat();
				// var_dump($chat);
				$result['chatroom'] = $this->checkChatroom($data['chatroom'], $chatroom);
				$chat = $this->getChat($chatID);

				$result['chat'] = $this->checkChat($data,$chat,$chatID);
				$readCount = $this->getReadCountN(array('data'=>json_encode(array("chatID"=>$chatID))));
				$result['readCount'] = $this->checkReadCount($data['readCount'],$readCount);
				$now = new DateTime( 'NOW' );
				
				
				$result['like']= $this->checkLike($data['like'],$like);

			}

			$ack=array(
				'status'=>'success',
				'notification'=>$notification,
				'star'=>$newstar,
				'class'=>$class,
				'chatroom'=>$chatroom,
				'chat'=>$chat,
				'readCount'=>$readCount,
				'like'=>$like,
				'result'=>$result
			);
			return $ack;
		}
		var $classState = array(
			'unchange'=>0,
			'delete'=>1,
			'new'=>2,
			'changeName'=>3,
			'changeNum'=>4
		);
		function checkNotification($old,$new){
			// var_dump($old[0][count]);
			// var_dump($new[0][count]);
			$out = array();
			$out['change'] = array();
			if($old[0][0] != $new[0][0]){
				$this->change=true;
				$out['change'] = $new[0][0];
			}
			return $out;
		}
		function checkClass($a, $b) {
		    $map = $out = array();
		    $out['delete'] = $out['new'] = $out['change'] =  $out['changeNum'] =array();
		    foreach($a as $val) {$map[$val['id']]['type'] = $this->classState['delete']; $map[$val['id']]['data'] = $val;}
		    foreach($b as $val) {

		    	// var_dump($map[$val['id']]['data']['sum'],$val['sum'])
		    	if(isset($map[$val['id']])) {	

		    		if($map[$val['id']]['data']['name']!=$val['name']) {
		    			$map[$val['id']]['type'] = $this->classState['changeName'];
		    			$map[$val['id']]['data'] = $val;
		    			$this->change=true;
		    		} else if ($map[$val['id']]['data']['sum']!=$val['sum']){
		    			// var_dump(val['sum']);
		    			$map[$val['id']]['type'] = $this->classState['changeNum'];
		    			$map[$val['id']]['data'] = $val;
		    			$this->change=true;

		    		}else {
		    			$map[$val['id']]['type'] = $this->classState['unchange'];
		    			$map[$val['id']]['data'] = $val;
		    		}
	    		}else {
	    			$map[$val['id']]['type'] = $this->classState['new'];
	    			$map[$val['id']]['data'] = $val;
	    			$this->change=true;
		    	}
			}
		    foreach($map as $val => $ok) if($ok['type']==1) {$out['delete'][] = $ok['data']; $this->change=true;} else if($ok['type']==2) $out['new'][] = $ok['data']; else if($ok['type']==3) $out['change'][] = $ok['data'];else if($ok['type']==4) $out['changeNum'][] = $ok['data'];
		    return $out;
		}
		var $readCountState = array(
			'unchange'=>0,
			'delete'=>1,
			'new'=>2,
			'changeName'=>3
		);
		function checkReadCount($a, $b) {
		    $map = $out = array();
		    $out['delete'] = $out['new'] = $out['change'] = array();
		    foreach($a as $val) {$map[$val['sentTime']]['type'] = $this->readCountState['delete']; $map[$val['sentTime']]['data'] = $val;}
		    foreach($b as $val) {
		    	if(isset($map[$val['sentTime']])) {
		    		if($map[$val['sentTime']]['data']['sum']!=$val['sum']) {
		    			$map[$val['sentTime']]['type'] = $this->readCountState['changeName'];
		    			$map[$val['sentTime']]['data'] = $val;
		    			$this->change=true;
		    		} else {
		    			$map[$val['sentTime']]['type'] = $this->readCountState['unchange'];
		    			$map[$val['sentTime']]['data'] = $val;
		    		}
	    		}else {
	    			$map[$val['sentTime']]['type'] = $this->readCountState['new'];
	    			$map[$val['sentTime']]['data'] = $val;
	    			$this->change=true;
		    	}
			}
		    foreach($map as $val => $ok) if($ok['type']==1) {$out['delete'][] = $ok['data']; $this->change=true;} else if($ok['type']==2) $out['new'][] = $ok['data']; else if($ok['type']==3) $out['change'][] = $ok['data'];
		    return $out;
		}
		var $likeCountState = array(
			'unchange'=>0,
			'new'=>1,
			'changed'=>2
		);
		function checkLike($a, $b) {
		    $map = $out = array();
		    $out['new'] = $out['change'] = array();
		    foreach($a as $val) {$map[$val['sentTime']]['data'] = $val;}
		    foreach($b as $val) {
		    	if(isset($map[$val['sentTime']])) {
		    		if($map[$val['sentTime']]['data']['likeCount']!=$val['likeCount']) {
		    			$map[$val['sentTime']]['type'] = $this->likeCountState['changed'];
		    			$map[$val['sentTime']]['data'] = $val;
		    			$this->change=true;
		    		} else {
		    			$map[$val['sentTime']]['type'] = $this->likeCountState['unchange'];
		    			$map[$val['sentTime']]['data'] = $val;
		    		}
	    		}else {
	    			$map[$val['sentTime']]['type'] = $this->likeCountState['new'];
	    			$map[$val['sentTime']]['data'] = $val;
	    			$this->change=true;
		    	}
			}
		    foreach($map as $val => $ok) if($ok['type']==1) $out['new'][] = $ok['data']; else if($ok['type']==2) $out['change'][] = $ok['data'];
		    return $out;
		}





		function getReadCountN($body){
			$data = json_decode($body['data'],true);
			$UID =$_SESSION['id'];
			$sql = '
				SELECT "sentTime" as "sentTime",SUM(count(*)) OVER (ORDER BY "sentTime" DESC)
					FROM(
					SELECT "chatHistory"."UID", MAX("chatContent"."sentTime") AS "sentTime"
					FROM staff_chat."chatHistory"
					LEFT JOIN staff_chat."chatContent" ON "chatHistory"."time" > "chatContent"."sentTime" AND "chatContent"."chatID" = :chatID
					WHERE "chatHistory"."chatID" = :chatID AND "chatHistory"."UID" != :UID
					GROUP BY "chatHistory"."UID"
				)AS A
				WHERE "sentTime" IS NOT NULL
				GROUP BY "sentTime"
				ORDER BY "sentTime" ASC;
			';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$data['chatID'],PDO::PARAM_INT);
			$sth->execute();

			$row = $sth->fetchAll();
			return $row;
		}
		var $chatroomState = array(
			'unchange'=>0,
			'delete'=>1,
			'new'=>2,
			'changeName'=>3
		);

		function checkChatroom($a, $b) {
		    $map = $out = array();
		    $out['delete'] = $out['new'] = $out['change'] = array();
		    foreach($a as $val) {$map[$val['chatID']]['type'] = 1; $map[$val['chatID']]['data'] = $val;}
		    foreach($b as $val) {
		    	if(isset($map[$val['chatID']])) {
		    		if($map[$val['chatID']]['data']['chatName']!=$val['chatName'] || $map[$val['chatID']]['data']['classID']!=$val['classID'] || $map[$val['chatID']]['data']['countContent']!=$val['countContent'] || $map[$val['chatID']]['data']['CountUnread']!=$val['CountUnread']) {
		    			$map[$val['chatID']]['type'] = 3;
		    			$map[$val['chatID']]['data'] = $val;
		    			$this->change=true;
		    		} else {
		    			$map[$val['chatID']]['type'] = 0;
		    			$map[$val['chatID']]['data'] = $val;
		    		}
	    		}else {
	    			$map[$val['chatID']]['type'] = 2;
	    			$map[$val['chatID']]['data'] = $val;
	    			$this->change=true;
		    	}
			}
		    foreach($map as $val => $ok) if($ok['type']==1) {$out['delete'][] = $ok['data']; $this->change=true;} else if($ok['type']==2) $out['new'][] = $ok['data']; else if($ok['type']==3) $out['change'][] = $ok['data'];
		    return $out;
		}
		function checkStar($old,$new,$chatID){
			// var_dump($old[0][count]);
			// var_dump($new[0][count]);
			$map = $out = array();
			
			// var_dump($old);
			// var_dump($new);
			// var_dump($old['chatID']);
			// var_dump($chatID);
			$out['delete'] = $out['new'] = $out['change'] = array();
			if($old['num'][0]['count'] != $new['num'][0]['count']){
				$this->change=true;
				$out['change']['num'] = $new['num'][0]['count'];
			}

			if($chatID == $old['chatID']){
				// var_dump($old['chatID']);
				foreach($old['info'] as $val) {
					$map[$val['id']]['type'] = 1; 
					$map[$val['id']]['data'] = $val;
				}
				
				foreach($new['info'] as $val) {
		    		if(isset($map[$val['id']])) {
		    		
			    		$map[$val['id']]['type'] = 0;
			    		$map[$val['id']]['data'] = $val;
			    	}else {
	    				$map[$val['id']]['type'] = 2;
		    			$map[$val['id']]['data'] = $val;
		    			$this->change=true;
			    	}
		    		
	    		}
	    		// var_dump($map);
		    	// $this->change=true;
				foreach($map as $val => $ok) if($ok['type']==1) {$out['delete'][] = $ok['data']; $this->change=true;} else if($ok['type']==2) $out['new'][] = $ok['data'];


			}else{
				// var_dump('inin');
				$out['new'] = $new['info'];
    			$this->change=true;
			}

			
			return $out;
		}
		function checkChat($data, $chat,$chatID){
			$new = array();
			if($chatID==$data['result']['chat']['chatID']){
				if(count($chat)-count($data['chat'])!=0){
					for($i=count($chat)-1;$i>=0;$i-=1){
						array_push($new,$chat[$i]);
					}
	    			$this->change=true;
				}
			}else{
				$new = $chat;
    			$this->change=true;
			}
			$result = array(
				'chatID'=>$chatID,
				'comchatID'=>$chatID==$data['result']['chat']['chatID'],
				'count'=>(count($chat)-count($data['chat'])),
				'new'=>$new
			);
			return $result;
		}
		function getLike($chatID){
			if(isset($chatID)){
				$sql='
					SELECT "sentTime", "chatContent"."likeID", "likeCount"
					FROM staff_chat."chatContent"
					left join(
						SELECT "likeID", Count("UID")as "likeCount"
						FROM staff_chat."chatLikeCount"
						group by "likeID")as "likeCount"
					on "chatContent"."likeID"="likeCount"."likeID"
					where "chatID"= :chatID AND "chatContent"."likeID" is not null;
				';
				$statement = $this->conn->prepare($sql);
				$statement->bindParam(':chatID',$chatID);
				$statement->execute();
				$row = $statement->fetchAll();
				return $row;
			}
		}
		function getClass($classID = null)
		{
			$staff_id = $_SESSION['id'];
			if(is_null($classID)){
				$sql ='
					SELECT  id, name ,sum("sum") as sum
					FROM(
						SELECT  id, name ,0 as sum
						FROM staff_chat."chatClass"
						WHERE "UID" = :id
						union(
							SELECT  
								(case WHEN  "allclass".id IS NULL  then 0 ELSE "allclass".id END) AS id,
								(case WHEN  "allclass".name IS NULL  then \'未命名議題\' ELSE "allclass".name END)AS name,
								SUM("tmpClassify"."CountUnread")
							FROM (
								SELECT "countUnread"."chatID","countUnread"."UID",COUNT("countUnread"."c")as "CountUnread","cClassify"."classID"
								FROM(
									SELECT "chatHistory"."chatID",  "chatHistory"."UID",(case when "time"<"sentTime" then \'1\' else null end) as "c"
									FROM staff_chat."chatHistory"
									join staff_chat."chatContent" on "chatHistory"."chatID"="chatContent"."chatID"
									where "chatHistory"."UID"=:id and "chatContent"."UID" != :id
								) as "countUnread"
								LEFT JOIN (
									SELECT "chatClassify"."classID" as "classID", "chatClassify"."chatID", "chatClassify"."UID"
									FROM staff_chat."chatClassify"
									where "chatClassify"."UID"=:id
								)as "cClassify" on "cClassify"."chatID" = "countUnread"."chatID"
								group by "countUnread"."chatID","countUnread"."UID","cClassify"."classID"
							)as "tmpClassify"
							LEFT JOIN(
								SELECT  name,id
								FROM staff_chat."chatClass"
								WHERE "UID" = :id
							)as "allclass" on "allclass".id = "tmpClassify"."classID"
							GROUP BY "allclass".id,"allclass".name
						)ORDER BY  name
					)AS A 
					GROUP BY id,name
					ORDER BY  name
				';
				$statement = $this->conn->prepare($sql);
			}else{
				$sql ='
					SELECT  name
					FROM staff_chat."chatClass"
					WHERE "UID" = :id and id=:classID
					ORDER BY name
				';
				$statement = $this->conn->prepare($sql);
				$statement->bindParam(':classID',$classID);
			}
			$statement->bindParam(':id',$staff_id);
			$statement->execute();
			$row = $statement->fetchAll();
			return $row;
		}

		function getChatroom(){
		   $sql = '

		    SELECT "chatResult"."chatID","receiver"."staff_name","chatResult"."chatName",cl.id AS"classID",cl.name AS "className","countContent","outerContent"."UID","outerContent"."sentTime" AS "LastTime1",to_char("sentTime",\'MM-DD\')as "LastTime","outerContent"."content","CountUnread",CASE WHEN "CountUnread" > 0 then \'1\'ELSE\'0\' END AS "Priority"
		    FROM (
				SELECT "chatHistory"."chatID","chatClassify"."classID","chatHistory"."time","chatroomInfo"."chatName"
				FROM "staff_chat"."chatHistory"
				LEFT JOIN "staff_chat"."chatClassify" ON "chatClassify"."chatID" = "chatHistory"."chatID"
				LEFT JOIN "staff_chat"."chatroomInfo" ON "chatHistory"."chatID" = "chatroomInfo"."chatID"
				WHERE "chatHistory"."UID" = :UID
		    )AS "chatResult"
		    LEFT JOIN (SELECT "chatID",count(*) AS "countContent" FROM "staff_chat"."chatContent" GROUP BY "chatID") AS "countChatroom" ON "countChatroom"."chatID" = "chatResult"."chatID"
		    LEFT JOIN "staff_chat"."chatContent" AS "outerContent" ON "outerContent"."chatID" = "chatResult"."chatID" AND "outerContent"."sentTime" = (SELECT MAX("sentTime") FROM "staff_chat"."chatContent" AS "innerContent" WHERE "innerContent"."chatID"="chatResult"."chatID")
		    LEFT JOIN (
		     SELECT "cH3"."chatID","UID" AS "chatToWhom","staff_name"
		     FROM(
		      SELECT "couUID","chatID","time"
		      FROM(
		       SELECT "chatID" AS "cID", COUNT("UID")AS "couUID"
		       FROM staff_chat."chatHistory"
		       group by "chatID"
		      ) AS "cUID"
		      LEFT JOIN staff_chat."chatHistory" AS "cH2" on "cUID"."cID"="cH2"."chatID" AND "cH2"."UID"= :UID AND "couUID"=2
		     )AS "check"
		     LEFT join staff_chat."chatHistory" AS "cH3" on "check"."chatID"="cH3"."chatID"
		     LEFT JOIN staff.staff ON "UID" = "staff_id"
		     where "UID"!= :UID
		    )AS "receiver" on "chatResult"."chatID"="receiver"."chatID"
		    LEFT JOIN (
		     SELECT *
		     FROM staff_chat."chatClass"
		     LEFT JOIN staff_chat."chatClassify"
		     ON "chatClass".id="chatClassify" ."classID"
		     WHERE "chatClassify"."UID"=:UID
		    ) as cl on cl."chatID"="chatResult" ."chatID"
		    LEFT JOIN (
				SELECT "chatID","UID",COUNT("c")as "CountUnread"
				FROM(
					SELECT "chatHistory"."chatID",  "chatHistory"."UID",(case when "time"<"sentTime" then \'1\' else null end) as "c"
					FROM staff_chat."chatHistory"
					join staff_chat."chatContent" on "chatHistory"."chatID"="chatContent"."chatID"
					where "chatHistory"."UID"=:UID and "chatContent"."UID" != :UID
				) as "countUnread"
				group by "chatID","UID"
			) as "countUnread" on "chatResult"."chatID"="countUnread"."chatID"
		    UNION
		    SELECT -1 AS "SUM",\'-1\' AS "SUM",\'-1\' AS "SUM",-1 AS "SUM",\'-1\' AS "SUM",SUM("countContent"), \'-1\' AS "SUM",\'1000-01-01 00:00:00\' AS "SUM", \'-1\' AS "SUM", \'-1\' AS "SUM",-1 AS "SUM",\'-1\' AS "SUM"
		    FROM (SELECT "staff_chat"."chatHistory"."chatID","countContent"
		    FROM "staff_chat"."chatHistory"
		    LEFT JOIN (SELECT "chatID",count(*) AS "countContent" FROM "staff_chat"."chatContent" GROUP BY "chatID") AS "countChatroom" ON "countChatroom"."chatID" = "staff_chat"."chatHistory"."chatID"
		    WHERE "UID" = :UID)AS "SELECT"
		    order by "classID","Priority" desc,"LastTime1"desc

		   ';
		   $sth = $this->conn->prepare($sql);
		   $sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
		   $sth->execute();
		   $row = $sth->fetchAll();
		   return $row;
		}
		function getChat($chatID){
			$sql = '
				SELECT "content",("sentTime")as "fullsentTime",to_char( "sentTime",\'MON DD HH24:MI:SS\' )as "sentTime","UID","diff","Read",staff_name,"likeID","count" as "LikeCount","liked","tmpChatContent"."starID"
				FROM (
					SELECT "chatContent"."content","chatContent"."sentTime","chatContent"."UID",(CASE "chatContent"."UID" WHEN :UID THEN \'me\' ELSE \'other\' END) as "diff",COALESCE("readCount",0) as "Read",staff_name,"CountLike"."likeID",case when "CountLike"."count" is null then 0 else "CountLike"."count" end,"CountLike"."liked",star."starID"
					FROM staff_chat."chatContent"
					LEFT JOIN (
						SELECT "content","sentTime","sentFrom",COUNT("UID") as "readCount"
						FROM (
								SELECT content, "sentTime", "UID" as "sentFrom","chatID"
								FROM staff_chat."chatContent"
								WHERE "chatID"= :chatID
							)as "display",(
								SELECT "chatID", "time", "UID"
								FROM staff_chat."chatHistory"
								Where "chatID"=:chatID
							) as "chatHistory"
						Where "UID"!=:UID and "display"."chatID"="chatHistory"."chatID" and "chatHistory"."time">"display"."sentTime"
						Group by "content","sentTime","sentFrom"
					) as "displayContent" on "chatContent"."content"="displayContent"."content" and "chatContent"."sentTime"="displayContent"."sentTime" and "chatContent"."UID"="displayContent"."sentFrom"
					LEFT JOIN(
						SELECT id as "starID","sentTime"
						FROM staff.star
						WHERE "UID"= :UID and "chatID" = :chatID
					)as star on star."sentTime" = "chatContent"."sentTime"
					LEFT JOIN staff."staff" on staff.staff_id="chatContent"."UID"
						LEFT JOIN(
							SELECT COUNT(*),"likeID",(CASE WHEN EXISTS (SELECT 1 FROM staff_chat."chatLikeCount" AS L WHERE L."UID" = :UID AND G."likeID" = L."likeID") THEN true ELSE false END) AS "liked"
							FROM staff_chat."chatLikeCount" as G
							GROUP BY "likeID"
						) as "CountLike" on "CountLike"."likeID" = "chatContent"."likeID"
					Where "chatID"=:chatID
					order by "chatContent"."sentTime" desc
				) as "tmpChatContent"
				order by "tmpChatContent"."sentTime" asc
			';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}
		function insertClass($classID,$chatID)
		{
			try{
				$sql ='DELETE
						FROM staff_chat."chatClassify"
						WHERE "chatID"=:chatID
								AND EXISTS(SELECT "chatID"
									FROM staff_chat."chatClassify"
									WHERE  "chatID"=:chatID AND "UID"=:UID);';
				$statement = $this->conn->prepare($sql);
				$statement->bindParam(':chatID',$chatID);
				$statement->bindParam(':UID',$_SESSION['id']);
				$statement->execute();

				$sql ='INSERT INTO staff_chat."chatClassify"("classID", "chatID","UID")
						VALUES (:id, :chatID, :UID);';
				$statement = $this->conn->prepare($sql);
				$statement->bindParam(':id',$classID);
				$statement->bindParam(':chatID',$chatID);
				$statement->bindParam(':UID',$_SESSION['id']);
				$statement->execute();
				$ack = array(
					'status'=>'success',
				);
			}catch(PDOException $e){
				$ack = array(
					'status'=>'failed',
				);
			}
			// try{
			// 	$sql ='INSERT INTO staff_chat."chatClassify"("classID", "chatID")
			// 			VALUES (:id, :chatID);';
			// 	$statement = $this->conn->prepare($sql);
			// 	$statement->bindParam(':id',$classId);
			// 	$statement->bindParam(':chatID',$chatID);
			// 	$statement->execute();
			// 	$ack = array(
			// 		'status'=>'success2',
			// 	);
			// 	return $ack;
			// }catch(PDOException $e){
			// 	$ack = array(
			// 		'status'=>'failed',
			// 	);
			// }
			return $ack;
		}
		function deleteClass($classID)
		{
			$staff_id = $_SESSION['id'];
			$sql ='DELETE FROM staff_chat."chatClass"
					WHERE id = :id ';
			$statement = $this->conn->prepare($sql);
			$statement->bindParam(':id',$classID);
			$statement->execute();
			$row = $statement->fetchAll();
			return $row;
		}
		function addClass(){
			$staff_id = $_SESSION['id'];
			$_POST=json_decode($_POST['data'],true);
			$sql ='INSERT INTO staff_chat."chatClass"("UID", name)VALUES (:id, :name);';
			$statement = $this->conn->prepare($sql);
			$statement->bindParam(':id',$staff_id);
			$statement->bindParam(':name',$_POST['name']);
			$statement->execute();
			$ack = array(
					'status'=>'success'
				);
			return $ack;
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

		function getMember($chatID){
			$sql = 'SELECT staff_name as name,"UID" as id FROM staff_chat."chatHistory" left join "staff"."staff" on staff.staff_id="chatHistory"."UID" WHERE "chatID"= :chatID and staff_delete=false and "seniority_workStatus" =1;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}
		function getMemberDepartment($chatID){
			$sql = 'SELECT "departmentName".department_id AS id ,"departmentName".department_name AS name 
					FROM staff.staff AS staff
						LEFT JOIN staff_information.department AS "departmentName"
							ON "departmentName".department_id=staff.staff_department
					WHERE staff.staff_id 
						IN(SELECT "UID" as staff_id FROM staff_chat."chatHistory" left join "staff"."staff" on staff.staff_id="chatHistory"."UID" 
							WHERE "chatID"= :chatID and staff_delete=false and "seniority_workStatus" =1)

					Group by(id);';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			return $row;
		}
		function getReadCount($body){
			$data = json_decode($body['data'],true);
			$UID =$_SESSION['id'];
			$sql = '
				SELECT "sentTime" as "sentTime",SUM(count(*)) OVER (ORDER BY "sentTime" DESC)
					FROM(
					SELECT "chatHistory"."UID", MAX("chatContent"."sentTime") AS "sentTime"
					FROM staff_chat."chatHistory"
					LEFT JOIN staff_chat."chatContent" ON "chatHistory"."time" > "chatContent"."sentTime" AND "chatContent"."chatID" = :chatID
					WHERE "chatHistory"."chatID" = :chatID AND "chatHistory"."UID" != :UID
					GROUP BY "chatHistory"."UID"
				)AS A
				WHERE "sentTime" IS NOT NULL
				GROUP BY "sentTime"
				ORDER BY "sentTime" ASC;
			';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$data['chatID'],PDO::PARAM_INT);
			$sth->execute();

			$row = $sth->fetchAll();
			array_push($row,array('chatID'=>$data['chatID']));
			return $row;
		}
		function checkLiked($body){
			$sql='SELECT "likeID"
			FROM staff_chat."chatContent"
			where "content"=:content and "sentTime"=:fullsentTime;';

			$sth = $this->conn->prepare($sql);
			$content=$body['content'];
			$fullsentTime=$body['fullsentTime'];
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			$sth->execute();

			$row = $sth->fetchAll();
			return $row;
		}
		function getReadList($body){
			$data = json_decode($body['data'],true);
			$sql = '
				SELECT "staff_name","staff_id","checkread"
				FROM(
					SELECT content, "chatHistory"."UID", "chatHistory"."chatID",case when "time" > "sentTime" then \'true\' else \'false\' end as "checkread"
					FROM staff_chat."chatContent" as "chatContent"
					join staff_chat."chatHistory" as "chatHistory" on "chatContent"."chatID"="chatHistory"."chatID"
					Where content=:whichTalk and "chatHistory"."chatID"=:chatID and "sentTime" = :sentTime
				)as "checkUnread"
				left join staff."staff" as "staff" on "staff"."staff_id"="checkUnread"."UID"
				where "staff_id"!=:UID and staff_delete=false and "seniority_workStatus" =1
				group by"staff_name","staff_id","checkread";
			';
			$sth = $this->conn->prepare($sql);
			$UID =$_SESSION['id'];
			$sth->bindParam(':sentTime',$data['sentTime'],PDO::PARAM_STR);
			$sth->bindParam(':whichTalk',$data['content'],PDO::PARAM_STR);
			$sth->bindParam(':chatID',$data['chatID'],PDO::PARAM_INT);
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->execute();

			$row = $sth->fetchAll();
			return $row;
		}
		function getCommentID($chatID,$sendtime){
			$sql ='
				SELECT id
				FROM staff_chat."commentInfo"
				WHERE "chatID" = :chatID AND "sentTIme"= :sentTIme
				;
			';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_STR);
			$sth->bindParam(':sentTIme',$sendtime,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			// var_dump($sql);
			if(count($row) == 0){
				$sql ='
					INSERT INTO staff_chat."commentInfo"("chatID", "sentTIme")
					VALUES (:chatID, :sentTIme);
				';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_STR);
				$sth->bindParam(':sentTIme',$sendtime,PDO::PARAM_INT);
				$sth->execute();
				return intval($this->conn->lastInsertId());
			}else{
				return ($row[0]['id']);
			}
			// return count($row);
		}
		function getComment($commentID){
			$data = json_decode($body['data'],true);
			$sql ='
				SELECT content, "UID", "commentChat"."sentTime",to_char( "commentChat"."sentTime",\'MON DD HH24:MI:SS\' )as "showSentTime" ,"readNum"."count" as "readNum","staffinfo".staff_name,CASE "UID" 
				  WHEN :UID THEN \'me\'
				  ELSE \'other\'
				  END
				FROM staff_chat."commentChat" as "commentChat"
				LEFT JOIN (SELECT staff_name,staff_id FROM staff.staff ) as "staffinfo"
				ON "staffinfo".staff_id = "commentChat"."UID"
				LEFT JOIN(
					SELECT "commentChat"."sentTime" ,COUNT(*)
					FROM staff_chat."commentHistory"  AS "commentHistory" 
					left join 
						(
							SELECT  "commentChat" .content,  "commentChat" ."UID", "commentChat" . "sentTime","commentChat"."commentID"
							FROM staff_chat."commentChat" 
						)
						as "commentChat" on "commentHistory"."commentID" = "commentChat"."commentID" AND "commentChat"."sentTime"<"commentHistory".lasttime 
					WHERE "commentChat"."commentID" = :commentID  AND "commentHistory"."UID" != "commentChat"."UID"
					GROUP BY "commentChat"."sentTime" 
				)as "readNum" on "readNum"."sentTime" = "commentChat"."sentTime"
				WHERE "commentID"= :commentID
				ORDER BY "sentTime" ASC;
			';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':commentID',$commentID,PDO::PARAM_STR);
			$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			$sth->execute();

			$row = $sth->fetchAll();
			return $row;
		}
		function getCommentReadList($commentID,$sentTime,$UID,$chatID){
			// $data = json_decode($body['data'],true);
			$sql = 'SELECT staff_name as name,"chatHistory"."UID" as id , 
					CASE WHEN "checkUnread"."UID" IS NULL 
				            THEN 0 
				            ELSE 1 
				    END AS haveRead
				FROM staff_chat."chatHistory" 
				left join "staff"."staff"
				on staff.staff_id="chatHistory"."UID"
				left join (
					SELECT "commentChat"."sentTime" ,"commentHistory"."UID" 
					FROM staff_chat."commentHistory"  AS "commentHistory" 
					left join 
						(
							SELECT  "commentChat" .content,  "commentChat" ."UID", "commentChat" . "sentTime","commentChat"."commentID"
							FROM staff_chat."commentChat" 
						)
						as "commentChat" on "commentHistory"."commentID" = "commentChat"."commentID" AND "commentChat"."sentTime"<"commentHistory".lasttime 
					WHERE "commentChat"."commentID" = :commentID 
						 AND "commentHistory"."UID" != :UID 
						 AND "commentChat"."sentTime" = :senttime
				) AS "checkUnread" on "checkUnread"."UID" =  "chatHistory"."UID"
				WHERE "chatID"= :chatID and staff_delete=false and "seniority_workStatus" =1 and "chatHistory"."UID" != :UID
				
			';
			$sth = $this->conn->prepare($sql);
			//$sth->bindParam(':t1',$data['sentTime']);
			$sth->bindParam(':commentID',$commentID,PDO::PARAM_STR);
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->bindParam(':senttime',$sentTime,PDO::PARAM_STR);
			$sth->bindParam(':chatID',$chatID,PDO::PARAM_STR);
			$sth->execute();

			$row = $sth->fetchAll();
			return $row;
		}

		function getChatContent($chatID,$body){
			$data = json_decode($body['data'],true);
			$UID =$_SESSION['id'];
			for ($i = 0, $timeout = 15; $i < $timeout; $i++ ) {

				$sql = '
					SELECT "content",("sentTime")as "fullsentTime",to_char( "sentTime",\'MON DD HH24:MI:SS\' )as "sentTime","UID","diff","Read",staff_name
					FROM (
						SELECT "chatContent"."content","chatContent"."sentTime","chatContent"."UID",(CASE "chatContent"."UID" WHEN :UID THEN \'me\' ELSE \'other\' END) as "diff",COALESCE("readCount",0) as "Read",staff_name
						FROM staff_chat."chatContent"
						LEFT JOIN (
							SELECT "content","sentTime","sentFrom",COUNT("UID") as "readCount"
							FROM (
									SELECT content, "sentTime", "UID" as "sentFrom","chatID"
									FROM staff_chat."chatContent"
									WHERE "chatID"= :chatID
								)as "display",(
									SELECT "chatID", "time", "UID"
									FROM staff_chat."chatHistory"
									Where "chatID"=:chatID
								) as "chatHistory" 
							Where "UID"!=:UID and "display"."chatID"="chatHistory"."chatID" and "chatHistory"."time">"display"."sentTime"
							Group by "content","sentTime","sentFrom" 
						) as "displayContent" on "chatContent"."content"="displayContent"."content" and "chatContent"."sentTime"="displayContent"."sentTime" and "chatContent"."UID"="displayContent"."sentFrom"
						LEFT JOIN staff."staff" on staff.staff_id="chatContent"."UID"
						Where "chatID"=:chatID
						order by "chatContent"."sentTime" desc 
						-- limit :limit 
					) as "tmpChatContent"
					order by "tmpChatContent"."sentTime" asc
				';
	            // $sql = 'SELECT content, to_char( "sentTime",\'MM-DD HH24:MI:SS\' )as "sentTime", "UID",(CASE "UID" WHEN :UID THEN \'me\' ELSE \'other\' END)
	            //         as "diff",staff_name 
	            //         FROM staff_chat."chatContent" 
	            //         left join "staff"."staff" on staff.staff_id="chatContent"."UID" 
	            //         WHERE "chatID"= :chatID 
	            //         order by "sentTime" asc;';

				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
				// $sth->bindParam(':limit',$data['limit'],PDO::PARAM_INT);
				$sth->execute();
				$row = $sth->fetchAll();
				var_dump($row);
				if(count($row)==$data['count']){
					usleep(3000000);
				}else{
					$result = array();
					for($j=$data['count'];$j<count($row);$j++){
						array_push($result,$row[$j]);
					}
					array_push($result,array('chatID'=>$chatID));
					// $body = array('chatID'=>$chatID);
					// $this->updateLastReadTime($body);
					return $result;
				}
			}

			// $result=($row==$data);
			// array_push($row, array('diff'=>$result));

			// $sth = $this->conn->prepare($sql);
			// $UID =$_SESSION['id'];
			// $sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			// $sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
			// $sth->bindParam(':limit',$data['limit'],PDO::PARAM_INT);
			// $sth->execute();

			// $row = $sth->fetchAll();
			// $body = array('chatID'=>$chatID);
			// $this->updateLastReadTime($body);
			$result = array();
			array_push($result,array('chatID'=>$chatID));
			return $result;
		}


		function updateMessage($body){
			try{
				$date = DateTime::createFromFormat('0.u00 U', microtime());
			  	$timezone = new DateTimeZone('Asia/Taipei');
			  	$date->setTimezone($timezone);
			  	$tmpFullTime = $date->format('Y-m-d H:i:s.u').'+08';
			  	// var_dump( $tmpFullTime);
				$sql = 'INSERT INTO staff_chat."chatContent"(	content, "UID", "sentTime", "chatID")
					VALUES ( :Msg , :UID , :fullTime, :chatID );';
				$sth = $this->conn->prepare($sql);
				$UID =$_SESSION['id'];
				$chatID=$body['chatID'];
				$Msg=$body['Msg'];
				$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
				$sth->bindParam(':fullTime',$tmpFullTime,PDO::PARAM_INT);
				$sth->bindParam(':Msg',$Msg,PDO::PARAM_INT);
				$sth->execute();
				// $insert_id = $this->conn->lastInsertId();

				$ack = array(
					'status'=>'success',
					// 'id'=>$insert_id,
					'time' => $tmpFullTime
				);
			}catch(PDOException $e){
                $ack = array(
                    'status' => 'failed', 
                    'message'=>$e
                );
            }
			
			return $ack;
		}
		function insertComment($commentID,$content){
			
			$sql = 'INSERT INTO staff_chat."commentChat"(content, "UID", "sentTime", "commentID")
					VALUES (:content, :UID, NOW(), :commentID);';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			$sth->bindParam(':content',$content,PDO::PARAM_STR);
			$sth->bindParam(':commentID',$commentID,PDO::PARAM_STR);
			$sth->execute();
			$ack = array(
				'status'=>'success' 
			);
			return $ack;
		}
		function updateComment($body){
			$sql = 'INSERT INTO staff_chat."chatComment"("chatID","chatOrigin","chatTime","content","sender","sentTime")
					VALUES (:CID,:UID,:CT,:Msg,:SID,NOW())';
			$sth = $this->conn->prepare($sql);
			$chatID=$body['chatID'];
			$origin=$body['chatOrigin'];
			$chattime=$body['chatTime'];
			$date = strtotime($chattime);
			$Msg=$body['Msg'];
			$SID =$_SESSION['id'];
			$sth->bindParam(':CID',$chatID);
			$sth->bindParam(':UID',$origin);
			$sth->bindParam(':CT',$chattime);
			$sth->bindParam(':Msg',$Msg);
			$sth->bindParam(':SID',$SID);
			$sth->execute();

			$ack = array(
				'content'=>$Msg,
				'time'=>date("Y-m-d H:i:s",$date)
			);
			return $ack;
		}
		function getLastOnLine($UID){
			$sql = 'SELECT CASE 
					WHEN (
							(
								(
									DATE_PART(\'day\', NOW()::timestamp - MAX("time")::timestamp) * 24 + DATE_PART(\'hour\', NOW()::timestamp - MAX("time")::timestamp)
								) * 60 + DATE_PART(\'minute\', NOW()::timestamp - MAX("time")::timestamp)
							)  > 60 
					) then	to_char(MAX("time"), \'YYYY/MM/DD HH12:MI:SS\')
					ELSE (
								(
									DATE_PART(\'day\', NOW()::timestamp - MAX("time")::timestamp) * 24 + DATE_PART(\'hour\', NOW()::timestamp - MAX("time")::timestamp)
								) * 60 + DATE_PART(\'minute\', NOW()::timestamp - MAX("time")::timestamp)
							)::text || \' 分鐘前上線\'
					END as "lastOnLine"
					FROM staff_chat."chatHistory"
					WHERE "chatHistory"."UID" = :UID
					';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
			$sth->execute();	
			$row = $sth->fetchAll();
			$ack = array(
				'status'=>'success',
				'time'=>$row[0][lastOnLine],

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

		function updateCommentReadTime($commentID){//TODO
			

			$sql = 'UPDATE staff_chat."commentHistory"
					SET "lasttime"=NOW()
					WHERE "UID"=:UID AND "commentID"=:commentID;';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
			$sth->bindParam(':commentID',$commentID,PDO::PARAM_INT);
			$sth->execute();
			$count = $sth->rowCount();
			if($count == 0){
				$sql = 'INSERT INTO staff_chat."commentHistory"("UID",lasttime, "commentID")
					VALUES (:UID, NOW(), :commentID);';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
				$sth->bindParam(':commentID',$commentID,PDO::PARAM_INT);
				$sth->execute();
			}
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
		function addlikeID($body){
			$body=json_decode($body['data'],true);
			$likeID=$body['likeID'];
			var_dump($body);
			if(is_null($likeID)){
				$sql='
					SELECT "likeID"
					FROM staff_chat."chatContent"
					where content=:content AND "UID"=:UID AND "sentTime"=:senttime AND"chatID"=:chatID;
				';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':content',$body['content'],PDO::PARAM_STR);
				$sth->bindParam(':senttime',$body['senttime'],PDO::PARAM_STR);
				$sth->bindParam(':UID',$body['UID'],PDO::PARAM_STR);
				$sth->bindParam(':chatID',$body['chatID'],PDO::PARAM_INT);
				$sth->execute();
				$row = $sth->fetchAll();
				var_dump($row);
				if(count($row)==1){
					if($row[0]["likeID"]==null){
					// var_dump($content,$senttime,$UID,$chatID);
	    			$sql='
						UPDATE staff_chat."chatContent"
						SET "likeID"=nextval(\'staff_chat."chatContent_likeID_seq"\'::regclass)
						WHERE content=:content AND "sentTime"=:senttime AND "UID"=:UID AND "chatID"=:chatID AND "likeID" is NULL;
					';
					$sth = $this->conn->prepare($sql);
					$sth->bindParam(':content',$body['content'],PDO::PARAM_STR);
					$sth->bindParam(':senttime',$body['senttime'],PDO::PARAM_STR);
					$sth->bindParam(':UID',$body['UID'],PDO::PARAM_STR);
					$sth->bindParam(':chatID',$body['chatID'],PDO::PARAM_INT);
					$sth->execute();

					// $likeID = $this -> $conn -> lastInsertId();

					// search likeID from "chatContent" and record likeid and uid to "chatLikeCount"
					$sql='
						SELECT "UID","likeID"
						FROM staff_chat."chatContent"
						WHERE content=:content AND "sentTime"=:senttime AND "UID"=:UID AND "chatID"=:chatID ;
					';
					$sth = $this->conn->prepare($sql);
					$sth->bindParam(':content',$body['content'],PDO::PARAM_STR);
					$sth->bindParam(':senttime',$body['senttime'],PDO::PARAM_STR);
					$sth->bindParam(':UID',$body['UID'],PDO::PARAM_STR);
					$sth->bindParam(':chatID',$body['chatID'],PDO::PARAM_INT);
					$sth->execute();

					$row=$sth -> fetchAll();
					$likeID = $row[0]["likeID"];

					$sql='
						INSERT INTO staff_chat."chatLikeCount"("likeID", "UID")
						VALUES (:likeID, :UID);
					';
					$sth = $this->conn->prepare($sql);
					$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
					$sth->bindParam(':likeID',$likeID,PDO::PARAM_INT);
					$sth->execute();

					}
		    	}

			}
			else{
				$sql='
					SELECT *
					FROM staff_chat."chatLikeCount"
					WHERE "UID"=:UID AND "likeID"=:likeID
				';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
				$sth->bindParam(':likeID',$likeID,PDO::PARAM_INT);
				$sth->execute();
				$row=$sth->fetchAll();

				var_dump($row);

				if(count($row)==1){
				//dislike
					if($row[0]["likeID"]!=null){
					$sql='
						DELETE FROM staff_chat."chatLikeCount"
						WHERE "UID"=:UID AND "likeID" =:likeID;
					';
					$sth = $this->conn->prepare($sql);
					$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
					$sth->bindParam(':likeID',$likeID,PDO::PARAM_INT);
					$sth->execute();
					}
				}
				else{
					$sql='
						INSERT INTO staff_chat."chatLikeCount"("likeID", "UID")
						VALUES (:likeID, :UID);
					';
					$sth = $this->conn->prepare($sql);
					$sth->bindParam(':UID',$_SESSION['id'],PDO::PARAM_STR);
					$sth->bindParam(':likeID',$likeID,PDO::PARAM_INT);
					$sth->execute();
				}
			}

		}
		function getList($chatID=null){
			if(is_null($chatID)){
				$sql ="SELECT staff_name as name,staff_id as id FROM staff.staff WHERE staff_id != :staff_id and staff_delete=false and \"seniority_workStatus\" =1;";
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':staff_id',$_SESSION['id'],PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetchAll();
			}else{
				$sql = 'SELECT staff_name as name,staff_id as id FROM staff.staff LEFT JOIN staff_chat."chatHistory" on staff_chat."chatHistory"."UID" = staff.staff.staff_id and "chatID"=:chatID WHERE "chatID" is null and staff_id != :staff_id and staff_delete=false and "seniority_workStatus" =1;';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':staff_id',$_SESSION['id'],PDO::PARAM_STR);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
				$sth->execute();

				$row = $sth->fetchAll();
			}
			return $row;
		}
		function uploadFile($chatID,$directory,$uploadedFiles,$isPicture){
			// handle single input with single file upload
		    $uploadedFile = $uploadedFiles['inputFile'];
		    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
		        $filename = $this->moveUploadedFile($directory, $uploadedFile);
		        $UID = $_SESSION['id'];
				$sql = 'INSERT INTO staff_chat.files("fileName", "UID", "fileNameClient") VALUES (:fileName, :UID, :fileNameClient);';
				$sth = $this->conn->prepare($sql);
				$sth->bindParam(':fileName',$filename,PDO::PARAM_STR);
				$sth->bindParam(':fileNameClient',$uploadedFile->getClientFilename(),PDO::PARAM_STR);
				$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
				$sth->execute();

				$sql = 'INSERT INTO staff_chat."chatContent"(	content, "UID", "sentTime", "chatID")
						VALUES ( :Msg , :UID , NOW(), :chatID );';
				$sth = $this->conn->prepare($sql);
				$UID = $_SESSION['id'];
				// if($isPicture){
				// 	$Msg = '
				// 		<a href="#" data-toggle="modal" data-target="#basicModal" data-type="photo" data-src="/chat/picture/'.$this->conn->lastInsertId().'">
				// 			<img src="/chat/thumbnail/'.$this->conn->lastInsertId().'" alt="..." class="img-thumbnail">
				// 		</a>
				// 	';
				// }else{
				// 	$Msg = '<a href="/chat/file/'.$this->conn->lastInsertId().'" style="color:#FFFFFF;">'.$uploadedFile->getClientFilename().'</a>';
				// }
				$Msg = '<a href="#" data-toggle="modal" data-target="#basicModal" data-type="file" data-href="/chat/file/'.$this->conn->lastInsertId().'" style="color:#FFFFFF;">'.$uploadedFile->getClientFilename().'</a>';

				$sth->bindParam(':UID',$UID,PDO::PARAM_STR);
				$sth->bindParam(':chatID',$chatID,PDO::PARAM_INT);
				$sth->bindParam(':Msg',$Msg,PDO::PARAM_STR);
				$sth->execute();

			    $result = array(
			    	'status' => 'success',
		    		'extension' => exif_imagetype($uploadedFile->getClientFilename())
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
		function getFileFormat($fileID){
			$supported_image = array(
			    'gif',
			    'jpg',
			    'jpeg',
			    'png'
			);
			$sql = '
				SELECT id, "fileName", "fileNameClient", "uploadTime", "UID"
				FROM staff_chat.files
				WHERE id = :fileID;
			';
			$sth = $this->conn->prepare($sql);
			$sth->bindParam(':fileID',$fileID,PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetchAll();
			if(count($row)==1){
			    $result = array(
			    	'status' => 'success',
			    );
			    $result['type'] = 'file';
		    	$ext = strtolower(pathinfo($row[0]['fileName'], PATHINFO_EXTENSION));
				if (in_array($ext, $supported_image)) {
			    	$result['type'] = 'picture';
				}
		    }else{
			    $result = array(
			    	'status' => 'failed'
			    );
		    }
		    return $result;
		}


		function downloadFile($fileID){
			$sql = '
				SELECT id, "fileName", "fileNameClient", "uploadTime", "UID"
				FROM staff_chat.files
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
	   	function thumbnail($filename,$width=200,$height=200){
	        //獲取原影象$filename的寬度$width_orig和高度$height_orig
	        list($width_orig,$height_orig) = getimagesize($filename);
	        $infos = @getimagesize($filename);
            switch($infos['mime']) {
		     	case 'image/gif':
		      		$image = imagecreatefromgif($filename);
		     	break;
				case 'image/jpeg':
					$image = imagecreatefromjpeg($filename);
				break;
				case 'image/png':
					$image = imagecreatefrompng($filename);
				break;
		    }
	        //根據引數$width和$height值，換算出等比例縮放的高度和寬度
	        if ($width && ($width_orig<$height_orig)){
	            $width = ($height/$height_orig)*$width_orig;
	        }else{
	            $height = ($width / $width_orig)*$height_orig;
	        }

	        //將原圖縮放到這個新建立的圖片資源中
	        $image_p = imagecreatetruecolor($width, $height);

	        //使用imagecopyresampled()函式進行縮放設定
	        imagecopyresampled($image_p,$image,0,0,0,0,$width,$height,$width_orig,$height_orig);
	 		return $image_p;
	    }

	}
?>