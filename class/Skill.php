<?php
class Skill {
  private $conn;
  private $table = "skills";

  public function __construct($db) {
    $this->conn = $db;
  }

  public function getAllSkills() {
    $query = "SELECT * FROM {$this->table} ORDER BY category, skill_name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getSkillById($id) {
    $query = "SELECT * FROM {$this->table} WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function addSkill($name, $level, $category) {
    $query = "INSERT INTO {$this->table} (skill_name, proficiency_level, category)
              VALUES (:name, :level, :category)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':category', $category);
    return $stmt->execute();
  }

  public function updateSkill($id, $name, $level, $category) {
    $query = "UPDATE {$this->table}
              SET skill_name = :name, proficiency_level = :level, category = :category
              WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':category', $category);
    return $stmt->execute();
  }

  public function deleteSkill($id) {
    $query = "DELETE FROM {$this->table} WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
  }
}
?>
