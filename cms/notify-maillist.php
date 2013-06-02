#!/usr/bin/php
<?php
error_reporting(E_ALL); 
ini_set('display_errors', '1');
require(dirname(__FILE__).'/mandrill/config.php');
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

		if ( $properties = $this->get_new_311_records() ) {
			if ( $users = $this->get_users() ) {
				$this->email_notifications( $users, $properties );
				$this->mark_new_311_records_sent();
			}
		}		
	}

	function get_new_311_records() {
      global $wpdb;
      $wpdb->show_errors();

      $sql = "SELECT * FROM wp_properties WHERE `status` = 0;";
      $records = $wpdb->get_results( $sql );

		foreach ( $records AS $i => $record ) {
			$records[$i] = get_object_vars( $records[$i] ) ;
		}

		return $records;
	}

	function get_users() {

      global $wpdb;
      $wpdb->show_errors();

		$users = array();

		$user_query = new WP_User_Query( array( '1' => '1' ) );

		// User Loop
		if ( ! empty( $user_query->results ) ) {
			foreach ( $user_query->results as $user ) {
				$users[] = array(
					'name' => $user->data->display_name,
					'email' => $user->data->user_email

				);
			}
		} else {
			return false;
		}

		return $users;

	}


	function email_notifications( &$users, &$properties ) {

		print_r($properties);
		print_r($users);
        $from = "Teardown Tattler <no-reply@teardowntattler.com>";
        $subject = "Teardown Tattler Alert!";

        $html=<<<EOF

                                        <table>
                                        <TR>

                                            <td>Address</td>
                                            <td>City</td>
                                            <td>State</td>
                                            <td>Zip</td>
                                            <td>Case ID</td>
                                            <td>Summary</td>
                                            <td>Status</td>

                                        </TR>
EOF;
        foreach($properties as $property){
            $property_case_id=$property['311_case_id'];
            $property_summary=$property['311_case_summary'];
            $property_status = $property['311_status'];
            $property_address=$property['address_line_1'];
            $property_city=$property['city'];
            $property_state=$property['state'];
            $property_zip=$property['zip'];

            $html.=<<<EOF

                                        <TR>
                                            <TD>
                                            $property_address
                                            </TD>
                                            <TD>
                                            $property_city
                                            </td>
                                            <td>
                                            $property_state
                                            </td>
                                            <td>
                                            $property_zip
                                            </td>
                                            <TD>
                                            $property_case_id
                                            </TD>
                                            <TD>
                                            $property_summary
                                            </TD>
                                            <td>
                                            $property_status
                                            </td>
                                      </tr>

EOF;
        }
        $html.="</table>";




        $html = str_replace(array("\n", "\t", "\r"), '', $html);
        //send emails
        foreach($users as $user){
            $sender = "Teardown Tattler <no-reply@teardowntattler.com>";                              // Your name and email address
            $recipient = $user['email'];
            $recipient_name = $user['name'];// The Recipients name and email address
            $subject = "Teardown Tattler Alert(s) for ".date("m.d.y");                                            // Subject for the email

            $uri = 'https://mandrillapp.com/api/1.0/messages/send.json';

            $postString = '{
            "key": "'.kA0Y2X1N9EOKBKe8FaI04Q.'",
            "message": {
                "html": "'.$html.'",
                "text": "Text version available in 2.0",
                "subject": "'.$subject.'",
                "from_email": "no-reply@teardowntattler.com",
                "from_name": "Teardown Tattler Notifications",
                "to": [
                    {
                        "email": "'.$recipient.'",
                        "name": "'.$recipient_name.'"
                    }
                ],
                "headers": {

                },
                "track_opens": true,
                "track_clicks": true,
                "auto_text": true,
                "url_strip_qs": true,
                "preserve_recipients": true,

                "merge": true,
                "global_merge_vars": [

                ],
                "merge_vars": [

                ],
                "tags": ["teardown tattler"

                ],
                "google_analytics_domains": [

                ],
                "google_analytics_campaign": "...",
                "metadata": [

                ],
                "recipient_metadata": [

                ],
                "attachments": [

                ]
            },
            "async": false
            }';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uri);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

            $result = curl_exec($ch);
        }

     }


	function mark_new_311_records_sent() {

      global $wpdb;
      $wpdb->show_errors();

		$wpdb->update(
			'wp_properties',				// table
			array( 'status' => 1 ),		// data to change
			array( 'status' => 0 )		// where clauses
		);
		
	}


}



