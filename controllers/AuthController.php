<?php
require_once './models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Sign-up
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if ($this->userModel->register($name, $username, $email, $password)) {
                header("Location: " . Path::base() . "/login");
                exit();
            } else {
                $_SESSION['error'] = "There was a problem to in Signing you up.";
                header("Location: " . Path::base() . "/signup");
                exit();
            }
        } else {
            include './views/signup.php';
        }
    }

    // login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
    
            $user = $this->userModel->authenticate($email, $password);
    
            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['firstLogin'] = true; 
                if($user['permission'] == 'admin'){
                    header("Location: " . Path::base() . "/admin");
                    exit;
                }
                header("Location: " . Path::base());
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: ". Path::base() ."/login");
                exit();

            }
        } else {
            include './views/login.php';
        }
    }

    // Logout
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: " . Path::base() . "/login");
    }

    // signup form
    public function showSignup(){
        if(Auth::isLoggedIn()){
            header("Location: " . Path::base());
            exit();
        } else {
            include './views/signup.php';  // if not logged in
        }
    }
    
    // Signin form
    public function showLogin(){
        if(Auth::isLoggedIn()){
            header("Location: " . Path::base());
            exit();
        } else {
            include './views/login.php';  // if not logged in
        }
    }

    //get current logged in user
    public function getCurrentUser($userid): mixed{
        if (Auth::isLoggedIn()) {
            $user = $this->userModel->getUser($userid);
            if ($user) {
                return $user;
            }
            return false; // In case the user doesn't exist
        } else {
            return false; // If not logged in
        }
    }
}
