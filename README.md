# JavaScript Calculator, Weather Widget, Calendar
Module 5 CSE 330 calculator, weather widget, and calendar to learn JavaScript, jQuery, AJAX and JSON, 
## JavaScript Calculator (10 Points):
* Calculator successfully adds, subtracts, multiplies, and divides numbers (3 points)
* The result is automatically computed when a value in either field is changed (3 points)
* Calculator is written entirely in pure, conventional JavaScript with no external libraries (4 points)*
* Note: be sure to fully separate content, appearance, and behavior. This means that you should not use the event attributes on the HTML elements like onclick, onchange, and onkeyup.
## Weather Widget (15 Points):
* Widget performs an AJAX request to fetch the current weather (4 points)
* The HTML template is filled with the correct information, including an image (4 points)
* Button to reload the weather widget (2 points)
* Widget is written entirely in pure, conventional JavaScript with no external libraries (5 points)*
## AJAX Calendar (60 Points):
* Calendar View (10 Points):
* The calendar is displayed as a table grid with days as the columns and weeks as the rows, one month at a time (5 points)
* The user can view different months as far in the past or future as desired (5 points)
## User and Event Management (25 Points):
* Events can be added, modified, and deleted (5 points)
* Events have a title, date, and time (2 points)
* Users can log into the site, and they cannot view or manipulate events associated with other users (8 points)
* Don't fall into the Abuse of Functionality trap! Check user credentials on the server side as well as on the client side.
* All actions are performed over AJAX, without ever needing to reload the page (10 points)
## Best Practices (20 Points):
* Code is well formatted and easy to read, with proper commenting (2 points)
* If storing passwords, they are stored salted and encrypted; if using OpenID, you are storing the user's OpenID identifier in the database (2 points)
* All AJAX requests that either contain sensitive information or modify something on the server are performed via POST, not GET (3 points)
* Safe from XSS attacks; that is, all content is escaped on output (3 points)
* Safe from SQL Injection attacks (2 points)
* CSRF tokens are passed when editing or removing events (3 points)
* Session cookie is HTTP-Only (3 points)
* Page passes the W3C validator (2 points)
* Extra Credit: Your code passes JSHint or JSLint (+3 bonus points)
## Usability (5 Points):
* Site is intuitive to use and navigate (4 points)
* Site is visually appealing (1 point)
* Creative Portion (15 Points)
## Additional Calendars Features (worth 15 points): Develop some additional features for the calendar, a few examples are provided below.
* Users can tag an event with a particular category and enable/disable those tags in the calendar view. (5 points)
* Users can share their calendar with additional users. (5 points)
* Users can create group events that display on multiple users calendars (5 points)
* Make sure to save a description of your creative portion, and a link to your server in your README.md file.
