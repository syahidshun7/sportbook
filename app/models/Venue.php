<?php
require_once ROOT_PATH . '/core/Model.php';

class Venue extends Model {
    protected string $table = 'venues';

    public function getFiltered(string $search = '', string $status = '', int $limit = 10, int $offset = 0): array {
        [$where, $params] = $this->buildFilter($search, $status);
        $params[] = $limit; $params[] = $offset;
        return $this->query("SELECT * FROM venues $where ORDER BY id DESC LIMIT ? OFFSET ?", $params)->fetchAll();
    }

    public function countFiltered(string $search = '', string $status = ''): int {
        [$where, $params] = $this->buildFilter($search, $status);
        return (int)$this->query("SELECT COUNT(*) FROM venues $where", $params)->fetchColumn();
    }

    private function buildFilter(string $search, string $status): array {
        $cond = []; $params = [];
        if ($search !== '') { $cond[] = '(nama LIKE ? OR jenis_olahraga LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
        if ($status !== '') { $cond[] = 'status = ?'; $params[] = $status; }
        return [$cond ? 'WHERE ' . implode(' AND ', $cond) : '', $params];
    }

    public function getActive(): array {
        return $this->findAll('status = ?', ['active']);
    }

    public function getBookedSlots(int $venueId, string $tanggal): array {
        return $this->query(
            "SELECT jam_mulai, jam_selesai FROM bookings
             WHERE venue_id=? AND tanggal=? AND status NOT IN ('rejected','cancelled')",
            [$venueId, $tanggal]
        )->fetchAll();
    }

    public function isSlotAvailable(int $venueId, string $tanggal, string $jamMulai, string $jamSelesai): bool {
        $stmt = $this->query(
            "SELECT COUNT(*) FROM bookings
             WHERE venue_id=? AND tanggal=? AND status NOT IN ('rejected','cancelled')
             AND jam_mulai < ? AND jam_selesai > ?",
            [$venueId, $tanggal, $jamSelesai, $jamMulai]
        );
        return (int)$stmt->fetchColumn() === 0;
    }
}
