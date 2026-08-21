@extends('app.layout')
@section('title','Dashboard Pengelola — TBN')
@section('content')
<div class="hero">
    <div>
        <div class="eyebrow">Pusat Kendali Pengelola</div>
        <div class="title">Dashboard Sekolah</div>
        <p class="subtitle">Pantau volume sampah, nilai ekonomi, transaksi, kontribusi kelas, dan performa TBN secara real-time dari database sekolah.</p>
    </div>
    <div class="hero-actions">
        <a href="{{ route('ranking') }}" class="btn btn-light">🏆 Ranking</a>
        <a href="{{ route('income') }}" class="btn btn-primary">💰 Laporan Penghasilan</a>
    </div>
</div>

<div class="grid grid-4">
    <div class="card stat-card"><div class="label">Total Sampah</div><div class="metric green">{{ number_format($totalWeight,2,',','.') }} kg</div><div class="stat-note">Seluruh setoran tercatat</div></div>
    <div class="card stat-card"><div class="label">Nilai Ekonomi</div><div class="metric">Rp {{ number_format($totalIncome,0,',','.') }}</div><div class="stat-note">Nilai aktual/estimasi</div></div>
    <div class="card stat-card"><div class="label">Transaksi Selesai</div><div class="metric">{{ number_format($totalTransactions,0,',','.') }}</div><div class="stat-note">Transaksi material</div></div>
    <div class="card stat-card"><div class="label">Pengguna</div><div class="metric">{{ number_format($totalUsers,0,',','.') }}</div><div class="stat-note">{{ $totalStudents }} siswa terdaftar</div></div>
</div>

<div class="grid grid-2" style="margin-top:18px">
    <div class="card chart-card">
        <div class="section-head"><div><h3>Volume Sampah per Bulan</h3><p class="subtitle">Kilogram sampah yang masuk ke sistem.</p></div><span class="chart-badge">KG</span></div>
        <div class="chart-box"><canvas id="monthlyWasteChart"></canvas></div>
    </div>
    <div class="card chart-card">
        <div class="section-head"><div><h3>Komposisi Sampah</h3><p class="subtitle">Distribusi berdasarkan kategori.</p></div><span class="chart-badge">KATEGORI</span></div>
        <div class="chart-box doughnut"><canvas id="categoryWasteChart"></canvas></div>
    </div>
</div>

<div class="grid grid-2" style="margin-top:18px">
    <div class="card chart-card">
        <div class="section-head"><div><h3>Kontribusi per Kelas</h3><p class="subtitle">Perbandingan berat sampah antar kelas.</p></div><span class="chart-badge">KELAS</span></div>
        <div class="chart-box"><canvas id="classWasteChart"></canvas></div>
    </div>
    <div class="card">
        <div class="section-head"><div><h3>Ringkasan Keuangan</h3><p class="subtitle">Bersumber dari waste_transactions.</p></div></div>
        <div class="finance-grid">
            <div><span class="label">Nilai Penjualan</span><strong>Rp {{ number_format($chartData['summary']['selling'],0,',','.') }}</strong></div>
            <div><span class="label">Net Profit</span><strong class="green-text">Rp {{ number_format($totalProfit,0,',','.') }}</strong></div>
        </div>
        <div class="quick-links">
            <a href="{{ route('income') }}" class="quick-link"><span>💰</span><div><b>Detail Penghasilan</b><small>Lihat penjualan, biaya, dan profit</small></div>→</a>
            <a href="{{ route('ranking') }}" class="quick-link"><span>🏆</span><div><b>Ranking Siswa</b><small>Peringkat berdasarkan kontribusi</small></div>→</a>
            <a href="{{ route('profile') }}" class="quick-link"><span>👤</span><div><b>Profil Pengelola</b><small>Kelola identitas dan foto</small></div>→</a>
        </div>
    </div>
</div>

<div class="card" style="margin-top:18px">
    <div class="section-head"><div><h3>Setoran Sampah Terbaru</h3><p class="subtitle">Aktivitas terbaru dari seluruh siswa.</p></div><a href="{{ route('income') }}" class="btn btn-light">Lihat semua</a></div>
    <div class="table-wrap"><table class="table"><thead><tr><th>Kode</th><th>Siswa</th><th>Kategori</th><th>Berat</th><th>Nilai</th><th>Status</th></tr></thead><tbody>
    @forelse($wasteRecords as $record)
        <tr><td><b>{{ $record->code }}</b></td><td>{{ $record->user->name ?? '-' }}</td><td>{{ $record->category->name ?? 'Lainnya' }}</td><td>{{ number_format($record->effective_weight,2,',','.') }} kg</td><td>Rp {{ number_format($record->effective_value,0,',','.') }}</td><td><span class="status">{{ $record->status }}</span></td></tr>
    @empty <tr><td colspan="6">Belum ada setoran.</td></tr>@endforelse
    </tbody></table></div>

<div class="card" style="margin-top:18px">
    <div class="section-head"><div><h3>📷 Foto Setoran Terbaru</h3><p class="subtitle">Data yang dikirim siswa melalui Scanner TBN.</p></div></div>
    <div class="table-wrap"><table class="table"><thead><tr><th>Foto</th><th>Siswa</th><th>Identifikasi</th><th>Poin</th><th>Waktu</th></tr></thead><tbody>
    @forelse($latestScans as $scan)<tr><td>@if($scan->image_path)<img src="{{ asset('storage/'.$scan->image_path) }}" style="width:54px;height:42px;object-fit:cover;border-radius:8px">@else—@endif</td><td>{{ $scan->user->name ?? '-' }}</td><td><b>{{ $scan->waste_name }}</b><br><small>{{ $scan->waste_type }}</small></td><td><span class="points-chip">+10</span></td><td>{{ $scan->created_at?->format('d/m/Y H:i') }}</td></tr>@empty<tr><td colspan="5">Belum ada foto setoran.</td></tr>@endforelse
    </tbody></table></div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<script>
const dashboardData = @json($chartData);
const baseOptions = {responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, grid:{color:'rgba(148,163,184,.15)'}, ticks:{color:'#64748b'}},x:{grid:{display:false},ticks:{color:'#64748b'}}}};
new Chart(document.getElementById('monthlyWasteChart'), {type:'line',data:{labels:dashboardData.monthly.labels,datasets:[{label:'Kg Sampah',data:dashboardData.monthly.values,tension:.35,fill:true,borderColor:'#059669',backgroundColor:'rgba(16,185,129,.12)',pointBackgroundColor:'#059669',pointRadius:4}]},options:baseOptions});
new Chart(document.getElementById('categoryWasteChart'), {type:'doughnut',data:{labels:dashboardData.category.labels,datasets:[{data:dashboardData.category.values,backgroundColor:['#059669','#10b981','#34d399','#f59e0b','#3b82f6','#8b5cf6','#ef4444'],borderWidth:0}]},options:{responsive:true,maintainAspectRatio:false,cutout:'68%',plugins:{legend:{position:'bottom',labels:{usePointStyle:true,padding:14}}}}});
new Chart(document.getElementById('classWasteChart'), {type:'bar',data:{labels:dashboardData.classes.labels,datasets:[{label:'Kg Sampah',data:dashboardData.classes.values,borderRadius:8,backgroundColor:'#10b981'}]},options:baseOptions});
</script>
@endpush
