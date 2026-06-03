<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="auth-card">
    <h2>Login Sportbook</h2>
    <form method="POST" action="<?= BASE_URL ?>/login">
        <?= csrfField() ?>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-check">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Ingat saya selama 30 hari</label>
        </div>
        <button type="submit" class="btn-primary btn-block">Login</button>
    </form>
    <p class="text-center">Belum punya akun? <a href="<?= BASE_URL ?>/register">Daftar di sini</a></p>
</div>
