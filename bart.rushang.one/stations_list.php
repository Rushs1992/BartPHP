<!DOCTYPE html>
<html>
<head>
    <title>Bart Station List</title>
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
        #infobutton {
            display: inline-block;
            padding: 15px 25px;
            font-size: 12px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: black;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }
        #infobutton:hover {background-color: #3e8e41}
        #infobutton:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
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

            <h1>Here is the list of bart stations</h1>
            <form>
                <input type="button" value="Home" onclick="window.location.href='index.php'" />
                <input type="button" value="Trips" onclick="window.location.href='trip_info.html'" />
            </form>
            <br>
            <table id="stationTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Navigate</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const stationXml = 'get_stations.php';

        async function fetchXML(file){
            const response = await fetch(file);
            const text = await response.text();
            const parser = new DOMParser();
            const jsonData = parser.parseFromString(text, "application/xml");
            return jsonData;
        }

        async function displayStations(){
            const stationList = await fetchXML(stationXml);
            const stations = stationList.getElementsByTagName('station');
            const displayTable = document.querySelector('#stationTable tbody');

            for(let i = 0; i < stations.length; i++){

                const station = stations[i];
                const trow = document.createElement('tr');

                const stationName = document.createElement('td');
                stationName.textContent = station.getElementsByTagName('name')[0].textContent;
                trow.appendChild(stationName);

                const stationLocation = document.createElement('td');
                const address = station.getElementsByTagName('address')[0].textContent;
                const city = station.getElementsByTagName('city')[0].textContent;
                const county = station.getElementsByTagName('county')[0].textContent;
                const state = station.getElementsByTagName('state')[0].textContent;
                const zipcode = station.getElementsByTagName('zipcode')[0].textContent;
                stationLocation.textContent = address.concat(",",city,",",county,",",state," ", zipcode);
                trow.appendChild(stationLocation);

                const buttonCell = document.createElement('td');
                const button = document.createElement('button');
                button.textContent = "Get more info";
                button.value = station.getElementsByTagName('abbr')[0].textContent;
                button.id = 'infobutton';
                trow.appendChild(button);

                displayTable.appendChild(trow);

                button.addEventListener('click', function(){
                    const abbr = this.value;
                    console.log('Button click for ' + abbr);
                    window.location.href = 'new_station.php?selectedAbbr='+abbr;
                });
            }
        }

        displayStations();
    </script>
</body>
</html>
