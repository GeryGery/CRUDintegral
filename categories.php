<?php

include_once 'php/lib.php';
include_once 'configs/config.php';

template('cat');
global $host;
global $user;
global $pass;
global $db;
$conn = mysqli_connect($host, $user, $pass, $db);
$query = mysqli_query($conn, "SELECT * FROM Category ORDER BY name ASC");
echo "<div class='middle'><button class='btn btn-primary openmodal' data-toggle='modal' data-target='#modalForm'>Add a new Category</button></div>";

if(!is_bool($query) and mysqli_num_rows($query) > 0) {
	echo "	<div class='grid-container'>
				<div class='grid-item header'>Name</div>
				<div class='grid-item header'>Edit</div>
				<div class='grid-item header'>Delete</div>";
	while($row = mysqli_fetch_assoc($query)) {
		echo "	<div class='grid-item'>
					<div class='originalName'>$row[name]</div>
					<div class='form'>
						<form id='editForm' role='form' onsubmit='submitCategoryUpdate($row[id]); return false'>
							<input type='hidden' name='id' value='$row[id]'>
							<input class='inputname $row[id]' type='text' name='name' maxlength='50' value='" . htmlspecialchars($row['name'], ENT_QUOTES) . "'>
							<button type='button' class='btn btn-default' onclick='resetEdits()'>Cancel</button>
							<button type='button' class='btn btn-success' onclick='submitCategoryUpdate($row[id])'>Save</button>
						</form>
					</div>
				</div>
				<div class='grid-item'><button class='editbtn btn btn-default'>Edit</button></div>
				<div class='grid-item'><button class='btn btn-danger openmodal' data-toggle='modal' data-target='#modalDelete'>Delete</button></div>";
	}
	echo "</div>";
}

echo "	<div class='modal fade' id='modalDelete' role='dialog'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title' id='myModalLabel'>Do you really want to delete this category?</h4>
					</div>
					<div class='modal-body'>
						<b>Category: </b><span id='target'></span>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						<button type='button' class='btn btn-danger'>Delete</button>
					</div>
				</div>
			</div>
		</div>
		<div class='modal fade' id='modalForm' role='dialog'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title' id='myModalLabel'>Create new category</h4>
					</div>
					<div class='modal-body'>
						<p id='statusMsg'></p>
						<form role='form' onsubmit='submitCategoryForm(); return false'>
							<div class='form-group'>
								<label for='name'>Name: </label>
								<input type='text' name='name' maxlength='50'>
							</div>
						</form>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						<button class='btn btn-primary submitBtn' onclick='submitCategoryForm()'>Send</button>
					</div>
				</div>
			</div>
		</div>"; 
?>