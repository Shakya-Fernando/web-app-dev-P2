<!-- resources/views/assessments/student_show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-home">
<h1 class="pink-highlight">{{ $assessment->title }}</h1>
<div class="container-card1">
    <p>{{ $assessment->instruction }}</p>
    <p>Due Date: {{ $assessment->due_date }}</p>
    <p>Number of Reviews Required: {{ $assessment->number_of_reviews }}</p>
    </div>
<h2 class="pink-highlight">Your Reviews Submitted</h2>
<div class="container-card2">
    <ul>
        @foreach($assessment->reviews()->where('reviewer_id', Auth::id())->get() as $review)
        <li>Review for {{ $review->reviewee->name }}: {{ $review->content }}</li>
        @endforeach
    </ul>
</div>
<!-- Section to submit review for another student -->
@if($assessment->due_date > now())
<h2 class="pink-highlight">Submit Review</h2>
<div class="container-card2">
    <form action="{{ route('reviews.submit', $assessment->id) }}" method="POST">
        @csrf
        <label for="reviewee_id">Select Reviewee:</label>
        <br>
        <select name="reviewee_id" id="reviewee_id" required>
            @foreach($assessment->course->users()->wherePivot('role', 'student')->where('users.id', '!=', Auth::id())->get() as $student)
            @if(!$assessment->reviews()->where('reviewer_id', Auth::id())->where('reviewee_id', $student->id)->exists())
            <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endif
            @endforeach
        </select>
        <br>
            <label for="content">Review Content:</label>
        <div>
            <textarea name="content" id="content" required></textarea>
        </div>
        <button type="submit" class="btn-custom">Submit Review</button>
    </form>
</div>
@endif
<!-- Recieved Reviews -->
<h2 class="pink-highlight">Reviews Received</h2>
    <div class="container-card2">
        <ul>
            @foreach($assessment->reviews()->where('reviewee_id', Auth::id())->get() as $review)
            <li>
                From {{ $review->reviewer->name }}: {{ $review->content }}
                <form action="{{ route('reviews.rate', $review->id) }}" method="POST">
                    @csrf
                    <label for="rating">Rate this Review:</label>
                    <select name="rating" id="rating" required>
                        @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit">Submit Rating</button>
                </form>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
