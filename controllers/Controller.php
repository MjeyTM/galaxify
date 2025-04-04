<?php

class Controller {
    // Method to load views with data : wont work IDK
    public function view($view, $data = []): void {
        if (!empty($data)) {
            extract($data); // Convert the data array into variables
        }

        include "./views/{$view}.php";
    }

    protected function getUserInfo() {
        // Ensure the user is logged in
        Auth::requireLogin();  
        $userid = Auth::isLoggedIn();

        if ($userid) {
            $authController = new AuthController();
            return $authController->getCurrentUser($userid);  
        }

        return ['error' => 'User not found'];  // If user is not found
    }

    // Helper function to load a specific view
    protected function loadView($viewFile) {
        ob_start();
        include '../views/' . $viewFile;
        return ob_get_clean();
    }
}