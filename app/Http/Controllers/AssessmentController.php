<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssessmentController extends Controller
{
    // Create assessment
    public function create(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);

        return view('assessments.create', compact('course'));
    }

    // Store assessment details
    public function store(Request $request, $course_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:20',
            'instruction' => 'required|string',
            'number_of_reviews' => 'required|integer|min:1',
            'max_score' => 'required|integer|between:1,100',
            'due_date' => 'required|date|after:today',
            'type' => 'required|in:student-select,teacher-assign',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Assessment::create([
            'course_id' => $course_id,
            'title' => $request->title,
            'instruction' => $request->instruction,
            'number_of_reviews' => $request->number_of_reviews,
            'max_score' => $request->max_score,
            'due_date' => $request->due_date,
            'type' => $request->type,
        ]);

        return redirect()->route('courses.show', $course_id)->with('success', 'Assessment created successfully.');
    }

    // Show assessment edit form
    public function edit($id)
    {
        $assessment = Assessment::findOrFail($id);

        // Check if there are any submissions for this assessment
        $submissionsExist = $assessment->reviews()->exists();

        if ($submissionsExist) {
            return redirect()->route('assessments.show', $id)
                ->with('error', 'This assessment cannot be updated because submissions already exist.');
        }

        return view('assessments.edit', compact('assessment'));
    }

    // Update correct assessment with new info
    public function update(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        // Check if there are any submissions for this assessment
        $submissionsExist = $assessment->reviews()->exists();

        if ($submissionsExist) {
            return redirect()->route('assessments.show', $id)
                ->with('error', 'This assessment cannot be updated because submissions already exist.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:20',
            'instruction' => 'required|string',
            'number_of_reviews' => 'required|integer|min:1',
            'max_score' => 'required|integer|between:1,100',
            'due_date' => 'required|date|after:today',
            'type' => 'required|in:student-select,teacher-assign',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the assessment
        $assessment->title = $request->title;
        $assessment->instruction = $request->instruction;
        $assessment->number_of_reviews = $request->number_of_reviews;
        $assessment->max_score = $request->max_score;
        $assessment->due_date = $request->due_date;
        $assessment->type = $request->type;
        $assessment->save();

        return redirect()->route('assessments.show', $id)
            ->with('success', 'Assessment updated successfully.');
    }

    // Show assessment
    public function show($id)
    {
        $assessment = Assessment::findOrFail($id);
        $user = Auth::user();
    
        if ($user->role == 'teacher') {
            // Fetch students enrolled in the course with pagination
            $students = $assessment->course->users()
                ->wherePivot('role', 'student')
                ->paginate(10);
    
            return view('assessments.teacher_show', compact('assessment', 'students'));
        } elseif ($user->role == 'student') {
            // Fetch necessary data for the student view
            $reviewsSubmitted = $assessment->reviews()->where('reviewer_id', $user->id)->get();
            $reviewsReceived = $assessment->reviews()->where('reviewee_id', $user->id)->get();
            $score = $assessment->scores()->where('student_id', $user->id)->first();
    
            return view('assessments.student_show', compact('assessment', 'reviewsSubmitted', 'reviewsReceived', 'score'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
    
    // Mark assessment
    public function markStudent($assessment_id, $student_id)
    {
        $assessment = Assessment::findOrFail($assessment_id);
        $student = User::findOrFail($student_id);

        $reviewsSubmitted = $assessment->reviews()->where('reviewer_id', $student_id)->get();
        $reviewsReceived = $assessment->reviews()->where('reviewee_id', $student_id)->get();

        return view('assessments.mark', compact('assessment', 'student', 'reviewsSubmitted', 'reviewsReceived'));
    }

    // Assign score to assessment
    public function assignScore(Request $request, $assessment_id, $student_id)
    {
        $assessment = Assessment::findOrFail($assessment_id); 
        $student = User::findOrFail($student_id);

        $validator = Validator::make($request->all(), [
            'score' => 'required|integer|between:0,' . $assessment->max_score,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Assign the score
        $score = $assessment->scores()->updateOrCreate(
            ['student_id' => $student_id],
            ['score' => $request->score]
        );

        return redirect()->route('assessments.show', $assessment_id)->with('success', 'Score assigned successfully.');
    }

}
