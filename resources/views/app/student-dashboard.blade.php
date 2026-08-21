@extends('app.layout')
@section('title','Dashboard Siswa — TBN')
@section('content')
<div class="hero"><div><div class="eyebrow">Dashboard Siswa</div><div class="title">Halo, {{ $user->name }} 👋</div><p class="subtitle">Pantau setoran, nilai ekonomi, dan posisi kontribusimu di TBN.</p></div><a href="{{ route('ranking') }}" class="btn btn-primary">🏆 Lihat Ranking</a></div>
<div class="grid grid-4">
<div class="card stat-card"><div class="label">Total Sampah</div><div class="metric green">{{ number_format($totalWeight,2,',','.') }} kg</div><div class="stat-note">Kontribusi pribadi</div></div>
<div class="card stat-card"><div class="label">Nilai Ekonomi</div><div class="metric">Rp {{ number_format($totalIncome,0,',','.') }}</div><div class="stat-note">Nilai setoran</div></div>
<div class="card stat-card"><div class="label">Setoran</div><div class="metric">{{ $totalTransactions }}</div><div class="stat-note">Total laporan</div></div>
<div class="card stat-card"><div class="label">Poin</div><div class="metric" style="color:#d97706">⭐ {{ number_format($user->points ?? 0) }}</div><div class="stat-note">10 poin per foto sampah</div></div>
<div class="card stat-card"><div class="label">Kelas</div><div class="metric" style="font-size:21px">{{ $user->class_name ?: 'Belum diatur' }}</div><div class="stat-note">Kelas aktif</div></div>
</div>
<div class="grid grid-2" style="margin-top:18px">
<div class="card"><h3>Setoran Terbaru</h3><div class="table-wrap"><table class="table"><thead><tr><th>Kategori</th><th>Berat</th><th>Nilai</th><th>Status</th></tr></thead><tbody>@forelse($wasteRecords as $record)<tr><td>{{ $record->category->name ?? 'Lainnya' }}</td><td>{{ number_format($record->effective_weight,2,',','.') }} kg</td><td>Rp {{ number_format($record->effective_value,0,',','.') }}</td><td><span class="status">{{ $record->status }}</span></td></tr>@empty<tr><td colspan="4">Belum ada setoran.</td></tr>@endforelse</tbody></table></div></div>
<div class="card"><h3>Akses Cepat</h3><p class="subtitle">Kelola profil dan lihat performa kontribusi.</p><div class="quick-links"><a href="{{ route('ranking') }}" class="quick-link"><span>🏆</span><div><b>Peringkat</b><small>Bandingkan kontribusi dengan siswa lain</small></div>→</a><a href="{{ route('income') }}" class="quick-link"><span>💰</span><div><b>Nilai Ekonomi</b><small>Lihat detail nilai setoranmu</small></div>→</a><a href="{{ route('profile') }}" class="quick-link"><span>👤</span><div><b>Profil</b><small>Tambahkan foto dan data diri</small></div>→</a></div></div>
</div>
<div class="grid grid-2" style="margin-top:18px">
<div class="card">
    <div class="section-head"><div><h3>♻️ Scanner Sampah</h3><p class="subtitle">Kirim foto sampah sebagai data pengumpulan. Setiap foto berhasil dikirim = <b>+10 poin</b>.</p></div><span class="points-chip">⭐ {{ number_format($user->points ?? 0) }} poin</span></div>
    <label class="scanner-drop" for="wasteImage"><div style="font-size:36px">📷</div><b>Pilih / ambil foto sampah</b><div class="small-note">JPG, PNG, WEBP • maksimal 10 MB</div><input id="wasteImage" type="file" accept="image/*"></label>
    <div id="scanStatus" class="small-note"></div><div id="scanResult" class="scan-result"></div>
</div>
<div class="card">
    <div class="section-head"><div><h3>🤖 Eco AI</h3><p class="subtitle">Tanya apa saja tentang sampah, daur ulang, poin, dan bank sampah.</p></div></div>
    <div class="ai-box" id="chatBox"><div class="chat-msg"><div class="chat-bubble"><b>Eco AI:</b> Halo! Saya siap membantu kamu menjaga sekolah tetap bersih 🌱</div></div></div>
    <form class="chat-form" id="chatForm"><input id="chatInput" maxlength="4000" placeholder="Contoh: bagaimana memilah botol plastik?" autocomplete="off"><button class="btn btn-primary" type="submit">Kirim</button></form>
</div>
</div>
<div class="card" style="margin-top:18px"><div class="section-head"><div><h3>⭐ Poin & Voucher</h3><p class="subtitle">Kumpulkan poin dari foto sampah lalu tukarkan dengan voucher.</p></div><a href="{{ route('points') }}" class="btn btn-light">Lihat Voucher →</a></div></div>

@push('scripts')
<script>
const csrf=document.querySelector('meta[name="csrf-token"]').content;
const scanInput=document.getElementById('wasteImage'), scanStatus=document.getElementById('scanStatus'), scanResult=document.getElementById('scanResult');
scanInput?.addEventListener('change', async ()=>{
 if(!scanInput.files.length)return; const fd=new FormData(); fd.append('image',scanInput.files[0]); scanStatus.textContent='Mengirim foto dan memproses data...'; scanResult.style.display='none';
 try{const r=await fetch('{{ route('ai.identify') }}',{method:'POST',headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json'},body:fd});const d=await r.json();if(!r.ok)throw new Error(d.message||'Upload gagal');scanStatus.textContent='✅ '+d.message;const x=d.result;scanResult.innerHTML='<b>'+x.name+'</b><br><span class="pill">'+x.type+'</span><p class="small-note">'+x.advice+'</p><span class="points-chip">+10 poin • Saldo '+x.points_balance+' poin</span>';scanResult.style.display='block';}catch(e){scanStatus.textContent='❌ '+e.message;}
});
const chatForm=document.getElementById('chatForm'), chatBox=document.getElementById('chatBox'), chatInput=document.getElementById('chatInput');
chatForm?.addEventListener('submit',async e=>{e.preventDefault();const msg=chatInput.value.trim();if(!msg)return;chatBox.insertAdjacentHTML('beforeend','<div class="chat-msg user"><div class="chat-bubble">'+escapeHtml(msg)+'</div></div>');chatInput.value='';chatBox.scrollTop=chatBox.scrollHeight;try{const r=await fetch('{{ route('ai.chat') }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},body:JSON.stringify({message:msg})});const d=await r.json();chatBox.insertAdjacentHTML('beforeend','<div class="chat-msg"><div class="chat-bubble"><b>Eco AI:</b> '+escapeHtml(d.message||'Tidak ada respons.')+'</div></div>');}catch(err){chatBox.insertAdjacentHTML('beforeend','<div class="chat-msg"><div class="chat-bubble">Eco AI sedang tidak tersedia.</div></div>')}chatBox.scrollTop=chatBox.scrollHeight;});
function escapeHtml(v){return String(v).replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[c]));}
</script>
@endpush
@endsection
