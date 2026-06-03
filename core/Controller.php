<?php
class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    protected function redirect(string $path): void {
        header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
        exit;
    }

    protected function requireAuth(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }
    }

    protected function requireAdmin(): void {
        $this->requireAuth();
        if ($_SESSION['role'] !== 'admin') {
            http_response_code(403);
            exit('403 Forbidden');
        }
    }

    protected function requireMember(): void {
        $this->requireAuth();
        if ($_SESSION['role'] !== 'member') {
            $this->redirect('admin');
        }
    }
}
