<?php
$url = 'https://api.bart.gov/api/stn.aspx?cmd=stns&key=MW9S-E7SL-26DU-VV8V';
$xml = file_get_contents($url);
header('Content-Type: application/xml');
echo $xml;
?>
