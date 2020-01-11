<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email'     =>     'require|email|unique',
            'password'  =>      'require|min:6'
        ];

        $this->validate($request, $rules);

        DB::table('admin')
            ->where([['email', $request->post('email')], ['password', $request->post('password')]]);

    }

    public function insertAdmin()
    {
        $newAdmin = [
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(bcrypt(env('ADMIN_PASSWORD')))
        ];

        DB::table('admin')->insert($newAdmin);
    }
}
