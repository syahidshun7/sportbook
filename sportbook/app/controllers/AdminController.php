<?php
require_once ROOT_PATH . '/app/models/Venue.php';
require_once ROOT_PATH . '/app/models/Booking.php';
require_once ROOT_PATH . '/app/models/Payment.php';
require_once ROOT_PATH . '/app/models/User.php';

class AdminController extends Controller {
    private Venue $venue;
    private Booking $booking;
    private Payment $payment;

    public function __construct() {
        $this->venue   = new Venue();
        $this->booking = new Booking();
        $this->payment = new Payment();
    }

    public function dashboard(): void {
        $this->requireAdmin();
        $db = getDB();
        $stats = [
            'total_venues'   => $db->query("SELECT COUNT(*) FROM venues")->fetchColumn(),
            'total_bookings' => $db->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
            'pending_payments' => $db->query("SELECT COUNT(*) FROM payments WHERE status='pending'")->fetchColumn(),
            'total_revenue'  => $db->query("SELECT SUM(total_harga) FROM bookings WHERE status='confirmed'")->fetchColumn() ?? 0,
        ];
        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    // --- VENUES ---
    public function venues(): void {
        $this->requireAdmin();
        $venues = $this->venue->findAll();
        $this->view('admin/venues', ['venues' => $venues, 'error' => flashGet('error'), 'success' => flashGet('success')]);
    }

    public function venueStore(): void {
        $this->requireAdmin();
        verifyCsrf();
        $data = [
            'nama'           => trim($_POST['nama']),
            'jenis_olahraga' => trim($_POST['jenis_olahraga']),
            'alamat'         => trim($_POST['alamat']),
            'deskripsi'      => trim($_POST['deskripsi'] ?? ''),
            'harga_per_jam'  => (float)$_POST['harga_per_jam'],
            'status'         => 'active',
        ];
        if (!empty($_FILES['foto']['name'])) {
            try { $data['foto'] = uploadFile('foto', 'venues'); }
            catch (Exception $e) { flashSet('error', $e->getMessage()); $this->redirect('admin/venues'); }
        }
        $this->venue->insert($data);
        flashSet('success', 'Venue berhasil ditambahkan.');
        $this->redirect('admin/venues');
    }

    public function venueUpdate(): void {
        $this->requireAdmin();
        verifyCsrf();
        $id   = (int)$_POST['id'];
        $data = [
            'nama'           => trim($_POST['nama']),
            'jenis_olahraga' => trim($_POST['jenis_olahraga']),
            'alamat'         => trim($_POST['alamat']),
            'deskripsi'      => trim($_POST['deskripsi'] ?? ''),
            'harga_per_jam'  => (float)$_POST['harga_per_jam'],
            'status'         => $_POST['status'],
        ];
        if (!empty($_FILES['foto']['name'])) {
            try { $data['foto'] = uploadFile('foto', 'venues'); }
            catch (Exception $e) { flashSet('error', $e->getMessage()); $this->redirect('admin/venues'); }
        }
        $this->venue->update($id, $data);
        flashSet('success', 'Venue berhasil diupdate.');
        $this->redirect('admin/venues');
    }

    public function venueDelete(): void {
        $this->requireAdmin();
        verifyCsrf();
        $this->venue->delete((int)$_POST['id']);
        flashSet('success', 'Venue berhasil dihapus.');
        $this->redirect('admin/venues');
    }

    // --- BOOKINGS ---
    public function bookings(): void {
        $this->requireAdmin();
        $bookings = $this->booking->getAllWithDetails();
        $this->view('admin/bookings', ['bookings' => $bookings, 'success' => flashGet('success')]);
    }

    public function bookingUpdate(): void {
        $this->requireAdmin();
        verifyCsrf();
        $this->booking->update((int)$_POST['id'], ['status' => $_POST['status']]);
        flashSet('success', 'Status booking diperbarui.');
        $this->redirect('admin/bookings');
    }

    // --- PAYMENTS ---
    public function payments(): void {
        $this->requireAdmin();
        $payments = $this->payment->getAll();
        $this->view('admin/payments', ['payments' => $payments, 'success' => flashGet('success')]);
    }

    public function paymentUpdate(): void {
        $this->requireAdmin();
        verifyCsrf();
        $id     = (int)$_POST['id'];
        $status = $_POST['status'];
        $this->payment->update($id, ['status' => $status]);
        // Sync booking status
        $payment = $this->payment->findById($id);
        if ($payment) {
            $bookingStatus = $status === 'verified' ? 'confirmed' : ($status === 'rejected' ? 'rejected' : 'pending');
            $this->booking->update($payment['booking_id'], ['status' => $bookingStatus]);
        }
        flashSet('success', 'Status pembayaran diperbarui.');
        $this->redirect('admin/payments');
    }
}
