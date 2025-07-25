@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="h3">Kitap Düzenleme</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kitap Adı</label>
            <input type="text" name="name" class="form-control col-5" value="{{ old('name', $book->name) }}" required>
        </div>
        <div class="form-group">
            <label for="author_id">Yazar Seç</label>
            <input list="authors" name="author_id" id="author_id" class="form-control col-5">
                <datalist id="authors">
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </datalist>            
        </div>

        <div class="form-group mt-2">
            <label for="new_author">Yeni Yazar Ekle (Eğer listede yoksa)</label>
            <input type="text" name="new_author" id="new_author" class="form-control col-5" value="{{ old('new_author') }}" placeholder="Yeni yazar adı">
            <small class="form-text text-muted">Listede yoksa buraya yeni bir yazar adı girin.</small>
        </div>

        <!-- Yazar ayari bas-->
        <script>
            const authorIdInput = document.getElementById('author_id');
            const authorNameInput = document.getElementById('new_author');

            authorIdInput.addEventListener('input', function () {
                if (authorIdInput.value.trim() !== '') {
                    authorNameInput.disabled = true;
                } else {
                    authorNameInput.disabled = false;
                }
            });

            authorNameInput.addEventListener('input', function () {
                if (authorNameInput.value.trim() !== '') {
                    authorIdInput.disabled = true;
                } else {
                    authorIdInput.disabled = false;
                }
            });
        </script>
        <!-- Yazar ayari son -->


        <div class="form-group mt-3">
            <label >Yeni Kitapçı ekle</label><br>
            @foreach($bookstores as $store)
                <input type="checkbox" name="bookstores[]"  value="{{ $store->id }}" id="store-{{ $store->id }}" class="form-control" {{ (isset($book) && $book->bookstores->contains($store->id)) ? 'checked' : '' }}>
                <label for="store-{{ $store->id }}" class="form-check-label">{{ $store->name }}</label>
            @endforeach                
        </div>        

        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control col-5" value="{{ old('isbn', $book->isbn) }}" required>
        </div>

        <div class="form-group">
            <label>Kapak Görseli</label>
            @if ($book->cover_image)
                <div class="mb-2">
                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('storage/default/book.png') }}" alt="Kapak" width="100">
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
