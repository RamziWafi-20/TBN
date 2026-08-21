<?php $__env->startSection('title','Profil Saya — TBN'); ?>
<?php $__env->startSection('content'); ?>
<div class="hero"><div><div class="eyebrow">Akun Saya</div><div class="title">Profil <?php echo e($user->role); ?></div><p class="subtitle">Kelola informasi akun dan pasang foto profil agar identitasmu lebih mudah dikenali.</p></div></div>
<div class="profile-grid">
<div class="card profile-card">
<?php if($user->profile_photo): ?><img class="profile-large" src="<?php echo e(asset('storage/'.$user->profile_photo)); ?>" alt="Foto profil"><?php else: ?><div class="profile-large"><?php echo e(strtoupper(substr($user->name,0,1))); ?></div><?php endif; ?>
<h3><?php echo e($user->name); ?></h3><span class="pill"><?php echo e($user->role); ?></span><p class="subtitle" style="margin-top:12px"><?php echo e($user->email); ?></p>
</div>
<div class="card"><h3>Informasi Profil</h3><form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?>
<div class="form-grid"><div class="field full"><label>Foto Profil</label><input type="file" name="profile_photo" accept="image/png,image/jpeg,image/webp"><span class="label">JPG/PNG/WEBP, maksimal 2 MB.</span></div><div class="field"><label>Nama Lengkap</label><input type="text" name="name" value="<?php echo e(old('name',$user->name)); ?>" required></div><div class="field"><label>Email</label><input type="email" value="<?php echo e($user->email); ?>" disabled></div><div class="field"><label>NIS</label><input type="text" name="nis" value="<?php echo e(old('nis',$user->nis)); ?>"></div><div class="field"><label>Kelas</label><input type="text" name="class_name" value="<?php echo e(old('class_name',$user->class_name)); ?>" placeholder="Contoh: XII RPL 2"></div><div class="field full"><label>Username</label><input type="text" value="<?php echo e($user->username); ?>" disabled></div></div><div style="margin-top:18px"><button class="btn btn-primary" type="submit">Simpan Perubahan</button></div></form></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp-portable-windows-x64-8.2.12-0-VS16\xampp\TBN\TBN Laravel\resources\views/app/profile.blade.php ENDPATH**/ ?>