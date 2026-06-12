    </main>
</div>

<?php require_once ROOT_PATH . '/app/views/layouts/_alert_modal.php'; ?>

<!-- Confirm Modal -->
<div id="confirmModal" class="am-overlay" style="display:none" role="dialog" aria-modal="true">
    <div class="am-box am-confirm">
        <div class="am-icon"><i class="fa-solid fa-circle-question"></i></div>
        <p class="am-msg" id="confirmMsg"></p>
        <div class="am-confirm-actions">
            <button class="am-close am-cancel" onclick="confirmResolve(false)">Batal</button>
            <button class="am-close am-ok" onclick="confirmResolve(true)">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById('admSidebar').classList.toggle('open');
    document.getElementById('admOverlay').classList.toggle('show');
}
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
</body>
</html>
