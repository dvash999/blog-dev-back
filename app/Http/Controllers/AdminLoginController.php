<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminLoginController extends Controller
{
    public static function createAdmin()
    {
//        $rules = [
//            'email' => 'required|string',
//            'password' => 'required|max:10'
//        ];

        $adminInfo = [
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'token' => Str::random(60),
        ];

        $admin = new Admin();
        if ($admin->createAdmin($adminInfo)) {
            return response(['status' => 200, 'message' => 'success']);
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        $validated = Validator::make($request->all(), $rules);

        if($validated->fails())
        {
            return response(['status' => 422, 'message' => 'incorrect credentials', 'payload' => $validated->errors()]);
        }

        if ($token = Admin::getAdmin($request)) {
            return response(['status' => 200, 'message' => 'success', 'payload' => $token]);
        } else {
            return response(['status' => 401, 'message' => 'failed']);
        }
    }

    public function authAdmin(Request $request)
    {
        if (Admin::authAdmin($request->post('token'))) {
            return response(['status' => 200, 'message' => 'success', 'payload' => true]);
        } else {
            return response(['status' => 401, 'message' => 'failed', 'payload' => false]);
        }
    }
}
