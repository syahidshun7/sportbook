<?php
require_once ROOT_PATH . '/app/models/Venue.php';
require_once ROOT_PATH . '/app/models/Booking.php';
require_once ROOT_PATH . '/app/models/Payment.php';
require_once ROOT_PATH . '/app/models/User.php';

class AdminController extends Controller {
    private Venue $venue;
    private Booking $booking;
    private Payment $payment;

    protected function view(string $view, array $data = []): void {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

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
        $search  = trim($_GET['search'] ?? '');
        $status  = $_GET['status'] ?? '';
        $perPage = 10;
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $offset  = ($page - 1) * $perPage;

        $venues     = $this->venue->getFiltered($search, $status, $perPage, $offset);
        $total      = $this->venue->countFiltered($search, $status);
        $totalPages = (int)ceil($total / $perPage);

        $this->view('admin/venues', [
            'venues'     => $venues,
            'search'     => $search,
            'status'     => $status,
            'page'       => $page,
            'totalPages' => max(1, $totalPages),
            'total'      => $total,
            'error'      => flashGet('error'),
            'success'    => flashGet('success'),
        ]);
    }

    public function venueStore(): void {
        $this->requireAdmin();
        verifyCsrf();
        $data = [
            'nama'           => trim($_POST['nama']),
            'jenis_olahraga' => trim($_POST['jenis_olahraga']),
            'alamat'         => trim($_POST['alamat']),
            'deskripsi'      => trim($_POST['deskripsi'] ?? ''),
            'no_telpon'      => trim($_POST['no_telpon'] ?? ''),
            'google_map'     => trim($_POST['google_map'] ?? ''),
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
            'no_telpon'      => trim($_POST['no_telpon'] ?? ''),
            'google_map'     => trim($_POST['google_map'] ?? ''),
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
        $search   = trim($_GET['search'] ?? '');
        $status   = $_GET['status'] ?? '';
        $venueId  = (int)($_GET['venue_id'] ?? 0);
        $perPage  = 10;
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $offset   = ($page - 1) * $perPage;

        $bookings   = $this->booking->getFiltered($search, $status, $venueId, $perPage, $offset);
        $total      = $this->booking->countFiltered($search, $status, $venueId);
        $totalPages = (int)ceil($total / $perPage);
        $venues     = $this->venue->findAll();

        $this->view('admin/bookings', [
            'bookings'   => $bookings,
            'venues'     => $venues,
            'search'     => $search,
            'status'     => $status,
            'venueId'    => $venueId,
            'page'       => $page,
            'totalPages' => $totalPages,
            'total'      => $total,
            'success'    => flashGet('success'),
        ]);
    }

    public function bookingUpdate(): void {
        $this->requireAdmin();
        verifyCsrf();
        $this->booking->update((int)$_POST['id'], ['status' => $_POST['status']]);
        flashSet('success', 'Status booking diperbarui.');
        $this->redirect('admin/bookings');
    }

    public function bookingDelete(): void {
        $this->requireAdmin();
        verifyCsrf();
        $this->booking->delete((int)$_POST['id']);
        flashSet('success', 'Booking berhasil dihapus.');
        $this->redirect('admin/bookings');
    }

    // --- PAYMENTS ---
    public function payments(): void {
        $this->requireAdmin();
        $search  = trim($_GET['search'] ?? '');
        $status  = $_GET['status'] ?? '';
        $perPage = 10;
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $offset  = ($page - 1) * $perPage;

        $payments   = $this->payment->getFiltered($search, $status, $perPage, $offset);
        $total      = $this->payment->countFiltered($search, $status);
        $totalPages = (int)ceil($total / $perPage);

        $this->view('admin/payments', [
            'payments'   => $payments,
            'search'     => $search,
            'status'     => $status,
            'page'       => $page,
            'totalPages' => max(1, $totalPages),
            'total'      => $total,
            'success'    => flashGet('success'),
        ]);
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
