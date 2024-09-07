<?php
require_once 'config/database.php';
require_once 'models/task_dao.php';
require_once 'controllers/task_con.php';

$taskDAO = new TaskDAO($pdo);
$taskController = new TaskController($taskDAO);

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'], '/'));

switch ($method) {
    case 'GET':
        if (isset($path[1])) {
            echo $taskController->getById($path[1]);
        } else {
            echo $taskController->getAll();
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        echo $taskController->create($data);
        break;
    case 'PUT':
        if (isset($path[1])) {
            $data = json_decode(file_get_contents('php://input'), true);
            echo $taskController->update($path[1], $data);
        }
        break;
    case 'DELETE':
        if (isset($path[1])) {
            echo $taskController->delete($path[1]);
        }
        break;
    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
