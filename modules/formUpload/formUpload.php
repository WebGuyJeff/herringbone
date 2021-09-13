<?php

	// Where you want to put the file - absolute path from site root
	$uploadsPath = $_SERVER['DOCUMENT_ROOT'] . "/upload/bucket/";

	if ( 0 < $_FILES['file']['error'] ) {
		echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	}
	else {
		
		// Where the file is temporarily stored when uploaded - do not change
		move_uploaded_file($_FILES['file']['tmp_name'],
		
		// Use the defined upload target and append the filename
		$uploadsPath . $_FILES['file']['name']);
		
		
		echo "Success! " . $_FILES['file']['name'] . " uploaded.";
	}

?>