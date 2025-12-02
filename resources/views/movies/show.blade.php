@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ $movie->title }}</h1>
    
    <div class="row">
        <div class="col-md-4">
            <img src="{{ $movie->poster ?: 'https://via.placeholder.com/300x450' }}" class="img-fluid rounded">
        </div>
        <div class="col-md-8">
            <p><strong>Thể loại:</strong> <span class="badge bg-success fs-6">{{ $movie->genre->name }}</span></p>
            <p><strong>Ngày công chiếu:</strong> {{ $movie->release_date->format('d/m/Y') }}</p>
            <p><strong>Giới thiệu:</strong></p>
            <p>{{ $movie->intro }}</p>
            
            <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-warning">Sửa</a>
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
</div>
@endsection