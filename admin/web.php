<?php
session_start();
require_once "db_config.php";
require_once "functions.php";


$referer = $_SERVER['HTTP_REFERER'];

$action = $_POST["action"];

if ($action != "" and in_array($action, $actions) and strpos($referer, SITE) !== false ) {

    switch ($action) {
        case "login":
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            if (!empty($username) and !empty($password)) {
                $data = checkUserLogin($pdo, $username, $password);

                if ($data and is_int($data['admin_id'])) {

                    $_SESSION['username'] = $username;
                    $_SESSION['admin_id'] = $data['admin_id'];
                    redirection('index.php');
                }
                else {
                    redirection('login.php?l=1');
                }
            } else {
                redirection('login.php?l=1');
            }
            break;

        case "register" :

            if (isset($_POST['phone'])) {
                $phone = trim($_POST["phone"]);
            }

            if (isset($_POST['firstname'])) {
                $firstname = trim($_POST["firstname"]);
            }

            if (isset($_POST['lastname'])) {
                $lastname = trim($_POST["lastname"]);
            }

            if (isset($_POST['password'])) {
                $password = trim($_POST["password"]);
            }

            if (isset($_POST['passwordConfirm'])) {
                $passwordConfirm = trim($_POST["passwordConfirm"]);
            }

            if (isset($_POST['email'])) {
                $email = trim($_POST["email"]);
            }
            if (isset($_POST['specialization'])) {
                $specialization = trim($_POST["specialization"]);
            }
            if (isset($_POST['office'])) {
                $office = trim($_POST["office"]);
            }
            if (isset($_POST['biography'])) {
                $biography = trim($_POST["biography"]);
            }

            if (empty($specialization)) {
                redirection('vetRegister.php?r=12');
            }
            if (empty($office)) {
                redirection('vetRegister.php?r=13');
            }
            if (empty($phone)) {
                redirection('vetRegister.php?r=7');
            }

            if (empty($firstname)) {
                redirection('vetRegister.php?r=7');
            }

            if (empty($lastname)) {
                redirection('vetRegister.php?r=7');
            }

            if (empty($password)) {
                redirection('vetRegister.php?r=9');
            }

            if (strlen($password) < 8) {
                redirection('vetRegister.php?r=10');
            }

            if (empty($passwordConfirm)) {
                redirection('vetRegister.php?r=9');
            }

            if ($password !== $passwordConfirm) {
                redirection('vetRegister.php?r=11');
            }

            if (empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirection('vetRegister.php?r=8');
            }

            if ((existsUser($pdo, $email, $email))) {
                redirection('vetRegister.php?r=2');
            }
            else {
                $result = registerUser($pdo, $email, $password, $firstname, $lastname, $phone, $specialization, $office, $biography, $_SESSION['admin_id']);
                if ($result[0] == true) {
                    newPopularity($pdo,$result[1]);
                    redirection('vetRegister.php?r=14');
                }
                else
                    redirection('vetRegister.php?r=6');
            }
            break;

        case "ban":
            if (isset($_POST['userBan'])) {
                $user_ban = $_POST["userBan"];
            }
            if (isset($_POST['userUnban'])) {
                $user_unban = $_POST["userUnban"];
            }
            if (isset($_POST['vetBan'])) {
                $vet_ban = $_POST["vetBan"];
            }
            if (isset($_POST['vetUnban'])) {
                $vet_unban = $_POST["vetUnban"];
            }

            if(!empty($user_ban))
            {
                $result = userBan($pdo,$user_ban,"users","user_id");
                if ($result == true)
                    redirection('users.php?ub=4');
                else
                    redirection('users.php?ub=6');
            }
            elseif(!empty($user_unban))
            {
                $result = userUnban($pdo,$user_unban,"users","user_id");
                if ($result == true)
                    redirection('users.php?ub=4');
                else
                    redirection('users.php?ub=6');
            }
            elseif(!empty($vet_ban))
            {
                $result = userBan($pdo,$vet_ban,"veterinarians","vet_id");
                if ($result == true)
                    redirection('users.php?ub=4');
                else
                    redirection('users.php?ub=6');
            }
            elseif(!empty($vet_unban))
            {
                $result = userUnban($pdo,$vet_unban,"veterinarians","vet_id");
                if ($result == true)
                    redirection('users.php?ub=4');
                else
                    redirection('users.php?ub=6');
            }
            else
                redirection(''.$referer.'?ub=6');

            break;


        default:
            redirection('login.php?l=1');
            break;
    }
}
else {
    redirection('login.php?l=1');
}