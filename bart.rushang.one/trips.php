<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - Trip</title>
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
            <div id="source-station">
                <p> Source Station: </p>
                <select id = "source-list">
                    <option value = "select">Select a station ... </option>
                </select>
                <br>
            </div>
            <div id="destination-station">
                <p> Destination Station: </p>
                <select id = "dest-list" disabled>
                    <option value = "select">Select a station ... </option>
                </select>
                <br>
            </div>
            <div>
                <br>
                <button id = "get-trip-info" disabled>Submit</button>
            </div>
        </div>
    </div>
    <script>
        let sourceSelected = false;
        let destinationSelected = false;
        let submitButton = document.getElementById('get-trip-info');
        let sourceAbbr = '';
        let destinationAbbr = '';

        document.addEventListener('DOMContentLoaded', async function(){

            const stationXML = 'get_stations.php';

            async function fetchXMLData(file){
                const response = await fetch(file);
                const text = await response.text();
                const parser = new DOMParser();
                const jsonData = parser.parseFromString(text, "application/xml");
                return jsonData;
            }

            async function displayStationList(){
                const stationList = await fetchXMLData(stationXML);
                const stations = stationList.getElementsByTagName('station');
                const sourceDropdown = document.getElementById('source-list');
                const destDropdown = document.getElementById('dest-list');

                for(let i = 0; i < stations.length; i++){

                    var station = stations[i];
                    let sourceOption = document.createElement('option');
                    let destinationOption = document.createElement('option');

                    stationName = station.getElementsByTagName('name')[0].textContent;
                    stationAbbr = station.getElementsByTagName('abbr')[0].textContent;

                    sourceOption.textContent = stationName;
                    sourceOption.value = stationAbbr;

                    destinationOption.textContent = stationName;
                    destinationOption.value = stationAbbr;

                    sourceDropdown.appendChild(sourceOption);
                    destDropdown.appendChild(destinationOption);
                }
            }
            displayStationList();

            const sourceStation = document.querySelector('#source-list');
            sourceStation.addEventListener("change", function(){
                sourceAbbr= this.value;
                console.log(sourceAbbr);
                let destinationDropdown = document.getElementById('dest-list');
                sourceSelected = true;
                destinationDropdown.disabled = false;
            });
        });


        const destinationStation = document.querySelector('#dest-list');
        destinationStation.addEventListener("change", function(){
            destinationAbbr = this.value;
            console.log(destinationAbbr);
            destinationSelected = true;
            if((sourceSelected) && (destinationSelected)){
                submitButton.disabled = false;
            }
        });

        submitButton.addEventListener('click', function(){
            window.location.href = 'new_schedule.php?sourceAbbr=' + sourceAbbr + '&destAbbr=' + destinationAbbr;
        });

    </script>
</body>
</html>