<?php
    $Abbr = $_GET['Abbr'];
    $url = 'https://api.bart.gov/api/stn.aspx?cmd=stninfo&key=MW9S-E7SL-26DU-VV8V&orig=' . $Abbr;
    $xmlData = file_get_contents($url);
    header('Content-Type: application/xml');
    echo $xmlData;
?>