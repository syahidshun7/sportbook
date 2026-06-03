<?php
require_once ROOT_PATH . '/core/Model.php';

class User extends Model {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        return $this->findOne('email = ?', [$email]);
    }

    public function isRateLimited(string $email, string $ip): bool {
        $cutoff = date('Y-m-d H:i:s', time() - LOGIN_LOCKOUT_TIME);
        $stmt = $this->query(
            "SELECT COUNT(*) FROM login_attempts WHERE (email=? OR ip_address=?) AND attempted_at > ?",
            [$email, $ip, $cutoff]
        );
        return (int)$stmt->fetchColumn() >= MAX_LOGIN_ATTEMPTS;
    }

    public function logAttempt(string $email, string $ip): void {
        $this->query("INSERT INTO login_attempts (email, ip_address) VALUES (?,?)", [$email, $ip]);
    }

    public function clearAttempts(string $email, string $ip): void {
        $this->query("DELETE FROM login_attempts WHERE email=? OR ip_address=?", [$email, $ip]);
    }

    public function saveRememberToken(int $userId, string $token, string $expires): void {
        $this->query("DELETE FROM remember_tokens WHERE user_id=?", [$userId]);
        $this->query("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?,?,?)",
            [$userId, hash('sha256', $token), $expires]);
    }

    public function findByRememberToken(string $token): ?array {
        $hashed = hash('sha256', $token);
        $stmt = $this->query(
            "SELECT u.* FROM users u JOIN remember_tokens rt ON u.id=rt.user_id
             WHERE rt.token=? AND rt.expires_at > NOW() LIMIT 1",
            [$hashed]
        );
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function deleteRememberToken(int $userId): void {
        $this->query("DELETE FROM remember_tokens WHERE user_id=?", [$userId]);
    }
}
