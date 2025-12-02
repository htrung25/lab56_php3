@extends('layouts.app')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Danh sách phim</h1>
        <a href="{{ route('movies.create') }}" class="btn btn-primary btn-lg">
            Thêm phim mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('movies.index') }}" method="GET" class="mb-4">
        <div class="input-group input-group-lg shadow">
            <input type="text" 
                   name="q" 
                   class="form-control" 
                   placeholder="Nhập tên phim cần tìm..." 
                   value="{{ $search ?? '' }}" 
                   autofocus>
            <button type="submit" class="btn btn-success">
                Tìm kiếm
            </button>
            @if($search)
                <a href="{{ route('movies.index') }}" class="btn btn-secondary">
                    Xóa bộ lọc
                </a>
            @endif
        </div>
    </form>

    <!-- Thông báo kết quả tìm kiếm -->
    @if($search)
        <div class="alert alert-info">
            Đang hiển thị kết quả cho: <strong>"{{ $search }}"</strong>
            (Tìm thấy {{ $movies->total() }} phim)
            <a href="{{ route('movies.index') }}" class="float-end">Xem tất cả</a>
        </div>
    @endif

    <!-- Thông báo thành công -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Áp phích</th>
                            <th>Tiêu đề</th>
                            <th>Thể loại</th>
                            <th>Ngày chiếu</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movies as $movie)
                        <tr>
                            <td>{{ $movie->id }}</td>
                            <td>
                                <img src="{{ $movie->poster ?: 'https://via.placeholder.com/60x90?text=No+Img' }}"
                                     width="60" height="90" class="rounded" style="object-fit:cover">
                            </td>
                            <td><strong>{{ $movie->title }}</strong></td>
                            <td><span class="badge bg-success">{{ $movie->genre->name }}</span></td>
                            <td>{{ $movie->release_date->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('movies.show', $movie) }}" class="btn btn-info btn-sm">Xem</a>
                                <a href="{{ route('movies.edit', $movie) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('movies.destroy', $movie) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Xóa phim «{{ $movie->title }}»?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <h4>Chưa có phim nào</h4>
                                <a href="{{ route('movies.create') }}" class="btn btn-primary">Thêm phim đầu tiên</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $movies->links() }}
        </div>
    </div>
</div>
@endsection