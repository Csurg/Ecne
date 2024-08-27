<?php
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
 * Function checks that login parameters exists in admin table
 *
 * @param PDO $pdo
 * @param string $email
 * @param string $enteredPassword
 * @return array
 */
function checkUserLogin(PDO $pdo, string $username, string $enteredPassword): array
{
    $sqlUser = "SELECT admin_id,username,password FROM admins WHERE username=:username";

    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':username', $username, PDO::PARAM_STR);

    $data = [];

    $stmtUser->execute();

    if($stmtUser->rowCount() > 0){
        $result = $stmtUser->fetch(PDO::FETCH_ASSOC);

    }



    if ($stmtUser->rowCount() > 0) {

        $registeredPassword = $result['password'];

        if (password_verify($enteredPassword, $registeredPassword)) {
            $data['admin_id'] = $result['admin_id'];
            $data['username'] = $result['username'];
        }
    }

    return $data;
}

function userBan(PDO $pdo,string $user_ban,string $table,string $id):bool
{
    $sql = "UPDATE $table SET is_banned = 1 WHERE $id = :user_ban";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_ban', $user_ban, PDO::PARAM_STR);


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
function userUnban(PDO $pdo,string $user_unban, string $table,string $id):bool
{
    $sql = "UPDATE $table SET is_banned = 0 WHERE $id = :user_unban";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_unban', $user_unban, PDO::PARAM_STR);


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

function registerUser(PDO $pdo,string $email, string $password, string $firstname, string $lastname,string $phone,int $specialization,int $office, string $biography, int $admin): array
{

    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO veterinarians(vet_password,firstname,lastname,email,phone,biography,specialization_id,vet_office_id,added_by,is_banned)
            VALUES (:passwordHashed,:firstname,:lastname,:email,:phone,:biography,:specialization_id,:vet_office_id,:added_by,0)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':passwordHashed', $passwordHashed, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':biography', $biography, PDO::PARAM_STR);
    $stmt->bindParam(':specialization_id', $specialization, PDO::PARAM_STR);
    $stmt->bindParam(':vet_office_id', $office, PDO::PARAM_STR);
    $stmt->bindParam(':added_by', $admin, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return array(true,$pdo->lastInsertId());
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return array(false);
    }

}

function getAll(PDO $pdo, string $table): array
{
    $sql = "SELECT * FROM $table ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function newPopularity(PDO $pdo, int $id): void
{
    $sql = "INSERT INTO vet_popularity(vet_id) VALUES ($id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

}
function updateVetData(PDO $pdo): void
{
    $sqlVet = "SELECT vet_id FROM veterinarians ORDER BY vet_id ASC";
    $stmtVet = $pdo->prepare($sqlVet);
    $stmtVet->execute();
    $vets = $stmtVet->fetchAll(PDO::FETCH_ASSOC);

    foreach ($vets as $vet)
    {
        $sqlCount = "SELECT COUNT(pet_id) AS patients FROM pets WHERE vet_id = {$vet['vet_id']};";
        $stmtCount = $pdo->prepare($sqlCount);
        $stmtCount->execute();
        $countPatients = $stmtCount->fetch(PDO::FETCH_ASSOC);

        $sqlCountTreatments = "SELECT COUNT(treatment_id) AS treatments 
                                FROM treatments t
                                INNER JOIN reserved_appointments ra ON t.reserved_appointment_id = ra.reserved_appointment_id
                                INNER JOIN appointments a ON ra.appointment_id = a.appointment_id
                                WHERE vet_id = {$vet['vet_id']}";
        $stmtCountTreatments = $pdo->prepare($sqlCountTreatments);
        $stmtCountTreatments->execute();
        $countTreatments = $stmtCountTreatments->fetch(PDO::FETCH_ASSOC);



        $sqlIn = "UPDATE vet_popularity SET patient_count = {$countPatients['patients']}, treatment_count = {$countTreatments['treatments']} WHERE vet_id = {$vet['vet_id']}";
        $stmtIn = $pdo->prepare($sqlIn);
        $stmtIn->execute();
    }



}
