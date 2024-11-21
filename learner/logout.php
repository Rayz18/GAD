<?php
session_start();
session_unset();
session_destroy();
header('Location: /GAD-1/Home.php'); // Redirect to the login page after logout
exit;