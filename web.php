<?php
session_start();
require_once "db_config.php";
require_once "functions.php";

require __DIR__ . '/vendor/autoload.php';
use Detection\MobileDetect;

$password = "";
$passwordConfirm = "";
$firstname = "";
$lastname = "";
$email = "";
$phone="";
$usertype="";

$biography="";

$action = "";

$referer = $_SERVER['HTTP_REFERER'];


$action = $_POST["action"];

if ($action != "" and in_array($action, $actions) and strpos($referer, SITE) !== false ) {


    switch ($action) {
        case "login":
            $_SESSION['usertype'] = $usertype;
            $_SESSION['firstname'] = '';
            $_SESSION['lastname'] = '';

            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            if (!empty($username) and !empty($password)) {
                $data = checkUserLogin($pdo, $username, $password);

                if ($data and is_int($data['user_id'])) {
                    $_SESSION['usertype'] = 'user';
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION['firstname'] = $data['firstname'];
                    $_SESSION['lastname'] = $data['lastname'];
                    $_SESSION['phone'] = $data['phone'];

                    $detect = new MobileDetect();
                    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
                    $ipAddress = getIpAddress();
                    $country = "";
                    $city = "";
                    $proxy = false;

                    $userAgent = $_SERVER['HTTP_USER_AGENT'];

                    $urlApi = "http://ip-api.com/json/$ipAddress?fields=$apiFields";
                    $apiResponse = getCurlData($urlApi);

                    $apiData = json_decode($apiResponse, true);

                    if (isset($apiData['country']))
                        $country = $apiData['country'];

                    if (isset($apiData['city']))
                        $city = $apiData['city'];

                    if (isset($apiData['proxy']))
                        $proxy = $apiData['proxy'];

                    insertIntoLog($pdo,$_SESSION['user_id'], $userAgent, $ipAddress, $deviceType, $country, $city,$proxy);



                    redirection('index.php');
                }
                else if ($data and is_int($data['vet_id'])) {
                    $_SESSION['usertype'] = 'vet';
                    $_SESSION['username'] = $username;
                    $_SESSION['vet_id'] = $data['vet_id'];
                    $_SESSION['firstname'] = $data['firstname'];
                    $_SESSION['lastname'] = $data['lastname'];
                    $_SESSION['phone'] = $data['phone'];
                    $_SESSION['biography'] = $data['biography'];
                    $_SESSION['specialization_id'] = $data['specialization_id'];
                    $_SESSION['vet_office_id'] = $data['vet_office_id'];
                    redirection('index.php');
                }

                else {
                    redirection('signIn.php?l=1');
                }

            } else {
                redirection('signIn.php?l=1');
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

            if (empty($phone)) {
                redirection('register.php?r=4');
            }

            if (empty($firstname)) {
                redirection('register.php?r=4');
            }

            if (empty($lastname)) {
                redirection('register.php?r=4');
            }

            if (empty($password)) {
                redirection('register.php?r=9');
            }

            if (strlen($password) < 8) {
                redirection('register.php?r=10');
            }

            if (empty($passwordConfirm)) {
                redirection('register.php?r=9');
            }

            if ($password !== $passwordConfirm) {
                redirection('register.php?r=7');
            }

            if (empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirection('register.php?r=8');
            }


                //Making sure that the e-mail is not taken
                if ((!existsUser($pdo, $email,$email))) {
                    $token = createToken(20);
                    if ($token) {
                        $id_user = registerUser($pdo, $password, $firstname, $lastname, $email, $token,$phone);
                        try {
                            $body = "Your username is $email. To activate your account click on the <a href=" . SITE . "active.php?token=$token   >link</a>";
                            sendEmail($pdo, $email, $emailMessages['register'], $body, $id_user);
                            redirection("register_authentication.php?r=3");
                        } catch (Exception $e) {
                            error_log("****************************************");
                            error_log($e->getMessage());
                            error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                            redirection("register_authentication.php?r=11");
                        }
                    }
                } else {
                    redirection('register.php?r=2');
                }


            break;


        case "forget" :
            $email = trim($_POST["email"]);
            if (!empty($email) and getUserData($pdo, 'user_id', 'email', $email)) {
                $token = createToken(20);
                if ($token) {
                    setForgottenToken($pdo, 'users', $email, $token);
                    $id_user = getUserData($pdo, 'user_id', 'email', $email);
                    try {
                        $body = "To start the process of changing password, visit <a href=" . SITE . "forget.php?token=$token>link</a>.";
                        sendEmail($pdo, $email, $emailMessages['forget'], $body, $id_user);
                        redirection('forgotPassword.php?f=13');
                    } catch (Exception $e) {
                        error_log("****************************************");
                        error_log($e->getMessage());
                        error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                        redirection("forgotPassword.php?f=11");
                    }
                } else {
                    redirection('forgotPassword.php?f=14');
                }
            }

            else {
                redirection('forgotPassword.php?f=13');
            }
            break;

        case "petRegister" :

            $isValid = true;

            if (isset($_POST['name'])) {
                $name = trim($_POST["name"]);
            }

            if (isset($_POST['age'])) {
                $age = trim($_POST["age"]);
            }

            if (isset($_POST['gender'])) {
                $gender = trim($_POST["gender"]);
            }

            if (isset($_POST['breed'])) {
                $breed = trim($_POST["breed"]);
            }
            if (isset($_POST['vet'])) {
                $vet = trim($_POST["vet"]);
            }
            if (isset($_POST['other'])) {
                $other = trim($_POST["other"]);
            }


            if (empty($name)) {
                $isValid = false;
                redirection('pet_register.php?r=4');
            }
            if (empty($age)) {
                $isValid = false;
                redirection('pet_register.php?r=4');
            }
            if ($age < 0 || $age>200) {
                $isValid = false;
                redirection('pet_register.php?r=20');
            }
            if (empty($gender)) {
                $isValid = false;
                redirection('pet_register.php?r=21');
            }
            if (empty($breed)) {
                $isValid = false;
                redirection('pet_register.php?r=18');
            }
            if (empty($vet)) {
                $isValid = false;
                redirection('pet_register.php?r=19');
            }

            if(!$isValid)
            {
                redirection('pet_register.php?r=28');
            }
            else {
                $result = registerPet($pdo, $_SESSION['user_id'],$name, $breed, $vet, $age, $gender, $other);
                if ($result== true) {
                    redirection('pet_register.php?r=27');
                }
                else
                    redirection('pet_register.php?r=23');
            }
            break;

        case "petEdit" :

            $isValid = true;

            if (isset($_POST['pet_id'])) {
                $pet_id = trim($_POST["pet_id"]);
            }

            if (isset($_POST['name'])) {
                $name = trim($_POST["name"]);
            }

            if (isset($_POST['age'])) {
                $age = trim($_POST["age"]);
            }

            if (isset($_POST['gender'])) {
                $gender = trim($_POST["gender"]);
            }

            if (isset($_POST['breed'])) {
                $breed = trim($_POST["breed"]);
            }
            if (isset($_POST['vet'])) {
                $vet = trim($_POST["vet"]);
            }
            if (isset($_POST['other'])) {
                $other = trim($_POST["other"]);
            }

            if (empty($pet_id)) {
                $isValid = false;
                redirection('edit_pet.php?r=25');
            }
            if (empty($name)) {
                $isValid = false;
                redirection('edit_pet.php?r=4');
            }
            if (empty($age)) {
                $isValid = false;
                redirection('edit_pet.php?r=4');
            }
            if ($age < 0 || $age>200) {
                $isValid = false;
                redirection('edit_pet.php?r=20');
            }
            if (empty($gender)) {
                $isValid = false;
                redirection('edit_pet.php?r=21');
            }
            if (empty($breed)) {
                $isValid = false;
                redirection('edit_pet.php?r=18');
            }
            if (empty($vet)) {
                $isValid = false;
                redirection('edit_pet.php?r=19');
            }

            if(!$isValid)
            {
                redirection('edit_pet.php?r=28');
            }
            else {
                $result = editPet($pdo,$pet_id, $_SESSION['user_id'],$name, $breed, $vet, $age, $gender, $other);
                if ($result== true) {
                    redirection('my_pets.php?r=24');
                }
                else
                    redirection('my_pets.php?r=23');
            }
            break;

        case "createApp" :
            $date="";
            $vet_id="";
            $title="";
            if (isset($_POST['date'])) {
                $date = $_POST["date"];
            }
            if (isset($_SESSION['vet_id'])) {
                $vet_id = $_SESSION["vet_id"];
            }
            if (isset($_POST['title'])) {
                $title = trim($_POST["title"]);
            }


            if($date != null && $title != null)
            {
                $result = createAppointments($pdo,$date,$vet_id,$title);
                if ($result== true) {
                    redirection('create_appointment.php?r=26');
                }
                else
                    redirection('create_appointment.php?r=23');
            }
            else
                redirection('create_appointment.php?r=23');

            break;

        case "appointmentStatus":
            if (isset($_POST['cancelApp'])) {
                $cancelApp = $_POST["cancelApp"];
            }
            if (isset($_POST['reopenApp'])) {
                $reopenApp = $_POST["reopenApp"];
            }


            if(!empty($cancelApp))
            {
                $result = cancelApp($pdo,$cancelApp);
                if ($result == true)
                    redirection('create_appointment.php?r=31');
                else
                    redirection('create_appointment.php?r=23');
            }
            elseif(!empty($reopenApp))
            {
                $result = reopenApp($pdo,$reopenApp);
                if ($result == true)
                    redirection('create_appointment.php?r=31');
                else
                    redirection('create_appointment.php?r=23');
            }
            else
                redirection('create_appointment.php?r=23');

            break;

        case "reservedappointmentStatus":
            if (isset($_POST['finish'])) {
                $finish = $_POST["finish"];
            }

            if(!empty($finish))
            {
                $result = finishApp($pdo,$finish);
                if ($result == true) {
                    $_SESSION['finish'] = $finish;
                    redirection('treatment_form.php');
                }
                else
                    redirection('create_appointment.php?r=23');
            }
            else
                redirection('create_appointment.php?r=23');

            break;

        case "treatmentSave":
            $description="";
            if (isset($_POST['title'])) {
                $title = $_POST["title"];
            }
            if (isset($_POST['medicine'])) {
                $medicine = $_POST["medicine"];
            }
            if (isset($_POST['description'])) {
                $description = $_POST["description"];
            }
            if (isset($_POST['reserved_appointment_id'])) {
                $reserved_appointment_id = $_POST["reserved_appointment_id"];
            }
            if (empty($title)) {
                redirection('treatment_form.php?r=4');
            }
            if (empty($medicine)) {
                redirection('treatment_form.php?r=4');
            }

            if(!empty($title && $medicine && $reserved_appointment_id))
            {
                $result = insertTreatment($pdo,$reserved_appointment_id,$title,$medicine,$description);
                if ($result == true) {
                    redirection('treatment_form.php?r=27');
                }
                else
                    redirection('treatment_form.php?r=23');
            }
            else
                redirection('treatment_form.php?r=23');

            break;


        default:
            redirection('signIn.php?l=1');
            break;


    }

} else {
    redirection('signIn.php?l=1');
}
