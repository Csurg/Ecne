<?php
header("Content-type: application/json; charset=UTF-8");

require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $petid = (int)$_GET['pet_id'] ?? 0;
    $pet = getPetData($petid);

    if ($pet === false) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'No data found']);
        exit();
    }
    if (empty($_GET['pet_id'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing pet id']);
        exit();
    }
    if (!empty($pet)) {
        http_response_code(200);
        echo json_encode($pet);
    }

}
else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Method Not Allowed"));
}
exit();