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
$filename = '';

$shortopts = "hf:d:";
#$longopts = array(
#    "help",
#    "directory::",
#    "filename::",
#);

#$options = getopt($shortopts, $longopts);
$options = getopt($shortopts);

if (array_key_exists('d',$options)) $directory = $options['d'];
if (array_key_exists('f',$options)) $filename = $options['f'];
if (array_key_exists('h',$options)) {
    print "usage -d=<path> -f=<name> [-h]\n";
    exit;
}

if (!isset($argv)) {
    $argv = array();
}


print "\n\n";
print "######################################################################\n";
print "Load 311 data: \n";
print "  Input:  $directory/$filename\n";
print "######################################################################\n";

$options = array('directory' => $directory, 'filename' => $filename);

define('DOING_AJAX', true);

class do_311_load {

	var $item_ref2term_id = array();

	public function main($options) {

        global $wpdb;

		$filename = $options['directory'] . '/' . $options['filename'];

		$importor = new load_311_data($filename);

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


require(dirname(__FILE__).'/excel_reader2.php');


$importer = new do_311_load();
$importer->main($options);

// testdata
// 311_Data_for_At_Risk_Buildings-2013-05-24.xls
// 311_Data_for_At_Risk_Buildings-2013-05-31.xls


class load_311_data {

	var $address_line_2_pattern = '/([\s\w]+),\s(\w+)\s([-\d]+)/';
	//var $longitude_latitude_pattern = '/\( ([-\.\d]+), ([-\.\d]+)\)/';
	var $longitude_latitude_pattern = '/\(([-\.\d]+), ([-\.\d]+)\)/';
	var $error_msg = '';

	var $headings = array(
			'CASE_ID',
			'NAME',
			'CASE_SUMMARY',
			'CREATION_DATE',
			'CLOSED_DATE',
			'RC_STATUS',
			'ADDRESS',
			'POSTAL',
			'PIN',
			'XCOORDINATE',
			'YCOORDINATE',
		);

	function  __construct ( $file_name ) {
		

		$data = new Spreadsheet_Excel_Reader( $file_name, true);	
		
		if (!empty($data->error_message)) {
			echo "Error: " . $data->error_message;
		} else {
			if ( $records = $this->extract_data($data) ) {
				if ( $ret = $this->load_records($records) ) {

				} else {

				};
			} else {
				echo "Error: " . $this->error_msg . "\n";;
			}
		}
	}


	function load_records($records) {

		global $wpdb;				// http://codex.wordpress.org/Class_Reference/wpdb
		$wpdb->show_errors();

		foreach ( $records AS $record ) {
			if ( $this->case_id_does_not_exist ( $record['311_case_id'] ) ) {
				if ( $wpdb->insert( 'wp_properties', $record ) ) {
					print "Case ID " . $record['311_case_id'] . " added\n";
				} else {
					print "ERROR was not able to save Case ID " . $record['311_case_id'] . "\n";
				}
			} else {
				if ( $wpdb->update ( 'wp_properties', $record , array ( '311_case_id' => $record['311_case_id'])) ) {
					print "Case ID " . $record['311_case_id'] . " updated\n";
				} else {
					print "ERROR was not able to update Case ID " . $record['311_case_id'] . "\n";
				}
			}
		}

	}


	function case_id_does_not_exist($case_id) {

		global $wpdb;
		$wpdb->show_errors();

		$sql = "SELECT COUNT(*) AS cnt FROM wp_properties WHERE `311_case_id` = '$case_id';";

		$ret = $wpdb->get_results( $sql );

		return ! ( $ret[0]->cnt );

	}


	function update_311_record($record) {

		global $wpdb;
		$wpdb->show_errors();

		$sql = "SELECT id AS cnt FROM wp_properties WHERE `311_case_id` = '$case_id';";

		$ret = $wpdb->get_results( $sql );
		$id = $ret[0]->cnt ;

		return ! ( $ret[0]->cnt );

	}


	function extract_data($ssdata) {

		if (  $this->headers_are_not_valid( $ssdata ) ) {
				return false;
		}

		$records = array();

		$max_rows = $ssdata->rowcount(0);

		for ($i = 2; $i <= $max_rows; $i++) {
			$c = 1;

			$validation_errors = array();
			$data = array();
			
			$data['311_case_id'] = trim($ssdata->val($i,$c++));

			$data['hash'] = md5($data['311_case_id']);

			$data['311_name'] = trim($ssdata->val($i,$c++));
			$data['311_case_summary'] = trim($ssdata->val($i,$c++));
			$data['311_creation_date'] = trim($ssdata->val($i,$c++));
			$data['311_close_date'] = trim($ssdata->val($i,$c++));
			$data['311_status'] = trim($ssdata->val($i,$c++));
			$data['311_address'] = trim($ssdata->val($i,$c++));
			$data['311_postal'] = trim($ssdata->val($i,$c++));
			$data['311_pin'] = trim($ssdata->val($i,$c++));
			$data['311_xcoordinate'] = trim($ssdata->val($i,$c++));
			$data['311_ycoordinate'] = trim($ssdata->val($i,$c++));

			$lines = preg_split('/\n/',$data['311_address']);

			$data['address_line_1'] = $lines[0];
			list ( $data['city'], $data['state'], $data['zip'] ) = $this->get_city_state_zip( $lines[1] );
			list ( $data['longitude'], $data['latitude'] ) = $this->get_longitude_latitude( $lines[2] );

			$records[] = $data;

		}
		
		return $records;

	}

	/**
	 * Split out the city, state and zip from a line
    * Input is in the format of 
    *    City Name, Statename ZIP  
    * Example
    *    Kansas City, Missouri 64116
    **/
	function get_city_state_zip ( $line ) {

		if (	preg_match ( $this->address_line_2_pattern, $line, $parts ) ) {

			$address_city = $parts[1];
			$address_state = $parts[2];
			$address_zip = $parts[3];

		} else {

			$address_city = '';
			$address_state = '';
			$address_zip = '';
			
			$validation_errors[] = "Address was not in City, State ZIP format";

		}

		return array( $address_city, $address_state, $address_zip );

	}

	/**
	 * Split out Longitude and Latitude from the last address line
    * Input 
    * Example
    *   (39.089550000332395, -94.53919999997987)
	 */

	function get_longitude_latitude ( $line ) {

		if (	preg_match ( $this->longitude_latitude_pattern, $line, $parts ) ) {

			$longitude = $parts[1];
			$latitude = $parts[2];

		} else {

			$longitude = '';
			$latitude = '';
			
			$validation_errors[] = "Longitude and/or latitude was not valide";

		}

		return array( $longitude, $latitude );
		
	}

	function headers_are_not_valid ( $ssdata ) {
		$miss = false;
		for ($c = 1; $c < 12; $c++) {
			$col_heading = $ssdata->val(1,$c);
			if ( $col_heading != $this->headings[$c-1] ) {
				$miss = true;
				break;
			}
		}

		if ( $miss ) {
			print "Error: Column's $c heading does not match, we expected '" . $col_heading . "' and got '" . $this->headings[$c-1] . "'.";
			$this->error_msg = "Error: Column's $c heading does not match, we expected '" . $col_heading . "' and got '" . $this->headings[$c-1] . "'.";
			return true;
		}

		return false;

	}

}



