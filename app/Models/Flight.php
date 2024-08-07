<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $uploads = '/flightPDF/';

    protected $upload_barcode = '/flightbarcode/';

    protected $guarded = [];

    public function getFileAttribute($photo)
    {
        return $this->uploads . $photo;
    }

    public function getBarcodeAttribute($photo)
    {
        return $this->upload_barcode . $photo;
    }

    public function getFlogoAttribute($photo)
    {
        return $this->upload_barcode . $photo;
    }
}
