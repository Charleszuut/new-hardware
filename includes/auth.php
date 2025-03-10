<?php
// includes/auth.php

session_start();
require_once __DIR__ . '/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user']) && !isset($_SESSION['customer'])) {
    header('Location: login.php');
    exit();
}

// Check if the user is an admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
}

// Check if the user is an employee
function isEmployee() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'employee';
}
?>
