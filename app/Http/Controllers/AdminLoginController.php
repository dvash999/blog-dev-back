<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email'     =>     'required|email',
            'password'  =>     'required|min:6'
        ];

        $this->validate($request, $rules);

        $email = $request->post('email');
        $password = $request->post('password');

        try {
            $admin = Admin::getAdmin($email);

            if (Hash::check($password, $admin->password)) {
                Helper::success($admin->token);
            } else {
                Helper::failed('Bad Credentials');
            }

        } catch (\Exception $e) {
            return $e;
        }

    }

    public static function createAdmin()
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|max:10'
        ];

        $adminInfo = [
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'token' => Str::random(60),
        ];

        Admin::createAdmin($adminInfo) ? Helper::success() : Helper::failed();
    }
}
