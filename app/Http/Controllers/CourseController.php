<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assessment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    // Swow course
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $assessments = $course->assessments;
        $user = Auth::user();
    
        // Initialize $studentsNotEnrolled as an empty collection
        $studentsNotEnrolled = collect();
    
        if ($user->role == 'teacher') {
            // Get IDs of students enrolled in the course
            $enrolledStudentIds = $course->users()
                ->wherePivot('role', 'student')
                ->pluck('users.id')
                ->toArray();
    
            // Fetch all students not enrolled in the course
            $studentsNotEnrolled = User::where('role', 'student')
                ->whereNotIn('id', $enrolledStudentIds)
                ->get();
        }
    
        return view('courses.show', compact('course', 'assessments', 'studentsNotEnrolled'));
    }

    // Method for teachers to enroll students
    public function enrollStudent(Request $request, $id)
    {
        $course = Course::findOrFail($id);
    
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $student = User::find($request->student_id);
    
        // Verify that the selected user is a student
        if ($student->role != 'student') {
            return redirect()->back()->with('error', 'Selected user is not a student.');
        }
    
        // Check if the student is already enrolled in the course
        $alreadyEnrolled = $course->users()
            ->wherePivot('role', 'student')
            ->where('users.id', $student->id)
            ->exists();
    
        if ($alreadyEnrolled) {
            return redirect()->back()->with('error', 'Student is already enrolled in this course.');
        }
    
        // Enroll the student
        $course->users()->attach($student->id, ['role' => 'student']);
    
        return redirect()->back()->with('success', 'Student enrolled successfully.');
    }
    // Display the file upload form
    public function showUploadForm()
    {
        return view('courses.upload');
    }

    // Handle the file upload
    public function uploadCourseFile(Request $request)
    {
        $request->validate([
            'course_file' => 'required|file|mimes:txt|max:2048',
        ]);

        $file = $request->file('course_file');
        $content = file_get_contents($file->getRealPath());

        // Process the file content
        $result = $this->processCourseFile($content);

        if ($result['status'] == 'error') {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', 'Course uploaded successfully.');
    }

    // Process the course file content
    private function processCourseFile($content)
    {
        try {
            // Parse the file content
            $lines = preg_split("/\r\n|\n|\r/", $content);
            $data = [];
            $section = null;

            foreach ($lines as $line) {
                $line = trim($line);

                if (empty($line)) {
                    continue;
                }

                // Check for section headers
                if (strpos($line, 'Course Code:') === 0) {
                    $data['course_code'] = trim(substr($line, strlen('Course Code:')));
                } elseif (strpos($line, 'Course Name:') === 0) {
                    $data['course_name'] = trim(substr($line, strlen('Course Name:')));
                } elseif ($line == 'Teachers:') {
                    $section = 'teachers';
                    $data['teachers'] = [];
                } elseif ($line == 'Assessments:') {
                    $section = 'assessments';
                    $data['assessments'] = [];
                } elseif ($line == 'Students:') {
                    $section = 'students';
                    $data['students'] = [];
                } else {
                    // Process section data
                    if ($section == 'teachers') {
                        $data['teachers'][] = $line;
                    } elseif ($section == 'assessments') {
                        $data['assessments'][] = $line;
                    } elseif ($section == 'students') {
                        $data['students'][] = $line;
                    }
                }
            }

            // Validate required data
            if (empty($data['course_code']) || empty($data['course_name'])) {
                return ['status' => 'error', 'message' => 'Course code and name are required.'];
            }

            // Check if the course already exists
            $existingCourse = Course::where('code', $data['course_code'])->first();
            if ($existingCourse) {
                return ['status' => 'error', 'message' => 'A course with this code already exists.'];
            }

            // Create the course
            $course = new Course();
            $course->code = $data['course_code'];
            $course->name = $data['course_name'];
            $course->save();

            // Attach teachers to the course
            if (!empty($data['teachers'])) {
                foreach ($data['teachers'] as $teacher_s_number) {
                    $teacher = User::where('s_number', $teacher_s_number)->first();

                    if (!$teacher) {
                        // Optionally, create the teacher account if not exists
                        $teacher = new User();
                        $teacher->s_number = $teacher_s_number;
                        $teacher->name = 'Teacher ' . $teacher_s_number;
                        $teacher->email = $teacher_s_number . '@example.com';
                        $teacher->password = Hash::make('password');
                        $teacher->role = 'teacher';
                        $teacher->save();
                    }

                    // Enroll the teacher in the course
                    $course->users()->attach($teacher->id, ['role' => 'teacher']);
                }
            }

            // Create assessments
            if (!empty($data['assessments'])) {
                foreach ($data['assessments'] as $assessmentLine) {
                    $assessmentParts = explode('|', $assessmentLine);

                    if (count($assessmentParts) != 6) {
                        continue; // Skip invalid lines
                    }

                    $assessment = new Assessment();
                    $assessment->course_id = $course->id;
                    $assessment->title = trim($assessmentParts[0]);
                    $assessment->instruction = trim($assessmentParts[1]);
                    $assessment->due_date = trim($assessmentParts[2]);
                    $assessment->type = trim($assessmentParts[3]);
                    $assessment->max_score = (int)trim($assessmentParts[4]);
                    $assessment->number_of_reviews = (int)trim($assessmentParts[5]);
                    $assessment->save();
                }
            }

            // Enroll students
            if (!empty($data['students'])) {
                foreach ($data['students'] as $student_s_number) {
                    $student = User::where('s_number', $student_s_number)->first();

                    if (!$student) {
                        // Optionally, create the student account if not exists
                        $student = new User();
                        $student->s_number = $student_s_number;
                        $student->name = 'Student ' . $student_s_number;
                        $student->email = $student_s_number . '@example.com';
                        $student->password = Hash::make('password');
                        $student->role = 'student';
                        $student->save();
                    }

                    // Enroll the student in the course
                    $course->users()->attach($student->id, ['role' => 'student']);
                }
            }

            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'An error occurred while processing the file: ' . $e->getMessage()];
        }
    }
}
