<?php
	// check if valid user and then if it is pull the events related to that user;
	$mysqli = new mysqli('localhost', 'JIANGT', 'Tjbreez11!', 'cal');
	 
	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}
	header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
	 
	$stmt = $mysqli->prepare("select username, password FROM users WHERE username=?");
					// Bind the parameter
	$username = (string)$_POST['username'];
	$stmt->bind_param('s', $username);
	
	$stmt->execute();
	// Bind the results
	$stmt->bind_result($user_id, $pwd_hash);
	$stmt->fetch();
	
	
	$pwd_guess = (string)$_POST['password'];
	// Compare the submitted password to the actual password hash
	if(crypt($pwd_guess, $pwd_hash)==$pwd_hash){
		session_start();
	// Login succeeded!
		$_SESSION['user_id'] = $user_id;
		$_SESSION['token'] = substr(md5(rand()), 0, 10); // generate a 10-character random string
	
		//echo json_encode(array("success" => true));
		$mysqli->close();
		
		$connection = new mysqli('localhost', 'JIANGT', 'Tjbreez11!', 'cal');
		if($connection->connect_errno) {
		printf("Connection Failed: %s\n", $connection->connect_error);
		exit;
		}
		
		header("Content-Type: application/json"); 
	
		//fetch table rows from mysql db
		
		$sql = "select * from events where user='" .$user_id. "'";
		$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
	
		//create an array
		$events = array();
		while($row =mysqli_fetch_assoc($result))
		{
			$events['events'][] = $row;
		}
		$events['success'][] = true;
		$events['token'][] = $_SESSION['token'];
		echo json_encode($events);
	
		//close the db connection
		mysqli_close($connection);
	}else{
	// Login failed; redirect back to the login screen
		echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
		));
		exit;
	} 
?>




