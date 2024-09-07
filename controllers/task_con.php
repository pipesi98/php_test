<?php
require_once 'models/task_dao.php';
require_once 'utils/validacion.php';

class TaskController {
    private $taskDAO;

    public function __construct($taskDAO) {
        $this->taskDAO = $taskDAO;
    }

    public function create($data) {
        $errors = Validator::validateTaskData($data);
        if (!empty($errors)) {
            return json_encode(['errors' => $errors]);
        }
        $id = $this->taskDAO->createTask($data['title'], $data['description'], $data['status']);
        return json_encode(['id' => $id]);
    }

    public function getAll() {
        $tasks = $this->taskDAO->getAllTasks();
        return json_encode($tasks);
    }

    public function getById($id) {
        $task = $this->taskDAO->getTaskById($id);
        if ($task) {
            return json_encode($task);
        }
        return json_encode(['error' => 'Task not found']);
    }

    public function update($id, $data) {
        $errors = Validator::validateTaskData($data);
        if (!empty($errors)) {
            return json_encode(['errors' => $errors]);
        }
        $rows = $this->taskDAO->updateTask($id, $data['title'], $data['description'], $data['status']);
        if ($rows > 0) {
            return json_encode(['message' => 'Task updated']);
        }
        return json_encode(['error' => 'Task not found']);
    }

    public function delete($id) {
        $rows = $this->taskDAO->deleteTask($id);
        if ($rows > 0) {
            return json_encode(['message' => 'Task deleted']);
        }
        return json_encode(['error' => 'Task not found']);
    }
}
?>
