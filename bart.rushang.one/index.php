<!DOCTYPE html>
<html>
<head>
	<title>Bart - Rushang Home Page</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
	<style>

        .container{
            margin: 10px 10px 10px 10px;
            background-color: #87CEEB60;
            min-height: 700px;
            height: auto;
            box-sizing: border-box;
            border: 5px solid #87CEEB90;
            font-family: 'Open Sans',cursive;
        }
		.border-line{
			height: 2px;
			background: black;
		}
        .rush-header{
            display: flex;
        }
        .rush-header img{
            padding-left: 10px;
            padding-right: 10px;
            height: 100px;
        }
        .rush-header p{
            padding-left: 10px;
            font-size: 24px;
            font-family: 'Righteous',cursive;
        }

        .copyright{
            font-size: 7px;
            margin-left: 200px;
        }

        .page-content{
            margin-left: 20px;
            margin-top: 20px;
        }


    </style>
</head>
<body>
	<div class = "container">
        <div class = "rush-header">
            <img src="/Bart-logo.svg.png">
            <p>Welcome to Rushang's sub domain of bart. This web server uses bart's public api's to curate the output. We can call it light-weight bart website</p>
        </div>
        <div class = "copyright">
            <p>The image is is reused under licensing from https://commons.wikimedia.org/wiki/File:Bart-logo.svg</p>
        </div>
		<div class = "border-line">
		</div>
		<div class = "page-content">
			<h1 id="welcome-message"></h1><br>
			<h2>Choose a page to go to:</h2>
			<form>
			    <div>
			        <p> Get list of all bart stations: </p>
				    <input type="button" value="Stations" onclick="window.location.href='stations_list.php'" />
				</div>
				<div>
				    <p> Schedule a trip: </p>
				    <input type="button" value="Trips" onclick="window.location.href='trips.php'" />
			    </div>
			</form>
		</div>
	</div>
	<script>
		// Check if a cookie named "visitCountHome" exists
		if(document.cookie.split(';').some((item) => item.trim().startsWith('visitCountHome='))) {
			var visitCountHome = parseInt(getCookie("visitCountHome")) + 1;
			document.cookie = "visitCountHome=" + visitCountHome + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
		} else {
  		document.cookie = "visitCountHome=1; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
		}
		function getCookie(name) {
  			var cookieArr = document.cookie.split(";");
			for (var i = 0; i < cookieArr.length; i++) {
    			var cookiePair = cookieArr[i].split("=");
				if (name == cookiePair[0].trim()) {
      				return decodeURIComponent(cookiePair[1]);
    			}
  		}
		return null;
		}
		document.getElementById("welcome-message").innerHTML = "You have visited Home page " + getCookie("visitCountHome") + " times.";
	</script>
</body>
</html>

