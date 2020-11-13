<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $bookable = Bookable::findOrFail($id);
        // dd($bookable);


        // così prendo tutte le reviews, se ci fosse reviews() metodo,
        // mi stamperebbe invece la query
        // $reviews = $bookable->reviews;
        // dd($reviews);

        $reviews = $bookable->reviews()->get();
        // dd($reviews);
        return BookableReviewIndexResource::collection(
            $reviews
        );
    }
}
