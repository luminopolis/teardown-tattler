#!/usr/bin/php
<?php
error_reporting(E_ALL); 
ini_set('display_errors', '1');

// From http://plugins.svn.wordpress.org/disqus-comment-system/trunk/lib/wp-cli.php
/**
 * Helper script for setting up the WP command line environment
 */
//error_reporting(E_ALL | E_STRICT);

if (php_sapi_name() != 'cli' && !empty($_SERVER['REMOTE_ADDR'])) {
    // Don't execute for web requests
    die("This script must be run from CLI.");
}

/**
 * Process command line options
 */
$directory = "/tmp";
$altkey = false;

$shortopts = "h";
#$longopts = array(
#    "help",
#);

#$options = getopt($shortopts, $longopts);
$options = getopt($shortopts);

if ( array_key_exists('h',$options)) {
    print "usage  [-h]\n";
    exit;
}

if (!isset($argv)) {
    $argv = array();
}


print "\n\n";
print "######################################################################\n";
print " Email notifications to users: \n";
print "######################################################################\n";


define('DOING_AJAX', true);

class do_email_notifications {

	public function main($options) {

		$importor = new email_notifications();

	}

}

define('WP_USE_THEMES', false);


// The following is from http://vocecommunications.com/blog/2011/03/running-wordpress-from-command-line/

//setup global $_SERVER variables to keep WP from trying to redirect
$_SERVER = array(
  "HTTP_HOST" => "http://teardowntattler.localhost",
  "SERVER_NAME" => "http://teardowntattler.localhost",
  "REQUEST_URI" => "/",
  "REQUEST_METHOD" => "GET"
);

//require the WP bootstrap
require_once(dirname(__FILE__).'/wp-load.php');


$doit = new do_email_notifications();
$doit->main($options);

// testdata
// 311_Data_for_At_Risk_Buildings-2013-05-24.xls
// 311_Data_for_At_Risk_Buildings-2013-05-31.xls


class email_notifications {


	function  __construct (  ) {

				$this->mark_new_311_records_not_sent();
	}


	function mark_new_311_records_not_sent() {

      global $wpdb;
      $wpdb->show_errors();

		$wpdb->update(
			'wp_properties',				// table
			array( 'status' => 0 ),		// data to change
			array( 'status' => 1 )		// where clauses
		);
		
	}


}



