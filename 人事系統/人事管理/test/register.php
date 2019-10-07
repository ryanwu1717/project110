<?php
	//phpinfo();
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
?>