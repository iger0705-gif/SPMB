<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode Verifikasi Email</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: #1E40AF; color: white; padding: 30px; text-align: center; }
        .content { padding: 40px 30px; }
        .otp-box { background: #f1f5f9; border: 2px dashed #1E40AF; border-radius: 10px; padding: 30px; text-align: center; margin: 30px 0; }
        .otp-code { font-size: 42px; font-weight: bold; color: #1E40AF; letter-spacing: 10px; margin: 15px 0; font-family: 'Courier New', monospace; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; color: #64748b; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Verifikasi Email</h1>
            <p>PPDB SMK Bakti Nusantara 666</p>
        </div>
        
        <div class="content">
            <h2>Halo{{ $name ? ', ' . $name : '' }}!</h2>
            <p>Terima kasih telah mendaftar di sistem PPDB kami. Untuk melanjutkan proses pendaftaran, silakan verifikasi email Anda dengan memasukkan kode OTP berikut:</p>
            
            <div class="otp-box">
                <p style="margin: 0; color: #64748b;">Kode Verifikasi Anda:</p>
                <div class="otp-code">{{ $otp }}</div>
                <p style="margin: 10px 0 0 0; color: #1E40AF; font-weight: bold;">Salin kode: {{ $otp }}</p>
                <p style="margin: 0; color: #64748b; font-size: 14px;">Kode berlaku selama 10 menit</p>
            </div>
            
            <p><strong>Penting:</strong></p>
            <ul style="color: #64748b;">
                <li>Jangan bagikan kode ini kepada siapapun</li>
                <li>Kode akan kedaluwarsa dalam 10 menit</li>
                <li>Jika Anda tidak merasa mendaftar, abaikan email ini</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; 2025 SMK Bakti Nusantara 666. All rights reserved.</p>
        </div>
    </div>
</body>
</html>