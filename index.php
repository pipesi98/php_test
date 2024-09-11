<?php
require_once 'config/database.php';
require_once 'models/task_dao.php';
require_once 'controllers/task_con.php';

// Conexión a la base de datos
$pdo = (new Database())->connect();
$taskDAO = new TaskDAO($pdo);
$taskController = new TaskController($taskDAO);

// Establecer la respuesta como JSON
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

try {
    switch ($method) {
        case 'GET':
            if (isset($path[1])) {
                echo json_encode($taskController->getById($path[1]));
            } else {
                echo json_encode($taskController->getAll());
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            // Validar los datos antes de continuar
            if (empty($data['title']) || empty($data['status'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input. Title and status are required.']);
                exit;
            }

            echo json_encode($taskController->create($data));
            break;
        case 'PUT':
            if (isset($path[1])) {
                $data = json_decode(file_get_contents('php://input'), true);

                // Validar los datos antes de continuar
                if (empty($data['title']) || empty($data['status'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid input. Title and status are required.']);
                    exit;
                }

                echo json_encode($taskController->update($path[1], $data));
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Task ID is required for update']);
            }
            break;
        case 'DELETE':
            if (isset($path[1])) {
                echo json_encode($taskController->delete($path[1]));
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Task ID is required for delete']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            break;
    }
} catch (Exception $e) {
    // Manejo general de errores
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()]);
}
?>
