<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$_POST = [
    'name' => 'Roy Dziyjanani',
    'email' => 'roydziyjanani8@gmail.com',
    'password' => '12345678',
    'confirm_password' => '12345678',
    'phone' => '+265885348937',
    'location' => 'Blantyre',
    'role' => 'provider'
];

include 'api/register.php';