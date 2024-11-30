<?php
ob_start();
session_start();

if (!isset($_SESSION['email'])){
	header('location:../login');
}
if(!empty($_SESSION['email'])){
	$email = $_SESSION['email'];
	if(!empty($email)){
		if (isset($_SESSION['email'])) {
			$status_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
			$status_fetch = mysqli_fetch_array($status_query);
			$status = $status_fetch['status'];
			if ($status == "0") {
				// header('location:../verify_page');
			}
		}
	}
}
?>