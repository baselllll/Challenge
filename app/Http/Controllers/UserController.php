<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isTrue;


class UserController extends Controller
{

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(Request $request){
        $validator =  Validator::make($request->all(), [
            'email'=>'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 200);
        }
        $check_login = $this->authService->login($request->email);
        if($check_login == true){
            $this->authService->send_code($request->email);
            return response()->json([
                'status' => true,
                'message' => 'success',
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'failed',
            ], 401);
        }
    }
    public function register(Request $request){
        $validator =  Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 200);
        }
        $first_auth = $this->authService->register([
            "name"=>$request->name,
            "email"=>$request->email]);

        if(isset($first_auth)){
            return response()->json([
                'status' => true,
                'message' => 'success created',
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'failed created',
            ], 401);
        }
    }
    public function verify(Request $request){
        $validator =  Validator::make($request->all(), [
            'email'=>'required|email',
            'code'=>'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 200);
        }
        $data = $this->authService->verify($request->code,$request->email);

        if(isset($data)){
            return response()->json([
                'status' => true,
                'message' => "success verified code",
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => $data,
            ], 401);
        }
    }
     public function send_code(Request $request){
         $validator =  Validator::make($request->all(), [
             'email'=>'required|email'
         ]);
         if ($validator->fails()) {
             return response()->json([
                 'status' => false,
                 'message' => 'validation error',
                 'errors' => $validator->errors()
             ], 200);
         }
         $send_code = $this->authService->send_code($request->email);
         if(isset($send_code)){
             return response()->json([
                 'status' => true,
                 'message' => 'success updated',
             ], 200);
         }else{
             return response()->json([
                 'status' => false,
                 'message' => 'failed updated',
             ], 401);
         }
     }
}
