<?php
require_once 'db_config.php';
require_once 'functions.php';

$data = json_decode(file_get_contents('php://input'), true);
$appointment_id = $data['appointment_id'];
$pet_id = $data['pet_id'];

function reserveAppointment($pdo, $appointment_id,$pet_id) {
    $sql = "INSERT INTO reserved_appointments(appointment_id,pet_id) VALUES (:appointment_id,:pet_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':appointment_id', $appointment_id, PDO::PARAM_INT);
    $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->errorInfo()]);
    }
}

reserveAppointment($pdo, $appointment_id,$pet_id);
?>
