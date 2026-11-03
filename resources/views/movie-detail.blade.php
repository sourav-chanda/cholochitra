<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie['title'] ?? 'Movie' }} - CholoChitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white font-sans antialiased min-h-screen selection:bg-red-600 selection:text-white">

    <!-- Navbar -->
    <header class="absolute top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/80 to-transparent p-4 md:px-12 flex justify-between items-center">
        <a href="/" class="text-2xl font-black tracking-wider text-red-600 drop-shadow-md">CholoChitra</a>
        <a href="/" class="bg-white/10 hover:bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-medium transition border border-white/10">← Back to Home</a>
    </header>

    <!-- Hero Backdrop Section -->
    @if(isset($movie['backdrop_path']))
    <div class="relative w-full h-[60vh] md:h-[70vh] bg-cover bg-center" style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie['backdrop_path'] }}');">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/60 to-black/40"></div>
    </div>
    @else
    <div class="w-full h-48 bg-gray-900"></div>
    @endif

    <!-- Main Content Container -->
    <div class="container mx-auto px-4 -mt-48 md:-mt-64 relative z-10 pb-16">
        
        <!-- Movie Details Card -->
        <div class="flex flex-col md:flex-row gap-8 items-start bg-gray-900/80 backdrop-blur-xl border border-white/10 p-6 md:p-8 rounded-2xl shadow-2xl">
            <!-- Poster -->
            <div class="w-full md:w-72 flex-shrink-0 mx-auto">
                @if(isset($movie['poster_path']))
                    <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full rounded-xl shadow-2xl border border-white/10 object-cover">
                @else
                    <div class="w-full h-96 bg-gray-800 rounded-xl flex items-center justify-center text-gray-500">No Image</div>
                @endif
            </div>
            
            <!-- Info -->
            <div class="flex-1">
                <h1 class="text-3xl md:text-5xl font-extrabold mb-2 tracking-tight text-white">{{ $movie['title'] ?? '' }}</h1>
                <p class="text-red-400 italic font-medium mb-4">{{ $movie['tagline'] ?? '' }}</p>
                
                <p class="text-gray-300 mb-6 leading-relaxed text-sm md:text-base">{{ $movie['overview'] ?? 'No overview available.' }}</p>
                
                <div class="flex flex-wrap gap-4 text-sm text-gray-300 mb-6">
                    <span class="bg-red-600/20 border border-red-500/30 px-3 py-1.5 rounded-lg text-red-400 font-semibold">⭐ {{ $movie['vote_average'] ?? '0' }} / 10</span>
                    <span class="bg-white/5 border border-white/10 px-3 py-1.5 rounded-lg">📅 {{ $movie['release_date'] ?? 'N/A' }}</span>
                    <span class="bg-white/5 border border-white/10 px-3 py-1.5 rounded-lg">⏱️ {{ $movie['runtime'] ?? 'N/A' }} mins</span>
                </div>
            </div>
        </div>

        <!-- 🎬 Watch Full Movie Online Streaming Section -->
        <div class="mt-12 bg-gray-900/80 backdrop-blur-xl border border-white/10 p-6 md:p-8 rounded-2xl shadow-2xl">
            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <span class="bg-red-600 w-3 h-8 rounded-full inline-block"></span> Watch Full Movie Online
            </h3>

            <!-- Responsive Embedded Video Player -->
            <div class="relative w-full overflow-hidden rounded-xl shadow-2xl bg-black border border-white/10" style="padding-top: 56.25%;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full border-0 rounded-xl"
                    src="https://vidsrc.to/embed/movie/{{ $movie['id'] }}" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <!-- 🎥 Similar Movies Section -->
        @if(isset($similarMovies) && count($similarMovies) > 0)
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <span class="bg-red-600 w-3 h-8 rounded-full inline-block"></span> You May Also Like
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach(array_slice($similarMovies, 0, 10) as $similar)
                    <div class="bg-gray-900/60 backdrop-blur-md rounded-xl overflow-hidden shadow-xl border border-white/10 hover:border-red-500/50 hover:scale-105 transition-all duration-300 flex flex-col justify-between group">
                        <a href="{{ route('movie.show', $similar['id']) }}">
                            @if(isset($similar['poster_path']))
                                <img src="https://image.tmdb.org/t/p/w500{{ $similar['poster_path'] }}" alt="{{ $similar['title'] ?? 'Movie' }}" class="w-full h-64 object-cover group-hover:opacity-90 transition">
                            @else
                                <div class="w-full h-64 bg-gray-800 flex items-center justify-center text-gray-500 text-sm">No Image</div>
                            @endif
                        </a>
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <h4 class="font-semibold text-sm truncate mb-2 text-gray-200 group-hover:text-red-400 transition" title="{{ $similar['title'] ?? '' }}">
                                {{ $similar['title'] ?? 'Untitled' }}
                            </h4>
                            <div class="flex justify-between items-center text-xs text-gray-400">
                                <span class="text-yellow-400 font-medium">⭐ {{ $similar['vote_average'] ?? '0' }}</span>
                                <a href="{{ route('movie.show', $similar['id']) }}" class="text-red-500 hover:text-red-400 font-bold">Watch →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</body>
</html>