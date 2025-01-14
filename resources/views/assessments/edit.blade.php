<!-- resources/views/assessments/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-home">
<h1>Edit Assessment: <span class="pink-highlight">{{ $assessment->title }}</span></h1>

@if(session('error'))
    <div style="color: red;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- For to edit existing assessment -->
<form action="{{ route('assessments.update', $assessment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="title">Title (max 20 characters):</label><br>
    <input type="text" name="title" id="title" value="{{ old('title', $assessment->title) }}" required maxlength="20"><br><br>

    <label for="instruction">Instruction:</label><br>
    <textarea name="instruction" id="instruction" required>{{ old('instruction', $assessment->instruction) }}</textarea><br><br>

    <label for="number_of_reviews">Number of Reviews Required (min 1):</label><br>
    <input type="number" name="number_of_reviews" id="number_of_reviews" value="{{ old('number_of_reviews', $assessment->number_of_reviews) }}" required min="1"><br><br>

    <label for="max_score">Max Score (1 to 100):</label><br>
    <input type="number" name="max_score" id="max_score" value="{{ old('max_score', $assessment->max_score) }}" required min="1" max="100"><br><br>

    <label for="due_date">Due Date (must be after today):</label><br>
    <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date', $assessment->due_date->format('Y-m-d\TH:i')) }}" required><br><br>

    <label for="type">Type:</label><br>
    <select name="type" id="type" required>
        <option value="student-select" {{ old('type', $assessment->type) == 'student-select' ? 'selected' : '' }}>Student Select</option>
        <option value="teacher-assign" {{ old('type', $assessment->type) == 'teacher-assign' ? 'selected' : '' }}>Teacher Assign</option>
    </select><br><br>

    <button type="submit" class="btn-custom">Update Assessment</button>
</form>
</div>
@endsection
