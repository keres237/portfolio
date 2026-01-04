<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Database.php';
include '../class/BaseModel.php'; // Change this for each entity

$database = new Database();
$db = $database->getConnection();
$table =
$model = new BaseModel($db, $table); // Change the class name accordingly

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    // 🔹 GET (all, single, search, pagination, stats)
    case 'GET':
        if (isset($_GET['id'])) {
            $data = $model->getById($_GET['id']);
            $response = $data ? ["status" => "success", "data" => $data] : ["status" => "error", "message" => "Record not found"];
        } elseif (isset($_GET['search'])) {
            $data = $model->search($_GET['search'], ['name', 'level']); // adjust columns
            $response = ["status" => "success", "results" => $data];
        } elseif (isset($_GET['limit']) && isset($_GET['offset'])) {
            $data = $model->getPaginated((int)$_GET['limit'], (int)$_GET['offset']);
            $response = ["status" => "success", "results" => $data];
        } elseif (isset($_GET['stats'])) {
            $data = $model->getStats();
            $response = ["status" => "success", "stats" => $data];
        } elseif (isset($_GET['latest'])) {
            $data = $model->getLatest((int)$_GET['latest']);
            $response = ["status" => "success", "latest" => $data];
        } else {
            $data = $model->getAll();
            $response = ["status" => "success", "results" => $data];
        }
        echo json_encode($response);
        break;

    // 🔹 POST (create)
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data)) {
            $result = $model->create($data);
            $response = $result
                ? ["status" => "success", "message" => "Record created successfully", "data" => $result]
                : ["status" => "error", "message" => "Failed to create record"];
        } else {
            $response = ["status" => "error", "message" => "Empty or invalid data"];
        }
        echo json_encode($response);
        break;

    // 🔹 PUT (update)
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            $result = $model->update($id, $data);
            $response = $result
                ? ["status" => "success", "message" => "Record updated", "data" => $result]
                : ["status" => "error", "message" => "Update failed"];
        } else {
            $response = ["status" => "error", "message" => "Missing record ID"];
        }
        echo json_encode($response);
        break;

    // 🔹 DELETE
    case 'DELETE':
        if (isset($_GET['id'])) {
            $result = $model->delete($_GET['id']);
            $response = $result
                ? ["status" => "success", "message" => "Record deleted", "data" => $result]
                : ["status" => "error", "message" => "Failed to delete"];
        } else {
            $response = ["status" => "error", "message" => "Missing ID"];
        }
        echo json_encode($response);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
