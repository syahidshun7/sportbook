<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

<div class="auth-card">
    <h2>Daftar Akun</h2>
    <form method="POST" action="<?= BASE_URL ?>/register">
        <?= csrfField() ?>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required autofocus>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password <small>(min. 8 karakter)</small></label>
            <input type="password" name="password" required minlength="8">
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn-primary btn-block">Daftar</button>
    </form>
    <p class="text-center">Sudah punya akun? <a href="<?= BASE_URL ?>/login">Login</a></p>
</div>
