<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Masuk & Daftar — TBN | Trash Bank Neskar</title>
    <meta name="description" content="Masuk atau daftar ke akun TBN Trash Bank Neskar untuk mengelola bank sampah sekolah." />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&amp;family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" />

    <!-- Lovable Styles & Tailwind -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles-Be6PXbW8.css')); ?>" />
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon" />

    <style>
        :root {
            --bg-page: #f8faf9;
            --card-bg: #ffffff;
            --primary-eco: #10b981;
            --primary-dark: #059669;
            --accent-glow: rgba(16, 185, 129, 0.15);
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #ecfdf5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            color: #0f172a;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 460px;
            margin: 0 auto;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(16, 185, 129, 0.05);
            padding: 2.25rem 2rem;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .auth-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #f1f5f9;
            padding: 0.35rem;
            border-radius: 0.85rem;
            margin-bottom: 1.75rem;
            gap: 0.35rem;
        }

        .auth-tab-btn {
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            border-radius: 0.6rem;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .auth-tab-btn.active {
            background: #ffffff;
            color: #059669;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .form-input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            background: #f8fafc;
            color: #0f172a;
            outline: none;
            transition: all 0.15s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #10b981;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .role-badge-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .role-radio-label {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.6rem;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            color: #64748b;
            transition: all 0.15s ease;
            text-align: center;
            background: #ffffff;
        }

        .role-radio-label input {
            display: none;
        }

        .role-radio-label.selected {
            border-color: #10b981;
            background: #ecfdf5;
            color: #059669;
        }

        .btn-submit {
            width: 100%;
            padding: 0.8rem 1.25rem;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ffffff;
            border: none;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .alert-box {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            margin-bottom: 1.25rem;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }

        .demo-box {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px dashed #e2e8f0;
            text-align: center;
        }

        .demo-btn {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 0.5rem;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            margin: 0.25rem;
            font-weight: 500;
            transition: all 0.15s;
        }

        .demo-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
    
        @keyframes authRise { from { opacity:0; transform:translateY(18px) scale(.99); } to { opacity:1; transform:none; } }
        @keyframes authGlow { 0%,100% { box-shadow:0 8px 20px -6px rgba(16,185,129,.5); } 50% { box-shadow:0 12px 32px -6px rgba(16,185,129,.72); } }
        .auth-card { animation: authRise .55s ease both; }
        .auth-header > div:first-child { animation: authGlow 3s ease-in-out infinite; }
        .form-input { transition: border-color .2s, box-shadow .2s, transform .2s; }
        .form-input:focus { transform: translateY(-1px); }

    </style>
</head>

<body>
    <div class="auth-wrapper">
        <!-- Back link -->
        <div style="margin-bottom: 1.25rem;">
            <a href="<?php echo e(url('/')); ?>" style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; font-weight: 600; color: #059669; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 3.5rem; height: 3.5rem; border-radius: 1rem; background: linear-gradient(135deg, #059669, #10b981 55%, #34d399); color: #fff; margin-bottom: 1rem; box-shadow: 0 8px 20px -6px rgba(16, 185, 129, 0.5);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                    </svg>
                </div>
                <h1 style="font-family: 'Sora', sans-serif; font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0 0 0.35rem 0;">TBN Portal</h1>
                <p style="font-size: 0.875rem; color: #64748b; margin: 0;">Bank Sampah Sekolah Digital — SMKN 1 Karawang</p>
            </div>

            <!-- Flash Messages & Errors -->
            <?php if(session('success')): ?>
                <div class="alert-box alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert-box" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8;">
                    <?php echo e(session('info')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert-box alert-error">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Tabs -->
            <div class="auth-tabs">
                <button type="button" class="auth-tab-btn active" id="tab-login-btn" onclick="switchTab('login')">
                    Masuk
                </button>
                <button type="button" class="auth-tab-btn" id="tab-register-btn" onclick="switchTab('register')">
                    Daftar Akun
                </button>
            </div>

            <!-- LOGIN FORM -->
            <form id="form-login" method="POST" action="<?php echo e(route('auth.login')); ?>">
                <?php echo csrf_field(); ?>
                <!-- Role Selection -->
                <label class="form-label">Pilih Peran Anda</label>
                <div class="role-badge-group">
                    <label class="role-radio-label selected" onclick="selectRole('login-role-siswa', this)">
                        <input type="radio" name="role" id="login-role-siswa" value="Siswa" checked>
                        Siswa
                    </label>
                    <label class="role-radio-label" onclick="selectRole('login-role-guru', this)">
                        <input type="radio" name="role" id="login-role-guru" value="Guru">
                        Guru / Staff
                    </label>
                    <label class="role-radio-label" onclick="selectRole('login-role-admin', this)">
                        <input type="radio" name="role" id="login-role-admin" value="Pengelola">
                        Pengelola
                    </label>
                </div>

                <div style="margin-bottom: 1.15rem;">
                    <label for="login-email" class="form-label">Email Sekolah / NIS</label>
                    <input type="text" id="login-email" name="email" class="form-input" placeholder="contoh: siswa@neskar.sch.id" value="<?php echo e(old('email')); ?>" required autofocus>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <label for="login-password" class="form-label" style="margin-bottom: 0;">Kata Sandi</label>
                        <a href="javascript:void(0)" onclick="alert('Silakan hubungi administrator bank sampah sekolah untuk reset kata sandi.')" style="font-size: 0.75rem; color: #059669; text-decoration: none; font-weight: 500;">Lupa sandi?</a>
                    </div>
                    <div style="position: relative;">
                        <input type="password" id="login-password" name="password" class="form-input" placeholder="••••••••" required style="padding-right: 2.75rem;">
                        <button type="button" onclick="togglePassword('login-password', this)" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; padding: 0.25rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <input type="checkbox" id="remember" name="remember" style="accent-color: #059669; width: 1rem; height: 1rem; cursor: pointer;">
                    <label for="remember" style="font-size: 0.8125rem; color: #475569; cursor: pointer; user-select: none;">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Akun</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/>
                        <path d="m12 5 7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <!-- REGISTER FORM -->
            <form id="form-register" method="POST" action="<?php echo e(route('auth.register')); ?>" style="display: none;">
                <?php echo csrf_field(); ?>
                <div style="margin-bottom: 1rem;">
                    <label for="reg-name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="reg-name" name="name" class="form-input" placeholder="contoh: Muhammad Rizky" value="<?php echo e(old('name')); ?>" required>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="reg-email" class="form-label">Email Sekolah</label>
                    <input type="email" id="reg-email" name="email" class="form-input" placeholder="nama@neskar.sch.id" value="<?php echo e(old('email')); ?>" required>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="reg-nis" class="form-label">NIS / NISN (Opsional)</label>
                    <input type="text" id="reg-nis" name="nis" class="form-input" placeholder="contoh: 212210045" value="<?php echo e(old('nis')); ?>">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="reg-class" class="form-label">Kelas <span style="color:#94a3b8;font-weight:500">(Opsional)</span></label>
                    <input type="text" id="reg-class" name="class_name" class="form-input" placeholder="contoh: XII RPL 2" value="<?php echo e(old('class_name')); ?>">
                </div>

                <label class="form-label">Peran Pengguna</label>
                <div class="role-badge-group">
                    <label class="role-radio-label selected" onclick="selectRole('reg-role-siswa', this)">
                        <input type="radio" name="role" id="reg-role-siswa" value="Siswa" checked>
                        Siswa
                    </label>
                    <label class="role-radio-label" onclick="selectRole('reg-role-guru', this)">
                        <input type="radio" name="role" id="reg-role-guru" value="Guru">
                        Guru
                    </label>
                    <label class="role-radio-label" onclick="selectRole('reg-role-pengelola', this)">
                        <input type="radio" name="role" id="reg-role-pengelola" value="Pengelola">
                        Pengelola
                    </label>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="reg-password" class="form-label">Kata Sandi (Min. 6 Karakter)</label>
                    <input type="password" id="reg-password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="reg-password-confirm" class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" id="reg-password-confirm" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Daftar Akun Baru</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" x2="19" y1="8" y2="14"/>
                        <line x1="22" x2="16" y1="11" y2="11"/>
                    </svg>
                </button>
            </form>

            <!-- Quick Demo Login Helpers -->
            <div class="demo-box">
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 0 0 0.5rem 0;">Akun Demo Cepat untuk Uji Coba:</p>
                <button type="button" class="demo-btn" onclick="fillDemo('siswa@neskar.sch.id', 'password123', 'Siswa')">
                    🌱 Demo Siswa
                </button>
                <button type="button" class="demo-btn" onclick="fillDemo('admin@neskar.sch.id', 'password123', 'Pengelola')">
                    🛡️ Demo Pengelola
                </button>
            </div>
        </div>

        <p style="text-align: center; font-size: 0.75rem; color: #94a3b8; margin-top: 1.5rem;">
            © <?php echo e(date('Y')); ?> TBN — Trash Bank Neskar. Bank Sampah Digital SMKN 1 Karawang.
        </p>
    </div>

    <script>
        function switchTab(tab) {
            const loginForm = document.getElementById('form-login');
            const registerForm = document.getElementById('form-register');
            const loginTabBtn = document.getElementById('tab-login-btn');
            const registerTabBtn = document.getElementById('tab-register-btn');

            if (tab === 'login') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                loginTabBtn.classList.add('active');
                registerTabBtn.classList.remove('active');
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                registerTabBtn.classList.add('active');
                loginTabBtn.classList.remove('active');
            }
        }

        function selectRole(radioId, labelElement) {
            const radio = document.getElementById(radioId);
            if (radio) {
                radio.checked = true;
                const parent = labelElement.parentElement;
                parent.querySelectorAll('.role-radio-label').forEach(el => el.classList.remove('selected'));
                labelElement.classList.add('selected');
            }
        }

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.style.color = '#059669';
            } else {
                input.type = 'password';
                btn.style.color = '#94a3b8';
            }
        }

        function fillDemo(email, password, role) {
            switchTab('login');
            document.getElementById('login-email').value = email;
            document.getElementById('login-password').value = password;
            if (role === 'Siswa') {
                selectRole('login-role-siswa', document.querySelector("label[onclick*='login-role-siswa']"));
            } else if (role === 'Pengelola') {
                selectRole('login-role-admin', document.querySelector("label[onclick*='login-role-admin']"));
            }
        }
    </script>
</body>

</html>
<?php /**PATH D:\xampp-portable-windows-x64-8.2.12-0-VS16\xampp\TBN\TBN Laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>