<?php
require_once 'config.php';
$GLOBALS['pdo'] = connectDatabase($dsn, $pdoOptions);


function connectDatabase(string $dsn, array $pdoOptions): PDO
{

    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}

function checkUserLogin(string $email, string $enteredPassword): array|false
{
    $sqlUser = "SELECT user_id, user_password FROM users WHERE email=:email AND active=1 AND is_banned = 0 LIMIT 0,1";

    $stmtUser = $GLOBALS['pdo']->prepare($sqlUser);
    $stmtUser->bindParam(':email', $email, PDO::PARAM_STR);

    $loginData = [];

    $stmtUser->execute();


    if ($stmtUser->rowCount() > 0) {
        $result = $stmtUser->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }

    if ($stmtUser->rowCount() > 0) {

        $registeredPassword = $result['user_password'];

        if (password_verify($enteredPassword, $registeredPassword)) {
            $loginData['user_id'] = $result['user_id'];
        }
    }

    return $loginData;
}

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

function getPets(array $fields,int $user_id): array|bool
{
    $fieldsDb = implode(',', $fields);
    $sql = "SELECT $fieldsDb FROM pets WHERE user_id = :user_id AND deleted_at IS NULL ORDER BY name";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPetData(int $petid): array|bool
{
    $sql = "Select p.pet_id,p.name AS petname,b.name as breed,CONCAT(v.firstname,' ',v.lastname) AS vetname,p.age,p.gender,p.other  FROM pets p
            INNER JOIN breeds b ON p.breed_id = b.breed_id
            INNER JOIN veterinarians v ON p.vet_id = v.vet_id
            WHERE pet_id = :pet_id";

    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->bindValue(':pet_id', $petid, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deletePet(int $petid): bool
{
    $sql = "UPDATE pets SET deleted_at = NOW() WHERE pet_id = :pet_id";

    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->bindValue(':pet_id', $petid, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $result = $stmt->fetchColumn();
        return $result === 'true';
    }

    return false;
}

function editPet(int $petid,string $name,int $age,string $other): bool
{
    $sql = "UPDATE pets SET name = :name, age = :age, other = :other, updated_at = NOW() WHERE pet_id = :pet_id";

    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->bindValue(':pet_id', $petid, PDO::PARAM_STR);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':age', $age, PDO::PARAM_STR);
    $stmt->bindValue(':other', $other, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $result = $stmt->fetchColumn();
        return $result === 'true';
    }

    return false;
}
function getBreeds(): array|bool
{

    $sql = "SELECT breed_id,name as breed FROM breeds";
    $stmt = $GLOBALS['pdo']->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getVets(): array|bool
{

    $sql = "SELECT vet_id,CONCAT(firstname,' ',lastname) as vetname FROM veterinarians";
    $stmt = $GLOBALS['pdo']->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertPet(int $user, string $name, int $breed, int $vet,int $age,string $gender,string $other): bool
{

    $sql = "INSERT INTO pets(user_id,name,breed_id,vet_id,age,gender,other,lost)
            VALUES (:user, :name, :breed, :vet, :age, :gender, :other ,0)";
    $stmt = $GLOBALS['pdo']->prepare($sql);
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