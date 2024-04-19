<?php
session_start();
ob_start();

unset($_SESSION['member_bdid']);
unset($_SESSION['member_id']);

header("Location: ../index.php");
