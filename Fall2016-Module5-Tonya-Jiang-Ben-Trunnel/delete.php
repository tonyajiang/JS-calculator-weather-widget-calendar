<?php
//deletes from database
$title = (string)mysql_real_escape_string($_POST['title']);

$mysqli = new mysqli('localhost', 'JIANGT', 'Tjbreez11!', 'cal');
	$stmt = $mysqli->prepare("delete from events where title = '$title'");	
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	echo ($title);			 
	$stmt->execute();
						
	$stmt->close();

?>