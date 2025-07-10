<?php
namespace App\Http\Controllers;

class PwaController extends Controller
{
    public function settings()
    {
        return view('pwa.settings');
    }

    public function offlineSync()
    {
        return view('pwa.offline');
    }
}
