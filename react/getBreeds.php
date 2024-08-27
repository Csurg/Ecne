<?php
header("Content-type: application/json; charset=UTF-8");

require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $breeds = getBreeds();
    if (empty($breeds)) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'No breeds found']);
    } else {
        http_response_code(200);
        echo json_encode($breeds);
    }

} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Method Not Allowed"));
}
exit();
