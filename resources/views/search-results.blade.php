<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results: {{ $query ?? '' }} - CHOLOCHITRA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white font-sans antialiased min-h-screen selection:bg-red-600 selection:text-white">

    <!-- Header / Navbar -->
    <header class="bg-gray-900/80 backdrop-blur-md border-b border-white/10 p-4 shadow-md flex flex-col md:flex-row justify-between items-center gap-4 px-8">
        <a href="/" class="text-2xl font-black tracking-wider text-red-600">CINEPHILE</a>
        
        <!-- Search Form -->
        <form action="{{ route('movie.search') }}" method="GET" class="flex w-full md:w-96">
            <input type="text" name="query" value="{{ $query ?? '' }}" placeholder="Search movies or series..." required class="w-full bg-gray-900 border border-white/10 rounded-l-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-red-500">
            <button type="submit" class="bg-red-600 hover:bg-red-700 px-5 rounded-r-xl text-sm font-semibold transition">Search</button>
        </form>
    </header>

    <!-- Search Results Container -->
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <span class="bg-red-600 w-3 h-8 rounded-full inline-block"></span> Search Results for: "<span class="text-red-500">{{ $query ?? '' }}</span>"
        </h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($movies as $item)
                @php
                    $mediaType = $item['media_type'] ?? 'movie';
                    $title = $item['title'] ?? $item['name'] ?? 'Untitled';
                    $detailRoute = ($mediaType === 'tv') ? route('series.show', $item['id']) : route('movie.show', $item['id']);
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
                    <p class="text-xl">No movies or series found matching your search.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>