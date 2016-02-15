<?php

require_once('twitter_proxy.php');

// Twitter OAuth Config options
$oauth_access_token = '288363689-6qYx65goXJtL72cY3FAHHcOXLoXDlvNhAHuUtxYQ';
$oauth_access_token_secret = 'PW8eOow2gI0BeCDbacFqAwEKkVqoEe44Uu5Y5n6hOpMsd';
$consumer_key = 'aOdD72fNKDI29xrglNPqJXQb9';
$consumer_secret = 'Isxx49ON9nhic2RwOGt76izOTC4U75esPiEyRYUIKFW0ArpRf1';
$user_id = '78884300';
$screen_name = 'AFF';
$count = 5;
$twitter_url = 'users/show.json';
// $twitter_url .= '?user_id=' . $user_id;
$twitter_url .= '?screen_name=' . $screen_name;
// $twitter_url .= '&count=' . $count;
// Create a Twitter Proxy object from our twitter_proxy.php class
$twitter_proxy = new TwitterProxy(
	$oauth_access_token,			// 'Access token' on https://apps.twitter.com
	$oauth_access_token_secret,		// 'Access token secret' on https://apps.twitter.com
	$consumer_key,					// 'API key' on https://apps.twitter.com
	$consumer_secret,				// 'API secret' on https://apps.twitter.com
	// $user_id,						// User id (http://gettwitterid.com/)
	$screen_name					// Twitter handle
	// $count							// The number of tweets to pull out
);
// Invoke the get method to retrieve results via a cURL request
$tweets = $twitter_proxy->get($twitter_url);
echo $tweets;

?>