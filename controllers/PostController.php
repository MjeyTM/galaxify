<?php
// controllers/PostController.php
require_once './models/Post.php';
class PostController extends Controller {
    private $model;

    public function __construct() {
        global $conn; // Use the global database connection
        $this->model = new Post($conn);
    }

    // Show all posts with filters
    public function getPosts($type = 'post'): array {
        Auth::requireLogin();
        //include './views/dashboard.php';
        $filters = [
            'title' => isset($_GET['title']) ? $_GET['title'] : '',
            'type' => isset($_GET['type']) ? $_GET['type'] : '',
            'caption' => isset($_GET['date']) ? $_GET['date'] : ''
        ];
        $result = $this->model->getPosts($type,$filters);
        $posts = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
        }
        return $posts;
    }

    // Show the create post form
    public function createForm() {
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'create-post';
        include './views/layout/master.php';
    }

    // Create a new post
    public function createPost() {
        Auth::requireLogin();
        // Handle the uploaded file
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
                header("Location: ".Path::base()."/create-post");
                exit();
            }
        
            // Check file size (example: max 5MB)
            if ($fileSize > 5 * 1024 * 1024) {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "File size exceeds the maximum allowed size (5MB).";
                header("Location: ".Path::base()."/create-post");
                exit();
            }

            // Define the directory to save the file
            $uploadDir = './src/assets/images/posts/';
            $newFileName = uniqid('post_', true) . '_' . basename($fileName);
            $uploadFilePath = $uploadDir . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                // File has been uploaded successfully, now save the path
                if ($uploadFilePath[0] === '.') {
                    $uploadFilePath = substr($uploadFilePath, 1);
                }
                $params = [
                    'title' => htmlspecialchars($_POST['title']),
                    'caption' => htmlspecialchars($_POST['caption']),
                    'location' => trim($_POST["location"]),
                    'tags' => trim($_POST["tags"]),
                    'image_url' => ltrim($uploadFilePath) // Save the file path in the database
                ];

                // Call the model to create the post
                if ($this->model->createPost($params)) {
                    $_SESSION["success_details"] = "Done!";
                    $_SESSION["success"] = "Post created successfully!";
                    header("Location: ".Path::base()."");
                } else {
                    $_SESSION["error_details"] = "Error occured!";
                    $_SESSION["error"] = "Error creating post.";
                    header("Location: ".Path::base()."/create-post");
                }
            } else {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "There was an error uploading the file.";
                header("Location: ".Path::base()."/create-post");
            }
        } else {
            $_SESSION["error_details"] = "Error occured!";
            $_SESSION["error"] = "No file uploaded or there was an error uploading.";
            header("Location: ".Path::base()."/create-post");
        }
    }

    
    public function getPostStats($id): mixed {  
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $postStats = $this->model->getPostStats($id, $userId);
        return $postStats;
    }

    public function likePost($id) {
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $this->model->likePost($id, $userId);
        $this->returnLikeStatus($id, $userId);
    }
    
    public function unlikePost($id) {
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $this->model->unlikePost($id, $userId);
        $this->returnLikeStatus($id, $userId);
    }
    
    private function returnLikeStatus($postId, $userId) {
        $postStats = $this->model->updateLikeStatus($postId, $userId);
        echo json_encode([
            'success' => true,
            'likesCount' => $postStats['likesCount'],
            'userLiked' => $postStats['userLiked']
        ]);
    }

    //post
    public function getSavedPostStats($id): mixed {  
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $postSavedStats = $this->model->getSavedPostStats($id, $userId);
        return $postSavedStats;
    }
    public function savePost($id): void {
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $this->model->savePost($id,$userId);
        $this->retrunPostStatus($id, $userId);
    }

    public function deleteSavedPost($id): void{
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $this->model->deleteSavedPost($id,$userId);
        $this->retrunPostStatus($id, $userId);
    }

    public function retrunPostStatus($postId,$userId){
        $postStats = $this->model->updateSavedStatus($postId, $userId);
        echo json_encode([
            'success' => true,
            'savesCount' => $postStats['savedCount'],
            'userSaved' => $postStats['userSaved']
        ]);
    }

    public function explore(){
        $userId = Auth::isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $search = trim($_POST['search'] ?? '');
            $filter = $_POST['filter'] ?? '';

            $posts = $this->model->searchPosts($search, $filter, $userId);
            echo json_encode($posts);
            exit();
        }
        $posts = $this->model->searchPosts('', '', $userId);
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'explore';
        include './views/layout/master.php';
    }

    public function showPostDetails($id){
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $result = $this->model->getPostDetails($id, $userId);
        $post = [];
        foreach($result as $post1){
            $post = $post1;
        }
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'details';
        include './views/layout/master.php';
    }

    public function editPostForm($id){
        Auth::requireLogin();
        $userId = Auth::isLoggedIn();
        $result = $this->model->getPostDetails($id,$userId);
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $postdetail = [];
        $isCreated = false;
        
        foreach($result as $post){
            $isCreated = ($post["isCreated"] === 1) ? true : false;
            $postdetail = $post;
        }
        
        if($userinfo["permission"] == 'admin'){
            $isCreated = true;
        }

        if($isCreated){
            $contentType = 'editPost';
            include './views/layout/master.php';
        } else {
            $contentType = 'post';
            header("Location: ".Path::base()."");
            exit();
        }
    }

    public function editPost($id){
        Auth::requireLogin();
        $file = false;
        // if new file uploaded
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
                header('Location: ' . Path::base() . '/edit-post/' . $id);
                exit();
            }
        
            // Check file size (example: max 5MB)
            if ($fileSize > 5 * 1024 * 1024) {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "File size exceeds the maximum allowed size (5MB).";
                header('Location: ' . Path::base() . '/edit-post/' . $id);
                exit();
            }
        
            // Define the directory to save the file
            $uploadDir = './src/assets/images/posts/';
            $newFileName = uniqid('post_', true) . '_' . basename($fileName);
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
                
                $file = true; 
            } else {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "There was an error uploading the file.";
                header('Location: ' . Path::base() . '/edit-post/' . $id);
                exit();
            }
        }

        $params = [
            'title' => htmlspecialchars($_POST['title']),
            'caption' => htmlspecialchars($_POST['caption']),
            'location' => trim($_POST["location"]),
            'tags' => trim($_POST["tags"]),
        ];
        
        if ($file) {
            $params['image_url'] = $uploadFilePath;
        }
        
        if ($this->model->editPost($params, $id)) {
            $_SESSION["success_details"] = "Done!";
            $_SESSION["success"] = "Post updated successfully!";
            header('Location: ' . Path::base() . '/posts/' . $id);
            exit();
        } else {
            $_SESSION["error_details"] = "Error occured!";
            $_SESSION["error"] = "Error updating post.";
            header('Location: ' . Path::base() . '/edit-post/' . $id);
            exit();
        }
    }

    public function deletePost($id){
        Auth::requireLogin();
        $userid = Auth::isLoggedIn();
        if ($this->model->deletePost($id, $userid)) {
            $_SESSION["success_details"] = "Done!";
            $_SESSION["success"] = "Post deleted successfully!";
            header('Location: ' . Path::base());
            exit();
        } else {
            $_SESSION["error_details"] = "Error occured!";
            $_SESSION["error"] = "Error deleting post.";
            header('Location: ' . Path::base());
            exit();
        }
    }

    public function getSavedPosts(){
        Auth::requireLogin();
        $userid = Auth::isLoggedIn();
        $savedPosts = $this->model->getSavedPosts($userid);
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'saves';
        include './views/layout/master.php';
    }

    public function showProfile($id){
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'profile';
        include './views/layout/master.php';
    }

    public function addStory($id) {
        Auth::requireLogin();
        $userid = Auth::isLoggedIn();

        // check whether this is the user that created this account or not
        if($userid != $id){
            $_SESSION["error"] = "You can't add a story to this user's profile.";
            header('Location: ' . Path::base() . '/profile/' . $id);
            exit();
        }

        // Handle the uploaded file
        if (isset($_FILES['postimg']) && $_FILES['postimg']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['postimg']['tmp_name'];
            $fileName = $_FILES['postimg']['name'];
            $fileSize = $_FILES['postimg']['size'];
            $fileType = $_FILES['postimg']['type'];

            // Check the file type (example: only allow images)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION["error"] = "Only image files (JPEG, PNG, GIF) are allowed.";
                header("Location: ".Path::base()."/add-story");
                exit();
            }
        
            // Check file size (example: max 5MB)
            if ($fileSize > 5 * 1024 * 1024) {
                $_SESSION["error"] = "File size exceeds the maximum allowed size (5MB).";
                header("Location: ".Path::base()."/add-story");
                exit();
            }

            // Define the directory to save the file
            $uploadDir = './src/assets/images/posts/';
            $newFileName = uniqid('post_', true) . '_' . basename($fileName);
            $uploadFilePath = $uploadDir . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                // File has been uploaded successfully, now save the path
                if ($uploadFilePath[0] === '.') {
                    $uploadFilePath = substr($uploadFilePath, 1);
                }
                $params = [
                    'caption' => htmlspecialchars($_POST['caption']),
                    'image_url' => ltrim($uploadFilePath) // Save the file path in the database
                ];

                // Call the model to add the post
                if ($this->model->addStory($params)) {
                    $_SESSION["success_details"] = "Done!";
                    $_SESSION["success"] = "Story added successfully!";
                    header("Location: ".Path::base()."");
                } else {
                    $_SESSION["error_details"] = "Error occured!";
                    $_SESSION["error"] = "Error Adding Story.";
                    header("Location: ".Path::base()."/add-story");
                }
            } else {
                $_SESSION["error_details"] = "Error occured!";
                $_SESSION["error"] = "There was an error uploading the file.";
                header("Location: ".Path::base()."/add-story");
            }
        } else {
            $_SESSION["error_details"] = "Error occured!";
            $_SESSION["error"] = "No file uploaded or there was an error uploading.";
            header("Location: ".Path::base()."/add-story");
        }
    }

    public function createStoryForm() {
        $userinfo = $this->getUserInfo();
        $content = $this->loadView('leftsidebar.php');
        $contentType = 'add-story';
        include './views/layout/master.php';
    }
    // Default method for home page
    public function index() {
        include './views/index.php';
    }
}