<?php
session_start();
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
}else{
	$email = "";
}
if (isset($_SESSION['link'])) {
	$prev_link = $_SESSION['link'];
}
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = uniqid();
}
$sessionId = $_SESSION['id'];


if(!empty($_GET['session_destroy'])){
    // session_destroy();
}

?>