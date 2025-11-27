<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailVerification;
use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function showVerifyForm()
    {
        if (!session('registration_data')) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        return view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $registrationData = session('registration_data');
        if (!$registrationData) {
            return back()->with('error', 'Session expired. Please register again.');
        }

        $verification = EmailVerification::where('email', $registrationData['email'])
            ->where('otp', $request->otp)
            ->where('is_verified', false)
            ->first();

        if (!$verification) {
            return back()->with('error', 'Kode OTP tidak valid!');
        }

        if ($verification->isExpired()) {
            return back()->with('error', 'Kode OTP sudah kedaluwarsa!');
        }

        // Buat user baru
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($registrationData['password']),
            'role' => $registrationData['role'],
            'email_verified_at' => now(),
        ]);

        // Mark OTP as verified
        $verification->update(['is_verified' => true]);

        // Clear session
        session()->forget('registration_data');

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }

    public function resendOTP()
    {
        $registrationData = session('registration_data');
        if (!$registrationData) {
            return back()->with('error', 'Session expired. Please register again.');
        }

        try {
            $verification = EmailVerification::generateOTP($registrationData['email']);
            Mail::to($registrationData['email'])->send(new OTPMail($verification->otp, $registrationData['name']));

            return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }
}