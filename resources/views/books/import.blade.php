@extends('layouts.app')

@section('content')
<div class="container mt-4">
        <h2 class="mb-4 h3">Bulk Import</h2><br>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('authors.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Excel/CSV Dosyası</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Yükle</button>
    </form>
</div>

@endsection
