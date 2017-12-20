#!/usr/bin/php
<?php

$url = 'https://api.fda.gov/food/enforcement.json?search=product_type:food&limit=1';



$retVal = json_decode($url, TRUE);

for ($x=0; $x < count($json); x++) {
	echo $reVal[$x]['openfda:']['product_description']."<br>/";
}

?>

