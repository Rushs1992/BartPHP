<?php
    $SourceAbbr =  $_GET['sourceAbbr'];
    $DestAbbr = $_GET['destAbbr'];

    $sourceStation = '&orig=' . $SourceAbbr;
    $destinationStation = '&dest=' . $DestAbbr;

    $url = 'https://api.bart.gov/api/sched.aspx?cmd=depart&date=now&&b=0&a=1&key=MW9S-E7SL-26DU-VV8V&json=y' . $sourceStation . $destinationStation;

    $xml = file_get_contents($url);
    $json = json_encode($xml);
    $json = str_replace("'","",$xml);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Schedule</title>
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

        .fares{
            display: block;
            padding-right: 50px;
        }

        .timer{
            display: flex;
            margin: auto;
        }

        .timer span{
            display: block;
            background: #000;
            color: #fff;
            margin-right: 5px;
            padding: 8px;
            border-radius: 5px;
            font-size: 45px;
            line-height: normal;
            text-align: center;

        }

        #hours:after, #minutes:after, #seconds:after {
            font-size: 14px;
            line-height: normal;
            display: block;
            width: inherit;
            margin-top: 10px;
            color: #5C5757;
            text-align: center;
        }

        #hours:after{
            content: "Hours";
        }

        #minutes:after{
            content: "Minutes";
        }

        #seconds:after{
            content: "Seconds";
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
            <p id = "start-time"></p>
            <p id = "end-time"></p>
            <p id = "total-time"></p>
            <p>Fare inforamtion in dollars<p>
            <div id = 'fares' class = "fares">
                <p id = "regular"></p>
                <p id = "start"></p>
                <p id = "seniorDisabled"></p>
                <p id = "youth"></p>
            </div>
            <br>
            <p>Countdown Timer</p>
            <div class = "timer">
                <span id = 'hours'>00</span>
                <span id = 'minutes'>00</span>
                <span id = 'seconds'>00</span>
            </div>
        </div>
    </div>
    <script>
    const stationNameAndAbbr = {};

    let schedule = '<?php echo $json ?>';
    async function getSchedule(){
        let tripWithoutSymbol = schedule.replace(/@/g,'att-');
        let cString = tripWithoutSymbol.replace(/[\n\r]/g,"").toString();
        const jsonData = JSON.parse(cString);
        return jsonData.root.schedule.request.trip;
    }


    async function displaySchedule(){
        let schdl = await getSchedule();
        console.log(schdl);
        let scheduleJson = "";
        if(Array.isArray(schdl)){
            scheduleJson = schdl[0];
        } else {
            scheduleJson = schdl;
        }

        let originTime = scheduleJson['att-origTimeMin'];
        document.getElementById('start-time').innerHTML = "Train departs at : " +originTime;
        let destinationTime = scheduleJson['att-destTimeMin'];
        document.getElementById('end-time').innerHTML = "Train will arrive destination at : " + destinationTime;
        let totalTripTime = scheduleJson['att-tripTime'];
        document.getElementById('total-time').innerHTML = "Total trip time : " + totalTripTime + "minutes";
        console.log(scheduleJson.fares);
        let regularFare = scheduleJson.fares.fare[0]['att-amount'];
        document.getElementById('regular').innerHTML = "Clipper: " + regularFare;
        let startFare = scheduleJson.fares.fare[1]['att-amount'];
        document.getElementById('start').innerHTML = "Clipper START: " + startFare;
        let seniorDisabledFare = scheduleJson.fares.fare[2]['att-amount'];
        document.getElementById('seniorDisabled').innerHTML = "Senior/Disabled Clipper: " + seniorDisabledFare;
        let youthFare = scheduleJson.fares.fare[3]['att-amount'];
        document.getElementById('youth').innerHTML = "Youth Clipper: " + youthFare;

        let origDateAndTime = scheduleJson['att-origTimeDate'] + " " + scheduleJson['att-origTimeMin'];

        let origStart = new Date(origDateAndTime).getTime();
        console.log(origStart);
        const timer = setInterval(function(){

            const currentTime = new Date().getTime();

            const difference = origStart - currentTime;
            if(difference > 0){

                const minutes = Math.floor((difference % (1000*60*60)) / (1000*60));
                console.log(minutes);
                const seconds = Math.floor((difference % (1000*60) / 1000));
                console.log(seconds);

                document.getElementById('minutes').innerHTML = minutes.toString();
                document.getElementById('seconds').innerHTML = seconds.toString();
            }
        }, 1000);
    }

    displaySchedule();

    const updates = setInterval(displaySchedule(),30000);

</script>
</body>
</html>