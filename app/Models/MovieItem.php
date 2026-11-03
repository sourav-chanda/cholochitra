<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieItem extends Model
{
    protected $fillable = [
        'tmdb_id',
        'title',
        'download_link_1080p',
        'download_link_720p',
    ];
}
