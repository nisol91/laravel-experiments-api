<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioProject extends Model
{
    // relations

    public function media()
    {
        return $this->hasMany(PortfolioMedia::class);
    }
}
