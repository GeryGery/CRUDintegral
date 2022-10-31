<?php

include_once 'lib.php';
include_once '../configs/config.php';
global $host;
global $user;
global $pass;
global $db;
$conn = mysqli_connect($host, $user, $pass, $db);

$name		  = trim($_POST['name']);
$category_id  = trim($_POST['category_id']);
if(isset($_POST['id'])) {
	$id  = trim($_POST['id']);
	if(	!empty($name) and strlen($name) >=3 and strlen($name) <=50) {
		$query = mysqli_query($conn, "SELECT id FROM Subcategory WHERE name = '$name' AND id != '$id'");
		$query2 = mysqli_query($conn, "SELECT id FROM Subcategory WHERE id = '$id'");
		if(!is_bool($query) and mysqli_num_rows($query) > 0) {
			echo 'notunique';
		} elseif(is_bool($query2) or mysqli_num_rows($query2) == 0) {
			echo 'nonexistent';
		} else {
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "UPDATE Subcategory SET name = ?, category_id = ? WHERE id = ?");
			mysqli_stmt_bind_param($stmt, "sii", $name, $category_id, $id);
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
		if(!empty($category_id) and is_numeric($category_id)) {
			$query = mysqli_query($conn, "SELECT id FROM Category WHERE id = '$category_id'");
			if(is_bool($query) or mysqli_num_rows($query) == 0) {
				echo 'notcategory';
			} else {
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "INSERT INTO Subcategory(name, category_id) VALUES(?, ?)");
				mysqli_stmt_bind_param($stmt, "si", $name, $category_id);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_errno($stmt) == '0') {
					echo 'ok';
				} else {
					echo "Error: " . mysqli_stmt_error($stmt);
				}
			}
		} else {
			echo 'category_id';
		}
	} else {
		echo 'length';
	}
}

die;

?>