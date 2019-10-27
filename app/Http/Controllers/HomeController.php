<?php

namespace App\Http\Controllers;

use App\BracketsChecker;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $line = $request->get('string');

        if($line && app(BracketsChecker::class)->check($line)) {
            return response('OK');
        } else {
            return response('FAIL', 400);
        }
    }
}
