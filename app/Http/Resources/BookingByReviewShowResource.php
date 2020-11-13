<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingByReviewShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'booking_id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            // creo una risorsa apposta che visualizza il bookable, cosi che nella chiamata
            // non vedo solo il bookable id ma il bookable vero e proprio
            // (ricorda: alla risorsa passo il bookable, tanto c'è la relazione)
            'bookable' => new BookingByReviewBookableShowResource($this->bookable),
        ];
    }
}
