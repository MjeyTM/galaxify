<?php

class AdminController extends Controller
{
    private $userModel;
    private $postModel;

    public function __construct() {
        global $conn;
        $this->userModel = new User();
        $this->postModel = new Post($conn);
    }

    public function isAdmin(){
        $userinfo = $this->getUserInfo();
        if (!isset($userinfo["permission"]) || $userinfo["permission"] != 'admin') {
            header('Location: ' . Path::base());
            exit;
        }
        return true;
    }

    public function index(){
        $this->isAdmin();
        $users = $this->userModel->getAllUsers();
        $posts = $this->postModel->getAllPosts();
        $likesCount = $this->postModel->countLikes();

        $usersCount = count($users);
        $postsCount = count($posts);

        $contentType = 'dashboard';
        include './views/admin/master.php';
    }

    public function manageUsers(){
        $this->isAdmin();
        $users = $this->userModel->getAllUsers();

        $contentType = 'customers';
        include './views/admin/master.php';
    }

    public function managePosts(){
        $this->isAdmin();
        $posts = $this->postModel->getAllPosts();

        $contentType = 'posts';
        include './views/admin/master.php';
    }

    public function deleteUser($id){
        $this->isAdmin();
        if($id == Auth::isLoggedIn()){
            $_SESSION['error'] = 'نمیتونی خودتو حذف کنی خب';
            $_SESSION['error_details'] = 'خطا';
            header('Location: ' . Path::base() . '/admin/users');
            exit;
        }
        $this->userModel->deleteUser($id);
        $_SESSION['success'] = 'با موفقیت حذف شد.';
        $_SESSION['success_details'] = 'انجام شد.';
        header('Location: ' . Path::base() . '/admin/users');
        exit;
    }

    public function createUserAdvancedForm()  {
        $this->isAdmin();
        $contentType = 'create-user';
        include './views/admin/master.php';
    }

    public function createUserAdvanced(){
        $this->isAdmin();
        $name = trim($_POST['username']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $usertype = trim($_POST['usertype']);
        if($this->userModel->register($name,$username,$email,$password, $usertype)){
            $_SESSION['success'] = 'با موفقیت ثبت شد';
            $_SESSION['success_details'] = 'انجام شد.';
            header("Location: " . Path::base() . "/admin/users");
            exit();
        } else {
            $_SESSION['error'] = "مشکلی در ثبت این کاربر پیش آمد";
            $_SESSION['error_details'] = "خطا";
            header("Location: " . Path::base() . "/signup");
            exit();
        }
    }

    public function adminDeletePost($id){
        $this->isAdmin();
        if($this->postModel->adminDeletePost($id)){
            $_SESSION['success'] = 'با موفقیت حذف شد.';
            $_SESSION['success_details'] = 'انجام شد.';
            header('Location: ' . Path::base() . '/admin/posts');
            exit;
        } else {
            $_SESSION['error'] = 'هیچ پست وجود ندارد';
            $_SESSION['error_details'] = 'خطا';
            header('Location: ' . Path::base() . '/admin/posts');
            exit;
        }
    }
}
