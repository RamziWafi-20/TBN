<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'TBN Dashboard'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--green:#059669;--green2:#10b981;--dark:#0f172a;--muted:#64748b;--bg:#f6faf8;--line:#e2e8f0;--white:#fff;--soft:#ecfdf5;--gold:#f59e0b}
        *{box-sizing:border-box} body{margin:0;background:var(--bg);color:var(--dark);font-family:'Plus Jakarta Sans',sans-serif} a{text-decoration:none;color:inherit}
        .topbar{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.94);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
        .topbar-inner{max-width:1240px;margin:auto;padding:13px 20px;display:flex;align-items:center;justify-content:space-between;gap:20px}
        .brand{display:flex;align-items:center;gap:10px;font:800 20px Sora}.brand-icon{width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#047857,#34d399);display:grid;place-items:center;color:white}
        .nav{display:flex;align-items:center;gap:5px;flex:1;justify-content:center}.nav a{font-size:13px;font-weight:700;color:var(--muted);padding:9px 11px;border-radius:10px}.nav a:hover,.nav a.active{background:var(--soft);color:var(--green)}
        .user-mini{display:flex;align-items:center;gap:9px}.avatar{width:38px;height:38px;border-radius:50%;object-fit:cover;background:#d1fae5;color:#047857;display:grid;place-items:center;font-weight:800}.user-meta{line-height:1.15}.user-meta b{font-size:12px}.user-meta span{font-size:11px;color:var(--muted)}
        .container{max-width:1240px;margin:0 auto;padding:28px 20px 60px}.hero{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:22px}.eyebrow{color:var(--green);font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.08em}.title{font:800 30px Sora;margin:5px 0}.subtitle{color:var(--muted);font-size:14px;margin:0;line-height:1.7}
        .grid{display:grid;gap:16px}.grid-4{grid-template-columns:repeat(4,1fr)}.grid-3{grid-template-columns:repeat(3,1fr)}.grid-2{grid-template-columns:repeat(2,1fr)}
        .card{background:var(--white);border:1px solid var(--line);border-radius:18px;padding:20px;box-shadow:0 8px 28px rgba(15,23,42,.04)}
        .stat-card{position:relative;overflow:hidden}.stat-card:after{content:'';position:absolute;width:90px;height:90px;border-radius:50%;right:-38px;top:-38px;background:#ecfdf5}.stat-note{font-size:11px;color:#94a3b8;margin-top:7px}.hero-actions{display:flex;gap:8px;flex-wrap:wrap}.section-head{display:flex;align-items:flex-start;justify-content:space-between;gap:15px;margin-bottom:12px}.section-head h3{margin-bottom:5px}.chart-badge{font-size:10px;font-weight:800;color:#047857;background:#ecfdf5;padding:6px 8px;border-radius:8px;white-space:nowrap}.chart-box{height:300px;position:relative}.chart-box.doughnut{height:320px}.finance-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}.finance-grid>div{padding:15px;border:1px solid var(--line);border-radius:14px;background:#fafefd}.finance-grid strong{display:block;font:800 20px Sora;margin-top:6px}.green-text{color:var(--green)}.quick-links{display:grid;gap:9px;margin-top:15px}.quick-link{display:flex;align-items:center;gap:10px;border:1px solid var(--line);padding:12px;border-radius:13px;transition:.2s}.quick-link:hover{border-color:#a7f3d0;background:#f0fdf4;transform:translateY(-1px)}.quick-link>span{font-size:20px}.quick-link div{flex:1}.quick-link b{display:block;font-size:12px}.quick-link small{display:block;color:var(--muted);font-size:11px;margin-top:2px}.status{display:inline-flex;padding:5px 8px;border-radius:999px;background:#ecfdf5;color:#047857;font-size:10px;font-weight:800}.class-card{padding:16px;border:1px solid var(--line);border-radius:15px;background:linear-gradient(180deg,#fff,#fbfffd)}.small-note{font-size:11px;color:#94a3b8;line-height:1.6;margin-top:15px}.small-note code{font-size:10px}.profile-grid{display:grid;grid-template-columns:300px 1fr;gap:18px}.card h3{font:700 16px Sora;margin:0 0 8px}.label{font-size:12px;color:var(--muted);font-weight:700}.metric{font:800 27px Sora;margin-top:8px}.metric.green{color:var(--green)}
        .btn{border:0;border-radius:11px;padding:10px 15px;font-weight:800;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;gap:7px}.btn-primary{background:var(--green);color:#fff}.btn-light{background:var(--soft);color:var(--green)}
        .table-wrap{overflow:auto}.table{width:100%;border-collapse:collapse;font-size:13px}.table th{text-align:left;color:var(--muted);background:#f8fafc;padding:12px;border-bottom:1px solid var(--line)}.table td{padding:13px 12px;border-bottom:1px solid #f1f5f9}.rank{width:32px;height:32px;border-radius:10px;background:#f1f5f9;display:grid;place-items:center;font-weight:800}.rank.top{background:#fef3c7;color:#92400e}
        .bar-row{margin:14px 0}.bar-head{display:flex;justify-content:space-between;font-size:12px;font-weight:700;margin-bottom:6px}.bar{height:10px;border-radius:20px;background:#e2e8f0;overflow:hidden}.bar span{display:block;height:100%;background:linear-gradient(90deg,#059669,#34d399);border-radius:20px}
        .profile-card{text-align:center}.profile-large{width:132px;height:132px;border-radius:50%;object-fit:cover;background:#d1fae5;margin:10px auto 16px;display:grid;place-items:center;font:800 42px Sora;color:#047857;border:5px solid #ecfdf5}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}.field{display:flex;flex-direction:column;gap:7px}.field.full{grid-column:1/-1}.field label{font-size:12px;font-weight:800}.field input,.field select{width:100%;border:1px solid #cbd5e1;border-radius:10px;padding:11px 12px;font:inherit;font-size:13px;outline:none}.field input:focus{border-color:var(--green);box-shadow:0 0 0 3px #d1fae5}.alert{padding:12px 14px;border-radius:11px;margin-bottom:16px;font-size:13px;font-weight:700}.alert.success{background:#dcfce7;color:#166534}.alert.error{background:#fee2e2;color:#991b1b}
        .footer{text-align:center;color:#94a3b8;font-size:11px;padding:20px}.pill{display:inline-flex;padding:5px 9px;border-radius:999px;background:#f1f5f9;color:#475569;font-size:11px;font-weight:800}.income-big{font:800 38px Sora;color:var(--green)}
        @media(max-width:900px){.grid-4,.grid-3{grid-template-columns:repeat(2,1fr)}.nav{display:none}.profile-grid{grid-template-columns:1fr}.hero{align-items:flex-start;flex-direction:column}}
        @media(max-width:620px){.grid-4,.grid-3,.grid-2,.form-grid{grid-template-columns:1fr}.container{padding:20px 14px 45px}.user-meta{display:none}.title{font-size:24px}}
        .theme-toggle{border:1px solid var(--line);background:var(--white);color:var(--dark);width:40px;height:40px;border-radius:11px;cursor:pointer;font-size:17px;display:grid;place-items:center}
        body.dark{--dark:#e7f7ef;--muted:#a9c7b8;--bg:#061a12;--line:#173b2c;--white:#0c2419;--soft:#0f3b28;--gold:#fbbf24;background:radial-gradient(circle at 10% 0%,rgba(16,185,129,.16),transparent 32%),linear-gradient(135deg,#061a12 0%,#08271a 50%,#03140d 100%);color:var(--dark)}
        body.dark .topbar{background:rgba(5,25,16,.88);border-color:#173b2c}.dark .card{background:rgba(12,36,25,.92);border-color:#173b2c;box-shadow:0 14px 40px rgba(0,0,0,.2)}.dark .nav a{color:#9fc4b1}.dark .nav a:hover,.dark .nav a.active{background:#0f3b28;color:#6ee7b7}.dark .table th{background:#0a2d1e;color:#9fc4b1;border-color:#173b2c}.dark .table td{border-color:#173b2c}.dark .finance-grid>div,.dark .class-card{background:#0a2d1e;border-color:#173b2c}.dark .field input,.dark .field select{background:#081f15;color:#e7f7ef;border-color:#28513f}.dark .quick-link{border-color:#173b2c}.dark .quick-link:hover{background:#0f3b28;border-color:#27684a}.dark .bar{background:#173b2c}.dark .pill{background:#123726;color:#b8dfcb}.dark .btn-light{background:#0f3b28;color:#6ee7b7}.dark .footer{color:#709686}.dark .subtitle{color:#a9c7b8}.dark .alert.success{background:#0d3b28;color:#86efac}.dark .alert.error{background:#451b1b;color:#fecaca}
        .ai-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:16px}.ai-box{height:310px;overflow:auto;background:#f8fffb;border:1px solid var(--line);border-radius:14px;padding:14px}.dark .ai-box{background:#071c13}.chat-msg{display:flex;margin:8px 0}.chat-msg.user{justify-content:flex-end}.chat-bubble{max-width:82%;padding:10px 12px;border-radius:14px;background:#e8f7ef;font-size:12px;line-height:1.6}.dark .chat-bubble{background:#123a28}.chat-msg.user .chat-bubble{background:var(--green);color:white}.chat-form{display:flex;gap:8px;margin-top:10px}.chat-form input{flex:1;border:1px solid var(--line);border-radius:11px;padding:11px}.scanner-drop{border:2px dashed #86efac;border-radius:16px;padding:24px;text-align:center;background:#f0fdf4;cursor:pointer}.dark .scanner-drop{background:#0b3020}.scanner-drop input{display:none}.scan-result{margin-top:12px;border:1px solid var(--line);border-radius:14px;padding:12px;display:none}.points-chip{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;background:#fef3c7;color:#92400e;font-weight:800;font-size:11px}.dark .points-chip{background:#4a3510;color:#fde68a}
        @media(max-width:900px){.ai-grid{grid-template-columns:1fr}}
    </style>
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body>
<?php ($user = $user ?? auth()->user()); ?>
<header class="topbar">
    <div class="topbar-inner">
        <a href="<?php echo e(route('beranda')); ?>" class="brand"><span class="brand-icon">🌿</span><span>TBN</span></a>
        <nav class="nav">
            <a href="<?php echo e(route('beranda')); ?>" class="<?php echo e(request()->routeIs('beranda','dashboard') ? 'active' : ''); ?>">Beranda</a>
            <a href="<?php echo e(route('ranking')); ?>" class="<?php echo e(request()->routeIs('ranking') ? 'active' : ''); ?>">🏆 Ranking</a>
            <a href="<?php echo e(route('income')); ?>" class="<?php echo e(request()->routeIs('income') ? 'active' : ''); ?>">💰 Penghasilan</a>
            <a href="<?php echo e(route('profile')); ?>" class="<?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">👤 Profil</a>
            <a href="<?php echo e(route('points')); ?>" class="<?php echo e(request()->routeIs('points*') ? 'active' : ''); ?>">⭐ Poin</a>
            <?php if(in_array($user->role, ['Pengelola', 'Guru'], true)): ?><a href="<?php echo e(route('vouchers')); ?>" class="<?php echo e(request()->routeIs('vouchers*') ? 'active' : ''); ?>">🎟️ Voucher</a><?php endif; ?>
        </nav>
        <button type="button" class="theme-toggle" id="themeToggle" title="Mode gelap">🌙</button>
        <div class="user-mini">
            <?php if($user->profile_photo): ?>
                <img class="avatar" src="<?php echo e(asset('storage/'.$user->profile_photo)); ?>" alt="Foto profil">
            <?php else: ?>
                <div class="avatar"><?php echo e(strtoupper(substr($user->name,0,1))); ?></div>
            <?php endif; ?>
            <div class="user-meta"><b><?php echo e($user->name); ?></b><br><span><?php echo e($user->role); ?></span></div>
            <form method="POST" action="<?php echo e(route('auth.logout')); ?>"><?php echo csrf_field(); ?><button class="btn btn-light" type="submit">Keluar</button></form>
        </div>
    </div>
</header>
<main class="container">
<?php if(session('success')): ?><div class="alert success"><?php echo e(session('success')); ?></div><?php endif; ?>
<?php if($errors->any()): ?><div class="alert error"><?php echo e($errors->first()); ?></div><?php endif; ?>
<?php echo $__env->yieldContent('content'); ?>
</main>
<footer class="footer">TBN — Trash Bank Neskar • Digital Waste Bank</footer>
<script>
(function(){const key='tbn-theme';const saved=localStorage.getItem(key);if(saved==='dark')document.body.classList.add('dark');const b=document.getElementById('themeToggle');if(b){b.textContent=document.body.classList.contains('dark')?'☀️':'🌙';b.onclick=()=>{document.body.classList.toggle('dark');const dark=document.body.classList.contains('dark');localStorage.setItem(key,dark?'dark':'light');b.textContent=dark?'☀️':'🌙';};}})();
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\xampp-portable-windows-x64-8.2.12-0-VS16\xampp\TBN\TBN Laravel\resources\views/app/layout.blade.php ENDPATH**/ ?>