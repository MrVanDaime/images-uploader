<?php
	function uploadImage( $file, $maxFileSize ) {
		// Define acceptable file extensions
		// application/octet-stream
		$tipos = array( 'image/png', 'image/jpg', 'image/jpeg' );

		// Convert MB to B
		$maxFileSizeB = $maxFileSize * 1024 * 1024;

		// Check for error
		if ( $file['error'] != 0 ) {
			switch ( $file['error'] ) {
				case 1:
					print_r( array( 'status' => 0, 'error' => 'The size of the uploaded file exceeds the maximum value specified in your php.ini file with the upload_max_filesize directive.' ) );
					break;
				case 2:
					print_r( array( 'status' => 0, 'error' => 'The size of the uploaded file exceeds the maximum value specified in the HTML form in the MAX_FILE_SIZE element.' ) );
					break;
				case 3:
					print_r( array( 'status' => 0, 'error' => 'The file was only partially uploaded.' ) );
					break;
				case 4: 
					print_r( array( 'status' => 0, 'error' => 'No file was uploaded' ) );
					break;
				case 6:
					print_r( array( 'status' => 0, 'error' => 'No temporary directory is specified in the php.ini.' ) );
					break;
				case 7:
					print_r( array( 'status' => 0, 'error' => 'Writing the file to disk failed.' ) );
					break;
				case 8:
					print_r( array( 'status' => 0, 'error' => 'A PHP extension stopped the file upload process. Checking the extensions loaded using phpinfo() can help.' ) );
					break;
			}

			exit();
		}

		// Check file type
		if ( !in_array( $file['type'], $tipos ) ) {
			print_r( array( 'status' => 0, 'error' => 'File need to be either PNG, JPG or JPEG.' ) );
			exit();
		}

		// Check file size
		if ( $file['size'] > $maxFileSizeB ) {
			print_r( array( 'status' => 0, 'error' => "File is too large: Max file size is ( {$maxFileSize}MB )" ) );
			exit();
		}

		// File name and type
		$file_data = explode('.', $file['name']);

		$file_name = strtolower( $file_data[0] );
		$file_type = strtolower( $file_data[1] );

		$finalName = "{$file_name}.{$file_type}";

		// Check if uploade folder exists (year)
		$uploads_folder = 'images/uploads/' . date( 'Y' );
		if ( !is_dir( $uploads_folder ) ) {
			mkdir( $uploads_folder );
		}

		// Check if uploade folder exists (month)
		if ( !is_dir( $uploads_folder . '/' . date( 'm' ) ) ) {
			mkdir( $uploads_folder . '/' . date( 'm' ) );
		}

		// Folder after checking year and month
		$uploads_folder = $uploads_folder . '/' . date( 'm' ) . '/';

		// Move file to server
		if ( file_exists( $uploads_folder . $finalName ) ) {
			$md5_anti_override = substr(md5(time()), 0, 6);
			$finalName = "{$file_name}-{$md5_anti_override}.{$file_type}";
		}

		if ( move_uploaded_file( $file['tmp_name'], "{$uploads_folder}{$finalName}" ) ) {
			print_r( array( 'status' => 1, 'image' => $finalName ) );
		} else {
			print_r( array( 'status' => 0, 'error' => 'There was an error uploading the image.' ) );
		}
	}