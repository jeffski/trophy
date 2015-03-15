<?php
namespace Trophy\Validation;

use Trophy\Config\Config;
use Trophy\Database\Database;

class Duplicate
{
    public function check($fields, $entries = 1, $hours = NULL)
    {
        $config = Config::getConfig();
        $db = Database::getDB($config);

        $db_fields = "";
        $form_fields = "";

        // Fields to check
        foreach ($fields as $field) {
            $db_fields .= $field . ", ";
            $form_fields .= $field . ' = ' . sprintf("'%s'", $this->sanitise($_POST[$field])) . ' AND ';
        }

        $db_fields = substr($db_fields, 0, -2);
        $form_fields = substr($form_fields, 0, -5);

        // Check if duplicate date period has past
        if ($hours && $hours > 0) {
            $form_fields .= sprintf(" AND NOW() <= DATE_ADD(date_time, INTERVAL %d HOUR)", $hours);
        }

        $sql = sprintf("SELECT COUNT(entry_id) AS records FROM " . $this->sanitise($config->db_table) . " WHERE %s;", $form_fields);

        $result = $db->read($sql);

        // False - duplicates not found - check passed, True - duplicates found - check failed
        return ($result[0]['records'] <= $entries) ? false : true;
    }


    // TODO: Repeated code - move to Database or Util class
    // Repeated in Form
    private function sanitise($input)
    {
        $value = $input; // trim($this->_xxs_cleanup($input));

        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        //check if this function exists
        if (function_exists("mysql_real_escape_string")) {
            $value = mysql_real_escape_string($value);
        } else {
            $value = addslashes($value);
        }

        return $value;
    }
}
