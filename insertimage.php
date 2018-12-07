<?php
require 'session.php';

$error = "";

function file_upload_path($original_filename, $upload_subfolder_name = 'images') 
{
  $current_folder = dirname(__FILE__);
  $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
  return join(DIRECTORY_SEPARATOR, $path_segments);
}

  if (isset($_FILES['image']))
    {
        $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    

      if ($image_upload_detected) 
        { 
            $image_filename       = $_FILES['image']['name'];
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $new_image_path       = explode(".", $image_filename);
            $image_extension      = end($new_image_path);
            $new_image_path       = file_upload_path($image_filename);
            
            move_uploaded_file($temporary_image_path, $new_image_path);
            header("refresh: 1; URL=create.php?name=$image_filename");
         }
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>File Upload Form</title>
  </head> 
<body>
  <h1>
    Please Choose an Image
  </h1>
    <form method="post" enctype="multipart/form-data">
        <label for="image">Image Filename:</label>
        <input type="file" name="image" id="image">
        <input type="submit" name="submit" value="Upload Image">
    </form>
</body>
</html>