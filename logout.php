<?php
require_once 'inc/func.php';

if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_login']);
    session_destroy();
}

header("Location: index.php");
exit();
?>
