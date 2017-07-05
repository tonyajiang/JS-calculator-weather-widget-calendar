<?php
    //select events related to user
    $connection = new mysqli('localhost', 'JIANGT', 'Tjbreez11!', 'cal');
    if($connection->connect_errno) {
	printf("Connection Failed: %s\n", $connection->connect_error);
	exit;
    }
    
    header("Content-Type: application/json"); 
	session_start();
	// Login succeeded!
	$user_id = $_SESSION['user_id'];
    //fetch table rows from mysql db
    $sql = "select * from events where user='" .$user_id. "'";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $events = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $events['events'][] = $row;
    }
    echo json_encode($events);

    //close the db connection
    mysqli_close($connection);
?>