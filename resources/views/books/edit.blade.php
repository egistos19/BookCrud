@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kitap Düzenle</h2>

    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kitap Adı</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $book->name) }}" required>
        </div>

        <div class="form-group">
            <label>Yazar</label>
            <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" required>
        </div>

        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}" required>
        </div>

        <div class="form-group">
            <label>Kapak Görseli</label>
            @if ($book->cover_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Kapak" width="100">
                </div>
            @endif
            <input type="file" name="cover_image" class="form-control-file" accept=".jpg,.jpeg,.png">
            <small class="form-text text-muted">Yeni kapak görseli yüklemek istersen seçebilirsin.</small>
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
