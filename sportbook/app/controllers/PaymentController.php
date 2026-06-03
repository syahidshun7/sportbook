<?php
require_once ROOT_PATH . '/app/models/Booking.php';
require_once ROOT_PATH . '/app/models/Payment.php';

class PaymentController extends Controller {
    private Booking $booking;
    private Payment $payment;

    public function __construct() {
        $this->booking = new Booking();
        $this->payment = new Payment();
    }

    public function show(string $bookingId): void {
        $this->requireMember();
        $booking = $this->booking->findById((int)$bookingId);
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            http_response_code(403); exit('Forbidden');
        }
        $this->view('member/payment', [
            'booking' => $booking,
            'error'   => flashGet('error'),
            'success' => flashGet('success'),
        ]);
    }

    public function upload(string $bookingId): void {
        $this->requireMember();
        verifyCsrf();

        $booking = $this->booking->findById((int)$bookingId);
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            http_response_code(403); exit('Forbidden');
        }

        try {
            $path = uploadFile('bukti_transfer', 'payments');
        } catch (Exception $e) {
            flashSet('error', $e->getMessage());
            $this->redirect("payment/$bookingId");
            return;
        }

        $existing = $this->payment->getByBooking((int)$bookingId);
        if ($existing) {
            $this->payment->update($existing['id'], [
                'bukti_transfer' => $path,
                'metode'         => trim($_POST['metode'] ?? ''),
                'status'         => 'pending',
            ]);
        } else {
            $this->payment->insert([
                'booking_id'     => (int)$bookingId,
                'metode'         => trim($_POST['metode'] ?? ''),
                'bukti_transfer' => $path,
            ]);
        }

        flashSet('success', 'Bukti pembayaran berhasil diupload.');
        $this->redirect('my-bookings');
    }
}
