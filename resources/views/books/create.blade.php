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

        <div class="mb-3">
            <input type="text" name="author" id="author" value="{{ old('author') }}" required class="form-control col-5" placeholder='Yazar'/>
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
