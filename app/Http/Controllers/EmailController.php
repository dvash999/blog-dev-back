<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\SendMail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $rules = [
            'name'      => 'required|string',
            'email'     => 'required|email',
            'content'   => 'required|string|max:500'
        ];
        try {
            $this->validate($request, $rules);

            $data = array(
                'name'      => $request->name,
                'email'     => $request->email,
                'content'   => $request->get('content')
            );

            Mail::to('drordvash4@gmail.com')->send(new SendMail($data));

            return response(['message' => 'success', 'status' => 200]);

        } catch (ValidationException $e) {
            return response(['message' => 'failed', 'status' => 400]);
        }
    }
}
