<?php

	// header("content-type:application/json");


	require_once('includes/codebird-php-master/src/codebird.php');

	$array = array('user 1' => 'AFF', 'user 2' => 'CatoInstitute');
	// echo $array;
	$user = $_POST['user'];
	// $user = 'CatoInstitute';

	$cb = \Codebird\Codebird::getInstance();
    $cb->setConsumerKey('aOdD72fNKDI29xrglNPqJXQb9', 'Isxx49ON9nhic2RwOGt76izOTC4U75esPiEyRYUIKFW0ArpRf1');
    $cb->setToken('288363689-6qYx65goXJtL72cY3FAHHcOXLoXDlvNhAHuUtxYQ', 'PW8eOow2gI0BeCDbacFqAwEKkVqoEe44Uu5Y5n6hOpMsd');

    $params = array('screen_name' => $user);    
	$reply = $cb->users_show($params);

	// print_r ($reply);

	// $user_name = "AFF";
	// echo $user_name;



	echo json_encode($reply);
	// echo $reply;


?>