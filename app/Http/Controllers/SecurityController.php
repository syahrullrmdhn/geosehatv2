<?php
namespace App\Http\Controllers;

class SecurityController extends Controller
{
    public function twoFactor()
    {
        return view('security.2fa');
    }
}
