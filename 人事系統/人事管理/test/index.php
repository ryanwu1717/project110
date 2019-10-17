<?php
	
	header("Content-Type:text/html; charset=utf8");
	$curl_handle=curl_init();
	curl_setopt($curl_handle,CURLOPT_URL,'http://localhost/test/testtest.php/login/user/get');
	curl_exec($curl_handle);
	curl_close($curl_handle);


?>