<?php

require_once("oauth-php/library/OAuthStore.php");
require_once("oauth-php/library/OAuthRequester.php");

class slyLOGIN {

	public static function config($config) {
		session_start();
		if (isset($_REQUEST['logout'])) {
			if (@$config['onLogout']) @$config['onLogout']();
            header("Location: ".$_SERVER['PHP_SELF']);
            die();
        }
		if (!(isset($_GET['oauth_token']) || (isset($_REQUEST['email']) && isset($_REQUEST['password'])))) return;
		$options = Array(
		    'consumer_key' => $config['key'],
		    'consumer_secret' => $config['secret'],
		    'server_uri' => 'http://api.slysolutions.ch',
		    'request_token_uri' => 'http://api.slysolutions.ch/request_token.php',
		    'authorize_uri' => 'http://api.slysolutions.ch/authorize.php',
		    'access_token_uri' => 'http://api.slysolutions.ch/access_token.php'
		);
		OAuthStore::instance('Session', $options);
		if (!isset($_GET['oauth_token'])) {
    			try {
        			$tokenResultParams = OauthRequester::requestRequestToken($options['consumer_key'], 1);
    			} catch(Exception $err) {
        			header("Location: ".$_SERVER['PHP_SELF']."?loginFailed");
					die();
    			}
			$r = Array();
			foreach($_REQUEST as $key => $val) {
				$r[] = $key."=".$val;
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $options['authorize_uri']);
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "oauth_token=".$tokenResultParams['token']."&oauth_callback=".urlencode("http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'])."&".implode("&", $r));
			$res = @curl_exec($ch);
			curl_close($ch);
			if (preg_match("/Content-Length:\s*0\s+/mi", $res) && preg_match("/Location:\s*([^? ]+\?oauth_token=([0-9a-f]+)&oauth_verifier=([0-9a-f]+))/mi", $res, $match)) {
				$oauth_token = $match[2];
				$oauth_verifier = $match[3];
				header("Location: ".$match[1]);
				die();
			} else {
				header("Location: ".$_SERVER['PHP_SELF']."?loginFailed");
				die();
			}
		}
		else {
    			$oauthToken = $_GET['oauth_token'];
    			$tokenResultParams = $_GET;
    			OAuthRequester::requestAccessToken($options['consumer_key'], $_GET['oauth_token'], 1, 'POST', $_GET);
    			$request = new OAuthRequester('http://api.slysolutions.ch/test_request.php', 'GET', $_GET);
    			$result = $request->doRequest(0);
    			if ($result['code'] == 200 && @$config['onLogin']) {
					@$config['onLogin'](json_decode($result['body']));
				}
       			header("Location: ".$_SERVER['PHP_SELF']);
        		die();
		}
	}
}

