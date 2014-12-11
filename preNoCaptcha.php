<?php
	/*
		noCaptcha reCpatcha from google, see: https://www.google.com/recaptcha/intro/index.html
		
		This preHook is needed to generate the field for noCaptcha and call the script
		It needs the chunk nocaptcha_tpl to be created from the nocaptcha_tpl.html
		
		usage: [[!FormIt? &preHooks=`preNoCaptcha` &ncTheme=`light|dark` &ncName=`other name for placeholder` &ncType=`image|audio` &forceFallback=`0|1` ]]
		
	*/
	
	//initial variables
	$output;
	$placeholders;
	$site_key = $modx->getOption('formit.recaptcha_public_key', null, '');
	$theme = $modx->getOption('ncTheme', $scriptProperties, 'light');
	$phName = $modx->getOption('ncName', $scriptProperties, 'nocaptcha');
	$forceFallback = $modx->getOption('forceFallback', $scriptProperties, 0);
	//used when fallback to captcha
	$ncType = $modx->getOption('ncType', $scriptProperties, 'image');
	
	if(!empty($site_key)){
		//check for force fallback
		if($forceFallback==1){
			$fallback = '?fallback=true';
		}else{
			$fallback = '';
		}
		//set array for placeholders
		$placeholders = array(
	    	'site_key' => $site_key,
	    	'theme' => $theme,
	    	'type' => $ncType,
	    	'fallback' => $fallback
		);
		//get generated chunk
		$output = $modx->getChunk('nocaptcha_tpl', $placeholders);	
	}else{
		//display error on form
		$output = '<pre>No public or site key given for system-setting formit.recaptcha_public_key</pre>';
	}
	
	//output to placeholder
	$modx->setPlaceholder($phName,$output);
	
	return true;
?>