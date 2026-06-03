<?php
require_once ROOT_PATH . '/core/Model.php';

class Venue extends Model {
    protected string $table = 'venues';

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
