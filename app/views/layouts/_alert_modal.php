<?php
$_am = $_SESSION['_alert_modal'] ?? null;
if ($_am) unset($_SESSION['_alert_modal']);
if (!$_am && !empty($GLOBALS['_alert_modal'])) $_am = $GLOBALS['_alert_modal'];
?>
<?php if ($_am): ?>
<div id="alertModal" class="am-overlay" role="dialog" aria-modal="true">
    <div class="am-box am-<?= htmlspecialchars($_am['type']) ?>">
        <div class="am-icon">
            <?php if ($_am['type'] === 'success'): ?>
                <i class="fa-solid fa-circle-check"></i>
            <?php elseif ($_am['type'] === 'error'): ?>
                <i class="fa-solid fa-triangle-exclamation"></i>
            <?php else: ?>
                <i class="fa-solid fa-circle-info"></i>
            <?php endif; ?>
        </div>
        <p class="am-msg"><?= htmlspecialchars($_am['message']) ?></p>
        <button class="am-close" onclick="document.getElementById('alertModal').remove()">OK</button>
    </div>
</div>
<script>
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') { var m = document.getElementById('alertModal'); if(m) m.remove(); }
});
document.getElementById('alertModal').addEventListener('click', function(e){
    if (e.target === this) this.remove();
});
</script>
<?php endif; ?>
