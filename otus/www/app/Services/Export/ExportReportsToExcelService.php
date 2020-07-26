<?php

namespace App\Services\Export;

use Illuminate\Support\Collection;


interface ExportReportsToExcelService
{
    /**
     * @param string $filename
     * @param Collection $collection
     * @param Collection $filesResponses
     * @return mixed
     */
    public function downloadExcel(string $filename, Collection $collection, Collection $filesResponses);
}
