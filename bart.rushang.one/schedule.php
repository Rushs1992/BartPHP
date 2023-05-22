<?php
    $SourceAbbr =  $_GET['sourceAbbr'];
    $DestAbbr = $_GET['destAbbr'];

    $sourceStation = '&orig=' . $SourceAbbr;
    $destinationStation = '&dest=' . $DestAbbr;

    $url = 'https://api.bart.gov/api/sched.aspx?cmd=depart&date=now&&b=0&a=1&key=MW9S-E7SL-26DU-VV8V&json=y' . $sourceStation . $destinationStation;

    $xml = file_get_contents($url);
    $json = json_encode($xml);
?>