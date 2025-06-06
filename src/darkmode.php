<?php
session_start();

// Toggle dark mode if requested
if (isset($_GET['toggle'])) {
    $_SESSION['darkmode'] = !isset($_SESSION['darkmode']) || !$_SESSION['darkmode'];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// Function to check dark mode status
function isDarkMode()
{
    return isset($_SESSION['darkmode']) && $_SESSION['darkmode'];
}
