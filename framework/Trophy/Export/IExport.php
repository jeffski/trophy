<?php 
namespace Trophy\Export;

interface IExport
{
    public function export($fields, $data);
}
