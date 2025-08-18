<?php

namespace App\Services\BulkImport\Handlers;

use App\Models\Author;
use Illuminate\Support\Facades\DB;

class ProcessAuthorsHandler extends BaseHandler
{
    protected function process(array $data): array
    {
        $rows = $data['rows'] ?? [];

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                $name = trim($row[0] ?? '');
                if ($name) {
                    Author::firstOrCreate(['name' => $name]);
                }
            }
        });

        return $data;
    }
}
