function registerAjax(){
	//adds users
	var username = document.getElementById("newUser").value; // Get the username from the form
	var password = document.getElementById("newPassword").value; // Get the password from the form
	console.log(username);
	console.log(password);
	// Make a URL-encoded string for passing POST data:
	var dataString = "newuser=" + encodeURIComponent(username) + "&newpassword=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "register_ajax.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been registered in!");
		}else{
			alert("You were not registered in.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
 