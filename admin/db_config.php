<?php

const PARAMS = [
    "HOST" => 'localhost',
    "USER" => 'root',
    "PASS" => '',
    "DBNAME" => 'ecne',
    "CHARSET" => 'utf8mb4'
];

const SITE = 'http://localhost/epets/admin/';

$dsn = "mysql:host=" . PARAMS['HOST'] . ";dbname=" . PARAMS['DBNAME'] . ";charset=" . PARAMS['CHARSET'];

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

$actions = ['login','ban','register'];

$messages = [
    0 => 'No direct access!',
    1 => 'Unknown user!',
    2 => 'User with this e-mail already exists, choose another one!',
    3 => 'You are logged out!',
    4 => 'Updated!',
    5 => 'No data',
    6 => 'Error!',
    7 => 'Fill all the fields!',
    8 => 'Format of e-mail address is not valid!',
    9 => 'Password can not be empty!',
    10 => 'Password is not long enough! (min 8 characters)',
    11 => 'Passwords are not equal!',
    12 => 'Select a specialization!',
    13 => 'Select an office!',
    14 => 'Registered successfully!'
];

