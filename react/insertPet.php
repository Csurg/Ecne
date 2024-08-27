<?php
header("Content-type: application/json; charset=UTF-8");

require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    try {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!empty($data)) {
            $other="";
            if (isset($data['user_id']))
                $user_id = (int)$data['user_id'];

            if (isset($data['name']))
                $name = $data['name'];

            if (isset($data['breed_id']))
                $breed_id = $data['breed_id'];

            if (isset($data['vet_id']))
                $vet_id = $data['vet_id'];

            if (isset($data['age']))
                $age = $data['age'];

            if (isset($data['gender']))
                $gender = $data['gender'];

            if (isset($data['other']))
                $other = $data['other'];


            if (isset($user_id)  AND isset($name) AND isset($breed_id) AND isset($vet_id) AND isset($age) AND isset($gender))
                $pet = insertPet($user_id, $name,$breed_id,$vet_id,$age,$gender,$other);
        }


        if (empty($user_id) || empty($name) || empty($breed_id) || empty($vet_id) || empty($age) || empty($gender)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Not enough variables given']);
            exit();
        }
        if (empty($pet)) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Not found']);
        } else {
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Successful register!"));
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

