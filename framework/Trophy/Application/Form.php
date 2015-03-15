<?php
namespace Trophy\Application;

use Trophy\Config\Config;
use Trophy\Database\Database;
use NoCSRF;
use Trophy\Validation\Validator;
use Trophy\Validation\Duplicate;

/**
 * Class Form
 * @package Trophy\Application
 */
class Form
{

    protected $config;
    protected $validationRules;

    public function __construct()
    {
        $this->config = Config::getConfig();
    }

    /**
     * Save Form
     * Process the form input and save to database
     *
     * @param array $data   Form post
     *
     * @return array
     */
    public function save($data)
    {
        $errorMessages = array();

        // CSRF Check
        try {
            NoCSRF::check('csrf_token', $_POST, true, 60 * 10, false);
        } catch (\Exception $e) {
            array_push($errorMessages, $e->getMessage());
        }

        // Check for duplicates
        if ($this->config->check_duplicates) {
            $duplicate = new Duplicate;
            $duplicates = $duplicate->check(
                $this->config->duplicates_fields,
                $this->config->duplicates_entries,
                $this->config->duplicates_delay
            );

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
    public function export()
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
    private function escape($input)
    {
        $value = $input;
        //$value = trim($this->_xxs_cleanup($input));

        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        //check if this function exists
        if (function_exists("mysql_real_escape_string")) {
            $value = mysql_real_escape_string($value);
        } else { //for PHP version < 4.3.0 use addslashes
            $value = addslashes($value);
        }
        return $value;
    }
}
