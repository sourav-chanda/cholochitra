<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Custom Links - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans flex items-center justify-center min-h-screen">

    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-red-500 text-center">Add Movie Download Links</h2>

        @if(session('success'))
            <div class="bg-green-600 text-white p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold mb-1">TMDB Movie ID:</label>
                <input type="number" name="tmdb_id" placeholder="e.g. 550 (from URL)" required class="w-full bg-gray-700 text-white p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Movie Title:</label>
                <input type="text" name="title" placeholder="Movie Name" required class="w-full bg-gray-700 text-white p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">1080p Download Link (BDIX / FTP):</label>
                <input type="url" name="download_link_1080p" placeholder="https://..." class="w-full bg-gray-700 text-white p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">720p Download Link:</label>
                <input type="url" name="download_link_720p" placeholder="https://..." class="w-full bg-gray-700 text-white p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 font-bold py-3 rounded mt-2 transition duration-200">
                Save Links
            </button>
        </form>
    </div>

</body>
</html>