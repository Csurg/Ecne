<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

require_once "db_config.php";

$pdo = connectDatabase($dsn, $pdoOptions);

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
 */
function connectDatabase(string $dsn, array $pdoOptions): PDO
{

    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASS'], $pdoOptions);

    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}


/**
 * Function redirects user to given url
 *
 * @param string $url
 */
function redirection($url)
{
    header("Location:$url");
    exit();
}


/**
 * Function checks that login parameters exists in users_web table
 *
 * @param PDO $pdo
 * @param string $email
 * @param string $enteredPassword
 * @return array
 */
function checkUserLogin(PDO $pdo, string $email, string $enteredPassword): array
{
    $sqlUser = "SELECT user_id, user_password,firstname,lastname,phone FROM users WHERE email=:email AND active=1 AND is_banned = 0 LIMIT 0,1";
    $sqlVet = "SELECT vet_id, vet_password,firstname,lastname,phone,biography,specialization_id,vet_office_id FROM veterinarians WHERE email=:email AND is_banned = 0 LIMIT 0,1";

    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':email', $email, PDO::PARAM_STR);

    $stmtVet = $pdo->prepare($sqlVet);
    $stmtVet->bindParam(':email', $email, PDO::PARAM_STR);

    $data = [];

    $stmtUser->execute();
    $stmtVet->execute();

    if ($stmtUser->rowCount() > 0) {
        $result = $stmtUser->fetch(PDO::FETCH_ASSOC);
        $data['firstname'] = $result['firstname'];
        $data['lastname'] = $result['lastname'];
        $data['phone'] = $result['phone'];
    }else if($stmtVet->rowCount() > 0){
        $result = $stmtVet->fetch(PDO::FETCH_ASSOC);
        $data['firstname'] = $result['firstname'];
        $data['lastname'] = $result['lastname'];
        $data['phone'] = $result['phone'];
        $data['biography'] = $result['biography'];
        $data['specialization_id'] = $result['specialization_id'];
        $data['vet_office_id'] = $result['vet_office_id'];

    }

    if ($stmtUser->rowCount() > 0) {

        $registeredPassword = $result['user_password'];

        if (password_verify($enteredPassword, $registeredPassword)) {
            $data['user_id'] = $result['user_id'];
        }
    }
    else if($stmtVet->rowCount() > 0) {

        $registeredPassword = $result['vet_password'];

        if (password_verify($enteredPassword, $registeredPassword)) {
            $data['vet_id'] = $result['vet_id'];
        }
    }
    return $data;
}


/**
 * Function checks that user exists in users table
 * @param PDO $pdo
 * @param string $email
 * @return bool
 */
function existsUser(PDO $pdo, string $email1,string $email2): bool
{
    $sql = "SELECT user_id, NULL AS vet_id
            FROM users
            WHERE email = :email1
            UNION ALL
            SELECT NULL AS id, vet_id 
            FROM veterinarians
            WHERE email = :email2";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email1', $email1, PDO::PARAM_STR);
    $stmt->bindParam(':email2', $email2, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

/**Function registers user and returns id of created user
 * @param PDO $pdo
 * @param string $password
 * @param string $firstname
 * @param string $lastname
 * @param string $email
 * @param string $token
 * @return int
 */
function registerUser(PDO $pdo, string $password, string $firstname, string $lastname, string $email, string $token,string $phone): int
{

    try {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(user_password, firstname, lastname, email, registration_token, registration_token_expiry, active, phone,is_banned)
                VALUES (:passwordHashed, :firstname, :lastname, :email, :token, DATE_ADD(now(), INTERVAL 1 DAY), 0, :phone,0)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':passwordHashed', $passwordHashed, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

        $stmt->execute();

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

/** Function creates random token for given length in bytes
 * @param int $length
 * @return string|null
 */
function createToken(int $length): ?string
{
    try {
        return bin2hex(random_bytes($length));
    } catch (\Exception $e) {
        // c:xampp/apache/logs/
        error_log("****************************************");
        error_log($e->getMessage());
        error_log("file:" . $e->getFile() . " line:" . $e->getLine());
        return null;
    }
}

/** Function tries to send email with activation code
 * @param PDO $pdo
 * @param string $email
 * @param array $emailData
 * @param string $body
 * @param int $id_user
 * @return void
 */

const GMailUSEREmail = 'epets2024@gmail.com'; // your username on gmail
const GoogleAppsPassword = 'wlck jdwl qufk wazp'; // you password for created APP

function sendEmail(PDO $pdo, string $email, array $emailData, string $body, int $id_user): void
{

    $toEmail =$email ;
    $subject = $emailData['subject'];
    $from = 'epets2024@gmail.com';
    $fromName = 'E-Pets';


    try {
        $phpmailer = new PHPMailer(true);
        $phpmailer->IsSMTP();
        $phpmailer->SMTPDebug = 0;
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->Port = 465;
        $phpmailer->Username = GMailUSEREmail;
        $phpmailer->Password = GoogleAppsPassword;
        $phpmailer->SetFrom($from, $fromName);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = $subject;
        $phpmailer->Body = $body;

        $phpmailer->AltBody = $emailData['altBody'];
        $phpmailer->AddAddress($toEmail);
        $phpmailer->send();
    } catch (Exception $e) {
        $message = "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        addEmailFailure($pdo, $id_user, $message);
    }

}


/** Function inserts data in database for e-mail sending failure
 * @param PDO $pdo
 * @param int $id_user
 * @param string $message
 * @return void
 */
function addEmailFailure(PDO $pdo, int $id_user, string $message): void
{
    $sql = "INSERT INTO user_email_failures (user_id, message, date_time_added)
            VALUES (:id_user,:message, now())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();

}

/**
 * Function returns user data for given field and given value
 * @param PDO $pdo
 * @param string $data
 * @param string $field
 * @param mixed $value
 * @return mixed
 */
function getUserData(PDO $pdo, string $data, string $field, string $value): string
{
    $sql = "SELECT $data as data FROM users WHERE $field=:value LIMIT 0,1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $data = '';

    if ($stmt->rowCount() > 0) {
        $data = $result['data'];
    }

    return $data;
}

/**
 * Function sets the forgotten token
 * @param PDO $pdo
 * @param string $email
 * @param string $token
 * @return void
 */

function setForgottenToken(PDO $pdo, string $table, string $email, string $token): void
{
    $sql = "UPDATE $table SET forgotten_password_token = :token, forgotten_password_expires = DATE_ADD(now(),INTERVAL 6 HOUR) WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
}

function getAll(PDO $pdo, string $table): array
{
    $sql = "SELECT * FROM $table ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**Function detects ip address of the request.
 * It returns valid ip address or unknown word.
 * @return string
 */
function getIpAddress(): string
{

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = "unknown";
    }

    return $ip;
}

/**Function inserts data into log table.
 * @param string $userAgent
 * @param string $ipAddress
 * @param string $deviceType
 * @param string $country
 * @param bool $proxy
 * @return void
 */
function insertIntoLog(PDO $pdo, int $user_id, string $userAgent, string $ipAddress, string $deviceType, string $country, string $city, bool $proxy): void
{

    $sql = "INSERT INTO users_detected_data(user_id,user_agent, ip_address,device_type, country, city, proxy) VALUES(:user_id,:userAgent, :ipAddress,:deviceType, :country,:city, :proxy)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userAgent', $userAgent, PDO::PARAM_STR);
    $stmt->bindValue(':ipAddress', $ipAddress, PDO::PARAM_STR);
    $stmt->bindValue(':country', $country, PDO::PARAM_STR);
    $stmt->bindValue(':city', $city, PDO::PARAM_STR);
    $stmt->bindValue(':proxy', $proxy, PDO::PARAM_INT);
    $stmt->bindValue(':deviceType', $deviceType, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

    $stmt->execute();
}

function insertIntoScanned(PDO $pdo, int $pet_id, string $ipAddress,string $coordinates, string $country, string $city): void
{

    $sql = "INSERT INTO scanned(pet_id, ip_address,coordinates, country, city) VALUES(:pet_id, :ipAddress,:coordinates, :country,:city)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ipAddress', $ipAddress, PDO::PARAM_STR);
    $stmt->bindValue(':country', $country, PDO::PARAM_STR);
    $stmt->bindValue(':city', $city, PDO::PARAM_STR);
    $stmt->bindValue(':coordinates', $coordinates, PDO::PARAM_STR);
    $stmt->bindValue(':pet_id', $pet_id, PDO::PARAM_STR);

    $stmt->execute();
}

/**Function executes curl session and returns the transfer as a string of the return value of execution.
 * @param $url
 * @return string
 */
function getCurlData($url): string
{
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: PHP\r\n" // Some servers require a user agent header
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}

function registerPet(PDO $pdo,int $user, string $name, int $breed, int $vet,int $age,string $gender,string $other): bool
{

    $sql = "INSERT INTO pets(user_id,name,breed_id,vet_id,age,gender,other,lost)
            VALUES (:user, :name, :breed, :vet, :age, :gender, :other ,0)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':breed', $breed, PDO::PARAM_INT);
    $stmt->bindParam(':vet', $vet, PDO::PARAM_INT);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':other', $other, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }

}

function editPet(PDO $pdo,int $petid, int $user, string $name, int $breed, int $vet,int $age,string $gender,string $other): bool
{

    $sql = "UPDATE pets SET 
            name = :name, 
            breed_id = :breed, 
            vet_id = :vet, 
            age = :age, 
            gender = :gender, 
            other = :other,
            updated_at = NOW()
        WHERE pet_id = :pet_id AND user_id = :user";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pet_id', $petid, PDO::PARAM_STR);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':breed', $breed, PDO::PARAM_STR);
    $stmt->bindParam(':vet', $vet, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':other', $other, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }

}

function hasPet($pdo,$id) :bool
{
    $sql = "Select pet_id FROM pets WHERE user_id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    else
        return false;
}

function getPetData($pdo,$id) :array
{
    $sql = "SELECT p.pet_id AS pet_id,p.name AS Pet,vo.name AS Office,vo.phone AS Phone, u.user_id AS id, u.email AS email, p.lost FROM pets p 
            INNER JOIN veterinarians v on p.vet_id = v.vet_id
            INNER JOIN vet_offices vo on v.vet_office_id = vo.vet_office_id
            INNER JOIN users u on p.user_id = u.user_id
            WHERE p.pet_id = $id; ";
    $stmt = $pdo->prepare($sql);

    try {
        $result = [];
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return array(false);
    }

}
function updateVisit($pdo,$id):void
{
    $sql = "UPDATE vet_popularity SET number_of_visits = COALESCE(number_of_visits, 0) + 1 WHERE vet_id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

function createAppointments($pdo,$date,$vetid,$title):bool
{
    $checkSql = "SELECT COUNT(*) FROM appointments WHERE vet_id = :vetid AND DATE(date) = :date";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute(['vetid' => $vetid, 'date' => $date]);
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {

        return false;
    }

    $times = ['08:00', '08:30', '09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00'];
    $values = [];

    foreach ($times as $time) {
        $values[] = "($vetid, '$title', '$date $time', 1)";
    }

    $sql = "INSERT INTO appointments(vet_id, title, date, is_available) VALUES " . implode(',', $values);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    else
        return false;
}

function cancelApp(PDO $pdo,string $id):bool
{
    $sql = "UPDATE appointments SET is_available = 0 WHERE appointment_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);


    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function reopenApp(PDO $pdo,string $id):bool
{
    $sql = "UPDATE appointments SET is_available = 1 WHERE appointment_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);


    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function finishApp(PDO $pdo,string $id):bool
{
    $sql = "UPDATE reserved_appointments SET is_finished = 1 WHERE reserved_appointment_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);


    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function insertTreatment(PDO $pdo,$reserved_appointment_id,$title,$medicine,$description) :bool
{
    $sql = "INSERT INTO treatments(reserved_appointment_id,title,description,medicine,date) VALUES (:id,:title,:description,:medicine,NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $reserved_appointment_id, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':medicine', $medicine, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}