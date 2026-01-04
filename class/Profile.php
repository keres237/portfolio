<?php
class Profile {
    private $conn;
    private $table = "profile";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🟢 Get all profiles (in case of multiple users)
    public function getAllProfiles() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🟢 Get single profile (you can use id=1 if single user)
    public function getProfileById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🟢 Add new profile
    public function addProfile($data) {
        $query = "INSERT INTO " . $this->table . " (full_name, title, bio, email, phone, profile_image)
                  VALUES (:full_name, :title, :bio, :email, :phone, :profile_image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":full_name", $data['full_name']);
        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":bio", $data['bio']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":profile_image", $data['profile_image']);

        return $stmt->execute();
    }

    // 🟢 Update existing profile
    public function updateProfile($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET full_name=:full_name, title=:title, bio=:bio, email=:email, phone=:phone, profile_image=:profile_image
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":full_name", $data['full_name']);
        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":bio", $data['bio']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":profile_image", $data['profile_image']);

        return $stmt->execute();
    }

    // 🟢 Delete profile
    public function deleteProfile($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
