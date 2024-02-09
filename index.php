<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Image uploader</title>
	</head>
	<body>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="file" />
			<input type="submit" name="submit" value="Submit" />
		</form>
	</body>
</html>