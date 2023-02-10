<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public static function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|min:10',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'response'=>$validator->errors()
            ]);
        }else{
            $userObj = new User();
            $userInfo = $userObj->getAllUsers()
                                ->where('email', '==', $request->email);
            $result  = $userObj->store($request->name, $request->surname,$request->email, $request->phone, $request->password);
            if($result){
                return response()->json([
                    'status'=>200,
                    'response'=>['massage' => 'User successfully registered']
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'response'=>['massage' => 'Sorry couldn\'t add new user']
                ]);
            }
        }
    }
    public static function userLogin(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'response'=>$validator->errors()
            ]);
        }else{
            if(auth()->attempt(request()->only(['email', 'password']))){
                return response()->json([
                    'status'=>200,
                    'response'=>['massage' => 'Successfully logged in']
                ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'response'=>['massage' => 'Invalid login details']
                ]);
            }
        }
    }
    public static function userLogout(){
        auth()->logout();
        return redirect('/');
    }
}
