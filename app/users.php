<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use \Firebase\JWT\JWT;
Use App\books;

class users extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    public $timestamps = false;

    public function books()
    {
        return $this->belongsToMany('App\books', 'users_borrow_books','user_id', 'book_id')->withTimestamps();
    }

    public function register(Request $request) {

        $user = new self();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();

        $token = $this->getTokenbyUser($user);

        return $token;

    }

    public function login(Request $request){
        try {
            $user = $this->getuserbyEmail($request->email);
        } catch (\Throwable $th) {
            return 204;
        }
        

            if ($user->password == $request->password) {
           
                return $user;
            } else {
                return 204;
 
        }


    }



    private function getuserbyEmail($email)
    {

        $user = users::findOrFail(DB::table('users')
        ->where('email', $email)
        ->select('users.*')->first()->id);

        return $user;
   
    }

    private function getuserbyId($id)
    {
        $user = users::findOrFail(DB::table('users')
        ->where('id', $id)
        ->select('users.*')->first()->id);

        return $user;

    }

    public function getTokenbyuser($user){

        $key = $user->password;
        $data_token = $user->email;

        $token = JWT::encode($data_token, $key);

        return $token;

    }

    public function getdecodedtoken($token, $user)
    {
        $decoded = JWT::decode($token, $user->password, array('HS256'));
        
        return $decoded;
    }


}
