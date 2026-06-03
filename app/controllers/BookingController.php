<?php
require_once ROOT_PATH . '/app/models/Venue.php';
require_once ROOT_PATH . '/app/models/Booking.php';

class BookingController extends Controller {
    private Venue $venue;
    private Booking $booking;

    public function __construct() {
        $this->venue   = new Venue();
        $this->booking = new Booking();
    }

    public function form(string $venueId): void {
        $this->requireMember();
        $venue = $this->venue->findById((int)$venueId);
        if (!$venue) { http_response_code(404); exit('Venue tidak ditemukan'); }
        $this->view('member/booking', ['venue' => $venue, 'error' => flashGet('error')]);
    }

    public function store(string $venueId): void {
        $this->requireMember();
        verifyCsrf();

        $venue     = $this->venue->findById((int)$venueId);
        $tanggal   = $_POST['tanggal'] ?? '';
        $jamMulai  = $_POST['jam_mulai'] ?? '';
        $jamSelesai = $_POST['jam_selesai'] ?? '';

        if (!$venue || !$tanggal || !$jamMulai || !$jamSelesai) {
            flashSet('error', 'Semua field wajib diisi.');
            $this->redirect("booking/$venueId");
        }

        if ($tanggal < date('Y-m-d')) {
            flashSet('error', 'Tanggal tidak boleh di masa lalu.');
            $this->redirect("booking/$venueId");
        }

        if ($jamMulai >= $jamSelesai) {
            flashSet('error', 'Jam selesai harus lebih besar dari jam mulai.');
            $this->redirect("booking/$venueId");
        }

        if (!$this->venue->isSlotAvailable((int)$venueId, $tanggal, $jamMulai, $jamSelesai)) {
            flashSet('error', 'Slot waktu sudah terpesan.');
            $this->redirect("booking/$venueId");
        }

        // Hitung total harga
        $start  = strtotime($jamMulai);
        $end    = strtotime($jamSelesai);
        $hours  = ($end - $start) / 3600;
        $total  = $hours * $venue['harga_per_jam'];

        $bookingId = $this->booking->insert([
            'user_id'    => $_SESSION['user_id'],
            'venue_id'   => (int)$venueId,
            'tanggal'    => $tanggal,
            'jam_mulai'  => $jamMulai,
            'jam_selesai'=> $jamSelesai,
            'total_harga'=> $total,
            'catatan'    => trim($_POST['catatan'] ?? ''),
        ]);

        flashSet('success', 'Booking berhasil! Silakan upload bukti pembayaran.');
        $this->redirect("payment/$bookingId");
    }

    public function history(): void {
        $this->requireMember();
        $bookings = $this->booking->getByUser($_SESSION['user_id']);
        $this->view('member/history', ['bookings' => $bookings]);
    }

    public function cancel(string $id): void {
        $this->requireMember();
        verifyCsrf();
        $booking = $this->booking->findById((int)$id);
        if ($booking && $booking['user_id'] == $_SESSION['user_id'] && $booking['status'] === 'pending') {
            $this->booking->update((int)$id, ['status' => 'cancelled']);
        }
        $this->redirect('my-bookings');
    }
}
