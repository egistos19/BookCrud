<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\ImportHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ImportAuthorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $importRecord;

    public function __construct($filePath, ImportHistory $importRecord)
    {
        $this->filePath = $filePath;
        $this->importRecord = $importRecord;
    }

    public function handle()
    {
        try {
            $fullPath = Storage::path($this->filePath);
            $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

            $authors = [];

            if (in_array($extension, ['csv', 'txt']) ) {
                $data = array_map('str_getcsv', file($fullPath));
                unset($data[0]);

                foreach ($data as $row) {
                    $name = trim($row[0] ?? '');
                    if ($name) {
                        $authors[] = $name;
                    }
                }

            } elseif (in_array($extension, ['xlsx', 'xls'])) {
                $rows = \Maatwebsite\Excel\Facades\Excel::toCollection(null, $fullPath)[0];

                foreach ($rows as $index => $row) {
                    if ($index === 0 && strtolower($row[0]) === 'yazar') {
                        continue;
                    }

                    $name = trim($row[0] ?? '');
                    if ($name) {
                        $authors[] = $name;
                    }
                }
            } else {
                throw new \Exception("Desteklenmeyen dosya türü: .$extension");
            }

            foreach ($authors as $name) {
                \App\Models\Author::firstOrCreate(['name' => $name]);
            }

            $this->importRecord->update(['status' => 'completed']);
        } catch (\Throwable $e) {
            Log::error('Author import error: ' . $e->getMessage());
            $this->importRecord->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
