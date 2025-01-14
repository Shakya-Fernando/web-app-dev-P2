@extends('layouts.app')

@section('content')
<div class="container-home">

<h1 class="pink-highlight">{{ $assessment->title }}</h1>
<div class="container-card1">
    <p>{{ $assessment->instruction }}</p>
    <p><strong>Due Date:</strong> {{ $assessment->due_date }}</p>
</div>
<!-- Erros -->
@if(session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="color: red;">
        {{ session('error') }}
    </div>
@endif

@php
    $submissionsExist = $assessment->reviews()->exists();
@endphp

<!-- Edit assessemtn ONLY if no sub -->
@if(!$submissionsExist)
<div class="container-card2">
    <a href="{{ route('assessments.edit', $assessment->id) }}">Edit Assessment</a>
</div>
@endif

<!-- Table (see details below) -->
<h2 class="pink-highlight">Students' Submissions</h2>
<div class="container-card2">
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Student Name (S-Number)</th>
            <th>Reviews Submitted</th>
            <th>Reviews Received</th>
            <th>Score</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }} ({{ $student->s_number }})</td>
            <td>{{ $assessment->reviews()->where('reviewer_id', $student->id)->count() }}</td>
            <td>{{ $assessment->reviews()->where('reviewee_id', $student->id)->count() }}</td>
            <td>{{ optional($assessment->scores()->where('student_id', $student->id)->first())->score ?? 'Not Assigned' }}</td>
            <td>
                <!-- View the content of the reviews and assign marks -->
                <a href="{{ route('assessments.mark', ['assessment_id' => $assessment->id, 'student_id' => $student->id]) }}">View Details and Assign Score</a> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $students->links() }}

<p>Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results</p>
</div>
@endsection
