<?php

define('FILE_UPLOAD_DIRECTORY','./testdata/');
// testdata
// 311_Data_for_At_Risk_Buildings-2013-05-24.xls
// 311_Data_for_At_Risk_Buildings-2013-05-31.xls

		require('excel_reader2.php');

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
		
		echo "Processing " . FILE_UPLOAD_DIRECTORY . "$file_name\n";

		$data = new Spreadsheet_Excel_Reader(FILE_UPLOAD_DIRECTORY . $file_name, true);	
		
		if (!empty($data->error_message)) {
			echo "Error: " . $data->error_message;
		} else {

			if ( $this->extract_data($data) ) {

			} else {
				echo "Error: " . $this->error_msg . "\n";;
			}
		}
	}


	function extract_data($ssdata) {

		if (  $this->headers_are_not_valid( $ssdata ) ) {
				return false;
		}
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

		   print_r($data); die;

		}
		
		return true;

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


	$x = new load_311_data('311_Data_for_At_Risk_Buildings-2013-05-24.xls');
