<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function article(){
        return $this->hasOne('App\Article'); //article이 category_id를 가지게 될 것임
    }
}
