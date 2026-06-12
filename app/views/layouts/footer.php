
<footer class="sports-footer">
        <div class="footer-container">
            <div class="footer-section brand-info">
                <h2 class="footer-logo">ARENA<span>SPORTS</span></h2>
                <p>Platform booking venue olahraga terbaik, tercepat, dan terpercaya. Temukan arena favoritmu dan mulai bertanding hari ini!</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="Youtube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-section footer-links">
                <h3>Navigasi</h3>
                <ul>
                    <li><a href="<?= BASE_URL ?>/venues#venue-list"><i class="fa-solid fa-chevron-right"></i> Cari Venue</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="<?= BASE_URL ?>/my-bookings"><i class="fa-solid fa-chevron-right"></i> Riwayat Booking</a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>/login"><i class="fa-solid fa-chevron-right"></i> Masuk Akun</a></li>
                        <li><a href="<?= BASE_URL ?>/register"><i class="fa-solid fa-chevron-right"></i> Daftar Member</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-section footer-contact">
                <h3>Hubungi Kami</h3>
                <p><i class="fa-solid fa-phone"></i> +62 812-3456-7890</p>
                <p><i class="fa-solid fa-envelope"></i> support@arenasports.com</p>
                <p><i class="fa-solid fa-clock"></i> Setiap Hari: 07.00 - 23.00 WIB</p>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="bottom-container">
                <p>&copy; <?= date('Y'); ?> ArenaSports. All Rights Reserved.</p>
                <div class="footer-legal">
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>
<?php require_once ROOT_PATH . '/app/views/layouts/_alert_modal.php'; ?>

<!-- Confirm Modal -->
<div id="confirmModal" class="am-overlay" style="display:none" role="dialog" aria-modal="true">
    <div class="am-box am-confirm">
        <div class="am-icon"><i class="fa-solid fa-circle-question"></i></div>
        <p class="am-msg" id="confirmMsg"></p>
        <div class="am-confirm-actions">
            <button class="am-close am-cancel" onclick="confirmResolve(false)">Batal</button>
            <button class="am-close am-ok"     onclick="confirmResolve(true)">Ya, Lanjutkan</button>
        </div>
    </div>
</div>
<script>
var _confirmForm = null;
function confirmResolve(ok) {
    document.getElementById('confirmModal').style.display = 'none';
    if (ok && _confirmForm) _confirmForm.submit();
    _confirmForm = null;
}
function showConfirm(form, msg) {
    _confirmForm = form;
    document.getElementById('confirmMsg').textContent = msg;
    document.getElementById('confirmModal').style.display = 'flex';
    return false;
}
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') confirmResolve(false);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>