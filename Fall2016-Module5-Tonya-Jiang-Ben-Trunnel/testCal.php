<!DOCTYPE html>
	<html>
		<head>
			<title>CALENDAR</title>
			<link rel="stylesheet" type="text/css" href="stylesheet.css">
			<script src="http://classes.engineering.wustl.edu/cse330/content/calendar.min.js" type="text/javascript"></script>
			<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
			<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" />
			<!-- We need the style sheet linked above or the dialogs/other parts of jquery-ui won't display correctly!-->			
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
			<!-- The main library. Note: must be listed before the jquery-ui library -->			
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
			<!-- jquery-UI hosted on Google's Ajax CDN-->
			<!-- Note: you can download the javascript file from the link provided on the google doc, or simply provide its URL in the src attribute (microsoft and google also host the jQuery library-->
			
		</head>
		<body>
			<form name ="input" method="POST" id="login">
				<label>Username: <input placeholder="ex. Sproull330" type="text" name="username" required="required" id="username"/></label>
				<label>Password: <input type="password" name="password" required="required" id="password"/></label>
				<button id="login_btn">Log In</button>
			</form>
			<form name ="input" method="POST" id="register">
				New user?
				<label>Username: <input placeholder="ex. Sproull330" type="text" name="newUser" required="required" id="newUser"/></label>
				<label>Password: <input type="password" name="newPassword" required="required" id="newPassword"/></label>
				<button id="register_btn">Register</button>				
			</form>		
			<h1 id="month"></h1>
			<button id="prev" class="button"><span>«</span></button>			
			<button id="next" class="button"><span>»</span></button>
			<script type="text/javascript" src="rajax.js"></script>
			<script type="text/javascript" src="put_events.js"></script>
			<script>
				var session = null;
				function showdialog(){
					$("#mydialog").dialog({resizable: false});
				}				
				// This updateCalendar() function only alerts the dates in the currently specified month.  You need to write
				// it to modify the DOM (optionally using jQuery) to display the days and weeks in the current month.
				function updateCalendar(){
					$("table").remove();
					var monthNames = ["January", "February", "March", "April", "May", "June",
					"July", "August", "September", "October", "November", "December"
					];
					var daysWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
					var body = document.getElementsByTagName("body")[0];
					console.log("in update Cal");
					var weeks = currentMonth.getWeeks();
					var cal = document.createElement("table");
					var tblBody = document.createElement("tbody");
					var head = document.createElement("tr");
					for(var i = 0; i<7; i++){
						var dayName = document.createElement("th");
						var name = document.createTextNode(daysWeek[i]);
						dayName.appendChild(name);
						head.appendChild(dayName);
						tblBody.appendChild(head);
					}
					
					document.getElementById("month").innerHTML = monthNames[currentMonth.month] + ", " + currentMonth.year;											
					for(var w in weeks){
						if(weeks.hasOwnProperty(w)){
							var days = weeks[w].getDates();
							// days contains normal JavaScript Date objects.
							console.log("Week starting on "+days[0]);							
							var row = document.createElement("tr");
							for(var d in days){								
								if(days.hasOwnProperty(d)){
									var cell = document.createElement("td");
									var getDayNum = /\d{2}/.exec(days[d]);
									var dayNum = document.createTextNode(getDayNum[0]);									
									cell.appendChild(dayNum);
									row.appendChild(cell);
									var id = /\w{3}\s\w{3}\b\s\d{2}\s\d{4}/.exec(days[d]);
									cell.id = id[0];							
								}								
							}							
							tblBody.appendChild(row);			
						}
					}				
					cal.appendChild(tblBody);
					// put <table> in the <body>
					body.appendChild(cal);
					// tbl border attribute to 
					cal.setAttribute("border", "2");

					if(session !== null){
					
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
					xmlHttp.open("POST", "read_events.php", true); // Starting a POST request
					xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
					xmlHttp.addEventListener("load", function(event) {
						var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object	
						console.log(jsonData);
						for (i = 0; i < jsonData.events.length; i++) {
							var elementExists = document.getElementById(jsonData.events[i].date);
							if (elementExists) {
								var a = document.createElement("p");
								a.appendChild(document.createTextNode(jsonData.events[i].title + " @ " + jsonData.events[i].time));
								console.log(jsonData.events[i].date);
								document.getElementById(jsonData.events[i].date).appendChild(a);
								a.id = jsonData.events[i].title;
								
								document.getElementById(jsonData.events[i].title).addEventListener("click", deleteEvent, false);
								if(jsonData.events[i].tag == "P"){
									document.getElementById(jsonData.events[i].title).style.color = "Blue";
								}
								if(jsonData.events[i].tag == "W"){
									document.getElementById(jsonData.events[i].title).style.color = "Red";
								}
								if(jsonData.events[i].tag == "F"){
									document.getElementById(jsonData.events[i].title).style.color = "Green";
								}
								if(jsonData.events[i].tag == "A"){
									document.getElementById(jsonData.events[i].title).style.color = "Grey";
								}
								if(jsonData.events[i].tag == "S"){
									document.getElementById(jsonData.events[i].title).style.color = "CornflowerBlue";
								}
								if(jsonData.events[i].tag == "U"){
									document.getElementById(jsonData.events[i].title).style.color = "Black";
								}
							}
						}
						
						$( "#eventAdd" ).click(function( event ) {
							mydialog();
							showdialog();
							event.preventDefault();
						  });
						$( "#eventEnter" ).click(function( event ) {
							addEvent();
							event.preventDefault();
						  });
					}, false); // Bind the callback to the load event
					xmlHttp.send(null); // Send the data	
					}
					
				}
				//logout to call logout.php where we end the session
				function logoutAjax(){
					console.log("a");
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance					
					xmlHttp.open("GET","logout.php",true);					
					xmlHttp.onreadystatechange=function(){
					if (xmlHttp.readyState == 4){
					   if(xmlHttp.status == 200){
							alert(xmlHttp.responseText);
						}
					  }
					  $("p").remove();					  
				   };
					xmlHttp.send();			
				}
				
				//addEvent calls addEvent.php
				function addEvent(){
					var title = document.getElementById("title").value;
					var date = document.getElementById("date").value; 
					var time = document.getElementById("time").value;
					var token = document.getElementById("token").value;
					var user = document.getElementById("user_id").value;
					console.log(token);
					console.log(title);
					console.log(user);
					console.log(session);
					// Make a URL-encoded string for passing POST data:
					var dataString = "title=" + encodeURIComponent(title) + "&date=" + encodeURIComponent(date) + "&time=" + encodeURIComponent(time) + "&token=" + encodeURIComponent(token);
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
					xmlHttp.open("POST", "addEvent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
					xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
					xmlHttp.addEventListener("load", function(event){
						var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
							if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
								alert("Event was added!");
							}else{
								alert("Something went wrong.");
							}
					}, false); // Bind the callback to the load event
					xmlHttp.send(dataString); // Send the data				
				}
				
				//mydialog creates a dialog in javascript, kinda brute forced my way to make session tokens work...
				function mydialog(){
					var div = document.createElement("div");
					div.id="mydialog";
					
					var form = document.createElement("form");
					form.setAttribute("method", "post");
					form.id = "eventForm";
					var token = document.createElement("input");
					token.setAttribute("type", "hidden");
					token.setAttribute("name", "token");
					token.setAttribute("value", session);
					token.id = "token";
					var user = document.createElement("input");
					user.setAttribute("type", "hidden");
					user.setAttribute("name", "user_id");
					user.setAttribute("value", "tonya");
					user.id = "user_id";
					var title = document.createElement("input");
					title.setAttribute("type", "text");
					title.setAttribute("name", "title");
					title.setAttribute("required", "required");
					title.id = "title";
					var date = document.createElement("input");
					date.setAttribute("type", "text");
					date.setAttribute("name", "date");
					date.setAttribute("required", "required");
					date.id = "date";
					var time = document.createElement("input");
					time.setAttribute("type", "time");
					time.setAttribute("name", "number");
					time.setAttribute("required", "required");
					time.id = "time";
					var sharedUser = document.createElement("input");
					sharedUser.setAttribute("type", "text");
					sharedUser.setAttribute("name", "sharedUser");
					sharedUser.setAttribute("value", "");
					sharedUser.id = "sharedUser";
					
					var eventEnter= document.createElement("button");
					var entertext = document.createTextNode("Add");       // Create a text node
					eventEnter.appendChild(entertext);                                // Append the text to <button>
					eventEnter.id = "eventEnter";
					form.appendChild(title);
					form.appendChild(date);
					form.appendChild(time);
					form.appendChild(token);
					form.appendChild(user);
					form.appendChild(sharedUser);
					form.appendChild(eventEnter);
					div.appendChild(form);
					document.body.appendChild(div);
					document.getElementById("mydialog").style.display = "none";
					var x = document.createElement("LABEL");
					var t = document.createTextNode("Title ");
					x.setAttribute("for", "title");
					x.appendChild(t);
					document.getElementById("eventForm").insertBefore(x,document.getElementById("title"));
					var a = document.createElement("LABEL");
					var b = document.createTextNode("Date ");
					a.setAttribute("for", "date");
					a.appendChild(b);
					document.getElementById("eventForm").insertBefore(a,document.getElementById("date"));
					var c = document.createElement("LABEL");
					var d = document.createTextNode("Time ");
					c.setAttribute("for", "time");
					c.appendChild(d);
					document.getElementById("eventForm").insertBefore(c,document.getElementById("time"));
					var e = document.createElement("LABEL");
					var f = document.createTextNode("Share with ");
					e.setAttribute("for", "sharedUser");
					e.appendChild(f);
					document.getElementById("eventForm").insertBefore(e,document.getElementById("sharedUser"));
				}
				
				//loginAjax sends to login_ajax.php to check if the user logged in correctly and then populates the table if he/she did
				function loginAjax(){
					var username = document.getElementById("username").value; // Get the username from the form
					var password = document.getElementById("password").value; // Get the password from the form
					// Make a URL-encoded string for passing POST data:
					var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
					xmlHttp.open("POST", "login_ajax.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
					xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
					xmlHttp.addEventListener("load", function(event){
					var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object	
						if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
							alert("You were logged in!");
							$("#login").hide();
							$("#register").hide();
							var logout = document.createElement("button");
							var logout_text = document.createTextNode("Logout");       // Create a text node
							logout.appendChild(logout_text);                                // Append the text 
							document.body.appendChild(logout);
							logout.id = "logout";
							
							var eventAdd = document.createElement("button");
							var add_text = document.createTextNode("Add Event");       // Create a text node
							eventAdd.appendChild(add_text);                                // Append the text
							document.body.appendChild(eventAdd);
							eventAdd.id = "eventAdd";
													
							$( "#logout" ).click(function( event ) {
								logoutAjax();
								$("#login").show();
								$("#register").show();
								//updateCalendar();
								event.preventDefault();
								$("#logout").remove();
							  });
							
							$( "#eventAdd" ).click(function( event ) {
								showdialog();
								event.preventDefault();
							  });
							
							for(i=0;i<jsonData.events.length;i++){
								var elementExists = document.getElementById(jsonData.events[i].date);
								if (elementExists) {
									console.log(jsonData.events[i].title + " " +jsonData.events[i].date);

									var a = document.createElement("p");
									a.appendChild(document.createTextNode(jsonData.events[i].title + " @ " + jsonData.events[i].time));
									document.getElementById(jsonData.events[i].date).appendChild(a);
									a.id = jsonData.events[i].title;
									document.getElementById(jsonData.events[i].title).addEventListener("click", deleteEvent, false);
									
									//unfinished tags for the creative portion
									if(jsonData.events[i].tag == "P"){
										document.getElementById(jsonData.events[i].title).style.color = "Blue";
									}
									if(jsonData.events[i].tag == "W"){
										
										document.getElementById(jsonData.events[i].title).style.color = "Red";
									}
									if(jsonData.events[i].tag == "F"){
										
										
										document.getElementById(jsonData.events[i].title).style.color = "Green";
									}
									if(jsonData.events[i].tag == "A"){
										
										document.getElementById(jsonData.events[i].title).style.color = "Grey";
									}
									if(jsonData.events[i].tag == "S"){
										
										document.getElementById(jsonData.events[i].title).style.color = "CornflowerBlue";
									}
									if(jsonData.events[i].tag == "U"){
										
										document.getElementById(jsonData.events[i].title).style.color = "Black";
									}
								}
							}
							session = jsonData.token[0];

							mydialog();
							$( "#eventEnter" ).click(function( event ) {
								addEvent();
								updateCalendar();
								$("#mydialog").hide();
								event.preventDefault();
							  });
						}else{
							alert("You were not logged in. " + jsonData.message);							
						}
					}, false); // Bind the callback to the load event
				
					xmlHttp.send(dataString); // Send the data
				}
				

				//deleteEvent calls delete.php 
				function deleteEvent(){
					var title = (event.target.id);
					var dataString = 'title=' + title;
					// AJAX code to submit form.
						$.ajax({
						type: "POST",
						url: "delete.php",
						data: dataString,
						cache: false,
						success: function(html) {
							alert("deleted");
					}
					});
					document.getElementById(event.target.id).remove();
					return false;
				}
				
				
		
				

				// For our purposes, we can keep the current month in a variable in the global scope
				var currentMonth = new Month(2012, 9); // October 2012
				updateCalendar();
				// Change the month when the "next" button is pressed
				$( "#next" ).click(function( event ) {
					currentMonth = currentMonth.nextMonth(); 
					console.log("yup");
					updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
					console.log("The new month is "+currentMonth.month+" "+currentMonth.year);
					event.preventDefault(); //dont reload, prevent default on button press
				  });
				
				$( "#prev" ).click(function( event ) {
					currentMonth = currentMonth.prevMonth(); 
					console.log("yup");
					updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
					console.log("The new month is "+currentMonth.month+" "+currentMonth.year);
					event.preventDefault();
				  });

				$( "#register_btn" ).click(function( event ) {
					registerAjax();
					event.preventDefault();
				  });
				
				$( "#login_btn" ).click(function( event ) {
					loginAjax();
					event.preventDefault();
				  });
		</script>
	</body>
	</html>	