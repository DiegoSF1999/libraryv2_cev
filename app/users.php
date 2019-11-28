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



    public function getuserbyEmail($email)
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
        $data_token = $user->email . $user->password;

        $token1 = JWT::encode($data_token, $key);

        $token2 = JWT::encode($data_token, $token1);

        $data_token = $token1;

        $token3 = JWT::encode($data_token, $token2);

        $data_token = $token2;

        $token4 = JWT::encode($data_token, $token3);

        $data_token = $token3;

        $token5 = JWT::encode($data_token, $token4);

        $data_token = $token4;

        $token6 = JWT::encode($data_token, $token5);

        $token = JWT::encode($token5, $token6 . $token5 . $token4 . $token3 . $token2);

        return $token;

    }

    public function getdecodedtoken($token, $key)       //FUNCION OBSOLETA
    {
        $decoded = JWT::decode($token, $key, array('HS256'));
        
        return $decoded;
    }

    
    

}
