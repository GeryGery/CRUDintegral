<?php

include_once 'php/lib.php';
include_once 'configs/config.php';

template('sub');
global $host;
global $user;
global $pass;
global $db;
$conn = mysqli_connect($host, $user, $pass, $db);
$query = mysqli_query($conn, "SELECT Subcategory.id as sub_id, Subcategory.name as sub_name, Subcategory.category_id, Category.name as cat_name FROM Subcategory LEFT JOIN Category ON Subcategory.category_id=Category.id ORDER BY cat_name ASC, sub_name ASC");
echo "<div class='middle'><button class='btn btn-primary openmodal' data-toggle='modal' data-target='#modalForm'>Add a new Subcategory</button></div>";

if(!is_bool($query) and mysqli_num_rows($query) > 0) {
	echo "	<div class='grid-container'>
				<div class='grid-item header'>Name</div>
				<div class='grid-item header'>Category</div>
				<div class='grid-item header'>Edit</div>
				<div class='grid-item header'>Delete</div>";
	while($row = mysqli_fetch_assoc($query)) {
		echo "	<div class='grid-item'>
					<div class='originalName'>$row[sub_name]</div>
					<div class='form'>
						<form class='editForm' role='form' onsubmit='submitSubcategoryUpdate($row[sub_id]); return false'>
							<input type='hidden' name='id' value='$row[sub_id]'>
							<input class='inputname $row[sub_id]' type='text' name='name' maxlength='50' value='" . htmlspecialchars($row['sub_name'], ENT_QUOTES) . "'>
						</form>
					</div>
				</div>
				<div class='grid-item'>
					<div class='originalCatName'>$row[cat_name]</div>
					<div class='Catform'>
						<form class='editForm' role='form' onsubmit='submitSubcategoryUpdate($row[sub_id]); return false'>
							<input type='hidden' name='id' value='$row[cat_name]'>
							<input type='hidden' value='$row[category_id]'>
							<select name='category_id' class='selectcat $row[sub_id]'>
								<option value=''></option>";
					$querycat = mysqli_query($conn, "SELECT * FROM Category");
					if(!is_bool($querycat) and mysqli_num_rows($querycat) > 0) {
						while($cat = mysqli_fetch_assoc($querycat)) {
							echo "<option value='$cat[id]'";
							if($cat['id'] == $row['category_id'])
								echo " selected ";
							echo ">".htmlspecialchars($cat['name'], ENT_QUOTES)."</option>";
						}
					}
					echo "	</select>
							<button type='button' class='btn btn-default' onclick='resetEdits()'>Cancel</button>
							<button type='button' class='btn btn-success' onclick='submitSubcategoryUpdate($row[sub_id])'>Save</button>
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
						<h4 class='modal-title' id='myModalLabel'>Do you really want to delete this Subcategory?</h4>
					</div>
					<div class='modal-body'>
						<p><b>Subcategory: </b><span id='target'></span></p>
						<p><b>Category: </b><span id='target2'></span></p>
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
						<h4 class='modal-title' id='myModalLabel'>Create new Subcategory</h4>
					</div>
					<div class='modal-body'>
						<p id='statusMsg'></p>
						<form role='form' onsubmit='submitSubcategoryForm(); return false'>
							<div class='form-group'>
								<label for='name'>Name: </label>
								<input type='text' name='name' maxlength='50'>
							</div>
							<div class='form-group'>
								<label for='name'>Category: </label>
								<select name='category_id'>
									<option value=''></option>";
						$querycat = mysqli_query($conn, "SELECT * FROM Category");
						if(!is_bool($querycat) and mysqli_num_rows($querycat) > 0) {
							while($row = mysqli_fetch_assoc($querycat)) {
								echo "<option value='$row[id]'>".htmlspecialchars($row['name'], ENT_QUOTES)."</option>";
							}
						}
						echo 	"</select>
							</div>
						</form>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						<button class='btn btn-primary submitBtn' onclick='submitSubcategoryForm()'>Send</button>
					</div>
				</div>
			</div>
		</div>"; 
?>