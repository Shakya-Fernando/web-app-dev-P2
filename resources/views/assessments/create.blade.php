<!-- resources/views/assessments/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-home">
<h1>Create New Assessment for <span class="pink-highlight">{{ $course->code }} - {{ $course->name }}</span></h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- Form to create assessment -->
<form action="{{ route('assessments.store', $course->id) }}" method="POST">
    @csrf
    <label for="title">Title (max 20 characters):</label><br>
    <input type="text" name="title" id="title" value="{{ old('title') }}" required maxlength="20"><br><br>

    <label for="instruction">Instruction:</label><br>
    <textarea name="instruction" id="instruction" required>{{ old('instruction') }}</textarea><br><br>

    <label for="number_of_reviews">Number of Reviews Required (min 1):</label><br>
    <input type="number" name="number_of_reviews" id="number_of_reviews" value="{{ old('number_of_reviews') }}" required min="1"><br><br>

    <label for="max_score">Max Score (1 to 100):</label><br>
    <input type="number" name="max_score" id="max_score" value="{{ old('max_score') }}" required min="1" max="100"><br><br>

    <label for="due_date">Due Date (must be after today):</label><br>
    <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date') }}" required><br><br>

    <label for="type">Type:</label><br>
    <select name="type" id="type" required>
        <option value="" disabled selected>Select Type</option>
        <option value="student-select" {{ old('type') == 'student-select' ? 'selected' : '' }}>Student Select</option>
        <option value="teacher-assign" {{ old('type') == 'teacher-assign' ? 'selected' : '' }}>Teacher Assign</option>
    </select><br><br>

    <button type="submit" class="btn-custom">Create Assessment</button>
</form>
</div>
@endsection
