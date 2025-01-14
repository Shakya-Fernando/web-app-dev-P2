@extends('layouts.app')

@section('content')
<h1>Upload Course File</h1>
<!-- Errors -->
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
<!-- ONLY teachers can upload course form - MOVED TO HOME -->
<form action="{{ route('courses.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="course_file">Select Course File (.txt):</label><br>
    <input type="file" name="course_file" id="course_file" accept=".txt" required><br><br>
    <button type="submit">Upload</button>
</form>
@endsection
