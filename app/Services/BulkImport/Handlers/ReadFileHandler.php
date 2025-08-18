<?php

namespace App\Services\BulkImport\Handlers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class ReadFileHandler extends BaseHandler
{
    protected function process(array $data): array
    {
        $filePath = $data['file_path'];
        $fullPath = Storage::path($filePath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        $rows = [];

        if ($extension === 'csv') {
            $rows = array_map('str_getcsv', file($fullPath));
            unset($rows[0]);
        } elseif (in_array($extension, ['xls', 'xlsx'])) {
            $spreadsheet = IOFactory::load($fullPath);
            $rows = $spreadsheet->getActiveSheet()->toArray();
            unset($rows[0]);
        }

        $data['rows'] = $rows;
        return $data;
    }
}
