<?php

include_once 'php/lib.php';
include_once 'configs/config.php';

template('doc');
global $host;
global $user;
global $pass;
global $db;
$conn = mysqli_connect($host, $user, $pass, $db);

if(isset($_POST['doc_id'])) {
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, "UPDATE Document SET del = 1 WHERE id = ?");
	mysqli_stmt_bind_param($stmt, "i", $_POST['doc_id']);
	mysqli_stmt_execute($stmt);
}


$query = mysqli_query($conn, "	SELECT
									Document.id as doc_id, Document.name as doc_name, description, Category.id as cat_id, Category.name as cat_name, Subcategory.id as sub_id, Subcategory.name as sub_name
								FROM
									Document LEFT JOIN Subcategory ON Document.subcategory_id = Subcategory.id LEFT JOIN Category ON Subcategory.category_id = Category.id
								WHERE
									del = 0
								ORDER BY
									cat_name asc, sub_name asc, doc_name asc");
echo "<div class='middle'><button class='btn btn-primary openmodal' data-toggle='modal' data-target='#modalForm'>Add a new Document</button></div>";

if(!is_bool($query) and mysqli_num_rows($query) > 0) {
	echo "	<div class='grid-container'>
				<div class='grid-item header'>Name</div>
				<div class='grid-item header'>Description</div>
				<div class='grid-item header'>Category</div>
				<div class='grid-item header'>Subcategory</div>
				<div class='grid-item header'>Edit</div>
				<div class='grid-item header'>Delete</div>";
	while($row = mysqli_fetch_assoc($query)) {
		echo "	<div class='grid-item'>
					<div class='originalName'>$row[doc_name]</div>
					<div class='form'>
						<form class='editForm' role='form' onsubmit='submitDocumentUpdate($row[doc_id]); return false'>
							<input type='hidden' name='id' value='$row[doc_id]'>
							<input class='inputname $row[doc_id]' type='text' name='name' maxlength='50' value='" . htmlspecialchars($row['sub_name'], ENT_QUOTES) . "'>
						</form>
					</div>
				</div>
				<div class='grid-item'>
					<div class='originalDesc'>$row[description]</div>
					<div class='descform'>
						<form class='editForm' role='form' onsubmit='submitDocumentUpdate($row[doc_id]); return false'>
							<input type='hidden' name='id' value='$row[doc_id]'>
							<textarea class='inputdesc $row[doc_id]' name='desc' maxlength='50'>" . htmlspecialchars($row['description'], ENT_QUOTES) . "</textarea>
						</form>
					</div>
				</div>
				<div class='grid-item'>
					<div class='originalCatName'>$row[cat_name]</div>
					<div class='Catform'>
						<form class='editForm' role='form' onsubmit='submitDocumentUpdate($row[doc_id]); return false'>
							<input type='hidden' name='id' value='$row[cat_name]'>
							<input type='hidden' value='$row[cat_id]'>
							<select name='category_id' class='selectcat $row[doc_id]'>
								<option value=''></option>";
					$querycat = mysqli_query($conn, "SELECT * FROM Category");
					if(!is_bool($querycat) and mysqli_num_rows($querycat) > 0) {
						while($cat = mysqli_fetch_assoc($querycat)) {
							echo "<option value='$cat[id]'";
							if($cat['id'] == $row['cat_id'])
								echo " selected ";
							echo ">".htmlspecialchars($cat['name'], ENT_QUOTES)."</option>";
						}
					}
					echo "	</select>
						</form>
					</div>
				</div>
				<div class='grid-item'>
					<div class='originalSubName'>$row[sub_name]</div>
					<div class='Subform'>
						<form class='editForm' role='form' onsubmit='submitDocumentUpdate($row[doc_id]); return false'>
							<input type='hidden' name='id' value='$row[cat_name]'>
							<input type='hidden' value='$row[sub_id]'>
							<select name='category_id' class='selectsub $row[doc_id]'>
								<option value=''></option>";
					$querycat = mysqli_query($conn, "SELECT * FROM Subcategory");
					if(!is_bool($querycat) and mysqli_num_rows($querycat) > 0) {
						while($sub = mysqli_fetch_assoc($querycat)) {
							echo "<option class='$sub[category_id]' value='$sub[id]'";
							if($sub['id'] == $row['doc_id'])
								echo " selected ";
							echo ">".htmlspecialchars($sub['name'], ENT_QUOTES)."</option>";
						}
					}
					echo "	</select>
							<button type='button' class='btn btn-default' onclick='resetEdits()'>Cancel</button>
							<button type='button' class='btn btn-success' onclick='submitDocumentUpdate($row[doc_id])'>Save</button>
						</form>
					</div>
				</div>
				<div class='grid-item'><button class='editbtn btn btn-default'>Edit</button></div>
				<div class='grid-item'><button class='$row[doc_id] btn btn-danger openmodal' data-toggle='modal' data-target='#modalDelete'>Delete</button></div>";
	}
	echo "</div>";
}

echo "	<div class='modal fade' id='modalDelete' role='dialog'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title' id='myModalLabel'>Do you really want to delete this Document?</h4>
					</div>
					<div class='modal-body'>
						<p><b>Document: </b><span id='target'></span></p>
						<p><b>Description: </b><span id='target2'></span></p>
						<p><b>Category: </b><span id='target3'></span></p>
						<p><b>Subcategory: </b><span id='target4'></span></p>
					</div>
					<div class='modal-footer'>
						<form id='delForm' role='form' action='' method='POST'>
							<input type='hidden' name='doc_id' value=''>
							<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
							<button type='submit' class='btn btn-danger'>Delete</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class='modal fade' id='modalForm' role='dialog'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h4 class='modal-title' id='myModalLabel'>Create new Document</h4>
					</div>
					<div class='modal-body'>
						<p id='statusMsg'></p>
						<form role='form' onsubmit='submitDocumentForm(); return false'>
							<div class='form-group'>
								<label for='name'>Name: </label>
								<input type='text' name='name' maxlength='120'>
							</div>
							<div class='form-group'>
								<label for='desc'>Description: </label>
								<textarea name='desc' maxlength='520'></textarea>
							</div>
							<div class='form-group'>
								<label for='category_id'>Category: </label>
								<select name='category_id'>
									<option value=''></option>";
						$querycat = mysqli_query($conn, "SELECT * FROM Category ORDER BY name");
						if(!is_bool($querycat) and mysqli_num_rows($querycat) > 0) {
							while($row = mysqli_fetch_assoc($querycat)) {
								echo "<option value='$row[id]'>".htmlspecialchars($row['name'], ENT_QUOTES)."</option>";
							}
						}
						echo 	"</select>
							</div>
							<div class='form-group'>
								<label for='subcategory_id'>Subcategory: </label>
								<select name='subcategory_id'>
									<option value=''></option>";
						$querycat = mysqli_query($conn, "SELECT * FROM Subcategory ORDER BY name");
						if(!is_bool($querycat) and mysqli_num_rows($querycat) > 0) {
							while($row = mysqli_fetch_assoc($querycat)) {
								echo "<option class='$row[category_id]' value='$row[id]'>".htmlspecialchars($row['name'], ENT_QUOTES)."</option>";
							}
						}
						echo 	"</select>
							</div>
						</form>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						<button class='btn btn-primary submitBtn' onclick='submitDocumentForm()'>Send</button>
					</div>
				</div>
			</div>
		</div>"; 
?>