

<?php
session_start();
require_once 'header.php';

echo "<h3>Upload Your Song </h3>";
echo "<div>";

if(isset($_POST['submit']))
    {
		
	$path = "useraudio/$user.";
	$valid_formats1 = array("mp3", "ogg", "flac");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
    {
        $file1 = $_FILES['file1']['name'];
        $size = $_FILES['file1']['size'];

        if(strlen($file1))
            {
                list($txt, $ext) = explode(".", $file1);
                if(in_array($ext,$valid_formats1))
                {
                        $actual_image_name = $txt.".".$ext;
                        $tmp = $_FILES['file1']['tmp_name'];
                        if(move_uploaded_file($tmp, $path.$actual_image_name))
                            {
                            echo "Upload Successful";
                            }
                        else
                            echo "failed";
                    }
        }
    }
}


echo <<<_END
    </div><br>
_END;

?>

<html>
  <meta charset="UTF-8">
  <title>Upload</title>

  <body>


	<form enctype="multipart/form-data" id="form1" method="post" action="testpage.php">
	<input type="file" name="file1" accept=".ogg,.flac,.mp3" required="required"/>
	<input type="submit" name="submit"/>
	</form>
  </body>
</html>

