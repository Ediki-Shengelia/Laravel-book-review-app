@extends('layouts.app')

@section('content')
    <h1>Book</h1>

    <form action="{{ route('books.index') }}" method="get">
        <input type="text" name="title" placeholder="Search by title" value="{{ request('title') }}" id="">
        <input type="hidden" name="filter" value="{{ request('filter') }}">
        <button>search</button>
        <a href="{{ route('books.index') }}">Clear</a>
    </form>


    <div>
        @php
            $filters = [
                '' => 'latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6months' => 'Popular Last 6 Months',
                'highest_rated_last_month' => 'Highest Rated Last Month',
                'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
            ];
        @endphp

        @foreach ($filters as $key => $label)
            <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}">
                {{ $label }}
            </a>
        @endforeach

    </div>
    <ul>
        @forelse ($books as $book)
            <li>
                <a href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
                <span> By {{ $book->authot }}</span>
                <div>
                    {{-- {{ number_format($book->reviews_avg_rating, 1) }} --}}
                    <x-star-rating :rating="$book->reviews_avg_rating" />
                </div>
                <div>
                    out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                </div>
            </li>
        @empty
            <li>
                <p>There is no book</p>

                <a href="{{ route('books.index') }}">Clear</a>
            </li>
        @endforelse
    </ul>
@endsection
