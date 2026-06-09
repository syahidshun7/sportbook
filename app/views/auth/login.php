<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<?php if (isset($lockout) && $lockout): ?>
<div class="lockout-banner-wrapper" id="lockoutBanner">
    <div class="lockout-banner">
        <div class="lockout-header">
            <span class="lockout-icon">🔒</span>
            <div class="lockout-title-group">
                <h3>Akses Ditangguhkan</h3>
                <p>Terlalu banyak percobaan login.</p>
            </div>
        </div>
        <div class="lockout-body">
            <div class="lockout-timer" id="lockoutCountdown">00:00</div>
            <div class="lockout-progress-container">
                <div class="lockout-progress-bar" id="lockoutTimelineBar"></div>
            </div>
            <div class="lockout-meta">
                <span>Target: <?= e($lockout['target']) ?></span>
                <span id="lockoutStatus">Mengamankan sistem...</span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="auth-card">
    <h2>Login Sportbook</h2>
    <form method="POST" action="<?= BASE_URL ?>/login">
        <?= csrfField() ?>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" id="loginEmail" required autofocus <?= isset($lockout) && $lockout ? 'disabled' : '' ?>>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="loginPassword" required <?= isset($lockout) && $lockout ? 'disabled' : '' ?>>
        </div>
        <div class="form-check">
            <input type="checkbox" name="remember" id="remember" <?= isset($lockout) && $lockout ? 'disabled' : '' ?>>
            <label for="remember">Ingat saya selama 30 hari</label>
        </div>
        <button type="submit" class="btn-primary btn-block" id="loginSubmitBtn" <?= isset($lockout) && $lockout ? 'disabled' : '' ?>>
            <?= isset($lockout) && $lockout ? '🔒 Terkunci' : 'Login' ?>
        </button>
    </form>
    <p class="text-center">Belum punya akun? <a href="<?= BASE_URL ?>/register">Daftar di sini</a></p>
</div>

<?php if (isset($lockout) && $lockout): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let remaining = <?= (int)$lockout['remaining'] ?>;
        const total = <?= (int)$lockout['total'] ?>;
        
        const countdownEl = document.getElementById('lockoutCountdown');
        const barEl = document.getElementById('lockoutTimelineBar');
        const bannerEl = document.getElementById('lockoutBanner');
        const statusEl = document.getElementById('lockoutStatus');
        
        const emailInput = document.getElementById('loginEmail');
        const passwordInput = document.getElementById('loginPassword');
        const submitBtn = document.getElementById('loginSubmitBtn');
        const rememberInput = document.getElementById('remember');
        
        function formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        }
        
        function updateTimer() {
            if (remaining <= 0) {
                clearInterval(interval);
                
                // Re-enable inputs
                if (emailInput) emailInput.disabled = false;
                if (passwordInput) passwordInput.disabled = false;
                if (rememberInput) rememberInput.disabled = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Login';
                }
                
                // Animate and hide banner
                if (bannerEl) {
                    bannerEl.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    bannerEl.style.opacity = '0';
                    bannerEl.style.transform = 'translateY(-20px)';
                    bannerEl.style.maxHeight = '0';
                    bannerEl.style.padding = '0';
                    bannerEl.style.marginBottom = '0';
                    setTimeout(() => {
                        bannerEl.remove();
                    }, 500);
                }
                return;
            }
            
            if (countdownEl) {
                countdownEl.textContent = formatTime(remaining);
            }
            
            if (barEl) {
                const pct = (remaining / total) * 100;
                barEl.style.width = `${pct}%`;
            }
            
            remaining--;
        }
        
        updateTimer();
        const interval = setInterval(updateTimer, 1000);
    });
</script>
<?php endif; ?>
