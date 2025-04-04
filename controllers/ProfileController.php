<?php 

class ProfileController extends Controller{
    private $userModel;
    private $postModel;

    public function __construct() {
        global $conn;
        $this->userModel = new User();
        $this->postModel = new Post($conn);
    }

    public function index($id){
        $followStats = $this->userModel->getFollowStats($id);
        $user = $this->userModel->getUser($id);
        $posts = $this->postModel->getProfilePostsDetails($id);
        $isFollowing = $this->userModel->isFollowing(Auth::isLoggedIn(), $id);
        $canFollow = true;
        $canEdit = false;

        if(Auth::isLoggedIn() == $id){
            $canFollow = false; // cant follow himself
            $canEdit = true; // can edit his profile
        }

        $postsCount = 0;
        foreach($posts as $post){
            $postsCount++;
        }

        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'profile';
        include './views/layout/master.php';
    }

    public function followAction($id){ 
        Auth::requireLogin();
        $userid = Auth::isLoggedIn();
        $isFollowing = $this->userModel->isFollowing($userid, $id);
        if($isFollowing == false){
            $this->userModel->followUser($userid, $id);
            $stats = $this->userModel->getFollowStats($id);
            echo json_encode(['success' => true, 'message' => 'Followed', 'stats' => $stats]);
            exit();
        } else {
            $this->userModel->unfollowUser($userid, $id);
            $stats = $this->userModel->getFollowStats($id);
            echo json_encode(['success' => true, 'message' => 'Unfollowed', 'stats' => $stats]);
            exit();
        }
    }

    public function getFollowStats($userId) {
        $stats = $this->userModel->getFollowStats($userId);
        echo json_encode($stats);
    }

    public function editprofileForm($id){
        Auth::requireLogin();
        $userinfo = $this->getUserInfo();
        $userToBeEdited = $this->getUserInfo();
        if($userToBeEdited["permission"] == 'admin'){
            $userid = $id;
            $userToBeEdited = $this->userModel->getUser($id);
        } else {
            $userid = Auth::isLoggedIn();
        }
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'editprofile';
        include './views/layout/master.php';
    }

    public function editprofile($id){
        Auth::requireLogin();
        $userid = Auth::isLoggedIn();
        $userinfo = $this->getUserInfo();

        if($userinfo["permission"] == 'admin'){
            $userid = $id;
        }

        if($userid != $id && $userinfo["permission"] != 'admin'){
            $_SESSION["error_details"] = 'Unauthorized Access';
            $_SESSION["error"] = 'You do not have permission to edit this profile.';
            header('Location: ' . Path::base());
            exit();
        }

        if (empty($_POST['name']) || empty($_POST['bio'])) {
            $_SESSION["error"] = 'Validation Error';
            $_SESSION["error_details"] = 'Name and bio cannot be empty';
            header('Location: ' . Path::base() . '/profile/' . $id);
            exit();
        }

        $params = [
            'username' => trim(htmlspecialchars($_POST['username'])),
            'name' => trim(htmlspecialchars($_POST['name'])),
            'password' => trim(htmlspecialchars($_POST['password'])),
            'bio' => trim($_POST["bio"]),
        ];

        if (isset($_FILES['postimg']) && $_FILES['postimg']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['postimg']['tmp_name'];
            $fileName = $_FILES['postimg']['name'];
            $fileSize = $_FILES['postimg']['size'];
            $fileType = $_FILES['postimg']['type'];
        
            // Check the file type (example: only allow images)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "Only image files (JPEG, PNG, GIF) are allowed.";
                header('Location: ' . Path::base() . '/editprofile/' . $id);
                exit();
            }
        
            // Check file size (example: max 5MB)
            if ($fileSize > 5 * 1024 * 1024) {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "File size exceeds the maximum allowed size (5MB).";
                header('Location: ' . Path::base() . '/editprofile/' . $id);
                exit();
            }
        
            // Define the directory to save the file
            $uploadDir = './src/assets/images/profiles/';
            $newFileName = uniqid('profile_', true) . '_' . basename($fileName);
            $uploadFilePath = $uploadDir . $newFileName;
        
            // Move the file to target directory
            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {

                if ($uploadFilePath[0] === '.') {
                    $uploadFilePath = substr($uploadFilePath, 1); // Remove leading dot
                }
                if (substr($uploadFilePath, 0, 1) !== '/') {
                    $uploadFilePath = '/' . $uploadFilePath; // Add leading slash if missing
                    var_dump($uploadFilePath);
                    exit();
                }

                $params = [
                    'username' => trim(htmlspecialchars($_POST['username'])),
                    'name' => trim(htmlspecialchars($_POST['name'])),
                    'password' => trim(htmlspecialchars($_POST['password'])),
                    'bio' => trim($_POST["bio"]),
                    'image_url' => ltrim($uploadFilePath)
                ];
                
            } else {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "There was an error uploading the file.";
                header('Location: ' . Path::base() . '/editprofile/' . $id);
                exit();
            }
        }
        $stat = $this->userModel->updateUser($userid, $params);
        if($stat != true){
            $_SESSION["error"] = 'Error';
            $_SESSION["error_details"] = 'There was a problem in editing your profile';
            header('Location: ' . Path::base() . '/editprofile/' . $id);
            exit();
        }
        $_SESSION["success"] = 'Done.';
        $_SESSION["success_details"] = 'Profile edited successfully';
        header('Location: ' . Path::base() . '/editprofile/' . $id);
        exit();
    }

    public function people($id){
        Auth::requireLogin();
        $currentUserId = Auth::isLoggedIn();

        if($currentUserId != $id){
            header('Location: ' . Path::base());
            exit();
        }

        $users = $this->userModel->getAllUsersWithFollowStats($currentUserId);
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'people';
        include './views/layout/master.php';
        
    }
}