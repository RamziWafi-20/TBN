<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email — TBN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/styles-Be6PXbW8.css') }}">
    <style>
        body{font-family:'Plus Jakarta Sans',sans-serif;background:linear-gradient(135deg,#f0fdf4,#f8fafc,#ecfdf5);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem;color:#0f172a}
        .card{width:min(460px,100%);background:#fff;border:1px solid #e2e8f0;border-radius:1.5rem;padding:2rem;box-shadow:0 20px 40px -15px rgba(0,0,0,.08);text-align:center}
        .icon{width:4rem;height:4rem;margin:0 auto 1rem;border-radius:1rem;background:linear-gradient(135deg,#059669,#10b981);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.8rem}
        button{width:100%;padding:.8rem;border:0;border-radius:.75rem;background:#059669;color:#fff;font-weight:700;cursor:pointer}
        .alert{padding:.75rem 1rem;border-radius:.75rem;margin:1rem 0;font-size:.85rem;background:#ecfdf5;color:#047857;border:1px solid #bbf7d0}
    </style>
</head>
<body>
<div class="card">
    <div class="icon">✉</div>
    <h1 style="font-family:Sora;margin:.2rem 0 .5rem;font-size:1.4rem">Verifikasi Email Anda</h1>
    <p style="color:#64748b;line-height:1.6;margin:0">Kami sudah mengirim tautan verifikasi ke <strong>{{ auth()->user()->email }}</strong>. Klik tautan di email tersebut untuk mengaktifkan akun TBN.</p>

    @if(session('success')) <div class="alert">{{ session('success') }}</div> @endif
    @if(session('info')) <div class="alert" style="background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe">{{ session('info') }}</div> @endif

    <form method="POST" action="{{ route('verification.send') }}" style="margin-top:1.25rem">
        @csrf
        <button type="submit">Kirim Ulang Email Verifikasi</button>
    </form>
    <form method="POST" action="{{ route('auth.logout') }}" style="margin-top:.65rem">
        @csrf
        <button type="submit" style="background:#f1f5f9;color:#475569">Keluar</button>
    </form>
</div>
</body>
</html>
