<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\MovieItem;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $apiKey = env('TMDB_API_KEY');
        
        $type = $request->input('type', 'movie'); // movie অথবা tv
        $category = $request->input('category', 'popular'); // popular অথবা top_rated
        $genreId = $request->input('genre'); 
        $language = $request->input('lang', 'en'); 
        $page = $request->input('page', 1);

        // জেনার লিস্ট আনা
        $genreResponse = Http::get("https://api.themoviedb.org/3/genre/{$type}/list?api_key={$apiKey}&language=en-US");
        $genres = $genreResponse->json()['genres'] ?? [];

        // যদি জেনার বা ভাষা সিলেক্ট করা থাকে, তবে discover ব্যবহার করব, না হলে সরাসরি popular/top_rated এন্ডপয়েন্ট
        if ($genreId) {
            $response = Http::get("https://api.themoviedb.org/3/discover/{$type}?api_key={$apiKey}&with_genres={$genreId}&page={$page}");
        } else {
            // মুভি বা টিভি সিরিজের জন্য সরাসরি জনপ্রিয় বা টপ রেটেড লিস্ট আনা
            $response = Http::get("https://api.themoviedb.org/3/{$type}/{$category}?api_key={$apiKey}&page={$page}");
        }
        
        $data = $response->json();
        $movies = $data['results'] ?? [];
        $currentPage = $data['page'] ?? 1;
        $totalPages = $data['total_pages'] ?? 1;

        return view('welcome', compact('movies', 'type', 'category', 'genreId', 'language', 'genres', 'currentPage', 'totalPages'));
    }

    public function show($id)
    {
        $apiKey = env('TMDB_API_KEY');
        
        $response = Http::get("https://api.themoviedb.org/3/movie/{$id}?api_key={$apiKey}");
        $movie = $response->json();

        // সিমিলার মুভি আনা
        $similarResponse = Http::get("https://api.themoviedb.org/3/movie/{$id}/similar?api_key={$apiKey}");
        $similarMovies = $similarResponse->json()['results'] ?? [];

        $videoResponse = Http::get("https://api.themoviedb.org/3/movie/{$id}/videos?api_key={$apiKey}");
        $videos = $videoResponse->json()['results'] ?? [];
        
        $trailerKey = null;
        foreach ($videos as $video) {
            if ($video['type'] === 'Trailer' && $video['site'] === 'YouTube') {
                $trailerKey = $video['key'];
                break;
            }
        }

        return view('movie-detail', compact('movie', 'similarMovies', 'trailerKey'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('TMDB_API_KEY');

        $movies = [];

        if ($query) {
            // /search/multi ব্যবহার করলে মুভি এবং টিভি সিরিজ দুটোই একসাথে পাওয়া যাবে (যেমন Stranger Things, Mirzapur ইত্যাদি)
            $response = Http::get("https://api.themoviedb.org/3/search/multi?api_key={$apiKey}&query={$query}");
            $results = $response->json()['results'] ?? [];

            // শুধু মুভি এবং টিভি সিরিজ ফিল্টার করে রাখা
            foreach ($results as $item) {
                if (isset($item['media_type']) && ($item['media_type'] === 'movie' || $item['media_type'] === 'tv')) {
                    $movies[] = $item;
                }
            }
        }

        return view('search-results', compact('movies', 'query'));
    }

    public function createMovieLink()
    {
        return view('admin-add-movie');
    }

    public function storeMovieLink(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required|numeric',
            'title' => 'required|string',
            'download_link_1080p' => 'nullable|url',
            'download_link_720p' => 'nullable|url',
        ]);

        MovieItem::updateOrCreate(
            ['tmdb_id' => $request->tmdb_id],
            [
                'title' => $request->title,
                'download_link_1080p' => $request->download_link_1080p,
                'download_link_720p' => $request->download_link_720p,
            ]
        );
        return redirect()->back()->with('success', 'Download links saved successfully!');
    }
    public function showSeries($id, $season = 1, $episode = 1)
    {
        $apiKey = env('TMDB_API_KEY');
        
        // TMDB থেকে সিরিজের ডিটেইলস আনা
        $response = Http::get("https://api.themoviedb.org/3/tv/{$id}?api_key={$apiKey}");
        $series = $response->json();

        // সিমিলার সিরিজ আনা
        $similarResponse = Http::get("https://api.themoviedb.org/3/tv/{$id}/similar?api_key={$apiKey}");
        $similarSeries = $similarResponse->json()['results'] ?? [];

        return view('series-detail', compact('series', 'similarSeries', 'season', 'episode'));
    }
}