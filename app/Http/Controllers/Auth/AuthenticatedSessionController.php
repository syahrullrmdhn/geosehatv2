<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /** Show login form */
    public function create()
    {
        return view('auth.login');
    }

    /** Handle login + 2FA */
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($request->only('email','password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        if ($user->two_factor_enabled) {
            Auth::logout();

            // generate OTP
            $code = rand(100000, 999999);
            $user->forceFill([
                'two_factor_code'       => $code,
                'two_factor_expires_at' => now()->addMinutes(5),
            ])->save();

            // send via Telegram
            $token  = config('app.telegram_bot_token');
            $chatId = $user->two_factor_chat_id;

            try {
                $response = Http::asForm()
                    ->timeout(5)
                    ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                        'chat_id' => $chatId,
                        'text'    => "Kode login Anda: {$code}",
                    ]);

                Log::info('Telegram sendMessage', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                session(['two_factor:status' =>
                    $response->successful() && data_get($response->json(),'ok')
                        ? 'Kode OTP telah dikirim ke Telegram Anda.'
                        : 'Gagal mengirim kode via Telegram.'
                ]);
            } catch (\Exception $e) {
                Log::error('Telegram exception: '.$e->getMessage());
                session(['two_factor:status' => 'Gagal mengirim kode via Telegram.']);
            }

            session(['two_factor:id' => $user->id]);
            return redirect()->route('2fa.verify');
        }

        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    /** Logout */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
