<?php
class Auth {
    public static function isLoggedIn(): mixed {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
    }

    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header("Location: ". Path::base() ."/login");
            exit();
        }
    }
}
