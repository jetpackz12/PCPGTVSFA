<?php

/**
 * 
 */
class upload_imageController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

        if($_SERVER['REQUEST_METHOD'] != "POST")
        {
			$this->controller->view()->view_render('pages/home/home.php');
			return;
        }
        
		// Check if a file was uploaded
		if (isset($_FILES['file']) && isset($_POST['usertype']))
        {
			// Get the file name, type, size, and temporary location
			$fileName = $_FILES["file"]["name"];
			$fileType = $_FILES["file"]["type"];
			$fileSize = $_FILES["file"]["size"];
			$fileTemp = $_FILES["file"]["tmp_name"];

            $allowedTypes = array("image/jpeg", "image/png", "image/gif");

            if(!in_array($fileType, $allowedTypes))
            {
				echo json_encode([
                    'response' => '0',
                    'message' => "File is not a image."
                ]);
                return;
            }

			$extension = pathinfo($fileName, PATHINFO_EXTENSION);
			$new_file_name = uniqid().'.'.$extension;

			switch($_POST['usertype']) {
				case 1:
						$filePath = BOOTSTRAP . "student_images/" . $new_file_name;
					break;
				case 2:
						$filePath = BOOTSTRAP . "teacher_images/" . $new_file_name;
					break;
			}

			// Set the destination path for the file
		
			// Move the file from the temporary location to the destination path
			if (move_uploaded_file($fileTemp, $filePath))
            {
				// File was successfully uploaded
				echo json_encode([
                    'response' => '1',
                    'message' => $filePath,
					'file_name' => $new_file_name
                ]);
			}
            else
            {
				// File could not be uploaded
				echo json_encode([
                    'response' => '0',
                    'message' => "File could not be uploaded"
                ]);
			}
		}
        else
        {
			// No file was uploaded
            echo json_encode([
                'response' => '0',
                'message' => "No file was uploaded"
            ]);
		}
	}

	public function signature()
	{
		$img = $_POST['imgBase64'];
		$signName = $_POST['signName'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$fileData = base64_decode($img);
		//saving
		$fileName = BOOTSTRAP . "signature_images/".$signName;
		file_put_contents($fileName, $fileData);
	}
	
}
?>