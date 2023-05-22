<?php
    $selectedAbbr = '2';
    if (isset($_GET['selectedAbbr'])) {
        $selectedAbbr = $_GET['selectedAbbr'];
    }
    else {
            $selectedAbbr = '12TH';
    }
    $url = 'https://api.bart.gov/api/stn.aspx?cmd=stninfo&key=MW9S-E7SL-26DU-VV8V&orig=' . $selectedAbbr;
    $xmlData = file_get_contents($url);
    $xmlData = str_replace("'","\\'", $xmlData);
    $xmlData = addslashes($xmlData);
?>
<!DOCTYPE html>
<html>
<head>
    <title id = "tab-title">Bart Station List</title>
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
            <p>Welcome to Rushang\'s sub domain of bart. This web server uses bart's public api's to curate the output. We can call it light-weight bart website</p>
        </div>
        <div class = "copyright">
            <p>The image is is reused under licensing from https://commons.wikimedia.org/wiki/File:Bart-logo.svg</p>
        </div>
		<div class = "border-line">
		</div>
        <div class = "page-content">
            <h1>Station information :</h1>
            <h2 id = "station-name"></h2>
            <br>
            <p id = "station-intro"></p>
            <br>
            <p id = "station-location"></p>
            <br>
            <p id = "cross-street"></p>
            <br>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded',async function(){
            const data = '<?php echo $xmlData ?>';
            console.log(data);
            async function fetchXML(file){
                const parser = new DOMParser();
                const jsonData = parser.parseFromString(file.replace(/'/g,"\''"), "application/xml");
                return jsonData;
            }

            async function displayData(){
                const stationJSON = await fetchXML(data);
                const stations = stationJSON.getElementsByTagName('station');

                for(let i = 0; i < stations.length; i++){
                    //Get station
                    const station = stations[i];
                    //Get station name
                    const stationName = station.getElementsByTagName('name')[0].textContent;
                    document.getElementById('station-name').innerHTML = stationName;
                    //Get station intro
                    const stationIntro = station.getElementsByTagName('intro')[0].textContent;
                    document.getElementById('station-intro').innerHTML = stationIntro;
                    //Get station location
                    const address = station.getElementsByTagName('address')[0].textContent;
                    const city = station.getElementsByTagName('city')[0].textContent;
                    const county = station.getElementsByTagName('county')[0].textContent;
                    const state = station.getElementsByTagName('state')[0].textContent;
                    const zipcode = station.getElementsByTagName('zipcode')[0].textContent;
                    const stationLocation = address.concat(", ",city,", ",county,", ",state," ", zipcode);
                    document.getElementById('station-location').innerHTML = stationLocation;
                    //Get cross street info
                    const crossStreet = station.getElementsByTagName('cross_street')[0].textContent;
                    document.getElementById('cross-street').innerHTML = crossStreet;
                }
            }

            displayData();
        });
    </script>
</body>
</html>