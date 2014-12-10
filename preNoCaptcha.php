<?php
	/*
		noCaptcha reCpatcha from google, see: https://www.google.com/recaptcha/intro/index.html
		
		This preHook is needed to generate the field for noCaptcha and call the script
		It needs the chunk nocaptcha_tpl to be created from the nocaptcha_tpl.html
		
		usage: [[!FormIt? &preHooks=`preNoCaptcha`]]
		
	*/
	
	//initial variables
	$output;
	$placeholders;
	$site_key = $modx->getOption('formit.recaptcha_public_key', $scriptProperties, '');
	$phName = $modx->getOption('phName', $scriptProperties, 'nocaptcha');
	
	if(!empty($site_key)){
		//set array for placeholders
		$placeholders = array(
	    	'site_key' => $site_key,
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