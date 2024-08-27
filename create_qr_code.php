<?php
require_once 'db_config.php';
require_once 'phpqrcode/qrlib.php';

if (isset($_POST['name']) && isset($_POST['pet_id'])) {

    $fileName = $_POST['name'] . "_QR.png";
    $qrCodeContent = URL . "?pet_id=" . $_POST['pet_id'];

    // Set headers to force download
    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    QRcode::png($qrCodeContent, null, QR_ECLEVEL_H, 8);

    exit;
} else {
    echo "Name and Pet ID are required.";
}
?>
