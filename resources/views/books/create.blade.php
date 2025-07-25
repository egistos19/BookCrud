@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="h3">Yeni Kitap Ekle</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 ">
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control col-5" placeholder='Kitap Adı' />
        </div>

        <label for="author_id">Yazar Seç</label>
        <select name="author_id" id="author_id" class="form-control col-5">
            <option value="">-- Seçiniz --</option>
            @foreach ($authors as $author)
                <option value="{{ $author->id }}" 
                    {{ old('author_id', optional($book ?? null)->author_id) == $author->id ? 'selected' : '' }}>
                    {{ $author->name }}
                </option>
            @endforeach
        </select>
        <!-- search bar techniqe
            <input list="authors" name="author_id" class="form-control col-5">
            <datalist id="authors">
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </datalist>
        -->        
        <div class="form-group mt-2">
            <label for="new_author">Yeni Yazar Ekle (Eğer listede yoksa)</label>
            <input type="text" name="new_author" id="new_author" class="form-control col-5" value="{{ old('new_author') }}" placeholder="Yeni yazar adı">
            <small class="form-text text-muted">Listede yoksa buraya yeni bir yazar adı girin.</small>
        </div>

        <div class="form-group mt-3">
            <label >Yeni Kitapçı ekle</label><br>
            @foreach($bookstores as $store)
                <input type="checkbox" name="bookstores[]"  value="{{ $store->id }}" id="store-{{ $store->id }}" class="form-control" {{ (isset($book) && $book->bookstores->contains($store->id)) ? 'checked' : '' }}>
                <label for="store-{{ $store->id }}" class="form-check-label">{{ $store->name }}</label>
            @endforeach                
        </div>
        
        <div class="mb-3">
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required class="form-control col-5" placeholder='ISBN'/>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Kapak Görseli (jpg, jpeg, png)</label>
            <input type="file" name="cover_image" id="cover_image" accept=".jpg,.jpeg,.png" class="form-control col-3" />
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
