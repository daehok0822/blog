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

    public function scopeArticleSearch($query, $searchWord)
    {
        if(empty($searchWord)) {
            return $query;
        } else {
            return $query->whereRaw("MATCH(title, description) AGAINST(? IN BOOLEAN MODE)", [$searchWord . "*"]);
//            return $query->where('description', 'like', '%' . $searchWord . '%')
//                ->orWhere('title', 'like', '%' . $searchWord . '%');
        }
    }
//    public function scopecategorySearch($query, $id){
//        if(empty($id)) {
//            return $query;
//        } else {
//            return $query->join('categories','articles.category_id', '=', 'categories.id')
//                ->where('categories.id', $id);
//
//        }
//    }

}
