<?php
require_once './models/initialize_db.php';

class User {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Register a new user
    public function register($name , $username, $email, $password, $type = 'user'): bool {
        // Check if user already exists
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            // User already exists
            return false;
        }
        $pfp = "/src/assets/images/profiles/placeholder.png";
        // Insert new user
        $stmt = $this->conn->prepare("INSERT INTO users (name ,username, email, password, image_pic_url, permission) 
        VALUES (?,?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name ,$username, $email, $password, $pfp, $type);
    
        return $stmt->execute();
    }

    // Authenticate a user
    public function authenticate($email, $password): array|bool {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && password_verify($password, $result['password'])) {
            return $result;
        }
        return false;
    }

    public function getUser($userid): array|bool|null{
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        if (!$stmt) {
            die('Query prepare failed: ' . $this->conn->error);
        }
        $stmt->bind_param("i", $userid);
        if (!$stmt->execute()) {
            die('Query execution failed: ' . $stmt->error);
        }
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function followUser($followerId,$followedId): void {
        $query = "INSERT INTO follows (follower_id, followed_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $followerId, $followedId);
        $stmt->execute();
    }

    public function unfollowUser($followerId,$followedId,): void {
        $query = "DELETE FROM follows WHERE follower_id = ? AND followed_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $followerId, $followedId);
        $stmt->execute();
    }

    public function isFollowing($followerId, $followedId): bool {
        $query = "SELECT 1 FROM follows WHERE follower_id = ? AND followed_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $followerId, $followedId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getFollowStats($userId): array|bool|null {
        $query = "SELECT 
                    (SELECT COUNT(*) FROM follows WHERE followed_id = ?) AS followersCount,
                    (SELECT COUNT(*) FROM follows WHERE follower_id = ?) AS followingCount";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateUser($userid, $params): bool {
        $query = "UPDATE users SET name = ?, username = ?, bio = ?";
        $types = "sss";
        $values = [$params['name'], $params['username'], $params['bio']];
    
        // Append password if provided
        if (!empty($params['password'])) {
            $password = password_hash($params['password'], PASSWORD_DEFAULT);
            $query .= ", password = ?";
            $types .= "s";
            $values[] = $password;
        }
    
        // Append image URL if provided
        if (!empty($params["image_url"])) {
            $query .= ", image_pic_url = ?";
            $types .= "s";
            $values[] = $params["image_url"];
        }
    
        // Add WHERE condition
        $query .= " WHERE id = ?";
        $types .= "i";
        $values[] = $userid;
    
        // Prepare and execute the query
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }
    

    public function getAllUsersWithFollowStats($currentUserId): array {
        $query = "
            SELECT 
                users.id, 
                users.name,
                users.username,
                users.bio, 
                users.image_pic_url, 
                users.created_at,
                (
                    SELECT COUNT(*) 
                    FROM follows 
                    WHERE follows.followed_id = users.id
                ) AS followersCount,
                (
                    SELECT COUNT(*) 
                    FROM follows 
                    WHERE follows.follower_id = users.id
                ) AS followingCount,
                (
                    SELECT CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM follows 
                            WHERE follows.follower_id = ? AND follows.followed_id = users.id
                        ) THEN 1 ELSE 0 END
                ) AS isFollowing
            FROM users
            WHERE users.id != ?
            ORDER BY users.name ASC
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $currentUserId, $currentUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAllUsers(){
        // Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM users ORDER BY created_at DESC");
        if (!$stmt) {
            die('Query prepare failed: ' . $this->conn->error);
        }

        // Execute the query
        if (!$stmt->execute()) {
            die('Query execution failed: ' . $stmt->error);
        }

        // Fetch all rows as an associative array
        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);

        // Free the result set and close the statement
        $stmt->close();

        return $users;
    }

    public function deleteUser($id){
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    
}
