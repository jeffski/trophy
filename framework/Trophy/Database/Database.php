<?php
namespace Trophy\Database;

class Database
{

    private static $instance; //store the single instance of the database

    private function __construct($config)
    {
        if ($config->domain == $_SERVER['SERVER_NAME'] || substr(strstr($config->domain, '.'), 1) == $_SERVER['SERVER_NAME']) {
            $connection = mysql_connect($config->dbhost_live, $config->dbuser_live, $config->dbpass_live) or die (mysql_error());
            $database = $config->dbname_live;
        } else {
            $connection = mysql_connect($config->dbhost_local, $config->dbuser_local, $config->dbpass_local) or die (mysql_error());
            $database = $config->dbname_local;
        }

        $db = mysql_select_db($database, $connection) or die(mysql_error());
    }

    /**
     * Get DB
     * 
     * Connect to database
     */
    public static function getDB($config)
    {
        if (!self::$instance) {
            self::$instance = new Database($config);
        }

        return self::$instance;
    }

    /**
     * Query
     * 
     * Run an SQL Query against the database
     */
    public function query($query)
    {
        $sql = mysql_query($query) or die(mysql_error());

        return $sql;
    }

    /**
     * Read 
     * 
     * Get the data from the table and return as array 
     *
     * @param string $query
     *
     * @return array
     */
    public function read($query)
    {
        $data = array();
        $resource = $this->query($query);

        while ($row = mysql_fetch_array($resource, MYSQL_ASSOC)) {
            foreach ($row as $key => $value) {
                $temp[$key] = $value;
            }
            array_push($data, $temp);
        }

        return $data;
    }

    /**
     * Fields
     *
     * Return the list of fields as array
     *
     * @param string $query
     *
     * @return array
     */
    public function fields($query)
    {
        $fields = array();
        $resource = $this->query($query);
        $index = 0;

        while ($index < mysql_num_fields($resource)) {
            $field = mysql_fetch_field($resource, $index);
            array_push($fields, $field->name);
            $index++;
        }

        return $fields;
    }
}
