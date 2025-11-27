<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email}';
    protected $description = 'Test email sending';

    public function handle()
    {
        $email = $this->argument('email');
        $otp = '123456';
        
        try {
            Mail::to($email)->send(new OTPMail($otp, 'Test User'));
            $this->info("Email berhasil dikirim ke: {$email}");
        } catch (\Exception $e) {
            $this->error("Gagal mengirim email: " . $e->getMessage());
        }
    }
}