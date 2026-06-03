<?php
require_once ROOT_PATH . '/config/security.php';
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/core/Router.php';
require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/core/Model.php';
require_once ROOT_PATH . '/app/helpers/functions.php';

class App {
    private Router $router;

    public function __construct() {
        session_start();
        $this->checkSessionTimeout();
        $this->router = new Router();
        $this->registerRoutes();
    }

    private function registerRoutes(): void {
        $r = $this->router;

        // Auth
        $r->add('GET',  'login',           'AuthController', 'loginForm');
        $r->add('POST', 'login',           'AuthController', 'login');
        $r->add('GET',  'register',        'AuthController', 'registerForm');
        $r->add('POST', 'register',        'AuthController', 'register');
        $r->add('GET',  'logout',          'AuthController', 'logout');

        // Member
        $r->add('GET',  '',                'VenueController', 'index');
        $r->add('GET',  'venues',               'VenueController', 'index');
        $r->add('GET',  'venues/{id}',          'VenueController', 'show');
        $r->add('POST', 'booking/cancel/{id}',  'BookingController', 'cancel');
        $r->add('GET',  'booking/{id}',         'BookingController', 'form');
        $r->add('POST', 'booking/{id}',         'BookingController', 'store');
        $r->add('GET',  'my-bookings',          'BookingController', 'history');
        $r->add('GET',  'payment/{id}',         'PaymentController', 'show');
        $r->add('POST', 'payment/{id}',         'PaymentController', 'upload');

        // Admin
        $r->add('GET',  'admin',               'AdminController', 'dashboard');
        $r->add('GET',  'admin/venues',        'AdminController', 'venues');
        $r->add('POST', 'admin/venues',        'AdminController', 'venueStore');
        $r->add('POST', 'admin/venues/update', 'AdminController', 'venueUpdate');
        $r->add('POST', 'admin/venues/delete', 'AdminController', 'venueDelete');
        $r->add('GET',  'admin/bookings',      'AdminController', 'bookings');
        $r->add('POST', 'admin/bookings/update','AdminController','bookingUpdate');
        $r->add('GET',  'admin/payments',      'AdminController', 'payments');
        $r->add('POST', 'admin/payments/update','AdminController','paymentUpdate');
    }

    public function run(): void {
        $url    = $_GET['url'] ?? '';
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($url, $method);
    }

    private function checkSessionTimeout(): void {
        if (isset($_SESSION['last_activity'])) {
            if (time() - $_SESSION['last_activity'] > SESSION_LIFETIME) {
                session_unset();
                session_destroy();
                session_start();
            }
        }
        $_SESSION['last_activity'] = time();
    }
}
