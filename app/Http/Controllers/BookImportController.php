<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportHistory;
use App\Jobs\ImportAuthorJob;
use App\Enums\ImportStatus;

class BookImportController extends Controller
{
    public function showImportForm()
    {
        return view('books.import');
    }

    public function importAuthors(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $uploadedFile = $request->file('file');
        $filename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($uploadedFile->getClientOriginalExtension());

        if (!in_array($extension, ['csv', 'xls', 'xlsx'])) {
            return back()->withErrors(['file' => 'Sadece CSV veya Excel dosyaları yükleyebilirsiniz.']);
        }

        $path = $uploadedFile->storeAs('author-imports', $filename . '.' . $extension);

        $history = ImportHistory::create([
            'filename' => basename($path),
            'status' => ImportStatus::Uploaded,
        ]);

        ImportAuthorJob::dispatch($path, $history->id);

        return redirect()->back()->with('success', 'Yazarların içe aktarılması başlatıldı.');
    }

    public function importHistory()
    {
        $histories = ImportHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('books.import-history', compact('histories'));
    }
}
