<?php
class Project {
  private $conn;
  private $table = "projects";

  public function __construct($db) {
    $this->conn = $db;
  }

  public function getAllProjects() {
    $query = "SELECT * FROM {$this->table} ORDER BY project_date DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getProjectById($id) {
    $query = "SELECT * FROM {$this->table} WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function addProject($title, $description, $link, $tech_stack, $project_date) {
    $query = "INSERT INTO {$this->table} (title, description, link, tech_stack, project_date)
              VALUES (:title, :description, :link, :tech_stack, :project_date)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':link', $link);
    $stmt->bindParam(':tech_stack', $tech_stack);
    $stmt->bindParam(':project_date', $project_date);
    return $stmt->execute();
  }

  public function updateProject($id, $title, $description, $link, $tech_stack, $project_date) {
    $query = "UPDATE {$this->table}
              SET title = :title, description = :description, link = :link,
                  tech_stack = :tech_stack, project_date = :project_date
              WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':link', $link);
    $stmt->bindParam(':tech_stack', $tech_stack);
    $stmt->bindParam(':project_date', $project_date);
    return $stmt->execute();
  }

  public function deleteProject($id) {
    $query = "DELETE FROM {$this->table} WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
  }
}
?>
