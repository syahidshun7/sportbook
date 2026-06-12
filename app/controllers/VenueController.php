<?php
require_once ROOT_PATH . '/app/models/Venue.php';

class VenueController extends Controller {
    private Venue $venue;

    public function __construct() {
        $this->venue = new Venue();
    }

    public function index(): void {
        $search = trim($_GET['search'] ?? '');
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 5;
        $offset = ($page - 1) * $limit;

        $venues = $this->venue->getFiltered($search, 'active', $limit, $offset);
        $total  = $this->venue->countFiltered($search, 'active');
        $pages  = (int)ceil($total / $limit);

        $this->view('member/venues', compact('venues', 'search', 'page', 'pages'));
    }

    public function show(string $id): void {
        $this->requireMember();
        $venue = $this->venue->findById((int)$id);
        if (!$venue) { http_response_code(404); exit('Venue tidak ditemukan'); }

        $bookedSlots = $this->venue->getBookedSlots((int)$id, date('Y-m-d'));
        $this->view('member/venue_detail', ['venue' => $venue, 'bookedSlots' => $bookedSlots]);
    }
}
