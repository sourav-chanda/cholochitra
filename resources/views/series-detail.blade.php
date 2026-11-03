<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $series['name'] ?? 'Series' }} - CholoChitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white font-sans antialiased min-h-screen selection:bg-red-600 selection:text-white">

    <!-- Header -->
    <header class="absolute top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/80 to-transparent p-4 md:px-12 flex justify-between items-center">
        <a href="/" class="text-2xl font-black tracking-wider text-red-600 drop-shadow-md">CholoChitra</a>
        <a href="/" class="bg-white/10 hover:bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-medium transition border border-white/10">← Back to Home</a>
    </header>

    <!-- Hero Backdrop Section -->
    @if(isset($series['backdrop_path']))
    <div class="relative w-full h-[50vh] md:h-[60vh] bg-cover bg-center" style="background-image: url('https://image.tmdb.org/t/p/original{{ $series['backdrop_path'] }}');">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/60 to-black/40"></div>
    </div>
    @else
    <div class="w-full h-48 bg-gray-900"></div>
    @endif

    <!-- Main Content Container -->
    <div class="container mx-auto px-4 -mt-32 md:-mt-48 relative z-10 pb-16">
        
        <!-- Series Details Card -->
        <div class="flex flex-col md:flex-row gap-8 items-start bg-gray-900/80 backdrop-blur-xl border border-white/10 p-6 md:p-8 rounded-2xl shadow-2xl">
            <div class="w-full md:w-72 flex-shrink-0 mx-auto">
                @if(isset($series['poster_path']))
                    <img src="https://image.tmdb.org/t/p/w500{{ $series['poster_path'] }}" alt="{{ $series['name'] }}" class="w-full rounded-xl shadow-2xl border border-white/10 object-cover">
                @else
                    <div class="w-full h-96 bg-gray-800 rounded-xl flex items-center justify-center text-gray-500">No Image</div>
                @endif
            </div>
            
            <div class="flex-1">
                <h1 class="text-3xl md:text-5xl font-extrabold mb-2 tracking-tight text-white">{{ $series['name'] ?? '' }}</h1>
                <p class="text-red-400 italic font-medium mb-4">{{ $series['tagline'] ?? '' }}</p>
                
                <p class="text-gray-300 mb-6 leading-relaxed text-sm md:text-base">{{ $series['overview'] ?? 'No overview available.' }}</p>
                
                <div class="flex flex-wrap gap-4 text-sm text-gray-300 mb-6">
                    <span class="bg-red-600/20 border border-red-500/30 px-3 py-1.5 rounded-lg text-red-400 font-semibold">⭐ {{ $series['vote_average'] ?? '0' }} / 10</span>
                    <span class="bg-white/5 border border-white/10 px-3 py-1.5 rounded-lg">📅 First Air: {{ $series['first_air_date'] ?? 'N/A' }}</span>
                    <span class="bg-white/5 border border-white/10 px-3 py-1.5 rounded-lg">📺 Seasons: {{ $series['number_of_seasons'] ?? '1' }}</span>
                </div>
            </div>
        </div>

        <!-- 🎬 TV Series Streaming Section with Season & Episode Selector -->
        <div class="mt-12 bg-gray-900/80 backdrop-blur-xl border border-white/10 p-6 md:p-8 rounded-2xl shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span class="bg-red-600 w-3 h-8 rounded-full inline-block"></span> Watch TV Series
                </h3>

                <!-- Season Selector Dropdown -->
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-400 font-medium">Select Season:</span>
                    <select onchange="location.href=this.value" class="bg-gray-800 border border-white/10 text-white text-sm rounded-xl px-4 py-2 focus:outline-none focus:border-red-500">
                        @for ($s = 1; $s <= ($series['number_of_seasons'] ?? 1); $s++)
                            <option value="{{ route('series.show', ['id' => $series['id'], 'season' => $s, 'episode' => 1]) }}" {{ $season == $s ? 'selected' : '' }}>
                                Season {{ $s }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Responsive Embedded Video Player for Series (vidsrc.to supports TV series using /embed/tv/{id}/{season}/{episode}) -->
            <div class="relative w-full overflow-hidden rounded-xl shadow-2xl bg-black border border-white/10 mb-6" style="padding-top: 56.25%;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full border-0 rounded-xl"
                    src="https://vidsrc.to/embed/tv/{{ $series['id'] }}/{{ $season }}/{{ $episode }}" 
                    allowfullscreen>
                </iframe>
            </div>

            <!-- Quick Episode Buttons (Example for Episodes 1 to 10) -->
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-gray-400 mb-3">Episodes (Current Season: {{ $season }}):</h4>
                <div class="flex flex-wrap gap-2">
                    @for ($ep = 1; $ep <= 20; $ep++)
                        <a href="{{ route('series.show', ['id' => $series['id'], 'season' => $season, 'episode' => $ep]) }}" class="px-4 py-2 rounded-lg text-xs font-bold transition border {{ $episode == $ep ? 'bg-red-600 text-white border-red-500 shadow-lg shadow-red-600/30' : 'bg-gray-800 text-gray-300 hover:bg-gray-700 border-white/10' }}">
                            Ep {{ $ep }}
                        </a>
                    @endfor
                </div>
            </div>
        </div>

        <!-- 🎥 Similar Series Section -->
        @if(isset($similarSeries) && count($similarSeries) > 0)
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <span class="bg-red-600 w-3 h-8 rounded-full inline-block"></span> You May Also Like
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach(array_slice($similarSeries, 0, 10) as $simSeries)
                    <div class="bg-gray-900/60 backdrop-blur-md rounded-2xl overflow-hidden shadow-xl border border-white/10 hover:border-red-500/50 hover:scale-105 transition-all duration-300 flex flex-col justify-between group">
                        <a href="{{ route('series.show', $simSeries['id']) }}">
                            @if(isset($simSeries['poster_path']))
                                <img src="https://image.tmdb.org/t/p/w500{{ $simSeries['poster_path'] }}" alt="{{ $simSeries['name'] ?? 'Series' }}" class="w-full h-72 object-cover group-hover:opacity-90 transition">
                            @else
                                <div class="w-full h-72 bg-gray-800 flex items-center justify-center text-gray-500 text-sm">No Image</div>
                            @endif
                        </a>
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <h4 class="font-bold text-sm truncate mb-2 text-gray-200 group-hover:text-red-400 transition" title="{{ $simSeries['name'] ?? '' }}">
                                {{ $simSeries['name'] ?? 'Untitled' }}
                            </h4>
                            <div class="flex justify-between items-center text-xs text-gray-400 pt-2 border-t border-white/5">
                                <span class="text-yellow-400 font-semibold">⭐ {{ $simSeries['vote_average'] ?? '0' }}</span>
                                <a href="{{ route('series.show', $simSeries['id']) }}" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white px-3 py-1 rounded-lg font-bold transition">Watch</a>
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