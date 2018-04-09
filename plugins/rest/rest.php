<?php
/*
 * Copyright (C) 2018 vagner
 *
 * This file is part of Kolibri.
 *
 * Kolibri is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kolibri is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kolibri. If not, see <http://www.gnu.org/licenses/>.
 */
class rest {
	private $dataArray = array ();
	private $callMethod;
	private $url;
	private $oauthData = array ();
	private $oauth_token = '';
	private $user_id = '';
	
	function setoauthToken($value) {
		$this->oauth_token = $value;
	}
	
	function setuserId($value) {
		$this->user_id = $value;
	}
	
	function setconsumer_key($value) {
		$this->oauthData ['consumer_key'] = $value;
	}
	function setconsumer_secret($value) {
		$this->oauthData ['consumer_secret'] = $value;
	}
	function setserver_uri($value) {
		$this->oauthData ['server_uri'] = $value;
	}
	function setrequest_token_uri($value) {
		$this->oauthData ['request_token_uri'] = $value;
	}
	function setauthorize_uri($value) {
		$this->oauthData ['authorize_uri'] = $value;
	}
	function setaccess_token_uri($value) {
		$this->oauthData ['access_token_uri'] = $value;
	}
	function __call($method, $value) {
		foreach ( $value as $v ) {
			if (isset ( $v )) {
				$out = $v;
			}
		}
		
		if (substr ( $method, 0, 3 ) == 'set') {
			$key = substr ( $method, 3 );
			$this->dataArray [$key] = $out;
		}
	}
	function seturl($url) {
		$this->url = $url;
	}
	function setcallGet() {
		$this->callMethod = 'GET';
	}
	function setcallPost() {
		$this->callMethod = 'POST';
	}
	function setcallPut() {
		$this->callMethod = 'PUT';
	}
	function setcallDelete() {
		$this->callMethod = 'DELETE';
	}
	private function curl($request = 'GET') {
		$service_url = $this->url;
		$curl = curl_init ( $service_url );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "$request" );
		$curl_response = curl_exec ( $curl );
		if (($request == 'POST') or ($request == "DELETE")) {
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $this->dataArray );
		}
		if ($request == 'PUT') {
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, http_build_query ( $this->dataArray ) );
		}
		$response = curl_exec ( $curl );
		if ($curl_response === false) {
			$info = curl_getinfo ( $curl );
			curl_close ( $curl );
			debug::log ( 'error occured during curl exec. Additioanl info: ' . var_export ( $info ) );
		}
		curl_close ( $curl );
		$decoded = json_decode ( $curl_response );
		if (isset ( $decoded->response->status ) && $decoded->response->status == 'ERROR') {
			debug::log ( 'error occured: ' . $decoded->response->errormessage );
		}
		debug::log ( 'response ok!' );
		return $decoded->response;
	}
	private function oauth($request = 'GET',$oauth_token='',$user_id='') {
		//$this->oauthData ['conn'] = database::kolibriDB ();
		OAuthStore::instance ( 'Session', $this->oauthData);
		if (empty($oauth_token)) {
			$tokenResultParams = OauthRequester::requestRequestToken( $this->oauthData['consumer_key'], $user_id);
			header('Location: ' . $options['authorize_uri'] .
					'?oauth_token=' . $tokenResultParams['token'] .
					'&oauth_callback=' . urlencode('http://' .
							$_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']));
		}else{
			// get an access token
			$oauthToken = $_GET['oauth_token'];
			$tokenResultParams = $_GET;
			OAuthRequester::requestAccessToken($options['consumer_key'],
					$tokenResultParams['oauth_token'], $id, 'POST', $_GET);
			$request = new OAuthRequester(OAUTH_HOST . '/test_request.php',
					'GET', $tokenResultParams);
			$result = $request->doRequest(0);
			if ($result['code'] == 200) {
				$decoded = json_decode($result['body']);
				return $decoded->response;
			}
			else {
				echo 'Error';
			}
		}
		
	}
	private function execGET() {
		$service_url = $this->url;
		$curl = curl_init ( $service_url );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		$curl_response = curl_exec ( $curl );
		if ($curl_response === false) {
			$info = curl_getinfo ( $curl );
			curl_close ( $curl );
			debug::log ( 'error occured during curl exec. Additioanl info: ' . var_export ( $info ) );
		}
		curl_close ( $curl );
		$decoded = json_decode ( $curl_response );
		if (isset ( $decoded->response->status ) && $decoded->response->status == 'ERROR') {
			debug::log ( 'error occured: ' . $decoded->response->errormessage );
		}
		echo 'response ok!';
		var_export ( $decoded->response );
	}
	private function execPOST() {
		$service_url = $this->url;
		$curl = curl_init ( $service_url );
		$curl_post_data = $this->dataArray;
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_POST, true );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $curl_post_data );
		$curl_response = curl_exec ( $curl );
		if ($curl_response === false) {
			$info = curl_getinfo ( $curl );
			curl_close ( $curl );
			debug::log ( 'error occured during curl exec. Additioanl info: ' . var_export ( $info ) );
		}
		curl_close ( $curl );
		$decoded = json_decode ( $curl_response );
		if (isset ( $decoded->response->status ) && $decoded->response->status == 'ERROR') {
			debug::log ( 'error occured: ' . $decoded->response->errormessage );
		}
		echo 'response ok!';
		var_export ( $decoded->response );
	}
	private function execPUT() {
		$service_url = $this->url;
		$ch = curl_init ( $service_url );
		
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
		$data = $this->dataArray;
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
		$response = curl_exec ( $ch );
		if ($response === false) {
			$info = curl_getinfo ( $ch );
			curl_close ( $ch );
			debug::log ( 'error occured during curl exec. Additioanl info: ' . var_export ( $info ) );
		}
		curl_close ( $ch );
		$decoded = json_decode ( $response );
		if (isset ( $decoded->response->status ) && $decoded->response->status == 'ERROR') {
			debug::log ( 'error occured: ' . $decoded->response->errormessage );
		}
		echo 'response ok!';
	}
	private function execDELETE() {
		$service_url = $this->url;
		$ch = curl_init ( $service_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
		$curl_post_data = $this->dataArray;
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $curl_post_data );
		$response = curl_exec ( $ch );
		if ($curl_response === false) {
			$info = curl_getinfo ( $curl );
			curl_close ( $curl );
			debug::log ( 'error occured during curl exec. Additioanl info: ' . var_export ( $info ) );
		}
		curl_close ( $curl );
		$decoded = json_decode ( $curl_response );
		if (isset ( $decoded->response->status ) && $decoded->response->status == 'ERROR') {
			debug::log ( 'error occured: ' . $decoded->response->errormessage );
		}
		echo 'response ok!';
		var_export ( $decoded->response );
	}
	function run() {
		
		if ( ! $this->oauth_token and ! $this->user_id ) {
			return $this->curl($this->callMethod);
		}else{
			return $this->oauth($this->callMethod,$this->oauth_token,$this->user_id);
		}
		
		//return $this->{'exec' . $this->callMethod} ();
	}
}