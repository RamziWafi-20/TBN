@extends('app.layout')
@section('title','Penghasilan & Nilai Ekonomi — TBN')
@section('content')
<div class="hero"><div><div class="eyebrow">Waste to Value</div><div class="title">Penghasilan & Nilai Ekonomi</div><p class="subtitle">{{ $isManager ? 'Ringkasan finansial seluruh aktivitas TBN sekolah.' : 'Ringkasan nilai ekonomi dari setoran sampahmu.' }}</p></div></div>
<div class="grid grid-4">
<div class="card stat-card"><div class="label">Nilai Penjualan</div><div class="income-big">Rp {{ number_format($selling,0,',','.') }}</div></div>
<div class="card stat-card"><div class="label">Net Profit</div><div class="metric green">Rp {{ number_format($netProfit,0,',','.') }}</div></div>
<div class="card stat-card"><div class="label">Biaya Proses</div><div class="metric">Rp {{ number_format($processing,0,',','.') }}</div></div>
<div class="card stat-card"><div class="label">Total Berat</div><div class="metric">{{ number_format($weight,2,',','.') }} kg</div></div>
</div>
<div class="grid grid-2" style="margin-top:18px">
<div class="card chart-card"><div class="section-head"><div><h3>Tren Nilai Ekonomi</h3><p class="subtitle">Penjualan dan profit per bulan.</p></div></div><div class="chart-box"><canvas id="incomeChart"></canvas></div></div>
<div class="card"><div class="section-head"><div><h3>Ringkasan</h3><p class="subtitle">Statistik aktivitas.</p></div></div><div class="finance-grid"><div><span class="label">Laporan</span><strong>{{ $count }}</strong></div><div><span class="label">Rata-rata</span><strong>Rp {{ number_format($average,0,',','.') }}</strong></div><div><span class="label">Gross Value</span><strong>Rp {{ number_format($gross,0,',','.') }}</strong></div><div><span class="label">Transaksi</span><strong>{{ $transactionsCount = $records->pluck('transaction')->filter()->count() }}</strong></div></div><p class="small-note">Data transaksi dihitung dari tabel <code>waste_transactions</code>; nilai setoran menggunakan <code>actual_value</code> dan fallback ke <code>estimated_value</code>.</p></div>
</div>
<div class="card" style="margin-top:18px"><div class="section-head"><div><h3>Transaksi / Setoran Terbaru</h3><p class="subtitle">Detail data yang digunakan pada laporan.</p></div></div><div class="table-wrap"><table class="table"><thead><tr><th>Tanggal</th><th>Pemilik</th><th>Kategori</th><th>Berat</th><th>Nilai</th><th>Transaksi</th></tr></thead><tbody>@forelse($records->take(15) as $record)<tr><td>{{ $record->created_at->format('d/m/Y') }}</td><td>{{ $record->user->name ?? '-' }}</td><td>{{ $record->category->name ?? 'Lainnya' }}</td><td>{{ number_format($record->effective_weight,2,',','.') }} kg</td><td>Rp {{ number_format($record->effective_value,0,',','.') }}</td><td>@if($record->transaction) Rp {{ number_format($record->transaction->selling_value,0,',','.') }} @else <span class="label">Belum ada</span> @endif</td></tr>@empty<tr><td colspan="6">Belum ada data.</td></tr>@endforelse</tbody></table></div></div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<script>
const monthly=@json($monthly);
new Chart(document.getElementById('incomeChart'),{type:'line',data:{labels:Object.keys(monthly),datasets:[{label:'Penjualan',data:Object.values(monthly).map(x=>x.selling),borderColor:'#059669',backgroundColor:'rgba(16,185,129,.10)',fill:true,tension:.35},{label:'Net Profit',data:Object.values(monthly).map(x=>x.profit),borderColor:'#f59e0b',backgroundColor:'transparent',tension:.35}]},options:{responsive:true,maintainAspectRatio:false,scales:{y:{beginAtZero:true,ticks:{callback:v=>'Rp '+Number(v).toLocaleString('id-ID')}},x:{grid:{display:false}}}}});
</script>
@endpush
