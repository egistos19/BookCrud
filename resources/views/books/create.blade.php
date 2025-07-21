@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Yeni Kitap Ekle</h1>

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

        <div class="mb-3">
            <label for="name" class="form-label">Kitap Adı *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control" />
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Yazar *</label>
            <input type="text" name="author" id="author" value="{{ old('author') }}" required class="form-control" />
        </div>

        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN *</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required class="form-control" />
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Kapak Görseli (jpg, jpeg, png)</label>
            <input type="file" name="cover_image" id="cover_image" accept=".jpg,.jpeg,.png" class="form-control" />
        </div>

        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
