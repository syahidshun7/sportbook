<?php
require_once ROOT_PATH . '/core/Model.php';

class Payment extends Model {
    protected string $table = 'payments';

    public function getByBooking(int $bookingId): ?array {
        return $this->findOne('booking_id = ?', [$bookingId]);
    }

    public function getAllPending(): array {
        return $this->query(
            "SELECT p.*, b.tanggal, b.total_harga, u.nama as user_nama, v.nama as venue_nama
             FROM payments p
             JOIN bookings b ON p.booking_id=b.id
             JOIN users u ON b.user_id=u.id
             JOIN venues v ON b.venue_id=v.id
             WHERE p.status='pending'
             ORDER BY p.created_at DESC"
        )->fetchAll();
    }

    public function getAll(): array {
        return $this->query(
            "SELECT p.*, b.tanggal, b.total_harga, u.nama as user_nama, v.nama as venue_nama
             FROM payments p
             JOIN bookings b ON p.booking_id=b.id
             JOIN users u ON b.user_id=u.id
             JOIN venues v ON b.venue_id=v.id
             ORDER BY p.created_at DESC"
        )->fetchAll();
    }
}
