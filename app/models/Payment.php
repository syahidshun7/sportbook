<?php
require_once ROOT_PATH . '/core/Model.php';

class Payment extends Model {
    protected string $table = 'payments';

    public function getByBooking(int $bookingId): ?array {
        return $this->findOne('booking_id = ?', [$bookingId]);
    }

    public function getFiltered(string $search = '', string $status = '', int $limit = 10, int $offset = 0): array {
        [$where, $params] = $this->buildFilter($search, $status);
        $params[] = $limit; $params[] = $offset;
        return $this->query(
            "SELECT p.*, b.tanggal, b.total_harga, u.nama as user_nama, v.nama as venue_nama
             FROM payments p JOIN bookings b ON p.booking_id=b.id
             JOIN users u ON b.user_id=u.id JOIN venues v ON b.venue_id=v.id
             $where ORDER BY p.created_at DESC LIMIT ? OFFSET ?", $params
        )->fetchAll();
    }

    public function countFiltered(string $search = '', string $status = ''): int {
        [$where, $params] = $this->buildFilter($search, $status);
        return (int)$this->query(
            "SELECT COUNT(*) FROM payments p JOIN bookings b ON p.booking_id=b.id
             JOIN users u ON b.user_id=u.id JOIN venues v ON b.venue_id=v.id $where", $params
        )->fetchColumn();
    }

    private function buildFilter(string $search, string $status): array {
        $cond = []; $params = [];
        if ($search !== '') { $cond[] = 'u.nama LIKE ?'; $params[] = "%$search%"; }
        if ($status !== '') { $cond[] = 'p.status = ?'; $params[] = $status; }
        return [$cond ? 'WHERE ' . implode(' AND ', $cond) : '', $params];
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
