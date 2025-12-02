<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;   
use App\Models\Movie;  
use Illuminate\Support\Str;

class GenreMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $genres = ['Hành động', 'Võ thuật', 'Hài', 'Kinh dị', 'Tình cảm', 'Hoạt hình'];

    foreach ($genres as $genreName) {
        $genre = Genre::create(['name' => $genreName]);

        // Mỗi thể loại có 3-5 phim ngẫu nhiên
        for ($i = 1; $i <= rand(3,5); $i++) {
            Movie::create([
                'title' => "$genreName - Phim mẫu " . Str::random(5),
                'poster' => 'https://via.placeholder.com/300x450?text=' . urlencode("$genreName $i"),
                'intro' => "Giới thiệu phim $genreName số $i rất hay và hấp dẫn...",
                'release_date' => now()->subDays(rand(100, 2000)),
                'genre_id' => $genre->id
            ]);
        }
    }
}
}