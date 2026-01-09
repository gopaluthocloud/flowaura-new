<?php
/**
 * Authentication Check Include
 * Include this file at the top of protected pages
 * 
 * Usage: include 'includes/auth-check.php';
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

// Optional: Check session timeout (30 minutes)
$session_timeout = 30 * 60; // 30 minutes in seconds

if (isset($_SESSION['last_activity'])) {
    $inactive_time = time() - $_SESSION['last_activity'];
    
    if ($inactive_time > $session_timeout) {
        // Session expired
        session_unset();
        session_destroy();
        header('Location: login.php?expired=1');
        exit();
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Get current user info
$current_user = [
    'id' => $_SESSION['user_id'] ?? null,
    'username' => $_SESSION['username'] ?? null,
    'full_name' => $_SESSION['full_name'] ?? null,
    'role' => $_SESSION['role'] ?? null
];
?>
