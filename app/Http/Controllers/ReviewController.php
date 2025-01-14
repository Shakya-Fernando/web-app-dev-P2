<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // Submut review (s)
    public function submitReview(Request $request, $assessment_id)
    {
        $assessment = Assessment::findOrFail($assessment_id);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'reviewee_id' => 'required|exists:users,id',
            'content' => 'required|string|min:5',
        ]);

        // Check if the reviewee is different and not already reviewed
        $existingReview = Review::where('assessment_id', $assessment_id)
            ->where('reviewer_id', $user->id)
            ->where('reviewee_id', $request->reviewee_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this student.');
        }

        Review::create([
            'assessment_id' => $assessment_id,
            'reviewer_id' => $user->id,
            'reviewee_id' => $request->reviewee_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
    // Rate review (s)
    public function rateReview(Request $request, $review_id)
    {
        $review = Review::findOrFail($review_id);
        $user = Auth::user();

        // Ensure the user is the reviewee
        if ($review->reviewee_id != $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
        ]);

        // Check if the user has already rated this review
        $existingRating = $review->ratings()->where('rated_by', $user->id)->first();

        if ($existingRating) {
            return redirect()->back()->with('error', 'You have already rated this review.');
        }

        $review->ratings()->create([
            'rated_by' => $user->id,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Review rated successfully.');
    }
    // Show review
    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.show', compact('review'));
    }

}
