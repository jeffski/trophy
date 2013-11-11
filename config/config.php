<?php
// --------------------------------------------------------
// APPLICATION DETAILS ----------------------------------------
// ---------------------------------------------------------

// Site live domain name, should be the same as $_SERVER['SERVER_NAME']
$config['domain'] = 'localhost';

// Site Title/Name
$config['title'] = 'Win the Internet';

// Default home page template (splash, closed or enter)
$config['index'] = 'splash';

// Theme name/folder
$config['theme'] = 'bootstrap';

// ---------------------------------------------------------
// DATABASE DETAILS ----------------------------------------
// ---------------------------------------------------------

// Database details (LIVE)
$config['dbhost_live'] = 'localhost';
$config['dbname_live'] = 'competition';
$config['dbuser_live'] = 'root';
$config['dbpass_live'] = '';

// Database details (DEVELOPMENT)
$config['dbhost_local'] = 'localhost';
$config['dbname_local'] = 'competition';
$config['dbuser_local'] = 'root';
$config['dbpass_local'] = '';

// ---------------------------------------------------------
// FORM TO DATABASE DETAILS --------------------------------
// ---------------------------------------------------------

// Table to insert form data in to
$config['db_table'] = 'entries';

// Form fields you don't want inserted in the database - i.e. submit buttons, hidden form fields, etc...
// Enclose field names in single quotes ' and seperate by commas, i.e. 'button','hidden','action',...
$config['form_exclude_fields'] = array('submit', 'csrf_token', 'dob_mm', 'dob_yyyy');

// Required fields
// Enclose field names in single quotes ' and seperate by commas, i.e. 'name','email','phone',...
$config['validation'] = array(
    'rules' => array(
        'first_name' => 'required|alpha',
        'last_name' => 'required|alpha',
        'email' => 'required|valid_email',
        'street' => 'required|street_address',
        'suburb' => 'required',
        'state' => 'required|alpha',
        'postcode' => 'required|numeric',
        'terms' => 'required|boolean'
    ),
    'filters' => array(
        'first_name' => 'trim',
        'last_name' => 'trim',
        'email' => 'trim',
        'street' => 'trim',
        'suburb' => 'trim',
        'state' => 'trim',
        'postcode' => 'trim',
        'terms' => 'trim'
    )
);


// Thank you message
$config['message_text'] = "Thank you for entering the competition.";

// Generic Error message - may be accompanied by other error messages such as PHP, MySQL or form field validation message.
$config['error_generic_text'] = "Sorry, an error has occured.";

// Required message - a basic message telling the user to complete the required fields.
$config['error_required_text'] = "Please ensure all fields are completed, please <a href=javascript:history.go(-1);>go back</a> and fill out all of the form fields";

// ---------------------------------------------------------
// VALIDATION CHECK DETAILS --------------------------------
// ---------------------------------------------------------

// Barcodes
$config['check_barcode'] = FALSE;
$config['barcode_fields'] = array('barcode');
$config['barcodes'] = array('');

$config['barcode_msg'] = "Barcode value <b>%s</b> is not correct. Please <a href=javascript:history.go(-1);>go back</a> and try again.";

// Duplicates
$config['check_duplicates'] = TRUE;
$config['duplicates_fields'] = array('email');
$config['duplicates_delay'] = 24; // Hours until next entries allowed or NULL to disable
$config['duplicates_entries'] = 3; // Number of duplicates allowed
$config['duplicates_msg'] = "Only 3 entries per person is allowed per day. Please try again in 24 hours.";

// ---------------------------------------------------------
// SEND EMAIL CONFIRMATION --------------------------------
// ---------------------------------------------------------

// Send an email to the admin/owner
$config['admin_email_send'] = FALSE;
$config['admin_email_subject'] = "";
$config['admin_email_template'] = "";
$config['admin_email_address'] = "";

// TODO - Add option to send email to submitter

// ---------------------------------------------------------
// CSV DOWNLOADS -------------------------------------------
// ---------------------------------------------------------

// Password
$config['login_username'] = "admin";
$config['login_password'] = "j4n1s3a7";

// Table to get data from
// As Above - $db_table

// Database columns to output in CSV file or use * for all
$config['db_columns'] = "*";

// CSV field seperator, normally a comma (,) but tab (\t), semi colon (;) and pipe are  (|) are also common
$config['csv_delimeter'] = ",";

// Line break characters, \n, \r or \r\n (Windows)
$config['csv_newline'] = "\r\n";

// Character to enclose fields, can be left blank or use \" or \'. creates values like "Jeff", "Shillitto", ...
$config['csv_enclose'] = "\"";
?>