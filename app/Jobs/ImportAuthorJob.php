<?php

namespace App\Jobs;

use App\Services\BulkImport\Handlers\ReadFileHandler;
use App\Services\BulkImport\Handlers\ProcessAuthorsHandler;
use App\Services\BulkImport\Handlers\UpdateHistoryHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ImportHistory;
use App\Enums\ImportStatus;
use Illuminate\Support\Facades\Log;

class ImportAuthorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $filePath;
    protected int $historyId;

    public function __construct(string $filePath, int $historyId)
    {
        $this->filePath = $filePath;
        $this->historyId = $historyId;
    }

    public function handle(): void
    {
        $history = ImportHistory::find($this->historyId);

        if (!$history || $history->status !== ImportStatus::Uploaded) {
            Log::warning("Import job skipped: Record not found or not in 'uploaded' status.");
            return;
        }

        try {
            Log::info("Import job started: history_id={$this->historyId}");

            $handler = new ReadFileHandler();
            $handler
                ->setNext(new ProcessAuthorsHandler())
                ->setNext(new UpdateHistoryHandler());

            $handler->handle([
                'file_path' => $this->filePath,
                'history_id' => $this->historyId,
            ]);

        } catch (\Throwable $e) {
            Log::error("ImportAuthorJob error: " . $e->getMessage());

            $history->update([
                'status' => ImportStatus::Failed,
            ]);
        }
    }
}
