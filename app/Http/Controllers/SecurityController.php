<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class SecurityController extends Controller
{
    /** Show 2FA settings */
    public function twoFactor()
    {
        $user = Auth::user();
        return view('security.2fa', compact('user'));
    }

    /** Enable 2FA with chat_id verification */
    public function enable2fa(Request $request)
    {
        $request->validate(['chat_id'=>'required|numeric']);
        $chatId = $request->chat_id;
        $token  = config('app.telegram_bot_token');

        $response = Http::asForm()
            ->timeout(5)
            ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text'    => 'Verifikasi chat untuk 2FA GeoSehat.',
            ]);

        if (! $response->successful() || ! data_get($response->json(),'ok')) {
            throw ValidationException::withMessages([
                'chat_id' => 'Chat ID invalid atau Anda belum mengirim /start ke bot.',
            ]);
        }

        $user = Auth::user();
        $user->two_factor_enabled  = true;
        $user->two_factor_chat_id  = $chatId;
        $user->save();

        return back()->with('success','2FA berhasil diaktifkan.');
    }

    /** Disable 2FA */
    public function disable2fa()
    {
        $user = Auth::user();
        $user->two_factor_enabled  = false;
        $user->two_factor_chat_id  = null;
        $user->save();

        return back()->with('success','2FA berhasil dinonaktifkan.');
    }
}
