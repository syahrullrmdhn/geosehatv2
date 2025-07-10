<?php
namespace App\Http\Controllers;

use App\Models\Webhook;

class WebhookController extends Controller
{
    public function index()
    {
        $webhooks = Webhook::all();
        return view('webhooks.index', compact('webhooks'));
    }
}
