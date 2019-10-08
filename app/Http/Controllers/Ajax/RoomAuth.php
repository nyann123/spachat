<?php

namespace App\Http\Controllers\ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RoomAuth extends Controller
{
    public function __invoke(Request $request)
    {
        if (Hash::check($request->password, $request->hash)) {

            return 'sucsess';
            
        }
    }
}
