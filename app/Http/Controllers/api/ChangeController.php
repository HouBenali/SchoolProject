<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRegisterController;
use App\Http\Requests\RequestNick;
use App\Http\Requests\RequestEmail;
use App\Http\Requests\RequestPass;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
// use Validator;
// use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class ChangeController extends ApiResponseController
{
    public function index()
    {
        $pokemons = Pokemon::orderBy('created_at','desc')->paginate(10);
        return $this->successResponse($pokemons);
    }
    
    public function updateEmail(Request $request) {
        // dd($request->all()['nick']);
        $validator = Validator::make($request->all(), RequestEmail::myRules());

        $email=$request->all()['email'];

        if ($validator->fails()) {
            // return $validator->errors();
            return $validator->errors($validator);
        }else{
            $id=\Auth::user()->id;
            $user=DB::table('users')->where('id',$id)->update([
                'email' => $email,
            ]);
            // dd($validator->validated()); 

            return $this->successResponse("exito");
            }
 
    }


    public function updateNick(Request $request) {
        $validator = Validator::make($request->all(), RequestNick::myRules());

        $nick=$request->all()['nick'];
       
        if ($validator->fails()) {
        
            return $validator->errors($validator);
        }else{
            $id=\Auth::user()->id;
            $user=DB::table('users')->where('id',$id)->update([
                'nick' => $nick,
            ]);
            return $this->successResponse("exito");
            }
 
    }

    public function reset(Request $request) {
        
        $validator = Validator::make($request->all(), RequestPass::myRules());
        $password=$request->all()['password'];
        $opassword=$request->all()['opassword'];
        $id=\Auth::user()->id;
        $user = DB::table('users')->where('id',$id)->first();
        $pass=$user->password;
        $hashedPassword=$pass;
        if ($validator->fails() || (!(Hash::check($opassword, $hashedPassword)))) {
            return "Error";
        } else {
            $user=DB::table('users')->where('id',$id)->update([
                'password' => Hash::make($password),
            ]);
            return  $this->successResponse("exito");
        }
        
    }

}
