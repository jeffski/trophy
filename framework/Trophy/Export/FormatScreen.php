<?php 
namespace Trophy\Export;

class FormatScreen implements IExport 
{
    /**
     * Export
     *
     * Get the fields and data, export as HTML table
     *
     * @param array $fields
     * @param array $data
     */
    public function export($fields, $data)
    {
        echo '<table border="1" cellpadding="5" cellspacing="0"><thead><tr>';

        foreach ($fields as $field)
        {
            echo '<td>' . $field . '</td>';
        }
        echo '</thead></tr><tbody>';

        foreach($data as $value)
        {
            echo '<tr>';
            foreach($fields as $field)
            {
                echo '<td>' . $value[$field] . '</td>';
            }
            echo '<tr>';
        }
        echo '</tbody></table>';
    } 
}