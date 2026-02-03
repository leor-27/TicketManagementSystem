<?php
session_start();
include 'backend/db.php';

session_unset();
session_destroy();

/* references the loggedOut status declared in index.php which alerts a message to the user */
header("Location: ../index.php?status=loggedOut");
exit;