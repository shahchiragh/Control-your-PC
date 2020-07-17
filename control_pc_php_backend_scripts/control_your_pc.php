<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
p{
	font-size: 18px;
}
</style>
<body>
<div class="container">
  <div class="jumbotron jumbotron-fluid">
    <h1 style="text-align: center;">Control Your PC</h1>      
    <p>Control your complete PC or laptop functionalities such as Turn on/off, open any file or document, using smart speakers such as Amazon Alexa, Google Home, Google Mini, Google Max or smart phone running Google Assistant.</p>
  </div>
  <p style="color:red;font-size:20px;font-weight: bold;">Notifications::</p>
  <div id="refreshDiv">

  </div>     
</div>
</body>
<script>
	//getBullet();
getIncomingPush();//start websocket

var websocket;
var messages = document.getElementById('refreshDiv');
function getIncomingPush() {
    if (websocket != null) {
        websocket.close();
    }
    // opening a websocket to wait for incoming Push Notifications.
    websocket = new WebSocket('wss://stream.pushbullet.com/websocket/o.qttbnrlCEJkwTQvu91RZDZeEbBxUYtKK');
    websocket.onopen = function(e) {
        //messages.innerHTML += "<p>WebSocket onopen</p>";
        messages.innerHTML += "<p>Listening for commands...</p>";
    }
    websocket.onmessage = function(e) {
    	var obj = JSON.parse(e.data);
    	if(obj.type =='tickle' && obj.subtype == 'push'){
    		//messages.innerHTML += "<p> Incoming Push: " + e.data + "</p>";
    		messages.innerHTML += "<p> Incoming Push ... </p>";
    		sendPush();
    	}
    	else {}
    }
    websocket.onerror = function(e) {
        messages.innerHTML += "<p>WebSocket onerror</p>";
    }
    websocket.onclose = function(e) {
        messages.innerHTML += "<p>WebSocket onclose</p>";
    }
}
	//Go background and do relevant operations that are received.
	function sendPush() {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			messages.innerHTML += "<p>"+ this.responseText + "</p>";
		}
	};
		xhttp.open("GET", "get_and_parse_Push.php", true);
		xhttp.send();
	}
</script>
</html>