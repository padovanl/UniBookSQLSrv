<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use JWTAuth;

class authController extends Controller
{

    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return response()->json(['result'=>true]);
    }

    public function login(Request $request) {

      $input = $request->only(['email', 'password']);   //Get the USERID and PSW from request.

      if ($user = User::where('email', $input['email'])->first()) {

        if (User::where('Password', md5($input['password']))->first()) {

          $token = JWTAuth::fromUser($user);  //Generate token from User Object.
          JWTAuth::setToken($token);          //Set generated token.

          return response()->json(['result' => $token]);
        }
        else
          return response()->json(['error' => "Password errata."]);
      }
      else
        return response()->json(['error' => "Nome utente non trovato."]);
    }


    public function get_user_details(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);
    }

}
