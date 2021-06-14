<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validate dữ liệu
        $this->validate($request, [
            'fullname' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        // sau khi lưu dữ liệu user mới vào CSDL, tiến hành đăng nhập luôn rồi trả về token đăng nhập
        if (!$token = JWTAuth::attempt($request->only(['fullname', 'username', 'password']))) {
            return abort(401);
        }
        return (new UserResource($user))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$token = JWTAuth::attempt($request->only(['fullname', 'username', 'password']))) {
            return response()->json([
                'errors' => [
                    'username' => ['There is something wrong! We could not verify details']
                ]
            ], 422);
        }
        dd(new UserResource($request->user()))
        ->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }

    public function user()
    {
        return [
            'data' => JWTAuth::parseToken()->authenticate()
        ];
    }
}
