<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $jsonFile = file_get_contents(public_path('news.json'));
        $newsData = json_decode($jsonFile, true);

        $newsItems = collect($newsData['channel']['item']);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $newsItems = $newsItems->filter(function ($item) use ($searchTerm) {
                return str_contains(strtolower($item['title']), strtolower($searchTerm));
            });
        }

        $sortColumn = $request->input('sort_column', 'published');
        $orderDirection = $request->input('sort_direction', 'desc');
        $sortedItems = $newsItems->sortBy($sortColumn, SORT_REGULAR, $orderDirection === 'desc');

        $currentPage = $request->get('page', 1);
        $perPage = 1;

        $paginatedItems = new LengthAwarePaginator(
            $sortedItems->forPage($currentPage, $perPage)->values(),
            $sortedItems->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $paginatedItems->getCollection()->transform(function ($item) {
            $item['image_url'] = isset($item['enclosure']['@url']) ? $item['enclosure']['@url'] : '';
            return $item;
        });

        return view('news.index', compact('paginatedItems'));
    }
}
