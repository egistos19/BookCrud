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
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use App\Enums\ImportStatus;
use Throwable;

class ImportAuthorJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $filePath;
    protected $importHistoryId;

    public function __construct($filePath, $importHistoryId)
    {
        $this->filePath = $filePath;
        $this->importHistoryId = $importHistoryId;
    }

    public function handle()
    {
        $importRecord = \App\Models\ImportHistory::find($this->importHistoryId);

        if (!$importRecord || $importRecord->status !== ImportStatus::Uploaded) {
            Log::warning("Import job skipped: Record not found or not in 'uploaded' status.");
            return;
        }

        try {
            $fullPath = Storage::path($this->filePath);
            $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

            $authors = [];

            if ($extension === 'csv') {
                $data = array_map('str_getcsv', file($fullPath));
                unset($data[0]);

                foreach ($data as $row) {
                    $name = trim($row[0] ?? '');
                    if ($name) {
                        $authors[] = $name;
                    }
                }

            } elseif (in_array($extension, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($fullPath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

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

            DB::transaction(function () use ($authors) {
                foreach ($authors as $name) {
                    Author::firstOrCreate(['name' => $name]);
                }
            });

            $importRecord->update(['status' => ImportStatus::Completed]);
        } catch (\Throwable $e) {
            Log::error('Author import error: ' . $e->getMessage());
            $importRecord->update([
                'status' => ImportStatus::Failed,
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
