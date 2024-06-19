<x-layout>
    <x-slot name="heading">
        Today's News
    </x-slot>
    
    <form action="{{ route('news.index') }}" method="GET" class="mb-4">
        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="px-2 py-1 border border-gray-300 rounded">
        <select name="sort_column" class="px-2 py-1 border border-gray-300 rounded">
            <option value="published" {{ request('sort_column') == 'published' ? 'selected' : '' }}>Latest First</option>
            <option value="title" {{ request('sort_column') == 'title' ? 'selected' : '' }}>Alphabetical by Title</option>
        </select>
        <select name="sort_direction" class="px-2 py-1 border border-gray-300 rounded">
            <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Filter</button>
    </form>
    
    <ul class="space-y-4">
        @foreach($paginatedItems as $item)
            <li class="news-item">
                <a href="{{ $item['link'] }}" class="block px-4 py-6 border border-gray-200 rounded-lg">
                    <div class="font-bold text-blue-600 text-lg">{{ $item['title'] }}</div>
                    
                    {!! $item['description'] !!}
                    
                    <p class="text-xs">Published on: {{ \Carbon\Carbon::parse($item['pubDate'])->format('Y-m-d H:i:s') }}</p>
                    
                    @if(!empty($item['image_url']))
                    <div class="mt-4">
                        {{-- <img src="{{ $item['image_url'] }}" alt="News Image" class="w-full h-auto rounded-lg"> --}}
                    </div>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
    
    {{ $paginatedItems->links() }}
</x-layout>
