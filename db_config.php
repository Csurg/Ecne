<?php

const PARAMS = [
    "HOST" => 'localhost',
    "USER" => 'root',
    "PASS" => '',
    "DBNAME" => 'ecne',
    "CHARSET" => 'utf8mb4'
];

const SITE = 'http://localhost/epets/';
const URL = "http://localhost/epets/qrCodes.php";

$dsn = "mysql:host=" . PARAMS['HOST'] . ";dbname=" . PARAMS['DBNAME'] . ";charset=" . PARAMS['CHARSET'];

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

$actions = ['login', 'register', 'forget','petRegister','petEdit','createApp','appointmentStatus','reservedappointmentStatus','treatmentSave'];

$messages = [
    0 => 'No direct access!',
    1 => 'Unknown user!',
    2 => 'User with this e-mail already exists, choose another one!',//
    3 => 'Check your email to activate your account!',
    4 => 'Fill all the fields!',//
    5 => 'You are logged out!!',
    6 => 'Your account is activated, you can login now!',
    7 => 'Passwords are not equal!',//
    8 => 'Format of e-mail address is not valid!',//
    9 => 'Password can not be empty!',//
    10 => 'Password is not long enough! (min 8 characters)',//
    11 => 'Something went wrong with mail server. We will try to send email later!',
    12 => 'Your account is already activated!',
    13 => 'If you have an account on our site an email with instructions is sent to you.',
    14 => 'Something went wrong with server.',
    15 => 'Token or other data is invalid!',
    16 => 'Your new password is set and you can login.',
    17 => 'Please enter your phone number',
    18 => 'Select a breed!',
    19 => 'Select a veterinarian!',
    20 => 'Enter a real age!',
    21 => 'Select a gender!',
    22 => 'Logged in successfully',
    23 => 'Error',
    24 => 'Successfully edited your pets data!',
    25 => 'Pet ID is empty!',
    26 => 'Successfully created appointments!',
    27 => 'Success!',
    28 => 'Something went wrong',
    29 => 'Something went wrong. Please contact our support.',
    30 => 'Fill at least one field!',
    31 => 'Successfully updated your data!',
];

$apiFields = "country,city,proxy,lat,lon";

$emailMessages = [
    'register' => [
        'subject' => 'Register on E-Pets',
        'altBody' => 'This is the body in plain text for non-HTML mail clients'
    ],
    'forget' => [
        'subject' => 'Forgotten password - create new password',
        'altBody' => 'This is the body in plain text for non-HTML mail clients'
    ],
    'lost' => [
    'subject' => 'Someone found your pet!',
    'altBody' => 'This is the body in plain text for non-HTML mail clients'
    ]
];
