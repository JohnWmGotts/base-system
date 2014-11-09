<?php 
class Configuration
{
	// For a full list of configuration parameters refer in wiki page (https://github.com/paypal/sdk-core-php/wiki/Configuring-the-SDK)
	public static function getConfig()
	{
		$config = array(
				// values: 'sandbox' for testing
				//		   'live' for production
				"mode" => "sandbox"

				// These values are defaulted in SDK. If you want to override default values, uncomment it and add your value.
				// "http.ConnectionTimeOut" => "5000",
				// "http.Retry" => "2",
			);
		return $config;
	}

	// Creates a configuration array containing credentials and other required configuration parameters.
	public static function getAcctAndConfig()
	{
		$modeconfig = self::getConfig();
		if ($modeconfig['mode'] == 'sandbox') {
			$config = array(
					// CR Sandbox
					"acct1.UserName" => "developer_api1.crowdedrocket.com",
					"acct1.Password" => "NCXWTU5VWA2GTB3U",
					"acct1.Signature" => "AkUBj7fCpYI6FdSHQSlytehd.GM-AODzrJy1jp1mamZoM0TTAOm2ik.4",
					"acct1.AppId" => "APP-80W284485P519543T"				
					);
		} else {
			$config = array(
					// *********** REPLACE WITH LIVE VALUES **************
					"acct1.UserName" => "developer_api1.crowdedrocket.com",
					"acct1.Password" => "NCXWTU5VWA2GTB3U",
					"acct1.Signature" => "AkUBj7fCpYI6FdSHQSlytehd.GM-AODzrJy1jp1mamZoM0TTAOm2ik.4",
					"acct1.AppId" => "APP-80W284485P519543T"				
					);
		}

		return array_merge($config, self::getConfig());;
	}

}