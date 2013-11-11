<?php 
namespace Trophy\Export;

use Trophy\Config\Config;

class FormatCSV implements IExport 
{
    private $delimeter;
    private $newline;
    private $enclose;
    private $table;

    public function __construct()
    {
        $config = Config::getConfig();
        $this->delimeter = $config->csv_delimeter;
        $this->newline = $config->csv_newline;
        $this->enclose = $config->csv_enclose;
        $this->table = $config->db_table;
    }

    /**
     * Export
     *
     * Get the fields and data, export as CSV
     *
     * @param array $fields
     * @param array $data
     */
    public function export($fields, $data)
    {
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=".$this->table.".csv");
        header("Content-Transfer-Encoding: ascii");

        $fields_name = implode($fields, $this->enclose . $this->delimeter . $this->enclose);
        echo $this->enclose . $fields_name . $this->enclose . $this->newline;

        foreach($data as $value)
        {
            $row = implode($value, $this->enclose . $this->delimeter . $this->enclose);
            echo $this->enclose . $row . $this->enclose . $this->newline;
        }
    } 
}