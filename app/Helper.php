<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }
    public static function tryCatch(...$args)
    {
        try{
            foreach($args as $arg) {
                $arg();
            }
        }catch (\Exception $e) {
            return $e;
        }
    }

    public static function success($payload = null, $message = 'success')
    {
        Response(['status' => 200, 'message' => $message, 'payload' => $payload]);
    }

    public static function failed($message = 'failed')
    {
        Response(['status' => 401, 'message' => $message]);
    }




}
