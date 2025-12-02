@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Sửa phim: {{ $movie->title }}</h1>

    <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <!-- Giống create.blade.php, chỉ thay required thành optional cho poster nếu muốn -->
        <div class="mb-3">
            <label>Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $movie->title) }}" required>
        </div>

        <div class="mb-3">
            <label>Giới thiệu <span class="text-danger">*</span></label>
            <textarea name="intro" rows="5" class="form-control" required>{{ old('intro', $movie->intro) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Ảnh bìa hiện tại:</label><br>
            <img src="{{ $movie->poster }}" width="200" class="img-thumbnail"><br><br>
            <label>Thay ảnh mới <span class="text-danger">*</span></label>
            <input type="file" name="poster" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label>Ngày công chiếu <span class="text-danger">*</span></label>
            <input type="date" name="release_date" class="form-control" value="{{ old('release_date', $movie->release_date->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label>Thể loại <span class="text-danger">*</span></label>
            <select name="genre_id" class="form-select" required>
                @foreach($genres as $g)
                    <option value="{{ $g->id }}" {{ old('genre_id', $movie->genre_id) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-warning btn-lg">Cập nhật</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary btn-lg">Hủy</a>
    </form>
</div>
@endsection