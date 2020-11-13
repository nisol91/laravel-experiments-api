<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id)
    {
        // non chiamo direttamente review ma chiamo una resource
        // che mi espone solamente la data di creazione, dal momento che è pubblica

        return new ReviewResource(Review::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'id' => 'required|size:36|unique:reviews',
                'content' => 'required|min:2',
                'rating' => 'required|in:1,2,3,4,5',

            ]
        );

        $booking = Booking::findByReviewKey($data['id']);
        if ($booking === null) {
            return abort(404);
        }

        // questo per sicurezza
        $booking->review_key = '';
        $booking->save();


        // ricordati di attivare il fillable nel model
        $review = Review::make($data);

        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();

        return new ReviewResource($review);
    }
}
