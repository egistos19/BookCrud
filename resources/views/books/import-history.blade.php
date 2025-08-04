@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 h3">Bulk Import Geçmişi</h2>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dosya Adı</th>
                <th>Durum</th>
                <th>Yüklenme Tarihi</th>
                <th>Güncellenme Tarihi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($histories as $history)
                <tr>
                    <td>{{ $history->id }}</td>
                    <td>{{ basename($history->filename) }}</td>
                    <td>
                        @if ($history->status === 'completed')
                            <span class="badge bg-success">Tamamlandı</span>
                        @elseif ($history->status === 'processing')
                            <span class="badge bg-warning text-dark">İşleniyor</span>
                        @else
                            <span class="badge bg-danger">Hata</span>
                        @endif
                    </td>
                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $history->updated_at->format('d.m.Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Kayıt yok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $histories->links() }}
</div>
@endsection
