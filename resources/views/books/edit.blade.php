@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="h3">Kitap Düzenleme</h2>

    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kitap Adı</label>
            <input type="text" name="name" class="form-control col-5" value="{{ old('name', $book->name) }}" required>
        </div>

        <div class="form-group">
            <label>Yazar</label>
            <input type="text" name="author" class="form-control col-5" value="{{ old('author', $book->author) }}" required>
        </div>

        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control col-5" value="{{ old('isbn', $book->isbn) }}" required>
        </div>

        <div class="form-group">
            <label>Kapak Görseli</label>
            @if ($book->cover_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Kapak" width="100">
                        <div class="form-check">
                            <input type="checkbox" name="remove_cover_image" id="remove_cover_image" class="form-check-input">
                            <label for="remove_cover_image" class="form-check-label">Fotoğrafı Kaldır</label>
                        </div>
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
