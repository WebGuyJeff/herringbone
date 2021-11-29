<?php
	// absolute path from site root
	$uploadsPath = $_SERVER['DOCUMENT_ROOT'] . "/upload/bucket/";
	if ( 0 < $_FILES['file']['error'] ) {
		echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	}
	else {
		// temp upload dir
		move_uploaded_file($_FILES['file']['tmp_name'],
		$uploadsPath . $_FILES['file']['name']);
		echo "Success! " . $_FILES['file']['name'] . " uploaded.";
	}