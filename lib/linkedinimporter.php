<?php

namespace Irune\Plugins\CVMaker;
use \LinkedIn\LinkedIn as LinkedIn;
class LinkedinImporter
{
	var $liConnection;
	
	function __construct($config)
	{
		$this->liConnection = new LinkedIn($config);	
		echo "Done";
		$url = $this->liConnection->getLoginUrl(
				array(
						LinkedIn::SCOPE_BASIC_PROFILE,
						LinkedIn::SCOPE_EMAIL_ADDRESS
				)
				);
		echo "Done2";
		echo $url;exit;
	}
}