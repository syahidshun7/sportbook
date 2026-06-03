<?php
require_once ROOT_PATH . '/app/models/User.php';

class AuthController extends Controller {
    private User $user;

    public function __construct() {
        $this->user = new User();
    }

    public function loginForm(): void {
        if (isLoggedIn()) $this->redirect(isAdmin() ? 'admin' : 'venues');
        $this->view('auth/login', ['error' => flashGet('error'), 'success' => flashGet('success')]);
    }

    public function login(): void {
        verifyCsrf();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($this->user->isRateLimited($email, $ip)) {
            flashSet('error', 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.');
            $this->redirect('login');
        }

        $u = $this->user->findByEmail($email);

        if (!$u || !password_verify($password, $u['password'])) {
            $this->user->logAttempt($email, $ip);
            flashSet('error', 'Email atau password salah.');
            $this->redirect('login');
        }

        if ($u['status'] === 'banned') {
            flashSet('error', 'Akun Anda telah dinonaktifkan.');
            $this->redirect('login');
        }

        $this->user->clearAttempts($email, $ip);
        session_regenerate_id(true);
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['nama']    = $u['nama'];
        $_SESSION['role']    = $u['role'];

        // Remember me
        if (!empty($_POST['remember'])) {
            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
            $this->user->saveRememberToken($u['id'], $token, $expires);
            setcookie('remember_token', $token, strtotime('+30 days'), '/', '', false, true);
        }

        $this->redirect($u['role'] === 'admin' ? 'admin' : 'venues');
    }

    public function registerForm(): void {
        if (isLoggedIn()) $this->redirect('venues');
        $this->view('auth/register', ['error' => flashGet('error')]);
    }

    public function register(): void {
        verifyCsrf();
        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if (!$nama || !$email || !$password) {
            flashSet('error', 'Semua field wajib diisi.');
            $this->redirect('register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flashSet('error', 'Format email tidak valid.');
            $this->redirect('register');
        }

        if (strlen($password) < 8) {
            flashSet('error', 'Password minimal 8 karakter.');
            $this->redirect('register');
        }

        if ($password !== $confirm) {
            flashSet('error', 'Konfirmasi password tidak cocok.');
            $this->redirect('register');
        }

        if ($this->user->findByEmail($email)) {
            flashSet('error', 'Email sudah terdaftar.');
            $this->redirect('register');
        }

        $this->user->insert([
            'nama'     => $nama,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role'     => 'member',
        ]);

        flashSet('success', 'Registrasi berhasil! Silakan login.');
        $this->redirect('login');
    }

    public function logout(): void {
        if (isset($_SESSION['user_id'])) {
            $this->user->deleteRememberToken($_SESSION['user_id']);
        }
        setcookie('remember_token', '', time() - 3600, '/');
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
