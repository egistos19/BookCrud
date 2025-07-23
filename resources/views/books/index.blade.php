@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 h3">Kitap Listesi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @auth
        <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Kitap Ekle</a>
    @endauth

    <div class="row">
        @forelse ($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('storage/default/book.png') }}" class="card-img-top" style="height: 300px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="card-title">{{ $book->name }}</h5>
                        <p class="card-text">Yazar: {{ $book->author }}</p>
                        <p class="card-text">ISBN: {{ $book->isbn }}</p>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm">Detay</a>
                        @auth
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-outline-secondary btn-sm">Düzenle</a>

                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">Sil</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Henüz kitap eklenmemiş.</p>
        @endforelse
    </div>
</div>
@endsection

