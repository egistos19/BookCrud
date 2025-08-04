<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportHistory;
use App\Jobs\ImportAuthorJob;

class BookImportController extends Controller
{
    public function showImportForm()
    {
        return view('books.import');
    }

    public function importAuthors(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls,txt|max:2048',
        ]);

        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->storeAs('author-imports', $filename);

        $history = ImportHistory::create([
            'filename' => basename($path),
            'status' => 'processing',
        ]);

        \App\Jobs\ImportAuthorJob::dispatch($path, $history);

        return redirect()->back()->with('success', 'Yazarların içe aktarılması başlatıldı.');
    }
    public function importHistory()
    {
        $histories = ImportHistory::orderBy('created_at', 'desc')->paginate(10);
         return view('books.import-history', compact('histories'));
    }

}

