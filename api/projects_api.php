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
include '../class/Project.php';

$database = new Database();
$db = $database->getConnection();
$project = new Project($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    if (isset($_GET['id'])) {
      $data = $project->getProjectById($_GET['id']);
      echo json_encode(["status" => "success", "project" => $data]);
    } else {
      $data = $project->getAllProjects();
      echo json_encode(["status" => "success", "projects" => $data]);
    }
    break;

  case 'POST':
    $input = json_decode(file_get_contents("php://input"), true);
    if ($project->addProject($input['title'], $input['description'], $input['link'], $input['tech_stack'], $input['project_date'])) {
      echo json_encode(["status" => "success", "message" => "Project added successfully"]);
    } else {
      echo json_encode(["status" => "error", "message" => "Failed to add project"]);
    }
    break;

  case 'PUT':
    $input = json_decode(file_get_contents("php://input"), true);
    if ($project->updateProject($input['id'], $input['title'], $input['description'], $input['link'], $input['tech_stack'], $input['project_date'])) {
      echo json_encode(["status" => "success", "message" => "Project updated successfully"]);
    } else {
      echo json_encode(["status" => "error", "message" => "Failed to update project"]);
    }
    break;

  case 'DELETE':
    if (isset($_GET['id']) && $project->deleteProject($_GET['id'])) {
      echo json_encode(["status" => "success", "message" => "Project deleted successfully"]);
    } else {
      echo json_encode(["status" => "error", "message" => "Failed to delete project"]);
    }
    break;

  default:
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
