<?php
require_once 'db_config.php';
require_once 'functions.php';

$petData = getPetData($pdo,$_GET['pet_id']);

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>QR CODE</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>';

if($petData)
{
    echo '<p class="bold-text">Pet name:'.$petData['Pet'].'</p>';
    echo '<p class="bold-text">Office name:'.$petData['Office'].'</p>';
    echo '<p class="bold-text">Office phone number:'.$petData['Phone'].'</p>';

    if($petData['lost'] == 1) {
        $ipAddress = getIpAddress();
        $country = "";
        $city = "";
        $lat = "";
        $lon = "";

        $urlApi = "http://ip-api.com/json/$ipAddress?fields=$apiFields";
        $apiResponse = getCurlData($urlApi);

        $apiData = json_decode($apiResponse, true);

        if (isset($apiData['country']))
            $country = $apiData['country'];

        if (isset($apiData['city']))
            $city = $apiData['city'];

        if (isset($apiData['lat']))
            $lat = $apiData['lat'];

        if (isset($apiData['lon']))
            $lon = $apiData['lon'];
        $coordinates = $lat . ' ' . $lon;

        $body = "   <p>Pet name: {$petData['Pet']}</p>
                    <p>Datas about your pets last location:</p>
                    <p><strong>Country: </strong>$country</p>
                    <p><strong>City: </strong>$city</p>
                    <p><strong>Coordinates: </strong><a href='https://maps.google.com/?q=$coordinates' target=\"_blank\">$coordinates</a></p>
                    <p><strong>IP Address: </strong>$ipAddress</p>
    ";

        insertIntoScanned($pdo, $petData['pet_id'], $ipAddress, $coordinates, $country, $city);

        sendEmail($pdo, $petData['email'], $emailMessages['lost'], $body, $petData['id']);
    }
}
else
    echo '<p class="bold-text">No data</p>';

echo '
</body>
</html>';