@extends('app.layout')
@section('title','Profil Saya — TBN')
@section('content')
<div class="hero"><div><div class="eyebrow">Akun Saya</div><div class="title">Profil {{ $user->role }}</div><p class="subtitle">Kelola informasi akun dan pasang foto profil agar identitasmu lebih mudah dikenali.</p></div></div>
<div class="profile-grid">
<div class="card profile-card">
@if($user->profile_photo)<img class="profile-large" src="{{ asset('storage/'.$user->profile_photo) }}" alt="Foto profil">@else<div class="profile-large">{{ strtoupper(substr($user->name,0,1)) }}</div>@endif
<h3>{{ $user->name }}</h3><span class="pill">{{ $user->role }}</span><p class="subtitle" style="margin-top:12px">{{ $user->email }}</p>
</div>
<div class="card"><h3>Informasi Profil</h3><form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">@csrf
<div class="form-grid"><div class="field full"><label>Foto Profil</label><input type="file" name="profile_photo" accept="image/png,image/jpeg,image/webp"><span class="label">JPG/PNG/WEBP, maksimal 2 MB.</span></div><div class="field"><label>Nama Lengkap</label><input type="text" name="name" value="{{ old('name',$user->name) }}" required></div><div class="field"><label>Email</label><input type="email" value="{{ $user->email }}" disabled></div><div class="field"><label>NIS</label><input type="text" name="nis" value="{{ old('nis',$user->nis) }}"></div><div class="field"><label>Kelas</label><input type="text" name="class_name" value="{{ old('class_name',$user->class_name) }}" placeholder="Contoh: XII RPL 2"></div><div class="field full"><label>Username</label><input type="text" value="{{ $user->username }}" disabled></div></div><div style="margin-top:18px"><button class="btn btn-primary" type="submit">Simpan Perubahan</button></div></form></div>
</div>
@endsection
