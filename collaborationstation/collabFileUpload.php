

<?php
session_start();


$result = queryMysql("SELECT * FROM members where user!='$user' LIMIT 3");
$following = array();
$num    = $result->num_rows;
for ($j = 0 ; $j < $num ; ++$j) {
    $row           = $result->fetch_array(MYSQLI_ASSOC);
    $following[$j] = $row['user'];
}

echo "<h5>Collaborate with...</h5>";
echo "<div class='discoverContainer'>";
echo "<p>Please choose who to share the collaborated song with (only marked users will be able to see)</p>";
foreach($following as $friend) {
    $name = "$friend";
    $count = 0;
    $exists = false;
    echo "<form enctype='multipart/form-data' id='form1' method='post' action='testpage.php'>";
    echo "<input type='checkbox' checked id='$name' name='$name' value='$name'>";
    echo "<label for='$name'> $name </label><br>";
    echo "<script> document.getElementById('$name').checked = true</script>";
}

//echo "<script>if (document.getElementById('$name').checked == true){ $concatCollab = $concatCollab + $name + '.' };</script>";
echo "<input type='text' id='concatCollab' name='concatCollab' value='tracy'>";



echo "</div>";


echo "<h3>Upload Your Song </h3>";
echo "<div>";

if(isset($_POST['submit']))
    {

	$path = "useraudio/$concatCollab" + "$user.";
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



	<input type="file" name="file1" accept=".ogg,.flac,.mp3" required="required"/>
	<input type="submit" name="submit"/>
	</form>
  </body>
</html>
