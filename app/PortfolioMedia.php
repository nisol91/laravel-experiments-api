<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioMedia extends Model
{
    // relazioni

    public function address()
    {
        return $this->belongsTo(PortfolioProject::class);
    }
}
