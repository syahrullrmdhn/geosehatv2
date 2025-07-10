<?php
namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function docs()
    {
        return view('api.docs');
    }
}
