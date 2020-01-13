<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{

    protected $fillable = ['email', 'password', 'token'];

    public static function createAdmin(array $attributes = [])
    {
        try {
            $admin = new self();
            $admin->fill($attributes);
            $admin->save();
            return $admin;
        } catch (\Exception $e) {
            DB::rollBack();
        }

    }

    public static function getAdmin($email)
    {
        return DB::table('admin')->where('email', $email)->get();
    }

}
