<?php
namespace Trophy\Application;

use Trophy\Config\Config;
use Trophy\Database\Database;
use NoCSRF;
use Trophy\Validation\Validator;
use Trophy\Validation\Duplicate;

class Form {

    protected $config;
    protected $validationRules;

    function __construct()
    {
        $this->config = Config::getConfig();
    }

    /**
     * Save Form
     * Process the form input and save to database
     *
     * @param array $data
     * @param string $table
     * @param array $exclude_fields
     * @return array
     */
    function save($data, $table, $exclude_fields)
    {
        $errorMessages = array();

        // CSRF Check
        try {
            NoCSRF::check( 'csrf_token', $_POST, true, 60*10, false );
        } catch ( \Exception $e ) {
            array_push($errorMessages, $e->getMessage());
        }

        // Check for duplicates
        if ($this->config->check_duplicates) {
            $duplicate = new Duplicate;
            $duplicates = $duplicate->check($this->config->duplicates_fields, $this->config->duplicates_entries, $this->config->duplicates_delay);

            if ($duplicates) {
                array_push($errorMessages, $this->config->duplicates_msg);
            }
        }

        // Validation using GUMP
        $validator = new Validator;

        $validator->validation_rules($this->config->validation['rules']);
        $validator->filter_rules($this->config->validation['filters']);

        $data = $validator->xss_clean($data);
        $data = $validator->sanitize($data);

        $validated_data = $validator->run($data);

        if ($validated_data === false) {
            $validationMessages = $validator->get_readable_errors(false);
            $errorMessages = array_merge($errorMessages, $validationMessages);
        }

        // Return errors if set
        if (!empty($errorMessages)) {
            return $errorMessages;
        }

        // Prepare SQL and insert in to database
        $db = Database::getDB($this->config);

        $fields = '';
        $values = '';

        foreach ($validated_data as $field_name => $submitted_value) {
            if (!in_array($field_name, $this->config->form_exclude_fields)) {
                $fields .= $this->escape($field_name) . ", ";
                $values .= "'" . $this->escape($submitted_value) . "', ";
            }
        }

        $sql = "INSERT INTO  " . $this->config->db_table . " (" . $fields . " date_time) VALUES (" . $values . " NOW());";
        $result = $db->query($sql);
    }


    // TODO: Move to Export class - should not be here
    function export()
    {
        $db = Database::getDB($this->config); 
        $sql = "SELECT " . $this->config->db_columns . " FROM " . $this->config->db_table;
        return $db->read($sql);
    }

    // TODO: Move to Export class - should not be here
    public function fields()
    {
        $db = Database::getDB($this->config); 
        $sql = "SELECT " . $this->config->db_columns . " FROM " . $this->config->db_table;
        return $db->fields($sql);
    }

    /**
     * Simple MySQL escape function
     *
     * @param $input
     * @return string
     */
    // TODO: Repeated code - move to Database or Util class
    // Repeated in Validator
    private function escape($input) {
        $value = $input;
        //$value = trim($this->_xxs_cleanup($input));

        if(get_magic_quotes_gpc()) {
            $value = stripslashes( $value );
        }
        //check if this function exists
        if(function_exists("mysql_real_escape_string")) {
            $value = mysql_real_escape_string($value);
        }
        //for PHP version < 4.3.0 use addslashes
        else {
            $value = addslashes($value);
        }
        return $value;
    }

    // TODO: Repeated code - move to Database or Util class
    // TODO: Deprectaed by GUMP
    // Repeated in Validator
/*    private function _xxs_cleanup($text)
    {
        $text = preg_replace(
            array(
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',
                // Add line breaks before and after blocks
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text );

        $text = strip_tags($text);
        $_Ary_TagsList = array('jav&#x0A;ascript:', 'jav&#x0D;ascript:', 'jav&#x09;ascript:', '<!-', '<', '>', '%3C', '&lt', '&lt;', '&LT', '&LT;', '&#60', '&#060', '&#0060', '&#00060', '&#000060', '&#0000060', '&#60;', '&#060;', '&#0060;', '&#00060;', '&#000060;', '&#0000060;', '&#x3c', '&#x03c', '&#x003c', '&#x0003c', '&#x00003c', '&#x000003c', '&#x3c;', '&#x03c;', '&#x003c;', '&#x0003c;', '&#x00003c;', '&#x000003c;', '&#X3c', '&#X03c', '&#X003c', '&#X0003c', '&#X00003c', '&#X000003c', '&#X3c;', '&#X03c;', '&#X003c;', '&#X0003c;', '&#X00003c;', '&#X000003c;', '&#x3C', '&#x03C', '&#x003C', '&#x0003C', '&#x00003C', '&#x000003C', '&#x3C;', '&#x03C;', '&#x003C;', '&#x0003C;', '&#x00003C;', '&#x000003C;', '&#X3C', '&#X03C', '&#X003C', '&#X0003C', '&#X00003C', '&#X000003C', '&#X3C;', '&#X03C;', '&#X003C;', '&#X0003C;', '&#X00003C;', '&#X000003C;', '\x3c', '\x3C', '\u003c', '\u003C', chr(60), chr(62));
        $text = @str_replace($_Ary_TagsList, '', $text);

        return((string)$text);
    }*/
}