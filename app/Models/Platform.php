<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /** @use HasFactory<\Database\Factories\PlatformFactory> */
    use HasFactory;
    protected $table    = 'platforms';
    protected $fillable = ['name', 'type'];
    protected $hidden   = [];
    public $timestamps  = true;
}
