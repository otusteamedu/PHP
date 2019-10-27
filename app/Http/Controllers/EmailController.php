<?php

namespace App\Http\Controllers;

use App\EmailValidator;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index()
    {
        return view('emails.index');
    }

    public function check(Request $request, EmailValidator $emailValidator)
    {
        $email = $request->get('email');

        return view('emails.check', [
            'isValidEmail' => $emailValidator->check($email),
        ]);
    }
}
