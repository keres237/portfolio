<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Admin credentials 
$ADMIN_USERNAME = "admin";
$ADMIN_PASSWORD = "admin123";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (isset($input['action'])) {
            if ($input['action'] === 'login') {
                $username = $input['username'] ?? '';
                $password = $input['password'] ?? '';
                
                // Validate credentials
                if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $username;
                    $_SESSION['login_time'] = time();
                    
                    echo json_encode([
                        "status" => "success",
                        "message" => "Login successful",
                        "logged_in" => true
                    ]);
                } else {
                    http_response_code(401);
                    echo json_encode([
                        "status" => "error",
                        "message" => "Invalid credentials",
                        "logged_in" => false
                    ]);
                }
            } elseif ($input['action'] === 'logout') {
                // Clear session
                $_SESSION['admin_logged_in'] = false;
                $_SESSION['admin_username'] = null;
                session_destroy();
                
                echo json_encode([
                    "status" => "success",
                    "message" => "Logged out successfully",
                    "logged_in" => false
                ]);
            }
        }
        break;

    case 'GET':
        // Check if admin is logged in
        $logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
        
        echo json_encode([
            "status" => "success",
            "logged_in" => $logged_in,
            "username" => $logged_in ? $_SESSION['admin_username'] : null
        ]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}
?>
