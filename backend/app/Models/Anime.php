<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'datanime'; // Make sure to change this to your table name

    protected $fillable = ['anime_name', 'slug', 'type', 'status', 'image_url', 'description', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
