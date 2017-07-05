<?php
	//edits --work in progress
	ini_set("session.cookie_httponly", 1);
	session_start();
	$mysqli = new mysqli('localhost', 'JIANGT', 'Tjbreez11!', 'cal');
	 
	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}
	header("Content-Type: application/json");
	
	//if($_SESSION['token'] !== $_POST['token']){
	//	die("Request forgery detected");
	//}
	
	$title= (string)mysql_real_escape_string($_POST['title']);
	$date= (string)mysql_real_escape_string($_POST['date']);
	$time= (string)mysql_real_escape_string($_POST['time']);
	$old= (string)mysql_real_escape_string($_POST['old']);
	//update the story description 
	$stmt = $mysqli->prepare("update events set title=?, date=?, time=? where title=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('ssss', $title, $date, $time, $old);
	 
	$stmt->execute();
	echo json_encode(array("success" => true));
	$stmt->close();

?>