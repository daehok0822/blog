<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopearticleSearch($query, $searchWord)
    {
        if(empty($searchWord)) {
            return $query;
        } else {
            return $query->whereRaw("MATCH(title, body) AGAINST(? IN BOOLEAN MODE)", [$searchWord . "*"]);
        }
    }

}
