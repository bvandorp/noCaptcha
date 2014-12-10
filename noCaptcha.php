<?php
	/*
		noCaptcha reCpatcha from google, see: https://www.google.com/recaptcha/intro/index.html
		
		This hook is needed to verify and validate the user submitted answer
		
		usage: [[!FormIt? &hooks=`noCaptcha`]]
	*/
	
	//initial variables
	$secret_key = $modx->getOption('formit.recaptcha_private_key', $scriptProperties, '');
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$response_string = $hook->getValue('g-recaptcha-response');
	$result;
	
	
	//checks for errors
	if(empty($secret_key)){
		$hook->addError('nocaptcha','No secret or private key given for system-setting formit.recaptcha_private_key.');
		return false;
	}
	if(empty($response_string)){
		$hook->addError('nocaptcha','No value was submitted for the captcha.');
		return false;
	}
	
	//urlencode vars
	$secret_key = urlencode($secret_key);
	$user_ip = urlencode($user_ip);
	$response_string = urlencode($response_string);
	
	//check for validation via cURL
	$curl = curl_init();
	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$response_string.'&remoteip='.$user_ip
	));
	
	//get results
	$result = curl_exec($curl);
	
	//close request
	curl_close($curl);
	
	//if $result is not false
	if($result){
		$resultObject = json_decode($result);
		if($resultObject->success){
			//success
			return true;
		}else{
			//errorCode to error handeling
			foreach($resultObject->error-codes as $errorCode){
				switch($errorCode){
					case 'missing-input-secret':
						$hook->addError('nocaptcha','The secret parameter is missing.');
						break;
					case 'invalid-input-secret':
						$hook->addError('nocaptcha','The secret parameter is invalid or malformed.');
						break;
					case 'missing-input-response':
						$hook->addError('nocaptcha','The response parameter is missing.');
						break;
					case 'invalid-input-response':
						$hook->addError('nocaptcha','The response parameter is invalid or malformed.');
						break;
					default:
						$hook->addError('nocaptcha','Unknown error: '.$errorCode);
						break;
				}
				return false;
			}
		}
	}else{
		$hook->addError('nocaptcha','There was an error executing your request');
		return false;
	}
	
?>