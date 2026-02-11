<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');
        $books = \App\Models\Book::when(
            $title,
            fn($q, $title) => $q->title($title)
        );
        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highesRatedLastMonth(),
            'highest_rated_last_6months' => $books->highesRatedLast6Months(),
            default => $books->latest()->withAvgRating()->withReviewsCount()
        };
        // $books = $books->get();
        $cacheKey = 'books:' . $filter . ":" .  $title;
        $books =       $books->get();
        // cache()->remember($cacheKey, 3600, fn() => 

        // );
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int  $id)
    {
        // return view('books.show', [
        //     'book' => $book->load([
        //         'reviews' => fn($q) => $q->latest()
        //     ])
        // ]);
        $cacheKey = 'book:' . $id;
        $book = cache()->remember(
            $cacheKey,
            3600,
            fn() =>
            Book::with([
                'reviews' => fn($q) => $q->latest()
            ])->withAvgRating()->withReviewsCount()->findOrFail($id)
        );
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
