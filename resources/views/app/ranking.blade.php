@extends('app.layout')
@section('title','Ranking & Peringkat — TBN')
@section('content')
<div class="hero"><div><div class="eyebrow">Leaderboard TBN</div><div class="title">Peringkat Kontributor</div><p class="subtitle">Peringkat siswa dihitung dari total berat sampah yang tercatat pada waste_reports.</p></div></div>
<div class="grid grid-2">
<div class="card"><div class="section-head"><div><h3>Ranking Siswa</h3><p class="subtitle">Semakin besar kontribusi, semakin tinggi peringkat.</p></div><span class="chart-badge">TOP {{ $ranking->count() }}</span></div><div class="table-wrap"><table class="table"><thead><tr><th>#</th><th>Nama</th><th>Kelas</th><th>Berat</th><th>Nilai</th></tr></thead><tbody>@forelse($ranking as $i => $row)<tr><td><span class="rank {{ $i < 3 ? 'top':'' }}">{{ $i+1 }}</span></td><td><b>{{ $row['user']->name }}</b><br><span class="label">{{ $row['transactions'] }} setoran</span></td><td>{{ $row['class'] }}</td><td><b>{{ number_format($row['weight'],2,',','.') }} kg</b></td><td>Rp {{ number_format($row['income'],0,',','.') }}</td></tr>@empty<tr><td colspan="5">Belum ada data ranking.</td></tr>@endforelse</tbody></table></div></div>
<div class="card chart-card"><div class="section-head"><div><h3>Kontribusi per Kelas</h3><p class="subtitle">Total kilogram per kelas.</p></div></div><div class="chart-box"><canvas id="classRankingChart"></canvas></div></div>
</div>
<div class="card" style="margin-top:18px"><div class="section-head"><div><h3>Ringkasan Kelas</h3><p class="subtitle">Performa kelas berdasarkan berat sampah.</p></div></div><div class="grid grid-3" style="margin-top:12px">@forelse($classes as $row)<div class="class-card"><span class="pill">{{ $row['class'] }}</span><div class="metric" style="font-size:22px">{{ number_format($row['weight'],2,',','.') }} kg</div><div class="label">{{ $row['students'] }} siswa • Rp {{ number_format($row['income'],0,',','.') }}</div></div>@empty<p class="subtitle">Belum ada data kelas.</p>@endforelse</div></div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<script>
const classes=@json($classes->values());
new Chart(document.getElementById('classRankingChart'),{type:'bar',data:{labels:classes.map(x=>x.class),datasets:[{label:'Kg Sampah',data:classes.map(x=>x.weight),backgroundColor:'#10b981',borderRadius:9}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true},x:{grid:{display:false}}}}});
</script>
@endpush
