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
include '../class/Skill.php';

$database = new Database();
$db = $database->getConnection();
$skill = new Skill($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    if (isset($_GET['id'])) {
      $data = $skill->getSkillById($_GET['id']);
      echo json_encode(["status" => "success", "skill" => $data]);
    } else {
      $data = $skill->getAllSkills();
      echo json_encode(["status" => "success", "skills" => $data]);
    }
    break;

  case 'POST':
    $input = json_decode(file_get_contents("php://input"), true);
    if ($skill->addSkill($input['skill_name'], $input['proficiency_level'], $input['category'])) {
      echo json_encode(["status" => "success", "message" => "Skill added successfully"]);
    } else {
      echo json_encode(["status" => "error", "message" => "Failed to add skill"]);
    }
    break;

  case 'PUT':
    $input = json_decode(file_get_contents("php://input"), true);
    if ($skill->updateSkill($input['id'], $input['skill_name'], $input['proficiency_level'], $input['category'])) {
      echo json_encode(["status" => "success", "message" => "Skill updated successfully"]);
    } else {
      echo json_encode(["status" => "error", "message" => "Failed to update skill"]);
    }
    break;

  case 'DELETE':
    if (isset($_GET['id']) && $skill->deleteSkill($_GET['id'])) {
      echo json_encode(["status" => "success", "message" => "Skill deleted successfully"]);
    } else {
      echo json_encode(["status" => "error", "message" => "Failed to delete skill"]);
    }
    break;

  default:
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
