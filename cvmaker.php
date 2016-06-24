<?php
/**
 * Plugin Name: CV Builder
* Description: Import and Display features for CVs from LinkedIn 
* Version: 1.0
* Author: Irune
*/

// autoloading classes placed inside 'lib/' directory
spl_autoload_register(function($class) {
	//project specific namespace prefix
	$prefix = 'Irune\\Plugins\\CVMaker\\';

	//base directory for the namespace prefix
	$base_dir = __DIR__ . '/lib/';
	//error_log('debug: base dir: '. $base_dir, 0);//debug
	//does the class use the namespace prefix
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		//error_log('debug: prefix did not match',0);//debug
		return;
	}

	//get the relative class name
	$relative_class = substr($class, $len);

	// replace the namespace prefix with base direcrory,
	// replace namespace separators with directory separators
	// in the relative class name, append with .php
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
	//error_log('debug: namespace matched, relative class ' . $relative_class . ' and file ' . $file, 0);//debug
	// if the fies exists, require it
	if (file_exists($file)) {
		//error_log('debug: file loaded ' . $file, 0);//debug
		require $file;
	}
});

	function cvmaker_init()
	{
		$feeds = new \Irune\Plugins\CVMaker\Setup();
	}

	add_action('init', 'cvmaker_init');


	/** FEED TESTING, DISABLE FEED CACHE FOR TEST
	 function return_cache_time( $seconds ){

	 // change the default feed cache recreation period to 60 seconds

	 return (int) 5;

	 }
	 //set feed cache duration
	 add_filter( 'wp_feed_cache_transient_lifetime', 'return_cache_time');

	 */