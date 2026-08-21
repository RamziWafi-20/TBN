<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="preload" as="image" href="<?php echo e(asset('assets/hero-tbn-DTHbnet-.jpg')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/styles-Be6PXbW8.css')); ?>" data-precedence="default" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&amp;family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" data-precedence="default" />
    <title>TBN — Trash Bank Neskar | Bank Sampah Sekolah Digital</title>
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="description" content="TBN mengubah sampah sekolah jadi nilai: AI Waste Scanner, Eco AI, pelaporan sampah, dan analitik Waste to Value." />
    <meta property="og:title" content="TBN — Trash Bank Neskar" />
    <meta property="og:description" content="Bank sampah sekolah digital: pindai, laporkan, dan ubah sampah menjadi nilai." />
    
    <link rel="modulepreload" href="<?php echo e(asset('assets/index-DhrqBnDf.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/jsx-runtime-BMhk9OTh.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/routes-CbptzsOX.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/button-CcC8dtDH.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/bot-C8MgQXIe.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/coins-CPVBr_xV.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/leaf-D5k7gyuA.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/recycle-BuBPdW-I.js')); ?>" />
    <link rel="modulepreload" href="<?php echo e(asset('assets/scan-line-DjekUQRW.js')); ?>" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon" />

    <meta name="twitter:title" content="TBN — Trash Bank Neskar">
    <meta name="twitter:description" content="Bank sampah sekolah digital: pindai, laporkan, dan ubah sampah menjadi nilai.">
    <meta property="og:image" content="https://pub-bb2e103a32db4e198524a2e9ed8f35b4.r2.dev/80ee5c1c26df8fe56eeb5008ea37cdb0/id-preview-d019a8f8--4ee2fd0f-ebe7-4e32-9f7b-2f67fcc3fec3.lovable.app-1786681407754.png">
    <meta name="twitter:image" content="https://pub-bb2e103a32db4e198524a2e9ed8f35b4.r2.dev/80ee5c1c26df8fe56eeb5008ea37cdb0/id-preview-d019a8f8--4ee2fd0f-ebe7-4e32-9f7b-2f67fcc3fec3.lovable.app-1786681407754.png">
</head>

<body>
    <!-- Main Content -->
    <main class="min-h-screen bg-background">
        <!-- Header -->
        <header class="mx-auto flex max-w-6xl items-center justify-between px-5 py-5">
            <div class="flex items-center gap-2">
                <span class="flex size-9 items-center justify-center rounded-xl bg-eco-gradient text-primary-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-leaf size-5" aria-hidden="true">
                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                    </svg>
                </span>
                <span class="font-display text-lg font-bold">TBN</span>
            </div>
            <a href="<?php echo e(url('/auth')); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium cursor-pointer transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 disabled:cursor-not-allowed [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-8 rounded-md px-3 text-xs">Masuk</a>
        </header>

        <!-- Hero Section -->
        <section class="eco-grid">
            <div class="mx-auto grid max-w-6xl items-center gap-10 px-5 pt-8 pb-16 md:grid-cols-2 md:pt-16">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-border bg-card px-3 py-1 text-xs font-semibold text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-leaf size-3.5" aria-hidden="true">
                            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                        </svg> Trash Bank Neskar
                    </span>
                    <h1 class="mt-5 text-4xl leading-tight font-extrabold text-balance md:text-6xl">
                        Ubah sampah sekolah menjadi <span class="text-primary">nilai nyata</span>.
                    </h1>
                    <p class="mt-4 max-w-lg text-base text-muted-foreground">
                        Satu aplikasi untuk memindai, melaporkan, mengelola, dan menguangkan sampah — didukung AI dan analitik dampak lingkungan.
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="<?php echo e(url('/auth')); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium cursor-pointer transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 disabled:cursor-not-allowed [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-10 rounded-md px-8">
                            Mulai sekarang 
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right size-4" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="<?php echo e(url('/auth')); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium cursor-pointer transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 disabled:cursor-not-allowed [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground h-10 rounded-md px-8">
                            Buat akun
                        </a>
                    </div>
                </div>
                <div class="overflow-hidden rounded-3xl shadow-lift">
                    <img src="<?php echo e(asset('assets/hero-tbn-DTHbnet-.jpg')); ?>" alt="Pelajar memilah sampah daur ulang di halaman sekolah" width="1600" height="1000" class="h-full w-full object-cover" />
                </div>
            </div>
        </section>

        <!-- Fitur Utama -->
        <section class="mx-auto max-w-6xl px-5 pb-20">
            <h2 class="text-2xl font-bold md:text-3xl">Fitur utama</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- AI Waste Scanner -->
                <div class="rounded-2xl border border-border bg-card p-5 shadow-card">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-secondary text-secondary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scan-line size-5" aria-hidden="true">
                            <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                            <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                            <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                            <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                            <path d="M7 12h10"></path>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-semibold">AI Waste Scanner</h3>
                    <p class="mt-1.5 text-sm text-muted-foreground">Foto sampah, AI mengenali jenis, material, berat, dan perkiraan nilainya.</p>
                </div>

                <!-- Eco AI -->
                <div class="rounded-2xl border border-border bg-card p-5 shadow-card">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-secondary text-secondary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bot size-5" aria-hidden="true">
                            <path d="M12 8V4H8"></path>
                            <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                            <path d="M2 14h2"></path>
                            <path d="M20 14h2"></path>
                            <path d="M15 13v2"></path>
                            <path d="M9 13v2"></path>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-semibold">Eco AI</h3>
                    <p class="mt-1.5 text-sm text-muted-foreground">Chatbot edukasi sampah, ide produk, dan peluang ekonomi sirkular.</p>
                </div>

                <!-- Pengelolaan Sampah -->
                <div class="rounded-2xl border border-border bg-card p-5 shadow-card">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-secondary text-secondary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-recycle size-5" aria-hidden="true">
                            <path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"></path>
                            <path d="M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12"></path>
                            <path d="m14 16-3 3 3 3"></path>
                            <path d="M8.293 13.596 7.196 9.5 3.1 10.598"></path>
                            <path d="m9.344 5.811 1.093-1.892A1.83 1.83 0 0 1 11.985 3a1.784 1.784 0 0 1 1.546.888l3.943 6.843"></path>
                            <path d="m13.378 9.633 4.096 1.098 1.097-4.096"></path>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-semibold">Pengelolaan Sampah</h3>
                    <p class="mt-1.5 text-sm text-muted-foreground">Laporkan sampah, pantau status, dan kelola lewat panel admin.</p>
                </div>

                <!-- Waste to Value -->
                <div class="rounded-2xl border border-border bg-card p-5 shadow-card">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-secondary text-secondary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-coins size-5" aria-hidden="true">
                            <path d="M13.744 17.736a6 6 0 1 1-7.48-7.48"></path>
                            <path d="M15 6h1v4"></path>
                            <path d="m6.134 14.768.866-.5 2 3.464"></path>
                            <circle cx="16" cy="8" r="6"></circle>
                        </svg>
                    </span>
                    <h3 class="mt-4 font-semibold">Waste to Value</h3>
                    <p class="mt-1.5 text-sm text-muted-foreground">Jual atau upcycle, catat pendapatan, dan lihat laporan dampak.</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-border py-8 text-center text-sm text-muted-foreground">
            TBN — Trash Bank Neskar · Bank sampah sekolah digital
        </footer>
    </main>

    <script type="module" async="" src="<?php echo e(asset('assets/index-DhrqBnDf.js')); ?>"></script>
</body>

</html>
<?php /**PATH D:\xampp-portable-windows-x64-8.2.12-0-VS16\xampp\TBN\TBN Laravel\resources\views/home.blade.php ENDPATH**/ ?>