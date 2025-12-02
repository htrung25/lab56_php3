@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Thêm phim mới</h1>

    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Giới thiệu <span class="text-danger">*</span></label>
            <textarea name="intro" rows="5" class="form-control @error('intro') is-invalid @enderror" required>{{ old('intro') }}</textarea>
            @error('intro') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Ảnh bìa <span class="text-danger">*</span></label>
            <input type="file" name="poster" class="form-control @error('poster') is-invalid @enderror" accept="image/*" required>
            @error('poster') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Ngày công chiếu <span class="text-danger">*</span></label>
            <input type="date" name="release_date" class="form-control @error('release_date') is-invalid @enderror" value="{{ old('release_date') }}" required>
            @error('release_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Thể loại <span class="text-danger">*</span></label>
            <select name="genre_id" class="form-select @error('genre_id') is-invalid @enderror" required>
                <option value="">-- Chọn thể loại --</option>
                @foreach($genres as $g)
                    <option value="{{ $g->id }}" {{ old('genre_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                @endforeach
            </select>
            @error('genre_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success btn-lg">Thêm phim</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary btn-lg">Hủy</a>
    </form>
</div>
@endsection