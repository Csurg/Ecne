<?php
session_start();
require_once 'functions.php';
if(!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    redirection('signIn.php?l=0');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pet_id = $_POST['pet_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE pets SET deleted_at = NOW() WHERE pet_id = $pet_id AND user_id = $user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    header('Location: my_pets.php');
    exit();
}
?>