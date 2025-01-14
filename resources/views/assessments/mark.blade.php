<!-- resources/views/assessments/mark.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-home">
<h1>Mark Assessment: <span class="pink-highlight">{{ $assessment->title }}</span></h1>

<h2>Student: <span class="pink-highlight">{{ $student->name }} ({{ $student->s_number }})</span></h2>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Display Reviews Submitted by the Student -->
<h3 class="pink-highlight">Reviews Submitted</h3>
<div class="container-card2">
    @if($reviewsSubmitted->isEmpty())
        <p>No reviews submitted by this student.</p>
    @else
        <ul>
            @foreach($reviewsSubmitted as $review)
                <li>
                    Review of {{ $review->reviewee->name }}:
                    <a href="{{ route('reviews.show', $review->id) }}">View Review</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<!-- Display Reviews Received by the Student -->
<h3 class="pink-highlight">Reviews Received</h3>
<div class="container-card2">
    @if($reviewsReceived->isEmpty())
        <p>No reviews received for this student.</p>
    @else
        <ul>
            @foreach($reviewsReceived as $review)
                <li>
                    Review by {{ $review->reviewer->name }}:
                    <a href="{{ route('reviews.show', $review->id) }}">View Review</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<!-- Form to Assign Score -->
<h3 class="pink-highlight">Assign Score</h3>
    <div class="container-card2">
        <form action="{{ route('assessments.score', [$assessment->id, $student->id]) }}" method="POST">
            @csrf
            <label for="score">Score (0 - {{ $assessment->max_score }}):</label><br>
            <input type="number" name="score" id="score" min="0" max="{{ $assessment->max_score }}" required><br><br>
            <button type="submit" class="btn-custom">Assign Score</button>
        </form>
    </div>
</div>
@endsection
