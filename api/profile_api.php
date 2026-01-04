<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'database.php';
include '../class/Profile.php';

$database = new Database();
$db = $database->getConnection();
$profile = new Profile($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if(isset($_GET['id'])) {
            $data = $profile->getProfileById($_GET['id']);
        } else {
            $data = $profile->getAllProfiles();
        }
        echo json_encode(["status" => "success", "data" => $data]);
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        if ($profile->addProfile($input)) {
            echo json_encode(["status" => "success", "message" => "Profile added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add profile"]);
        }
        break;

    case 'PUT':
        if(!isset($_GET['id'])) {
            echo json_encode(["status" => "error", "message" => "ID required"]);
            break;
        }
        $id = $_GET['id'];
        $input = json_decode(file_get_contents("php://input"), true);
        if ($profile->updateProfile($id, $input)) {
            echo json_encode(["status" => "success", "message" => "Profile updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        break;

    case 'DELETE':
        if(!isset($_GET['id'])) {
            echo json_encode(["status" => "error", "message" => "ID required"]);
            break;
        }
        $id = $_GET['id'];
        if ($profile->deleteProfile($id)) {
            echo json_encode(["status" => "success", "message" => "Profile deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
