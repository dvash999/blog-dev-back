<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{

    protected $fillable = ['email', 'password', 'token'];

    public static function getAdmin($adminInfo)
    {
        $email = $adminInfo->post('email');
        $password = $adminInfo->post('password');

        try {
            $admin = DB::table('admins')->where('email', $email)->first();
            if (Hash::check($password, $admin->password)) {
                return $admin->token;
            } else {
                return false;
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public static function authAdmin($token)
    {
        return DB::table('admins')->where('token', $token)->first();
    }


    public function createAdmin($adminInfo)
    {
//        try {
//            $this->fill($adminInfo);
//            return $this->save();
//        } catch (Exception $e) {
//            print_r($e);
//        }

    }

}
