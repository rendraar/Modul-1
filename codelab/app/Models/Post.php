<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * 
     * @var array
     */

     protected $fillable = [
        'image',
        'title',
        'content',
     ];

     /**
      * 
      * @return Atribute
      */

      protected function image(): Attribute{
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/' . $image),
        );
      }
}
