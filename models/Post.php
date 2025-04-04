<?php
// models/Post.php
class Post {
    private $conn;
    private $table = "posts";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new post
    public function createPost($params = []): mixed {
        Auth::requireLogin();
        $userid = Auth::isLoggedIn();
        $query = "INSERT INTO " . $this->table . " (title, user_id, caption, tags, location, image_url) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissss", $params['title'], $userid, $params["caption"], $params["tags"], $params["location"], $params["image_url"]);
        return $stmt->execute();
    }

    public function addStory($params = []): mixed {
        Auth::requireLogin();
        $userid = Auth::isLoggedIn();
        $type = 'story';
        $query = "INSERT INTO " . $this->table . " (title, user_id, type, caption, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sisss", $params['caption'], $userid, $type, $params["caption"], $params["image_url"]);
        return $stmt->execute();
    }

    // Get posts with dynamic filters
    public function getPosts($type, $filters = []): mixed {
        // Start the query to select posts and join with users table
        $query = "SELECT posts.*, users.id AS userid, users.name, users.username,users.image_pic_url AS userpic  FROM " . $this->table . " LEFT JOIN users ON posts.user_id = users.id";
        
        $conditions = [];
        $params = [];
    
        // Filter by type (post or story)
        if ($type == 'post') {
            $conditions[] = "posts.type = ?";
            $params[] = $type;
        } else if ($type == 'story') {
            $conditions[] = "posts.type = ?";
            $params[] = $type;
        }
    
        // Check for title filter
        if (!empty($filters['title'])) {
            $conditions[] = "posts.title LIKE ?";
            $params[] = "%" . $filters['title'] . "%";  // Add LIKE for partial matching
        }
    
        // Check for author filter
        if (!empty($filters['author'])) {
            $conditions[] = "users.name LIKE ?";
            $params[] = "%" . $filters['author'] . "%";  // Add LIKE for partial matching
        }
    
        // Check for date filter
        if (!empty($filters['date'])) {
            $conditions[] = "posts.date = ?";
            $params[] = $filters['date'];
        }
    
        // If we have any conditions, append them to the query
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
            $query .= " ORDER BY posts.id DESC";
        }
    
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters dynamically
        if (count($params) > 0) {
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings ('s')
            $stmt->bind_param($types, ...$params);
        }
    
        // Execute the query
        $stmt->execute();
    
        // Return the result set
        return $stmt->get_result();
    }

    public function getPostStats($postid, $userId): mixed {
        // Query to get the like count and if the user has liked the post
        $query = "SELECT 
                COUNT(likes.id) AS likesCount, 
                CASE WHEN EXISTS (
                    SELECT 1 
                    FROM likes 
                    WHERE likes.post_id = posts.id AND likes.user_id = ?
                ) THEN 1 ELSE 0 END AS userLiked,
                likes.post_id
              FROM posts 
              LEFT JOIN likes ON posts.id = likes.post_id
              WHERE posts.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $postid);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateLikeStatus($postId, $userId): mixed {
        $query = "
            SELECT 
                COUNT(likes.id) AS likesCount, 
                CASE WHEN EXISTS (
                    SELECT 1 FROM likes WHERE post_id = ? AND user_id = ?
                ) THEN 1 ELSE 0 END AS userLiked
            FROM likes WHERE post_id = ?";
            
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $postId, $userId, $postId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function likePost(int $postId, int $userId): void {
        // SQL query to insert a like into the likes table
        $query = "INSERT IGNORE INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
    }

    public function unlikePost(int $postId, int $userId): void {
        // SQL query to delete the like from the likes table
        $query = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
    }

    public function getSavedPostStats($postid, $userId): mixed {
        // Query to get the saved count and if the user has saved the post
        $query = "SELECT 
                COUNT(saved.id) AS savesCount, 
                CASE WHEN EXISTS (
                    SELECT 1 
                    FROM saved 
                    WHERE saved.post_id = posts.id AND saved.user_id = ?
                ) THEN 1 ELSE 0 END AS userSaved,
                saved.post_id
              FROM posts 
              LEFT JOIN saved ON posts.id = saved.post_id
              WHERE posts.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $postid);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateSavedStatus($postId, $userId): mixed {
        $query = "
            SELECT 
                COUNT(saved.id) AS savedCount, 
                CASE WHEN EXISTS (
                    SELECT 1 FROM saved WHERE post_id = ? AND user_id = ?
                ) THEN 1 ELSE 0 END AS userSaved
            FROM saved WHERE post_id = ?";
            
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $postId, $userId, $postId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function savePost(int $postId, int $userId) {
        // SQL query to insert a like into the likes table
        $query = "INSERT IGNORE INTO saved (post_id, user_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
    }

    public function deleteSavedPost(int $postId, int $userId) {
        // SQL query to delete the like from the likes table
        $query = "DELETE FROM saved WHERE post_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
    }

    public function searchPosts($search, $filter,$userId): mixed {
        $query = "SELECT 
                    p.*, 
                    u.id AS userid, 
                    u.username, 
                    u.image_pic_url, 
                    COALESCE(l.likesCount, 0) AS likesCount, 
                    COALESCE(s.savesCount, 0) AS savesCount, 
                    EXISTS (
                        SELECT 1 
                        FROM likes 
                        WHERE post_id = p.id AND user_id = ?
                    ) AS userLiked,
                    EXISTS (
                        SELECT 1 
                        FROM saved 
                        WHERE post_id = p.id AND user_id = ?
                    ) AS userSaved
                FROM 
                    posts p 
                LEFT JOIN 
                    (SELECT post_id, COUNT(*) AS likesCount FROM likes GROUP BY post_id) l ON p.id = l.post_id 
                LEFT JOIN 
                    (SELECT post_id, COUNT(*) AS savesCount FROM saved GROUP BY post_id) s ON p.id = s.post_id
                LEFT JOIN 
                    users u ON p.user_id = u.id
                WHERE 
                    (p.title LIKE ? OR p.caption LIKE ? OR p.tags LIKE ?) AND p.type = ?

             ";

        if ($filter === 'last_day') {
            $query .= " AND p.created_at >= NOW() - INTERVAL 1 DAY";
        } elseif ($filter === 'last_week') {
            $query .= " AND p.created_at >= NOW() - INTERVAL 1 WEEK";
        } elseif ($filter === 'last_month') {
            $query .= " AND p.created_at >= NOW() - INTERVAL 1 MONTH";
        }
        $type = 'post';
        $stmt = $this->conn->prepare($query);
        $searchTerm = "%" . $search . "%";
        $stmt->bind_param("iissss", $userId, $userId, $searchTerm, $searchTerm, $searchTerm, $type);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostDetails($postId, $userId){
        $query = "SELECT 
                    p.*, 
                    u.id AS userid, 
                    u.username, 
                    u.image_pic_url, 
                    COALESCE(l.likesCount, 0) AS likesCount, 
                    COALESCE(s.savesCount, 0) AS savesCount, 
                    EXISTS (
                        SELECT 1 
                        FROM likes 
                        WHERE post_id = p.id AND user_id = ?
                    ) AS userLiked,
                    EXISTS (
                        SELECT 1 
                        FROM saved 
                        WHERE post_id = p.id AND user_id = ?
                    ) AS userSaved,
                    EXISTS (
                        SELECT 1 
                        FROM posts 
                        WHERE id = p.id AND user_id = ?
                    ) AS isCreated
                FROM 
                    posts p 
                LEFT JOIN 
                    (SELECT post_id, COUNT(*) AS likesCount FROM likes GROUP BY post_id) l ON p.id = l.post_id 
                LEFT JOIN 
                    (SELECT post_id, COUNT(*) AS savesCount FROM saved GROUP BY post_id) s ON p.id = s.post_id
                LEFT JOIN 
                    users u ON p.user_id = u.id
                WHERE 
                    p.id = ? AND p.type = ?";
        
        $type = 'post';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiiis", $userId, $userId, $userId, $postId, $type);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getProfilePostsDetails($userId){
        $query = "SELECT 
                    p.*, 
                    u.id AS userid, 
                    u.username, 
                    u.image_pic_url, 
                    COALESCE(l.likesCount, 0) AS likesCount, 
                    COALESCE(s.savesCount, 0) AS savesCount, 
                    EXISTS (
                        SELECT 1 
                        FROM likes 
                        WHERE post_id = p.id AND user_id = ?
                    ) AS userLiked,
                    EXISTS (
                        SELECT 1 
                        FROM saved 
                        WHERE post_id = p.id AND user_id = ?
                    ) AS userSaved,
                    EXISTS (
                        SELECT 1 
                        FROM posts 
                        WHERE id = p.id AND user_id = ?
                    ) AS isCreated
                FROM 
                    posts p 
                LEFT JOIN 
                    (SELECT post_id, COUNT(*) AS likesCount FROM likes GROUP BY post_id) l ON p.id = l.post_id 
                LEFT JOIN 
                    (SELECT post_id, COUNT(*) AS savesCount FROM saved GROUP BY post_id) s ON p.id = s.post_id
                LEFT JOIN 
                    users u ON p.user_id = u.id
                WHERE 
                    p.user_id = ? AND p.type = ?";
        
        $type = 'post';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiiis", $userId, $userId, $userId, $userId, $type);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function editPost($params, $postId): mixed {
        $datetime = date("Y-m-d H:i:s");
    
        $query = "SELECT image_url FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $oldImagePath = '';
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . Path::base() . $row['image_url'];
        }

        if (isset($params["image_url"]) && !empty($params["image_url"]) && file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        if (isset($params["image_url"]) && !empty($params["image_url"])) {
            $query = "UPDATE posts SET title = ?, caption = ?, tags = ?, location = ?, image_url = ?, updated_at = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssssssi", 
                $params['title'], 
                $params['caption'], 
                $params['tags'], 
                $params['location'], 
                $params['image_url'], 
                $datetime, 
                $postId
            );
        } else {
            $query = "UPDATE posts SET title = ?, caption = ?, tags = ?, location = ?, updated_at = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssi", 
                $params['title'], 
                $params['caption'], 
                $params['tags'], 
                $params['location'], 
                $datetime, 
                $postId
            );
        }
    
        return $stmt->execute();
    }

    public function deletePost($postId, $userId) {
        $query = "SELECT image_url FROM posts WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . Path::base() . $row['image_url'];
    
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Delete the file
            }
    
            $deleteQuery = "DELETE FROM posts WHERE id = ? AND user_id = ?";
            $deleteStmt = $this->conn->prepare($deleteQuery);
            $deleteStmt->bind_param("ii", $postId, $userId);
            
            return $deleteStmt->execute();
        } 
        // Post not found or unauthorized
        return false;
    }
    
    public function getSavedPosts($userId) {
        $query = "SELECT p.*,s.created_at AS saved_at 
                  FROM saved s
                  JOIN posts p ON s.post_id = p.id 
                  WHERE s.user_id = ? 
                  ORDER BY s.id DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countLikes(){
        $query = "SELECT COUNT(*) as likes FROM likes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['likes'];
    }

    public function getAllPosts(){
        $query = "SELECT posts.*, users.id AS userid, users.name, users.username,users.image_pic_url AS userpic  FROM " . $this->table . " LEFT JOIN users ON posts.user_id = users.id WHERE posts.type = 'post' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function adminDeletePost($postid){
        $query = "DELETE FROM posts WHERE id = ? AND type = 'post'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $postid);
        return $stmt->execute();
    }
}