<?php

namespace App\Http\Controllers;

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

        try {
            return DB::table('admin')
                ->where([['email', $request->post('email')], ['password', $request->post('password')]])
                ->get();
        } catch (\Exception $e) {
            return $e;
        }

    }

    public function insertAdmin()
    {
        $newAdmin = [
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'token' => Str::random(60),
        ];

        DB::table('admin')->insert($newAdmin);
    }
}
