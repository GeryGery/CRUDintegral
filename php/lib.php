<?php

function template($where = 'index') {
	echo "
		<!doctype html>
		<html lang='en'>
			<head>
				<meta charset='utf-8'>
				<meta name='viewport' content='height=device-height, width=device-width, initial-scale=1'>
				<title>Grupo Integral - Prueba CRUD</title>
				<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
				<link href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css' rel='stylesheet' type='text/css'>
				<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
				<link href='lib/template.css' rel='stylesheet' type='text/css'>";
		if(file_exists("lib/$where.css"))
			echo "<link href='lib/$where.css' rel='stylesheet' type='text/css'>";
		if(file_exists("lib/$where.js"))
			echo "<script src='lib/$where.js'>";
			echo "
				<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js' integrity='sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB' crossorigin='anonymous'></script>
				<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js' integrity='sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13' crossorigin='anonymous'></script>
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
				<script type='text/javascript' charset='utf8' src='https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
				<script src='configs/config.js' type='text/javascript'></script>
			</head>";
		if(file_exists("lib/$where.js"))
			echo "<body onload='init()'>";
		else
			echo "<body>";
		echo "
			<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
			<a class='navbar-brand' href='https://www.linkedin.com/in/gerard-romero-bujalance/'>Gerard Romero</a>
			<div class='collapse navbar-collapse' id='navbarNavAltMarkup'>
				<div class='navbar-nav'>
				<a class='nav-item nav-link ";
				if($where == 'index')
					echo " active";
				echo "' href='/'>Home</a>
				<a class='nav-item nav-link ";
				if($where == 'cat')
					echo " active";
				echo "' href='/categories'>Categories</a>
				<a class='nav-item nav-link ";
				if($where == 'sub')
					echo " active";
				echo "' href='/subcategories'>Subcategories</a>
				<a class='nav-item nav-link ";
				if($where == 'doc')
					echo " active";
				echo "' href='/documents'>Documents</a>
				</div>
			</div>
			</div>
			<span class='navbar-text'>CRUD Mini project</span>
			</nav>
			<div id='main'>";
}



?>