<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
class ApiController extends Controller
{
   // public $loginAfterSignUp = true;

    // public function register(RegisterAuthRequest $request)
    // {
    //     $user = new User;
    //     $user->firstname = $request->firstname;
    //     $user->lastname = $request->lastname;
    //     $user->mobile  = $request->mobile ;
    //     $user->age = $request->age;
    //     $user->gender = $request->gender;
    //     $user->city = $request->city;
    //     $user->email = $request->email;
    //     $user->password = bcrypt($request->password);
    //     $user->save();
 
    //     if ($this->loginAfterSignUp) {
    //         return $this->login($request);
    //     }
 
    //     return response()->json([
    //         'success' => true,
    //         'data' => $user
    //     ], 200);
    // }



    // public function login(Request $request)
    // {
    //     $input = $request->only('email', 'password');
    //     $jwt_token = null;
 
    //     if (!$jwt_token = JWTAuth::attempt($input)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid Email or Password',
    //         ], 401);
    //     }
 
    //     return response()->json([
    //         'success' => true,
    //         'token' => $jwt_token,
    //     ]);
    // }


    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('firstname','lastname','mobile','email','age','gender' ,'email','city', 'password');
        $validator = Validator::make($data, [
         
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
                 'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'mobile'  => $request->mobile ,
                'age' => $request->age,
                'gender' => $request->gender,
                'city' => $request->city,
                'email' => $request->email,
                'password'=> bcrypt($request->password),
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }
 


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }
 	
 		//Token created, return with success response and jwt token
        return response()->json([
            'data' => $credentials,
            'success' => true,
            'token' => $token,
        ]);
    }












    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function getAuthUser()
    {
      
 
                $data = "This is the test data";
                    return response()->json(compact('data'),200);
    }
 
 
}
