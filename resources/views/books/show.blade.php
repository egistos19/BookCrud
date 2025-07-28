@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class='h3'>Kitap Detayları</h2>

    <div class="card" style="width: 18rem;">

        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('storage/default/book.png') }}" class="card-img-top" alt="Kapak">

        <div class="card-body">
            <h5 class="card-title h5">{{ $book->name }}</h5>
            <p class="card-text"><strong>Yazar:</strong> {{  $book->author ? $book->author->name : 'Yazar belirtilmemiş' }}</p>
            <p class="card-text"><strong>Kitapçılar:</strong> 
                            @if ($book->bookstores->count())
                                {{ $book->bookstores->pluck('name')->join(', ') }}
                            @else
                                Kitapçı belirtilmemiş
                            @endif</p>
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
