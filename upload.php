<?php

	require_once( "php/uploadImage-script.php" );

	// File, max MB
	$image = uploadImage( $_FILES['file'], 2 );