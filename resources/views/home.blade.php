<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-home">
    <div class="container-card1">
        <h1 class="pink-highlight">Your Courses</h1>
        <!-- See enrolled courses -->
        <ul class="list-group">
            @foreach($courses as $course)
                <li class="list-group-item">
                    <a href="{{ route('courses.show', $course->id) }}">{{ $course->code }} - {{ $course->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
        @auth
            @if(Auth::user()->role == 'teacher')
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <!-- ONLY teachers can upload course form -->
                <div class="container-card2">
                <h1 class="mt-4 pink-highlight">Upload Course File</h2>
                <form action="{{ route('courses.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    <div class="form-group">
                        <label for="course_file">Select Course File (.txt):</label>
                        <input type="file" name="course_file" id="course_file" accept=".txt" required class="form-control-file">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
                </div>
            @endif
        @endauth
</div>
@endsection
