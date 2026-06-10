<div class="sports-container">
    
    <?php if ($success = flashGet('success')): ?>
        <div class="auth-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span><?= e($success) ?></span>
        </div>
    <?php endif; ?>

    <div class="sports-page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div class="header-title-wrapper">
            <span class="sub-title">AKTIVITAS SAYA</span>
            <h2>Riwayat Booking Saya</h2>
        </div>
        <a href="<?= BASE_URL ?>/venues" class="btn-sports-primary" style="text-decoration: none; padding: 10px 20px; font-size: 0.9rem;">
            <i class="fa-solid fa-plus"></i> <span>Booking Baru</span>
        </a>
    </div>
    <div class="header-line" style="margin-top: -10px; margin-bottom: 30px;"></div>

    <?php if (empty($bookings)): ?>
        <div class="sports-alert-info">
            <i class="fa-solid fa-calendar-xmark"></i>
            <span>Belum ada booking.</span>
        </div>
    <?php else: ?>
        <div class="sports-history-list">
            <?php foreach ($bookings as $b): ?>
                <div class="sports-history-card">
                    
                    <div class="history-schedule">
                        <div class="schedule-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <span class="date" style="font-size: 0.8rem; color: #a4b0be; font-weight: normal; margin-bottom: 2px;">
                                ID Booking: #<?= $b['id'] ?>
                            </span>
                            <span class="date"><?= e($b['tanggal']) ?></span>
                            <span class="time">
                                <i class="fa-regular fa-clock"></i> <?= e($b['jam_mulai']) ?> - <?= e($b['jam_selesai']) ?> WITA
                            </span>
                        </div>
                    </div>

                    <div class="history-details">
                        <h4><?= e($b['venue_nama']) ?></h4>
                        <p><i class="fa-solid fa-volleyball" style="color: #ff4757; margin-right: 4px;"></i> <?= e($b['jenis_olahraga']) ?></p>
                    </div>

                    <div class="history-price">
                        <span class="label">Total Bayar</span>
                        <span class="amount"><?= formatRupiah($b['total_harga']) ?></span>
                    </div>

                    <div class="history-status-action" style="display: flex; flex-direction: column; gap: 8px; justify-content: center;">
                        <?php 
                            // Konfigurasi dinamis badge warna sesuai status database Anda
                            $status = strtolower($b['status']);
                            $statusClass = '';
                            if ($status == 'pending') $statusClass = 'status-pending';
                            elseif ($status == 'lunas' || $status == 'confirmed' || $status == 'success') $statusClass = 'status-success';
                            else $statusClass = 'status-failed';
                        ?>
                        <span class="status-badge <?= $statusClass ?>"><?= ucfirst($b['status']) ?></span>

                        <?php if ($b['status'] === 'pending'): ?>
                            <div style="display: flex; gap: 6px; width: 100%;">
                                <a href="<?= BASE_URL ?>/payment/<?= $b['id'] ?>" class="btn-sports-sm" style="flex: 1; text-align: center; text-decoration: none; justify-content: center;">
                                    <span>Upload Bukti</span>
                                </a>
                                
                                <form method="POST" action="<?= BASE_URL ?>/booking/cancel/<?= $b['id'] ?>" style="display:inline; margin:0;" onsubmit="return confirm('Batalkan booking ini?')">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn-sports-sm" style="background: #ff4757; border: none; cursor: pointer; padding: 8px 12px;">
                                        <i class="fa-solid fa-trash-can" style="margin: 0; color: #fff;"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>