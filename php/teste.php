<?php
include "config.php";
phpinfo();
echo "/--------------------------------------------/";
echo "<br />";
$url = "config.php";
//var_dump($url);
$process = curl_init();
curl_setopt($process, CURLOPT_URL, $url);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($process, CURLOPT_TIMEOUT, 30);
$return = curl_exec($process);

echo $return;


?>