<?php
header("Content-type: application/json; charset=UTF-8");

require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $fields = ['pet_id', 'user_id', 'name','vet_id'];

    $pets = getPets($fields,(int)$_GET['user_id']);
    if (empty($pets)) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'You have not registered a pet yet!']);
    } else {
        http_response_code(200);
        echo json_encode($pets);
    }

} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Method Not Allowed"));
}
exit();
