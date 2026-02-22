<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = ['name', 'description', 'link'];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
