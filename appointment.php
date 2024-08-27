<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';
if(!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    redirection('signIn.php?l=0');
}

if(isset($_POST['pet']) && !empty($_POST['pet'])) {
    $sql = "Select vet_id FROM pets WHERE pet_id = {$_POST['pet']}";
    $query = $pdo->prepare($sql);
    $query->execute();
    $vet = $query->fetch(PDO::FETCH_ASSOC);

    if ($vet) {
        $vetid = $vet['vet_id'];

        $sqlApp = "SELECT   a.appointment_id AS id, 
                            a.title, 
                            a.date, 
                            a.is_available,
                            (SELECT COUNT(reserved_appointment_id) 
                             FROM reserved_appointments 
                             WHERE appointment_id = a.appointment_id) AS is_reserved,
                            u.user_id AS reserved_by
                        FROM appointments a
                        LEFT JOIN reserved_appointments ra ON a.appointment_id = ra.appointment_id
                        LEFT JOIN pets p ON ra.pet_id = p.pet_id
                        LEFT JOIN users u ON p.user_id = u.user_id
                        WHERE a.vet_id = :vet_id AND a.date > NOW() AND a.is_available = 1 AND (ra.is_finished = 0 OR ra.is_finished IS NULL)";
        $queryApp = $pdo->prepare($sqlApp);
        $queryApp->bindParam(':vet_id', $vetid, PDO::PARAM_INT);
        $queryApp->execute();
        $apps = $queryApp->fetchAll(PDO::FETCH_ASSOC);

        error_log(print_r($apps, true));
    } else {
        $apps = [];
    }


    $eventsJson = json_encode($apps);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Appointments</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var userHasReservation = false;
            var petId = <?php echo json_encode($_POST['pet']); ?>;
            var currentUserId = <?php echo json_encode($_SESSION['user_id']); ?>;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                firstDay:1,
                defaultTimedEventDuration: '00:30',
                events: <?php echo $eventsJson; ?>,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventDidMount: function(info) {
                    if (info.event.extendedProps.is_reserved) {
                        if (info.event.extendedProps.reserved_by === currentUserId) {

                            info.el.style.backgroundColor = 'orange';
                            info.el.style.borderColor = 'orange';
                            userHasReservation = true;
                        } else {

                            info.el.style.backgroundColor = 'red';
                            info.el.style.borderColor = 'red';
                        }
                    }
                },
                eventClick: function(info) {
                    console.log('Event ID:', info.event.id);

                    if (info.event.extendedProps.is_reserved && info.event.extendedProps.reserved_by === currentUserId) {
                        var confirmCancellation = confirm('Do you want to cancel this appointment at ' + info.event.title + '?');
                        if (confirmCancellation) {
                            info.el.style.backgroundColor = '';
                            info.el.style.borderColor = '';
                            info.event.setProp('classNames', ['rerender']);
                            alert('Appointment cancelled at ' + info.event.title);
                            userHasReservation = false;

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'cancel_reservation.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    var response = JSON.parse(xhr.responseText);
                                    if (xhr.status === 200 && response.status === 'success') {
                                        console.log('Reservation cancelled successfully');
                                        info.event.setExtendedProp('is_reserved', false);
                                        info.event.setExtendedProp('reserved_by', null);
                                    } else {
                                        console.error('Error cancelling reservation:', response.message);
                                    }
                                }
                            };
                            var data = JSON.stringify({ appointment_id: info.event.id, pet_id: petId });
                            xhr.send(data);

                        }
                    } else if (!info.event.extendedProps.is_reserved) {
                        if (userHasReservation) {
                            alert('You already have a reserved appointment. Please cancel it before reserving a new one.');
                        } else {
                            var confirmReservation = confirm('Do you want to reserve an appointment at ' + info.event.title + '?');
                            if (confirmReservation) {
                                info.el.style.backgroundColor = 'orange';
                                info.el.style.borderColor = 'orange';
                                info.event.setProp('classNames', ['rerender']);
                                alert('Appointment reserved at ' + info.event.title);
                                userHasReservation = true;

                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', 'reserve_appointment.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4) {
                                        var response = JSON.parse(xhr.responseText);
                                        if (xhr.status === 200 && response.status === 'success') {
                                            console.log('Appointment reserved successfully');
                                            info.event.setExtendedProp('is_reserved', true);
                                            info.event.setExtendedProp('reserved_by', currentUserId);
                                        } else {
                                            console.error('Error reserving appointment:', response.message);
                                        }
                                    }
                                };
                                var data = JSON.stringify({ appointment_id: info.event.id, pet_id: petId });
                                xhr.send(data);

                            }
                        }
                    } else {
                        alert('This appointment is already reserved by another user.');
                    }
                }
            });

            calendar.render();
        });

    </script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-Pets</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="vets.php">Veterinarians</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
                <?php
                if (!isset($_SESSION['username'])) {
                    echo'
                <li class="nav-item"><a class="nav-link" href="signIn.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Registration</a></li>
                    ';
                }else if(isset($_SESSION['user_id'])){
                    echo '
                    <li class="nav-item"><a class="nav-link active" aria-current="page"  href="appointment.php">Appointments</a></li>                 
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="editprofile.php">Edit profile</a>
                        <a class="dropdown-item" href="my_pets.php">My pets</a>
                   <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Log out</a>
                            </div>
                        </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container d-flex justify-content-center align-items-center px-4 px-lg-5 mt-5 mb-5">
    <div class="col-3">
        <form action="appointment.php" method="post">
        <label for="pet" class="label">Select your pet</label>
        <select name="pet" id="pet" class="form-select">
            <option value="" hidden>Choose</option>

            <?php
            $sql = 'SELECT pet_id,name FROM pets WHERE user_id ='. $_SESSION['user_id'].' AND deleted_at IS NULL';
            $query = $pdo->prepare($sql);
            $query->execute();
            $pets = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($pets as $pet) {
                $petId= $pet['pet_id'];
                $petName = $pet['name'];
                ?>
                <option value="<?php echo $petId; ?>"><?php echo $petName; ?></option>
                <?php
            }
            ?>
        </select>
            <button class="btn btn--radius-2 btn-success" type="submit">Show appointments</button>
        </form>
    </div>
</div>

<div class="container px-4 px-lg-5 mb-5">
    <div id='calendar'></div>
</div>



<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>