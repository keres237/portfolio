<?php
class BaseModel {
    protected $conn;
    protected $table;

    public function __construct($db, $table) {
        $this->conn = $db;
        $this->table = $table;
    }

    // 🔹 Get all records
    public function getAll($orderBy = "id DESC") {
        $query = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Get single record by ID
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Create record (dynamic)
    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", htmlspecialchars(strip_tags($value)));
        }

        if ($stmt->execute()) {
            return ["id" => $this->conn->lastInsertId()] + $data;
        }
        return false;
    }

    // 🔹 Update record (dynamic)
    public function update($id, $data) {
        $setClause = implode(", ", array_map(fn($k) => "$k = :$k", array_keys($data)));
        $query = "UPDATE {$this->table} SET $setClause WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", htmlspecialchars(strip_tags($value)));
        }
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ["id" => $id] + $data;
        }
        return false;
    }

    // 🔹 Delete record
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ["id" => $id, "message" => "Record deleted successfully"];
        }
        return false;
    }

    /* ==============================
       🔍 EXTRA FEATURES (OPTIONAL)
       ============================== */

    // 🔹 Search by keyword
    public function search($keyword, $columns = []) {
        $conditions = [];
        foreach ($columns as $col) {
            $conditions[] = "$col LIKE :keyword";
        }
        $where = implode(" OR ", $conditions);
        $query = "SELECT * FROM {$this->table} WHERE $where";

        $stmt = $this->conn->prepare($query);
        $searchTerm = "%{$keyword}%";
        $stmt->bindParam(":keyword", $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Pagination
    public function getPaginated($limit, $offset) {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Stats / aggregates
    public function getStats() {
        $query = "SELECT COUNT(*) AS total, MAX(id) AS latest_id, MIN(id) AS first_id FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Subquery example (latest)
    public function getLatest($limit = 5) {
        $query = "SELECT * FROM {$this->table} WHERE id IN (
                    SELECT id FROM {$this->table} ORDER BY id DESC LIMIT :limit
                  )";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
