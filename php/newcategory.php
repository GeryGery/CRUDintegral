<?php

include_once 'lib.php';
include_once '../configs/config.php';
global $host;
global $user;
global $pass;
global $db;
$conn = mysqli_connect($host, $user, $pass, $db);

$name  = trim($_POST['name']);
if(isset($_POST['id'])) {
	$id  = trim($_POST['id']);
	if(	!empty($name) and strlen($name) >=3 and strlen($name) <=50) {
		$query = mysqli_query($conn, "SELECT id FROM Category WHERE name = '$name' AND id != '$id'");
		$query2 = mysqli_query($conn, "SELECT id FROM Category WHERE id = '$id'");
		if(!is_bool($query) and mysqli_num_rows($query) > 0) {
			echo 'notunique';
		} elseif(is_bool($query2) or mysqli_num_rows($query2) == 0) {
			echo 'nonexistent';
		} else {
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "UPDATE Category SET name = ? WHERE id = ?");
			mysqli_stmt_bind_param($stmt, "si", $name, $id);
			mysqli_stmt_execute($stmt);
			if(mysqli_stmt_errno($stmt) == '0') {
				echo 'ok';
			} else {
				echo "Error: " . mysqli_stmt_error($stmt);
			}
		}
	} else {
		echo 'length';
	}
} else {
	if(	!empty($name) and strlen($name) >=3 and strlen($name) <=50) {
		$query = mysqli_query($conn, "SELECT id FROM Category WHERE name = '$name'");
		if(!is_bool($query) and mysqli_num_rows($query) > 0) {
			echo 'notunique';
		} else {
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "INSERT INTO Category(name) VALUES(?)");
			mysqli_stmt_bind_param($stmt, "s", $name);
			mysqli_stmt_execute($stmt);
			if(mysqli_stmt_errno($stmt) == '0') {
				echo 'ok';
			} else {
				echo "Error: " . mysqli_stmt_error($stmt);
			}
		}
	} else {
		echo 'length';
	}
}

die;

?>