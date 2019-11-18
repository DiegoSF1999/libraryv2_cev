<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use \Firebase\JWT\JWT;
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

    public function register(Request $request) {

        $book = new self();
    
        $book->title = $request->title;
        $book->description = $request->description;
    
        $book->save();

        return $book;
    
    }

    public function getbookbytitle($title){

        $book = books::findOrFail(DB::table('books')->where('title', $title)
        ->first()->id);
       

        return $book; 
    }

    public function getbookbyid($id){

        $book = books::findOrFail($id);
       

        return $book; 
    }

}
