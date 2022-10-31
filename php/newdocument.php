<?php

include_once 'lib.php';
include_once '../configs/config.php';
global $host;
global $user;
global $pass;
global $db;
$conn = mysqli_connect($host, $user, $pass, $db);

$name		  	= trim($_POST['name']);
$desc		  	= trim($_POST['desc']);
$subcategory_id = trim($_POST['subcategory_id']);
if(isset($_POST['id'])) {
	$id  = trim($_POST['id']);
	if(	!empty($name) and strlen($name) >= 5 and strlen($name) <= 120) {
		if(!empty($subcategory_id) and is_numeric($subcategory_id)) {
			$query = mysqli_query($conn, "SELECT category_id FROM Subcategory WHERE id = '$subcategory_id'");
			if(is_bool($query) or mysqli_num_rows($query) == 0) {
				echo 'nonexistentsubcategory';
			} else {
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "UPDATE Document SET name = ?, description = ?, subcategory_id = ? WHERE id = ?");
				mysqli_stmt_bind_param($stmt, "ssii", $name, $desc, $subcategory_id, $id);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_errno($stmt) == '0') {
					echo 'ok';
				} else {
					echo "Error: " . mysqli_stmt_error($stmt);
				}
			}
		} else {
			echo 'subcategory_id';
		}
	} else {
		echo 'length';
	}
} else {
	if(	!empty($name) and strlen($name) >= 5 and strlen($name) <= 120) {
		if(!empty($subcategory_id) and is_numeric($subcategory_id)) {
			$query = mysqli_query($conn, "SELECT category_id FROM Subcategory WHERE id = '$subcategory_id'");
			if(is_bool($query) or mysqli_num_rows($query) == 0) {
				echo 'nonexistentsubcategory';
			} else {
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "INSERT INTO Document(name, description, subcategory_id) VALUES(?, ?, ?)");
				mysqli_stmt_bind_param($stmt, "ssi", $name, $desc, $subcategory_id);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_errno($stmt) == '0') {
					echo 'ok';
				} else {
					echo "Error: " . mysqli_stmt_error($stmt);
				}
			}
		} else {
			echo 'subcategory_id';
		}
	} else {
		echo 'length';
	}
}

die;

?>