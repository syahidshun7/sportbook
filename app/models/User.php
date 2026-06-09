<?php
require_once ROOT_PATH . '/core/Model.php';

class User extends Model {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        return $this->findOne('email = ?', [$email]);
    }

    public function isRateLimited(string $email, string $ip): bool {
        return $this->getLockoutDetails($ip, $email) !== null;
    }

    public function getLockoutDetails(string $ip, string $email = ''): ?array {
        $cutoff = date('Y-m-d H:i:s', time() - LOGIN_LOCKOUT_TIME);
        
        // 1. If email is provided, check if that specific email is rate limited
        if (!empty($email)) {
            $stmt = $this->query(
                "SELECT TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD(attempted_at, INTERVAL ? SECOND)) AS remaining_seconds 
                 FROM login_attempts 
                 WHERE email = ? AND attempted_at > ? 
                 ORDER BY attempted_at DESC LIMIT ?, 1",
                [LOGIN_LOCKOUT_TIME, $email, $cutoff, MAX_LOGIN_ATTEMPTS - 1]
            );
            $row = $stmt->fetch();
            if ($row && $row['remaining_seconds'] > 0) {
                return [
                    'remaining' => (int)$row['remaining_seconds'],
                    'total' => LOGIN_LOCKOUT_TIME,
                    'reason' => 'email',
                    'target' => $email
                ];
            }
        }

        // 2. Check if the IP itself is rate limited
        $stmt = $this->query(
            "SELECT TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD(attempted_at, INTERVAL ? SECOND)) AS remaining_seconds 
             FROM login_attempts 
             WHERE ip_address = ? AND attempted_at > ? 
             ORDER BY attempted_at DESC LIMIT ?, 1",
            [LOGIN_LOCKOUT_TIME, $ip, $cutoff, MAX_LOGIN_ATTEMPTS - 1]
        );
        $row = $stmt->fetch();
        if ($row && $row['remaining_seconds'] > 0) {
            return [
                'remaining' => (int)$row['remaining_seconds'],
                'total' => LOGIN_LOCKOUT_TIME,
                'reason' => 'ip',
                'target' => $ip
            ];
        }

        // 3. Check if the most recent attempted email from this IP is rate limited
        $stmt = $this->query(
            "SELECT email FROM login_attempts 
             WHERE ip_address = ? AND attempted_at > ? 
             ORDER BY attempted_at DESC LIMIT 1",
            [$ip, $cutoff]
        );
        $lastAttempt = $stmt->fetch();
        if ($lastAttempt && !empty($lastAttempt['email']) && $lastAttempt['email'] !== $email) {
            $lastEmail = $lastAttempt['email'];
            $stmt = $this->query(
                "SELECT TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD(attempted_at, INTERVAL ? SECOND)) AS remaining_seconds 
                 FROM login_attempts 
                 WHERE email = ? AND attempted_at > ? 
                 ORDER BY attempted_at DESC LIMIT ?, 1",
                [LOGIN_LOCKOUT_TIME, $lastEmail, $cutoff, MAX_LOGIN_ATTEMPTS - 1]
            );
            $row = $stmt->fetch();
            if ($row && $row['remaining_seconds'] > 0) {
                return [
                    'remaining' => (int)$row['remaining_seconds'],
                    'total' => LOGIN_LOCKOUT_TIME,
                    'reason' => 'email',
                    'target' => $lastEmail
                ];
            }
        }

        return null;
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
