@extends('app.layout')
@section('title','Poin & Voucher — TBN')
@section('content')
<div class="hero"><div><div class="eyebrow">Reward Center</div><div class="title">Poin & Voucher 🎁</div><p class="subtitle">Setiap foto sampah yang berhasil dikirim memberikan <b>10 poin</b>.</p></div><span class="points-chip" style="font-size:14px">⭐ {{ number_format($user->points) }} Poin</span></div>
<div class="grid grid-2">
<div class="card"><h3>Voucher Tersedia</h3><p class="subtitle">Tukar poin dengan voucher WiFi atau koperasi.</p><div class="quick-links">
@forelse($vouchers as $v)
<div class="quick-link"><span>{{ $v->type === 'wifi' ? '📶' : '🛒' }}</span><div><b>{{ $v->name }}</b><small>{{ $v->description ?: 'Voucher TBN' }} • Stok {{ $v->stock }}</small><small><b>{{ number_format($v->points_cost) }} poin</b>@if($v->expires_at) • sampai {{ $v->expires_at->format('d/m/Y') }}@endif</small></div><form method="POST" action="{{ route('points.redeem',$v) }}">@csrf<button class="btn btn-primary" type="submit" onclick="return confirm('Tukar voucher ini dengan {{ number_format($v->points_cost) }} poin?')">Tukar</button></form></div>
@empty<div class="small-note">Belum ada voucher aktif.</div>@endforelse
</div></div>
<div class="card"><h3>Riwayat Poin</h3><div class="table-wrap"><table class="table"><thead><tr><th>Aktivitas</th><th>Poin</th><th>Saldo</th></tr></thead><tbody>@forelse($history as $h)<tr><td>{{ $h->description }}</td><td><b style="color:{{ $h->points >= 0 ? '#059669':'#dc2626' }}">{{ $h->points >= 0 ? '+' : '' }}{{ $h->points }}</b></td><td>{{ $h->balance_after }}</td></tr>@empty<tr><td colspan="3">Belum ada aktivitas poin.</td></tr>@endforelse</tbody></table></div></div>
</div>
<div class="card" style="margin-top:18px"><h3>Voucher yang Pernah Ditukar</h3><div class="table-wrap"><table class="table"><thead><tr><th>Voucher</th><th>Kode</th><th>Poin</th><th>Tanggal</th></tr></thead><tbody>@forelse($redemptions as $r)<tr><td>{{ $r->voucher->name ?? 'Voucher' }}</td><td><b>{{ $r->voucher_code }}</b></td><td>{{ number_format($r->points_spent) }}</td><td>{{ $r->redeemed_at?->format('d M Y H:i') }}</td></tr>@empty<tr><td colspan="4">Belum ada penukaran.</td></tr>@endforelse</tbody></table></div></div>
@endsection
