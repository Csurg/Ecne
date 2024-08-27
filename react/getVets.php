<?php
header("Content-type: application/json; charset=UTF-8");

require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $vets = getVets();
    if (empty($vets)) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'No vets found']);
    } else {
        http_response_code(200);
        echo json_encode($vets);
    }

} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Method Not Allowed"));
}
exit();
