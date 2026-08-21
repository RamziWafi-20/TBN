<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Verifikasi Akun — TBN</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:'Plus Jakarta Sans',sans-serif;background:linear-gradient(135deg,#ecfdf5,#f8fafc 45%,#dcfce7);display:grid;place-items:center;padding:20px;overflow:hidden}
body:before,body:after{content:"";position:fixed;width:320px;height:320px;border-radius:50%;filter:blur(80px);opacity:.25;animation:float 8s ease-in-out infinite;pointer-events:none}body:before{background:#34d399;top:-100px;left:-80px}body:after{background:#60a5fa;right:-100px;bottom:-100px;animation-delay:-4s}
.card{position:relative;width:min(470px,100%);background:rgba(255,255,255,.94);border:1px solid #e2e8f0;border-radius:28px;padding:34px;box-shadow:0 30px 80px rgba(15,23,42,.12);animation:rise .65s ease both}
.logo{width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,#059669,#10b981,#34d399);color:#fff;display:grid;place-items:center;font-size:25px;margin-bottom:20px;box-shadow:0 12px 28px rgba(5,150,105,.25)}
h1{font-family:Sora;margin:0 0 10px;font-size:24px}p{color:#64748b;line-height:1.7;margin:0}.email{color:#065f46;font-weight:700;word-break:break-all}
.alert{padding:12px 14px;border-radius:13px;margin:18px 0;font-size:13px;line-height:1.5}.success{background:#ecfdf5;border:1px solid #bbf7d0;color:#047857}.error{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c}
.code{width:100%;margin-top:22px;padding:16px;text-align:center;border:2px solid #d1fae5;border-radius:16px;background:#f0fdf4;font-size:32px;letter-spacing:12px;font-weight:800;color:#065f46;outline:none;transition:.2s}.code:focus{border-color:#10b981;box-shadow:0 0 0 4px #d1fae5}
button{width:100%;border:0;border-radius:14px;padding:14px;margin-top:14px;background:linear-gradient(135deg,#047857,#10b981);color:#fff;font-weight:800;cursor:pointer;transition:.2s;box-shadow:0 8px 20px rgba(5,150,105,.2)}button:hover{transform:translateY(-2px);box-shadow:0 12px 25px rgba(5,150,105,.28)}button.secondary{background:#f1f5f9;color:#475569;box-shadow:none}
.otp-box{margin-top:20px;padding:18px;border:2px solid #a7f3d0;border-radius:18px;background:#ecfdf5;text-align:center}.otp-label{font-size:11px;font-weight:800;letter-spacing:2px;color:#047857}.otp-value{margin-top:6px;font-family:Sora,sans-serif;font-size:34px;font-weight:800;letter-spacing:10px;color:#065f46}.otp-note{margin-top:8px;font-size:11px;color:#6b7280}.small{text-align:center;font-size:12px;color:#94a3b8;margin-top:16px}@keyframes rise{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}@keyframes float{50%{transform:translate(20px,30px) scale(1.08)}} 
</style>
</head>
<body>
<div class="card">
<div class="logo">✓</div>
<h1>Verifikasi Akun Anda</h1>
<p>Untuk mode lokal TBN, email tidak digunakan. Gunakan <strong>OTP dummy</strong> di bawah ini untuk mengaktifkan akun <span class="email">{{ $user->email }}</span>.</p>
@if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
@if(session('info'))<div class="alert success">{{ session('info') }}</div>@endif
@if($errors->any())<div class="alert error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
<div class="otp-box">
    <div class="otp-label">OTP DUMMY UNTUK SEMUA AKUN</div>
    <div class="otp-value">123456</div>
    <div class="otp-note">Gunakan kode ini untuk semua akun TBN dalam mode lokal.</div>
</div>
<form method="POST" action="{{ route('verification.code.submit') }}">
@csrf
<input class="code" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required autofocus>
<button type="submit">Verifikasi & Aktifkan Akun</button>
</form>
<form method="POST" action="{{ route('verification.code.resend') }}">
@csrf
<button type="submit" class="secondary">Gunakan OTP Dummy</button>
</form>
<div class="small">OTP dummy tetap: 123456. Mode ini khusus untuk pengujian lokal TBN.</div>
</div>
</body>
</html>
