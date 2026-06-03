<?php
require_once ROOT_PATH . '/app/models/Venue.php';

class VenueController extends Controller {
    private Venue $venue;

    public function __construct() {
        $this->venue = new Venue();
    }

    public function index(): void {
        $venues = $this->venue->getActive();
        $this->view('member/venues', ['venues' => $venues]);
    }

    public function show(string $id): void {
        $this->requireMember();
        $venue = $this->venue->findById((int)$id);
        if (!$venue) { http_response_code(404); exit('Venue tidak ditemukan'); }

        $bookedSlots = $this->venue->getBookedSlots((int)$id, date('Y-m-d'));
        $this->view('member/venue_detail', ['venue' => $venue, 'bookedSlots' => $bookedSlots]);
    }
}
