<?php if ($error): ?>
    <div class="auth-alert-danger">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?= e($error) ?></span>
    </div>
<?php endif; ?>

<div class="sports-auth-container">
    <div class="sports-auth-box">
        
        <div class="auth-visual-side register-bg">
            <div class="visual-content">
                <h1 class="auth-brand">ARENA<span>SPORTS</span></h1>
                <p class="visual-tagline">Gabung komunitas olahraga terbesar. Nikmati kemudahan akses booking berbagai arena pilihan.</p>
            </div>
            <div class="visual-overlay"></div>
        </div>

        <div class="auth-form-side">
            <div class="auth-form-header">
                <h2>Daftar Akun</h2>
                <p>Lengkapi data di bawah ini untuk mendaftar ke Sportbook.</p>
            </div>

            <form method="POST" action="<?= BASE_URL ?>/register" class="sports-form">
                <?= csrfField() ?>
                
                <div class="form-group">
                    <label for="regNama"><i class="fa-solid fa-id-card"></i> Nama Lengkap</label>
                    <input type="text" name="nama" id="regNama" required autofocus class="sports-input" placeholder="Contoh: Budi Santoso" value="<?= e($old_nama ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="regEmail"><i class="fa-solid fa-envelope"></i> Email</label>
                    <input type="email" name="email" id="regEmail" required class="sports-input" placeholder="nama@email.com" value="<?= e($old_email ?? '') ?>">
                </div>

                <div class="form-row split-2" style="margin-bottom: 0;">
                    <div class="form-group">
                        <label for="regPassword"><i class="fa-solid fa-lock"></i> Password <small style="color: #a4b0be; text-transform: none; font-weight: 500;">(min. 8 karakter)</small></label>
                        <input type="password" name="password" id="regPassword" required minlength="8" class="sports-input" placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label for="regConfirmPassword"><i class="fa-solid fa-shield-halved"></i> Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="regConfirmPassword" required class="sports-input" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-sports-primary auth-submit-btn" style="margin-top: 20px;">
                    <span>Daftar</span> <i class="fa-solid fa-user-plus"></i>
                </button>
            </form>

            <div class="auth-footer-links">
                <p>Sudah punya akun? <a href="<?= BASE_URL ?>/login">Login</a></p>
                <a href="<?= BASE_URL ?>/venues" class="back-to-home"><i class="fa-solid fa-arrow-left"></i> Lihat Daftar Venue</a>
            </div>
        </div>

    </div>
</div>