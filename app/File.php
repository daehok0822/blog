<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'article_id', 'name'
    ];

    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
