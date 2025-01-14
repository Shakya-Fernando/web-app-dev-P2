<!-- resources/views/courses/show.blade.php -->

@extends('layouts.app')

@section('content')
<!-- Show courses -->
<div class="container-home">
    <h1><span class="pink-highlight">{{ $course->code }}</span> - {{ $course->name }}</h1>
    <h2 class="pink-highlight">Teachers</h2>
        <div class="container-card1">
            <ul>
                <!-- Show teachers for the course -->
                @foreach($course->users()->wherePivot('role', 'teacher')->get() as $teacher)
                <li>{{ $teacher->name }}</li>
                @endforeach
        </ul>
        </div>
    <h2 class="pink-highlight">Assessments</h2>
    <div class="container-card3">
        <ul>
            @foreach($assessments as $assessment)
            <li>
                <!-- Show assessment for the course -->
                <a href="{{ route('assessments.show', $assessment->id) }}">{{ $assessment->title }}</a>
                - Due: {{ $assessment->due_date }}
            </li>
            @endforeach
        </ul>
    </div>
    <!-- ONLY teachers and enrol students (if not enrolled already) -->
    @if(Auth::user()->role == 'teacher')
    <h2 class="pink-highlight">Enroll Student</h2>
    @if($studentsNotEnrolled->isEmpty())
        <p>All students are already enrolled in this course.</p>
    @else
        <div class="container-card3">
            <!-- Dropdown to select student form -->
            <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                @csrf
                <label for="student_id">Select Student:</label>
                <select name="student_id" id="student_id" required>
                    <option value="" disabled selected>Select a student</option>
                    @foreach($studentsNotEnrolled as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->s_number }})</option>
                    @endforeach
                </select>
                <button type="submit">Enroll</button>
            </form>
        </div>
    @endif
    <!-- ONLY teachers can create new ass -->
    <h2 class="pink-highlight">Add Assessment</h2>
    <div class="container-card3">
        <a href="{{ route('assessments.create', $course->id) }}">Create New Assessment</a>
    <div>

    @endif
</div>
@endsection
