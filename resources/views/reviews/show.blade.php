<!-- resources/views/reviews/show.blade.php -->

@extends('layouts.app')

@section('content')
<!--Show reviews -->
<div class="container-home">
    <h1 class="pink-highlight">Review Details</h1>

    <p><strong>Reviewer:</strong> {{ $review->reviewer->name }}</p>
    <p><strong>Reviewee:</strong> {{ $review->reviewee->name }}</p>
    <p><strong>Content:</strong></p>
    <p>{{ $review->content }}</p>
</div>
@endsection
