<?php
	//this adds events to the database
	session_start();
	$mysqli = new mysqli('localhost', 'JIANGT', 'Tjbreez11!', 'cal');
 
	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}
	if($_SESSION['token'] !== $_POST['token']){
		die("Request forgery detected");
	}
	
	header("Content-Type: application/json");
	$user_id = (string)$_SESSION['user_id'];
	$title = (string)mysql_real_escape_string($_POST['title']);
	$eventDate = (string)mysql_real_escape_string($_POST['date']);
	$time = (string)mysql_real_escape_string($_POST['time']);
	//insert comment into comments table

	$stmt = $mysqli->prepare("insert into events (title, date, time, user) values (?, ?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('ssss', $title, $eventDate, $time, $user_id);
	 
	$stmt->execute();

	$stmt->close();
	
	$stmt2 = $mysqli->prepare("insert into events (title, date, time, user) values ('$title', '$eventDate', '$time', '$sharedUser')");
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt2->bind_param('ssss', $title, $eventDate, $time, $sharedUser);
	$stmt2->execute();
	$stmt2->close();
	echo json_encode(array("success" => true));
?>