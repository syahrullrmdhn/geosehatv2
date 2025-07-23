<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    /** Show OTP form */
    public function showVerifyForm()
    {
        if (! session('two_factor:id')) {
            return redirect()->route('login');
        }
        return view('security.verify-2fa');
    }

    /** Process OTP verify */
    public function verify(Request $request)
    {
        $request->validate(['code'=>'required|digits:6']);

        $user = User::find(session('two_factor:id'));
        if (! $user) {
            return redirect()->route('login');
        }

        if ($request->code !== $user->two_factor_code
            || $user->two_factor_expires_at->isPast()) {
            throw ValidationException::withMessages([
                'code' => 'Kode tidak valid atau sudah kadaluarsa.',
            ]);
        }

        $user->forceFill([
            'two_factor_code'       => null,
            'two_factor_expires_at' => null,
        ])->save();

        Auth::login($user);
        $request->session()->regenerate();
        session()->forget('two_factor:id');
        session()->forget('two_factor:status');

        return redirect()->intended('/');
    }
}
