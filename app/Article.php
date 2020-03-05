<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
        'title', 'description', 'user_id','category_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopearticleSearch($query, $searchWord)
    {
        if(empty($searchWord)) {
            return $query;
        } else {
            return $query->where('description', 'like', '%' . $searchWord . '%')
                ->orWhere('title', 'like', '%' . $searchWord . '%');
        }
    }

}
