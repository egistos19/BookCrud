@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Kitap Detayları</h2>

    <div class="card" style="width: 18rem;">
        @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="Kapak">
        @endif

        <div class="card-body">
            <h5 class="card-title">{{ $book->name }}</h5>
            <p class="card-text"><strong>Yazar:</strong> {{ $book->author }}</p>
            <p class="card-text"><strong>ISBN:</strong> {{ $book->isbn }}</p>

            @auth
                <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Düzenle</a>

                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Silmek istediğine emin misin?')" class="btn btn-danger">Sil</button>
                </form>
            @endauth

            <a href="{{ route('books.index') }}" class="btn btn-secondary">Geri Dön</a>
        </div>
    </div>
</div>
@endsection
