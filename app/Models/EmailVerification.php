<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmailVerification extends Model
{
    protected $fillable = ['email', 'otp', 'expires_at', 'is_verified'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function isExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    public static function generateOTP($email)
    {
        // Cek apakah ada OTP yang masih valid dalam 1 menit terakhir (anti spam)
        $recentOTP = self::where('email', $email)
            ->where('created_at', '>', Carbon::now()->subMinute())
            ->first();
            
        if ($recentOTP) {
            throw new \Exception('Silakan tunggu 1 menit sebelum meminta OTP baru.');
        }

        // Hapus OTP lama untuk email ini
        self::where('email', $email)->delete();

        // Generate OTP 6 digit
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        return self::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10), // Berlaku 10 menit
        ]);
    }
}