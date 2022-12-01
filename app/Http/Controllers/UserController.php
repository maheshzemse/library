<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return response()->json(['data'=> $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->mobile  = $request->mobile ;
            $user->age = $request->age;
            $user->gender = $request->gender;
            $user->city = $request->city;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        }
    
    
    
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrfail($id);
        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $user = User::find($id);

            return response()->json(['data'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user= User::findOrfail($id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobile  = $request->mobile ;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->city = $request->city;
        $user->email = $request->email;
        if($user->save())
        {
            return response()->json([
                'message' => 'User Updated successfully',
                'success' => true,
                'data' => $user
            ], 200);

        }
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $user = User::findOrfail($id);

        if($user->delete())
        {
            return response()->json([
                'message' => 'User Deleted successfully',
                'success' => true,
                'data' => $user
            ], 200);
    }
}
}