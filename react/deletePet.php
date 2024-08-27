<?php
header("Content-type: application/json; charset=UTF-8");

require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {

    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $pet_id = (int)$data['pet_id'];
        $pet = deletePet($pet_id);
        if (empty($pet_id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing pet id']);
            exit();
        }
        if (empty($pet)) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Not found']);
        } else {
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Deleted successfully!"));
        }
        exit();

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Database error!"));
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Method Not Allowed"));
    exit();
}

