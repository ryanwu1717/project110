<?php
	//phpinfo();
	session_start();
	$dbhost = 'localhost';
	$dbuser = 'postgres';
	$dbpasswd = '880817';
	$dbname = 'ryanDB';
	$dsn = "pgsql:host=".$dbhost.";dbname=".$dbname;
	$conn = new PDO($dsn,$dbuser,$dbpasswd);
	$conn->exec("SET CHARACTER SET utf8");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$_SESSION['id']='user';
	if (!$conn){
     		 echo "Error : Unable to open database";
     		 echo '<br/>';

   	} else {
     		 // echo "Opened database successfully";
     		 // echo '<br><br/>';
   				$id = $_GET['id'];
   				if($id=='1'){
					$sql ='SELECT * from staff_information.department;';
   				}else if($id=='2'){
					$sql ='SELECT * from staff_information.position;';
   				}else if($id=='3'){
					$sql ='SELECT * from staff_information.gender;';
   				}else if($id=='4'){
					$sql ='SELECT * from staff_information.marriage;';
   				}else if($id=='5'){
					$sql ='SELECT * from staff_salary.insuredcompany;';
   				}else if($id=='6'){
					$sql ='SELECT * from staff_salary."workStatue";';
   				}else if($id=='7'){
					$sql ='SELECT * from staff_salary."staffType";';
   				}else if($id=='8'){
					$sql ='SELECT * from staff_education.condition;';
   				}else if($id=='9'){
   					$sql ='SELECT DISTINCT s."staff_name" as name ,x."position_name" as position,
   											d."department_name" as department,s."contact_phoneNumber" as phonenumber,
   											s."seniority_endDate" as enddate,s."seniority_staffType" as stafftype,
   											s."staff_id" 
						   from staff.staff as s,staff_information.department as d,staff_information.position as x
						   where s."staff_position" = x."position_id" and s."staff_department" = d."department_id"
						   ORDER BY position DESC;';
   				}else if($id=='staffNum'){
					$sql ='SELECT COUNT (*) as num FROM staff.staff;';
   				}else if($id=='10'){
					$_SESSION['id']='user';
   				}else if($id=='11'){
   					// if($_SESSION['login']){
   						
		   				echo ($_SESSION['user']);
						//echo($_SESSION['id']);
   					// }else{
   					// 	echo "user";
   					// }
   					
   				}else if($id=='12'){
					session_destroy();
   				}
				$sth = $conn->prepare($sql);
				$sth->execute();
				$row = $sth->fetchAll(PDO::FETCH_ASSOC);
				header("Content-Type: application/json");
				echo json_encode($row);	
				
   	}
?>