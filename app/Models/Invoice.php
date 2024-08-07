<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFileAttribute($photo)
    {
        return $this->uploads . $photo;
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
