<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'article_id', 'thumbnail_image', 'description_image', 'original_image'
    ];

    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
