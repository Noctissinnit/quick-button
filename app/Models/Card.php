<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'url', 'order', 'category', 'image', 'institution_id'];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
