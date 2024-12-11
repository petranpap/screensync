<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    public function screens()
    {
        return $this->belongsToMany(Screen::class)->withPivot('image_file');
    }

}
