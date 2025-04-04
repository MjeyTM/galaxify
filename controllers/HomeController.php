<?php

class HomeController extends Controller{
    public function index() {
        Auth::requireLogin();
        $postController = new PostController();
        $posts = $postController->getPosts('post');
        $details = [];
        $savedPostStats = [];
        foreach ($posts as $post) {
            $postId = $post['id'];
            $details[$postId] = $postController->getPostStats($postId);
            $savedPostStats[$postId] = $postController->getSavedPostStats($postId);
        }

        // Get user info
        $userinfo = $this->getUserInfo();

        $contentType = 'posts';
        $content = $this->loadView('leftsidebar.php');
        include './views/layout/master.php';
    }
}