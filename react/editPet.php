<?php

header("Content-type: application/json; charset=UTF-8");

require_once 'config.php';
require_once 'functions.php';
if ($_SERVER["REQUEST_METHOD"] === "PATCH") {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        $pet_id = $data["pet_id"];
        $name = $data["name"];
        $age = $data['age'];
        $other = $data['other'];
        if (empty($pet_id) || empty($name) || empty($age)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Empty variables']);
            exit();
        }

        $edit = editPet($pet_id,$name,$age,$other);
        if ($edit) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Not found']);
        } else {
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Updated successfully!"));
        }
        exit();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Database error"));
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Method Not Allowed"));
    exit();
}

