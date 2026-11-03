<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CholoChitra - Watch Movies Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white font-sans antialiased min-h-screen selection:bg-red-600 selection:text-white">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-gray-950/80 backdrop-blur-md border-b border-white/10 px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="/" class="text-2xl font-black tracking-wider text-red-600">CholoChitra</a>
        
        <!-- Search Bar -->
        <form action="{{ route('movie.search') }}" method="GET" class="flex w-full md:w-96">
            <input type="text" name="query" placeholder="Search movies or series..." required class="w-full bg-gray-900 border border-white/10 rounded-l-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-red-500">
            <button type="submit" class="bg-red-600 hover:bg-red-700 px-5 rounded-r-xl text-sm font-semibold transition">Search</button>
        </form>
    </header>

    <!-- Main Content Container -->
    <main class="container mx-auto px-4 py-8">
        
        <!-- Content Type Selector (Movies vs TV Series) -->
        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-white/10">
            <a href="{{ route('home', array_merge(request()->all(), ['type' => 'movie', 'page' => 1])) }}" class="px-6 py-2.5 rounded-xl text-sm font-bold transition {{ ($type ?? 'movie') == 'movie' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-400 hover:text-white border border-white/10' }}">🎬 Movies</a>
            <a href="{{ route('home', array_merge(request()->all(), ['type' => 'tv', 'page' => 1])) }}" class="px-6 py-2.5 rounded-xl text-sm font-bold transition {{ ($type ?? '') == 'tv' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-400 hover:text-white border border-white/10' }}">📺 TV Series</a>
        </div>

        <!-- Language Filter Tabs -->
        <div class="flex items-center gap-3 overflow-x-auto pb-4 mb-4 scrollbar-none">
            <span class="text-gray-400 font-semibold text-sm whitespace-nowrap">Language/Region:</span>
            <a href="{{ route('home', array_merge(request()->except('lang'), ['lang' => 'en'])) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ ($language ?? 'en') == 'en' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">🌐 English</a>
            <a href="{{ route('home', array_merge(request()->except('lang'), ['lang' => 'hi'])) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ ($language ?? '') == 'hi' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">🇮🇳 Hindi</a>
            <a href="{{ route('home', array_merge(request()->except('lang'), ['lang' => 'bn'])) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ ($language ?? '') == 'bn' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">🇧🇩 Bangla</a>
        </div>

        <!-- Categories Filter Tabs -->
        <div class="flex items-center gap-3 overflow-x-auto pb-4 mb-4 scrollbar-none">
            <span class="text-gray-400 font-semibold text-sm whitespace-nowrap">Categories:</span>
            <a href="{{ route('home', array_merge(request()->all(), ['category' => 'popular', 'page' => 1])) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ (!isset($genreId) && ($category ?? 'popular') == 'popular') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">🔥 Popular</a>
            <a href="{{ route('home', array_merge(request()->all(), ['category' => 'top_rated', 'page' => 1])) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ (!isset($genreId) && ($category ?? '') == 'top_rated') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">⭐ Top Rated</a>
            <a href="{{ route('home', array_merge(request()->all(), ['category' => 'upcoming', 'page' => 1])) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ (!isset($genreId) && ($category ?? '') == 'upcoming') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">⏰ Upcoming</a>
            <a href="{{ route('home', array_merge(request()->all(), ['category' => 'now_playing', 'page' => 1])) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ (!isset($genreId) && ($category ?? '') == 'now_playing') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">🎬 Now Playing</a>
        </div>

        <!-- Genres Filter Tabs -->
        @if(isset($genres) && count($genres) > 0)
        <div class="flex items-center gap-2 overflow-x-auto pb-6 mb-8 scrollbar-none">
            <span class="text-gray-400 font-semibold text-sm whitespace-nowrap">Genres:</span>
            <a href="{{ route('home', array_merge(request()->except('genre'), ['page' => 1])) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ !isset($genreId) ? 'bg-red-600 text-white' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">All</a>
            @foreach($genres as $genre)
                <a href="{{ route('home', array_merge(request()->all(), ['genre' => $genre['id'], 'page' => 1])) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition {{ (isset($genreId) && $genreId == $genre['id']) ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-900 text-gray-300 hover:bg-gray-800 border border-white/10' }}">
                    {{ $genre['name'] }}
                </a>
            @endforeach
        </div>
        @endif

        <!-- Movie & Series Grid Section -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($movies as $item)
                @php
                    $isTv = ($type ?? 'movie') == 'tv';
                    $title = $item['title'] ?? $item['name'] ?? 'Untitled';
                    $detailRoute = $isTv ? route('series.show', $item['id']) : route('movie.show', $item['id']);
                @endphp
                <div class="bg-gray-900/60 backdrop-blur-md rounded-2xl overflow-hidden shadow-xl border border-white/10 hover:border-red-500/50 hover:scale-105 transition-all duration-300 flex flex-col justify-between group">
                    <a href="{{ $detailRoute }}">
                        @if(isset($item['poster_path']))
                            <img src="https://image.tmdb.org/t/p/w500{{ $item['poster_path'] }}" alt="{{ $title }}" class="w-full h-72 object-cover group-hover:opacity-90 transition">
                        @else
                            <div class="w-full h-72 bg-gray-800 flex items-center justify-center text-gray-500 text-sm">No Image</div>
                        @endif
                    </a>
                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <h3 class="font-bold text-sm truncate mb-2 text-gray-200 group-hover:text-red-400 transition" title="{{ $title }}">
                            {{ $title }}
                        </h3>
                        <div class="flex justify-between items-center text-xs text-gray-400 pt-2 border-t border-white/5">
                            <span class="text-yellow-400 font-semibold">⭐ {{ $item['vote_average'] ?? '0' }}</span>
                            <a href="{{ $detailRoute }}" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white px-3 py-1 rounded-lg font-bold transition">Watch</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-400">
                    <p class="text-xl">No results found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination Section -->
        @if(isset($totalPages) && $totalPages > 1)
        <div class="flex justify-center items-center gap-4 mt-12">
            @if($currentPage > 1)
                <a href="{{ route('home', array_merge(request()->all(), ['page' => $currentPage - 1])) }}" class="bg-gray-900 border border-white/10 hover:bg-gray-800 px-5 py-2.5 rounded-xl text-sm font-semibold transition">← Previous</a>
            @endif

            <span class="text-sm text-gray-400 font-medium">Page <b class="text-white">{{ $currentPage }}</b> of {{ $totalPages }}</span>

            @if($currentPage < $totalPages)
                <a href="{{ route('home', array_merge(request()->all(), ['page' => $currentPage + 1])) }}" class="bg-gray-900 border border-white/10 hover:bg-gray-800 px-5 py-2.5 rounded-xl text-sm font-semibold transition">Next →</a>
            @endif
        </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-white/10 bg-gray-950 py-6 text-center text-xs text-gray-500">
        © 2026 CHOLOCHITRA. All rights reserved. Powered by TMDB API.
    </footer>

</body>
</html>