<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'barcode',
        'quantity',
        'brands',
        'packaging',
        'categories',
        'imported_t',
        'status'
    ];
    use HasFactory;
}
