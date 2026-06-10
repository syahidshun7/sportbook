<?php
require_once ROOT_PATH . '/core/Model.php';

class Booking extends Model {
    protected string $table = 'bookings';

    public function getByUser(int $userId): array {
        return $this->query(
            "SELECT b.*, v.nama as venue_nama, v.jenis_olahraga
             FROM bookings b JOIN venues v ON b.venue_id=v.id
             WHERE b.user_id=? ORDER BY b.created_at DESC",
            [$userId]
        )->fetchAll();
    }

    public function getAllWithDetails(): array {
        return $this->query(
            "SELECT b.*, u.nama as user_nama, u.email, v.nama as venue_nama
             FROM bookings b
             JOIN users u ON b.user_id=u.id
             JOIN venues v ON b.venue_id=v.id
             ORDER BY b.created_at DESC"
        )->fetchAll();
    }

    public function getFiltered(string $search = '', string $status = '', int $venueId = 0, int $limit = 10, int $offset = 0): array {
        [$where, $params] = $this->buildFilter($search, $status, $venueId);
        $params[] = $limit;
        $params[] = $offset;
        return $this->query(
            "SELECT b.*, u.nama as user_nama, u.email, v.nama as venue_nama
             FROM bookings b JOIN users u ON b.user_id=u.id JOIN venues v ON b.venue_id=v.id
             $where ORDER BY b.created_at DESC LIMIT ? OFFSET ?",
            $params
        )->fetchAll();
    }

    public function countFiltered(string $search = '', string $status = '', int $venueId = 0): int {
        [$where, $params] = $this->buildFilter($search, $status, $venueId);
        return (int)$this->query(
            "SELECT COUNT(*) FROM bookings b JOIN users u ON b.user_id=u.id JOIN venues v ON b.venue_id=v.id $where",
            $params
        )->fetchColumn();
    }

    private function buildFilter(string $search, string $status, int $venueId): array {
        $conditions = [];
        $params = [];
        if ($search !== '') { $conditions[] = 'u.nama LIKE ?'; $params[] = "%$search%"; }
        if ($status !== '') { $conditions[] = 'b.status = ?'; $params[] = $status; }
        if ($venueId > 0)   { $conditions[] = 'b.venue_id = ?'; $params[] = $venueId; }
        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
        return [$where, $params];
    }

    public function getDetail(int $id): ?array {
        $stmt = $this->query(
            "SELECT b.*, u.nama as user_nama, v.nama as venue_nama, v.harga_per_jam,
                    p.status as payment_status, p.bukti_transfer, p.metode, p.id as payment_id
             FROM bookings b
             JOIN users u ON b.user_id=u.id
             JOIN venues v ON b.venue_id=v.id
             LEFT JOIN payments p ON p.booking_id=b.id
             WHERE b.id=? LIMIT 1",
            [$id]
        );
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
