<?php
require_once 'config/database.php';
require_once 'models/task.php';

class TaskDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createTask($title, $description, $status) {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (title, description, status) VALUES (:title, :description, :status)");
        $stmt->execute(['title' => $title, 'description' => $description, 'status' => $status]);
        return $this->pdo->lastInsertId();
    }

    public function getAllTasks() {
        $stmt = $this->pdo->query("SELECT * FROM tasks");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, $title, $description, $status) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET title = :title, description = :description, status = :status WHERE id = :id");
        $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description, 'status' => $status]);
        return $stmt->rowCount();
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}
?>
