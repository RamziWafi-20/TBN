<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Beranda — TBN Trash Bank Neskar | Dashboard</title>
    <meta name="description" content="Skor Eco, statistik, dampak sekolah, peringkat, dan tantangan eco TBN." />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&amp;family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/styles-Be6PXbW8.css') }}" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <style>
        :root {
            --primary: #059669;
            --primary-light: #10b981;
            --primary-bg: #ecfdf5;
            --bg-page: #f8fafc;
            --card-border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--card-border);
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(10px);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-link {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            padding: 0.5rem 0.85rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary);
            background: var(--primary-bg);
        }

        .badge-eco {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fef08a;
            padding: 0.3rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 1.75rem auto;
            padding: 0 1.25rem 3rem 1.25rem;
        }

        .card-custom {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.03);
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .card-custom:hover {
            box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.06);
        }

        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.25rem 1rem;
            background: #ffffff;
            border: 1.5px solid var(--card-border);
            border-radius: 1rem;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.875rem;
            gap: 0.6rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-action-btn:hover {
            border-color: var(--primary-light);
            background: var(--primary-bg);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .table-custom th {
            text-align: left;
            padding: 0.75rem 1rem;
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--card-border);
        }

        .table-custom td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-main);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 1rem;
        }

        .modal-content {
            background: #ffffff;
            border-radius: 1.5rem;
            max-width: 520px;
            width: 100%;
            padding: 1.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-height: 90vh;
            overflow-y: auto;
        }
    
        /* TBN motion layer — visual only, layout preserved */
        @keyframes tbnFadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes tbnFloat { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-8px) rotate(1deg); } }
        @keyframes tbnPulse { 0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,.18); } 50% { box-shadow: 0 0 0 9px rgba(16,185,129,0); } }
        .dashboard-container > * { animation: tbnFadeUp .55s ease both; }
        .grid-stats > .card-custom { animation: tbnFadeUp .55s ease both; }
        .grid-stats > .card-custom:nth-child(2) { animation-delay: .06s; }
        .grid-stats > .card-custom:nth-child(3) { animation-delay: .12s; }
        .grid-stats > .card-custom:nth-child(4) { animation-delay: .18s; }
        .navbar { animation: tbnFadeUp .4s ease both; }
        .quick-action-btn:hover svg { animation: tbnFloat .7s ease-in-out; }
        .badge-eco { animation: tbnPulse 2.8s ease-in-out infinite; }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; scroll-behavior: auto !important; }
        }

    </style>
</head>

<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="navbar-inner">
            <div style="display: flex; align-items: center; gap: 2rem;">
                <a href="{{ url('/beranda') }}" style="display: flex; align-items: center; gap: 0.6rem; text-decoration: none; color: inherit;">
                    <span style="display: flex; width: 2.25rem; height: 2.25rem; border-radius: 0.75rem; background: linear-gradient(135deg, #059669, #10b981 55%, #34d399); color: #fff; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                        </svg>
                    </span>
                    <span style="font-family: 'Sora', sans-serif; font-size: 1.25rem; font-weight: 800; letter-spacing: -0.02em;">TBN</span>
                </a>

                <nav style="display: flex; gap: 0.25rem;" class="nav-menu">
                    <a class="nav-link active" onclick="switchSection('overview', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        Beranda
                    </a>
                    <a class="nav-link" onclick="openScanner()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><path d="M7 12h10"/></svg>
                        AI Scanner
                    </a>
                    <a class="nav-link" onclick="openEcoAi()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
                        Eco AI
                    </a>
                    <a class="nav-link" onclick="switchSection('transactions', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.744 17.736a6 6 0 1 1-7.48-7.48"/><path d="M15 6h1v4"/><path d="m6.134 14.768.866-.5 2 3.464"/><circle cx="16" cy="8" r="6"/></svg>
                        Waste to Value
                    </a>
                </nav>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span class="badge-eco">
                    ⭐ <strong>420</strong> Eco Points
                </span>
                <div style="display: flex; align-items: center; gap: 0.5rem; padding-left: 0.5rem; border-left: 1px solid var(--card-border);">
                    <div style="width: 2rem; height: 2rem; border-radius: 50%; background: #10b981; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8125rem;">
                        {{ strtoupper(substr($user['name'] ?? 'S', 0, 1)) }}
                    </div>
                    <form method="POST" action="{{ route('auth.logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" title="Keluar" style="background: none; border: none; cursor: pointer; color: #94a3b8; padding: 0.35rem; display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="dashboard-container">
        <!-- Flash Alert -->
        @if(session('success'))
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 0.85rem 1.25rem; border-radius: 1rem; margin-bottom: 1.5rem; font-size: 0.875rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <span>🎉</span> {{ session('success') }}
            </div>
        @endif

        <!-- HERO WELCOME BANNER -->
        <div style="background: linear-gradient(135deg, #064e3b 0%, #059669 60%, #10b981 100%); color: #ffffff; border-radius: 1.5rem; padding: 2rem; position: relative; overflow: hidden; box-shadow: 0 12px 30px -8px rgba(5, 150, 105, 0.45);">
            <div style="position: relative; z-index: 2; max-width: 650px;">
                <span style="display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); padding: 0.3rem 0.85rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; color: #a7f3d0; margin-bottom: 0.75rem;">
                    🌿 Level 3: Eco Guardian SMKN 1 Karawang
                </span>
                <h1 style="font-family: 'Sora', sans-serif; font-size: 1.85rem; font-weight: 800; margin: 0 0 0.5rem 0; line-height: 1.2;">
                    Halo, {{ $user->name ?? 'Pelajar Neskar' }}! 👋
                </h1>
                <p style="color: #d1fae5; font-size: 0.9375rem; margin: 0 0 1.5rem 0; line-height: 1.5;">
                    Ubah sampah sekolahmu menjadi nilai nyata hari ini. Pindai sampah, catat setoran, dan lihat kontribusi dampak lingkunganmu.
                </p>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="button" onclick="openScanner()" style="background: #ffffff; color: #065f46; font-weight: 700; font-size: 0.875rem; padding: 0.75rem 1.25rem; border-radius: 0.75rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><path d="M7 12h10"/></svg>
                        Pindai Sampah (AI Scanner)
                    </button>
                    <button type="button" onclick="openEcoAi()" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; font-weight: 600; font-size: 0.875rem; padding: 0.75rem 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.3); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; backdrop-filter: blur(8px);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
                        Tanya Eco AI
                    </button>
                </div>
            </div>
            <!-- Background Decorative leaf -->
            <div style="position: absolute; right: -20px; bottom: -30px; opacity: 0.15; pointer-events: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="280" height="280" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                </svg>
            </div>
        </div>

        <!-- 4 STATS CARDS -->
        <div class="grid-stats">
            <div class="card-custom" style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 3.25rem; height: 3.25rem; border-radius: 1rem; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Saldo Tabungan</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); font-family: 'Sora', sans-serif;">Rp 85.500</div>
                    <div style="font-size: 0.75rem; color: #059669; font-weight: 600;">+Rp 12.000 minggu ini</div>
                </div>
            </div>

            <div class="card-custom" style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 3.25rem; height: 3.25rem; border-radius: 1rem; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"></path><path d="M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12"></path></svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Sampah Terkumpul</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); font-family: 'Sora', sans-serif;">18.4 Kg</div>
                    <div style="font-size: 0.75rem; color: #2563eb; font-weight: 600;">PET, Kertas & Kardus</div>
                </div>
            </div>

            <div class="card-custom" style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 3.25rem; height: 3.25rem; border-radius: 1rem; background: #fefce8; color: #ca8a04; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Eco Points</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); font-family: 'Sora', sans-serif;">420 Poin</div>
                    <div style="font-size: 0.75rem; color: #ca8a04; font-weight: 600;">Peringkat #4 di Kelas</div>
                </div>
            </div>

            <div class="card-custom" style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 3.25rem; height: 3.25rem; border-radius: 1rem; background: #fdf2f8; color: #db2777; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Reduksi Emisi</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); font-family: 'Sora', sans-serif;">26.8 Kg</div>
                    <div style="font-size: 0.75rem; color: #db2777; font-weight: 600;">CO₂ Equivalen dicegah</div>
                </div>
            </div>
        </div>

        <!-- QUICK ACTIONS & RECENT ACTIVITY -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 1.75rem;" class="grid-content">
            <!-- Left: Setoran Terakhir / Waste to Value -->
            <div class="card-custom">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                    <div>
                        <h2 style="font-family: 'Sora', sans-serif; font-size: 1.15rem; font-weight: 700; margin: 0;">Riwayat Setoran Sampah</h2>
                        <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0.25rem 0 0 0;">Catatan transaksi dan konversi nilai sampah terbaru</p>
                    </div>
                    <button type="button" onclick="openScanner()" style="padding: 0.45rem 0.85rem; font-size: 0.75rem; font-weight: 600; background: var(--primary-bg); color: var(--primary); border: 1px solid #a7f3d0; border-radius: 0.5rem; cursor: pointer;">
                        + Setor Baru
                    </button>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Sampah</th>
                                <th>Berat</th>
                                <th>Nilai (Rp)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wasteRecords as $record)
                                <tr>
                                    <td>{{ $record->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div style="font-weight: 600;">{{ $record->waste_name ?: $record->waste_type }}</div>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">AI Waste Scanner</span>
                                    </td>
                                    <td>{{ number_format($record->estimated_weight, 2, ',', '.') }} Kg</td>
                                    <td style="font-weight: 700; color: #059669;">Rp {{ number_format($record->estimated_price, 0, ',', '.') }}</td>
                                    <td><span style="background: #dcfce7; color: #166534; font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.55rem; border-radius: 1rem;">Tervalidasi AI</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;color:var(--text-muted);padding:2rem 1rem;">
                                        Belum ada hasil scan. Gunakan <strong>AI Waste Scanner</strong> untuk memulai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: Eco Challenge & AI Recommendation -->
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <!-- Eco Challenge -->
                <div class="card-custom" style="background: #ffffff;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="font-size: 1.25rem;">🎯</span>
                        <h3 style="font-family: 'Sora', sans-serif; font-size: 1rem; font-weight: 700; margin: 0;">Tantangan Eco Minggu Ini</h3>
                    </div>
                    <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0 0 0.75rem 0;">Kumpulkan 5 Kg Botol Plastik bersama kelasmu.</p>
                    <div style="background: #f1f5f9; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.5rem;">
                        <div style="background: #10b981; width: 70%; height: 100%;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; font-weight: 600; color: var(--text-muted);">
                        <span>3.5 Kg / 5.0 Kg</span>
                        <span style="color: #059669;">70% Selesai</span>
                    </div>
                </div>

                <!-- Eco AI Advisor -->
                <div class="card-custom" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1px solid #a7f3d0;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.6rem;">
                        <span style="font-size: 1.25rem;">🤖</span>
                        <h3 style="font-family: 'Sora', sans-serif; font-size: 0.9375rem; font-weight: 700; color: #065f46; margin: 0;">Saran Eco AI</h3>
                    </div>
                    <p style="font-size: 0.8125rem; color: #047857; margin: 0 0 1rem 0; line-height: 1.4;">
                        "Botol plastik PET yang dicuci bersih dan dipisahkan labelnya memiliki harga jual 25% lebih tinggi di Bank Sampah Neskar!"
                    </p>
                    <button type="button" onclick="openEcoAi()" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; font-weight: 600; background: #059669; color: #fff; border: none; border-radius: 0.6rem; cursor: pointer;">
                        Buka Asisten Eco AI
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- 1. AI WASTE SCANNER MODAL -->
    <div id="modal-scanner" class="modal-overlay" onclick="closeModalOnBackdrop(event, this)">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 2rem; height: 2rem; border-radius: 0.5rem; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><path d="M7 12h10"/></svg>
                    </span>
                    <h3 style="font-family: 'Sora', sans-serif; font-size: 1.15rem; font-weight: 700; margin: 0;">AI Waste Scanner</h3>
                </div>
                <button type="button" onclick="closeModal('modal-scanner')" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #94a3b8;">&times;</button>
            </div>

            <div id="scanner-viewfinder" style="background: #0f172a; border-radius: 1rem; height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #ffffff; position: relative; overflow: hidden;">
                <div style="position: absolute; border: 2px dashed #10b981; width: 70%; height: 70%; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 0.75rem; color: #a7f3d0; font-weight: 600;">Arahkan Kamera ke Sampah</span>
                </div>
                <div id="scan-loading" style="display: none; position: absolute; inset: 0; background: rgba(5, 150, 105, 0.85); flex-direction: column; align-items: center; justify-content: center; z-index: 10;">
                    <div style="font-size: 1.5rem; animation: pulse 1s infinite;">🔍</div>
                    <span style="font-weight: 700; margin-top: 0.5rem; font-size: 0.875rem;">AI Sedang Menganalisis...</span>
                </div>
                <div style="position:absolute;bottom:12px;z-index:4;display:flex;gap:.5rem;align-items:center;">
                    <input type="file" id="waste-image" accept="image/jpeg,image/png,image/webp" capture="environment" style="display:none" onchange="previewWasteImage(event)">
                    <button type="button" onclick="document.getElementById('waste-image').click()" style="background:#fff;color:#047857;border:0;border-radius:.65rem;padding:.55rem .8rem;font-weight:700;cursor:pointer;">
                        Pilih / Foto Sampah
                    </button>
                </div>
            </div>

            <div id="scan-result" style="display: none; margin-top: 1.25rem; background: #f0fdf4; border: 1px solid #a7f3d0; padding: 1rem; border-radius: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; gap:1rem;">
                    <div>
                        <div style="font-size: 0.75rem; color: #047857; font-weight: 600;">Hasil Deteksi AI:</div>
                        <div id="result-name" style="font-size: 1.125rem; font-weight: 800; color: #064e3b; font-family: 'Sora', sans-serif;">-</div>
                        <div id="result-type" style="font-size:.82rem;color:#047857;margin-top:.2rem;">Jenis: -</div>
                    </div>
                    <span id="result-confidence" style="background: #10b981; color: #fff; padding: 0.25rem 0.5rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700;">Akurasi -</span>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.75rem; font-size: 0.8125rem;">
                    <div>⚖️ Estimasi Berat: <strong id="result-weight">-</strong></div>
                    <div>💰 Estimasi Nilai: <strong id="result-price">-</strong></div>
                    <div>🧼 Kondisi: <strong id="result-condition">-</strong></div>
                    <div>💡 Saran: <strong id="result-advice">-</strong></div>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.25rem;">
                <button type="button" id="btn-do-scan" onclick="identifyWaste()" style="flex: 1; padding: 0.75rem; background: #059669; color: #fff; font-weight: 700; border: none; border-radius: 0.75rem; cursor: pointer;">
                    Mulai Scan AI
                </button>
                <button type="button" onclick="closeModal('modal-scanner')" style="padding: 0.75rem 1rem; background: #f1f5f9; color: #475569; font-weight: 600; border: none; border-radius: 0.75rem; cursor: pointer;">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- 2. ECO AI CHATBOT MODAL -->
    <div id="modal-eco-ai" class="modal-overlay" onclick="closeModalOnBackdrop(event, this)">
        <div class="modal-content" style="display: flex; flex-direction: column; height: 500px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 2rem; height: 2rem; border-radius: 0.5rem; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                        🤖
                    </span>
                    <h3 style="font-family: 'Sora', sans-serif; font-size: 1.15rem; font-weight: 700; margin: 0;">Eco AI Assistant</h3>
                </div>
                <button type="button" onclick="closeModal('modal-eco-ai')" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #94a3b8;">&times;</button>
            </div>

            <div id="chat-messages" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 0.75rem; padding: 0.5rem; background: #f8fafc; border-radius: 0.75rem; margin-bottom: 1rem;">
                <div style="align-self: flex-start; max-width: 85%; background: #ffffff; border: 1px solid var(--card-border); padding: 0.75rem 1rem; border-radius: 1rem; font-size: 0.875rem; color: #0f172a;">
                    Halo! Saya <strong>Eco AI</strong> TBN. Anda bisa menanyakan jenis sampah apa yang bisa disetor, cara memilah, atau ide upcycling produk daur ulang!
                </div>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <input type="text" id="chat-input" placeholder="Ketik pertanyaan tentang sampah..." style="flex: 1; padding: 0.7rem 1rem; border: 1.5px solid var(--card-border); border-radius: 0.75rem; font-size: 0.875rem; outline: none;" onkeypress="if(event.key === 'Enter') sendChatMessage()">
                <button type="button" onclick="sendChatMessage()" style="padding: 0.7rem 1.1rem; background: #059669; color: #ffffff; border: none; border-radius: 0.75rem; font-weight: 600; cursor: pointer;">
                    Kirim
                </button>
            </div>
        </div>
    </div>

    <script>
        function switchSection(section, element) {
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
            if (element) element.classList.add('active');
        }

        function openScanner() {
            document.getElementById('modal-scanner').style.display = 'flex';
        }

        function openEcoAi() {
            document.getElementById('modal-eco-ai').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function closeModalOnBackdrop(event, overlay) {
            if (event.target === overlay) {
                overlay.style.display = 'none';
            }
        }

        let selectedWasteFile = null;

        function previewWasteImage(event) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;
            selectedWasteFile = file;

            const url = URL.createObjectURL(file);
            const view = document.getElementById('scanner-viewfinder');
            const old = document.getElementById('waste-preview');
            if (old) old.remove();

            const img = document.createElement('img');
            img.id = 'waste-preview';
            img.src = url;
            img.alt = 'Foto sampah';
            img.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:2;';
            view.appendChild(img);
        }

        async function identifyWaste() {
            const fileInput = document.getElementById('waste-image');
            const file = selectedWasteFile || (fileInput.files && fileInput.files[0]);

            if (!file) {
                alert('Pilih atau ambil foto sampah terlebih dahulu.');
                return;
            }

            const loader = document.getElementById('scan-loading');
            const result = document.getElementById('scan-result');
            const button = document.getElementById('btn-do-scan');

            loader.style.display = 'flex';
            result.style.display = 'none';
            button.disabled = true;
            button.textContent = 'AI sedang menganalisis...';

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch('{{ route('ai.identify') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Analisis gagal.');
                }

                const r = data.result;
                document.getElementById('result-name').textContent = r.name || '-';
                document.getElementById('result-type').textContent = 'Jenis: ' + (r.type || '-');
                document.getElementById('result-confidence').textContent = 'Akurasi ' + Math.round(r.confidence || 0) + '%';
                document.getElementById('result-weight').textContent = (r.weight || 0) + ' Kg';
                document.getElementById('result-price').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(r.price || 0);
                document.getElementById('result-condition').textContent = r.condition || '-';
                document.getElementById('result-advice').textContent = r.advice || '-';
                result.style.display = 'block';
            } catch (error) {
                alert(error.message);
            } finally {
                loader.style.display = 'none';
                button.disabled = false;
                button.textContent = 'Analisis Foto dengan AI';
            }
        }

        async function sendChatMessage() {
            const input = document.getElementById('chat-input');
            const container = document.getElementById('chat-messages');
            const text = input.value.trim();
            if (!text) return;

            const userBubble = document.createElement('div');
            userBubble.style.cssText = 'align-self: flex-end; max-width: 85%; background: #059669; color: #ffffff; padding: 0.75rem 1rem; border-radius: 1rem; font-size: 0.875rem;';
            userBubble.textContent = text;
            container.appendChild(userBubble);
            input.value = '';
            container.scrollTop = container.scrollHeight;

            const loadingBubble = document.createElement('div');
            loadingBubble.id = 'ai-typing';
            loadingBubble.style.cssText = 'align-self: flex-start; max-width: 85%; background: #ffffff; border: 1px solid var(--card-border); padding: 0.75rem 1rem; border-radius: 1rem; font-size: 0.875rem; color: #64748b;';
            loadingBubble.textContent = 'Eco AI sedang berpikir...';
            container.appendChild(loadingBubble);
            container.scrollTop = container.scrollHeight;

            try {
                const response = await fetch('{{ route('ai.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();
                document.getElementById('ai-typing')?.remove();

                if (!response.ok) {
                    throw new Error(data.message || 'Eco AI gagal merespons.');
                }

                const aiBubble = document.createElement('div');
                aiBubble.style.cssText = 'align-self: flex-start; max-width: 85%; background: #ffffff; border: 1px solid var(--card-border); padding: 0.75rem 1rem; border-radius: 1rem; font-size: 0.875rem; color: #0f172a; white-space: pre-wrap;';
                aiBubble.textContent = data.message;
                container.appendChild(aiBubble);
                container.scrollTop = container.scrollHeight;
            } catch (error) {
                document.getElementById('ai-typing')?.remove();
                const aiBubble = document.createElement('div');
                aiBubble.style.cssText = 'align-self: flex-start; max-width: 85%; background: #fef2f2; border: 1px solid #fecaca; padding: 0.75rem 1rem; border-radius: 1rem; font-size: 0.875rem; color: #b91c1c;';
                aiBubble.textContent = error.message;
                container.appendChild(aiBubble);
                container.scrollTop = container.scrollHeight;
            }
        }
    </script>
</body>

</html>
