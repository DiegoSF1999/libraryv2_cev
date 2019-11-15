<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use App\users;

class books extends Model
{
    protected $table = 'books';
    protected $fillable = ['title', 'description'];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('App\users', 'users_borrow_books', 'book_id','user_id')->withTimestamps();
    }

}
