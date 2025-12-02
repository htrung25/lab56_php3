<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    // 1. Danh sách phim
    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ URL (?q=avenger)
        $search = $request->query('q');

        // Query cơ bản
        $query = Movie::with('genre')->latest('release_date');

        // Nếu có từ khóa → tìm gần đúng (LIKE) theo title
        if ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        // Phân trang 10 phim/trang
        $movies = $query->paginate(10);

        // Giữ lại từ khóa trong thanh tìm kiếm sau khi phân trang
        $movies->appends(['q' => $search]);

        return view('movies.index', compact('movies', 'search'));
    }

    // 2. Form thêm phim
    public function create()
    {
        $genres = Genre::all();
        return view('movies.create', compact('genres'));
    }

    // 3. Lưu phim mới
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255|unique:movies,title',
            'intro'        => 'required|string',
            'release_date' => 'required|date|after_or_equal:today',
            'genre_id'     => 'required|exists:genres,id',
            'poster'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'title.required'       => 'Tiêu đề phim không được để trống!',
            'title.unique'         => 'Tên phim này đã tồn tại, vui lòng chọn tên khác!',
            'intro.required'       => 'Giới thiệu không được để trống!',
            'release_date.after_or_equal' => 'Ngày công chiếu phải từ hôm nay trở đi!',
            'genre_id.required'    => 'Vui lòng chọn thể loại phim!',
            'poster.image'         => 'File phải là hình ảnh!',
            'poster.max'           => 'Ảnh bìa không được quá 2MB!',
        ]);

        $data = $request->all();

        // Xử lý upload ảnh
        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
            $data['poster'] = asset('storage/' . $data['poster']);
        }

        Movie::create($data);

        return redirect()->route('movies.index')
            ->with('success', 'Thêm phim thành công!');
    }

    // 4. Chi tiết phim
    public function show(Movie $movie)
    {
        $movie->load('genre');
        return view('movies.show', compact('movie'));
    }

    // 5. Form sửa phim
    public function edit(Movie $movie)
    {
        $genres = Genre::all();
        return view('movies.edit', compact('movie', 'genres'));
    }

    // 6. Cập nhật phim
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title'        => 'required|string|max:255|unique:movies,title,' . $movie->id,
            'intro'        => 'required|string',
            'release_date' => 'required|date|after_or_equal:today',
            'genre_id'     => 'required|exists:genres,id',
            'poster'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'title.required'       => 'Tiêu đề phim không được để trống!',
            'title.unique'         => 'Tên phim này đã tồn tại, vui lòng chọn tên khác!',
            'intro.required'       => 'Giới thiệu không được để trống!',
            'release_date.after_or_equal' => 'Ngày công chiếu phải từ hôm nay trở đi!',
            'genre_id.required'    => 'Vui lòng chọn thể loại phim!',
            'poster.image'         => 'File phải là hình ảnh!',
            'poster.max'           => 'Ảnh bìa không được quá 2MB!',
        ]);

        $data = $request->all();

        // Xử lý upload ảnh mới (nếu có)
        if ($request->hasFile('poster')) {
            // Xóa ảnh cũ nếu có
            if ($movie->poster && file_exists(public_path(str_replace(asset('storage'), 'storage', $movie->poster)))) {
                Storage::disk('public')->delete(str_replace(asset('storage/'), '', $movie->poster));
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
            $data['poster'] = asset('storage/' . $data['poster']);
        }

        $movie->update($data);

        return redirect()->route('movies.index')
            ->with('success', 'Cập nhật phim thành công!');
    }

    // 7. Xóa phim
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('movies.index')
            ->with('success', 'Xóa phim thành công!');
    }
}
