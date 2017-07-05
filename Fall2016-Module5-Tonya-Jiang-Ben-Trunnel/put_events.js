function putEvents(){
	//puts events for each updateCalendar call
	console.log("what up");
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "read_events.php", true); // Starting a POST request
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object	
		console.log(jsonData);
		for(i=0;i<jsonData.events.length;i++){			
			var a = document.createElement("p");
			a.appendChild(document.createTextNode(jsonData.events[i].title));
			document.getElementById(jsonData.events[i].date).appendChild(a);
			a.id = jsonData.events[i].title;
			document.getElementById(jsonData.events[i].title).addEventListener("click", deleteEvent, false);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(null); // Send the data
}