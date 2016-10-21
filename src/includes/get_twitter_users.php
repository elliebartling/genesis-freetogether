<?php

// echo "Working?";



require_once('TwitterAPIExchange.php');

$settings = array(
'oauth_access_token' => "288363689-6qYx65goXJtL72cY3FAHHcOXLoXDlvNhAHuUtxYQ",
'oauth_access_token_secret' => "PW8eOow2gI0BeCDbacFqAwEKkVqoEe44Uu5Y5n6hOpMsd",
'consumer_key' => "aOdD72fNKDI29xrglNPqJXQb9",
'consumer_secret' => "Isxx49ON9nhic2RwOGt76izOTC4U75esPiEyRYUIKFW0ArpRf1"
);

$user = "AFF";

$url = "https://api.twitter.com/1.1/users/lookup.json";

$requestMethod = "GET";

$getfield = '?screen_name=' . $user;


$twitter = new TwitterAPIExchange($settings);

$partner = $twitter->setGetfield($getfield)
	             ->buildOauth($url, $requestMethod)
	             ->performRequest();

echo $partner;
// return $partner;



?>