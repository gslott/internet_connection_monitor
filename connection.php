<?php

date_default_timezone_set('CET');

echo "Connection test\n";

$success = 0;

//List of hosts to try to connect to
$hosts = array(
		"http://www.gunnarslott.se",
		"http://www.svt.se",
		"http://www.dn.se",
		"http://www.aftonbladet.se"

	);

//Iterate at try each host
foreach ($hosts as &$url_string) {

	//Call test method with URL as argument
	$result = urlExists($url_string);

	//Summon all successful connection tests
	if ($result == true) {
		//echo " - Connection\n";
		$success = $success + 1;

	} //else echo " - No Connection\n";

}

//If no connection test succeded the intenet connection is supposed to be broken
//and a logfile is created or updated in case of existance
if ($success == 0){

	//echo "Total Failure, writing to file\n";

	$file = 'faild_connections.csv';
	$error_message = date('Y-m-d , H:i:s') . " , Total failure to connect\n";
	file_put_contents($file, $error_message, FILE_APPEND | LOCK_EX);

}

//echo "Number of connections: " . $success . "\n";

function urlExists($url)  
{  
	echo $url;
    if($url == NULL) return false;  
    
    $ch = curl_init($url);  
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    $data = curl_exec($ch);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
    curl_close($ch);

    echo $httpcode;
    if($httpcode>=200 && $httpcode<300){  
        return true;  
    } else {  
        return false;  
    }  
}
 
?>