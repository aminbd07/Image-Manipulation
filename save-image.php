<?php

$result = [];

if (isset($_FILES["images"]["name"]))
{
	foreach ($_FILES["images"]["name"] as $key => $name) {
		$extension = pathinfo($name, PATHINFO_EXTENSION);
		$valid_extensions = ["jpg", "jpeg", "png"];

		$filename = pathinfo($name, PATHINFO_FILENAME);
		$filename .= '-'.rand(1111, 9999);

		if (in_array($extension, $valid_extensions)) {
			$upload_path = 'galaries/' . $filename . '.' . $extension;
			if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $upload_path)) {
				$result = [
					"message" => "Image Uploaded",
					"status" => "success"
				];
			}
		} else {
			$result = [
				"message" => "Only .jpg, .jpeg and .png Image allowed to upload",
				"status" => "error"
			];
		}
	}
	echo json_encode($result);
}