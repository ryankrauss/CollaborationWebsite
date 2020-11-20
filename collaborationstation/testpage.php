

<?php
session_start();
require_once 'header.php';


echo "<h3>Upload Your Song </h3>";
echo "<div>";

$result = queryMysql("SELECT * FROM members where user!='$user' LIMIT 3");
$following = array();
$num    = $result->num_rows;
for ($j = 0 ; $j < $num ; ++$j) {
    $row           = $result->fetch_array(MYSQLI_ASSOC);
    $following[$j] = $row['user'];
}

echo "<p>If you would like your song to be private and only shared with selected others, please open the menu below...</p>";
echo "<button type='button' class='collapsible'>(Optional) Add Collaboration</button>";
echo "<div class='content'>";
echo "<div class='discoverContainer'>";
foreach($following as $friend) {
    $name = "$friend";
    $count = 0;
    $exists = false;
    echo "<form enctype='multipart/form-data' id='form1' method='post' action='testpage.php'>";
    echo "<input type='checkbox' checked id='$name' name='$name' value='$name'>";
    echo "<label for='$name'> $name </label><br>";
    echo "<script> document.getElementById('$name').checked = false</script>";
}
echo "</div>";



if(isset($_POST['submit']))
    {
      foreach($following as $friend) {
          $name = "$friend";
          //$concatCollab = isset($_POST[$name]) ? $_POST[$name] : 0;
          if (isset($_POST[$name])){
            $concatCollab =  $concatCollab . $_POST[$name] . ".";
          }
        }
      //$concatCollab = $_POST['$name'];
      foreach($following as $friend) {
          $name = "$friend";
          $count = 0;
          $exists = false;
      //echo "<script>if (document.getElementById('$name').checked == true){ $concatCollab = '$name' }</script>";
    }
	//$path = "useraudio/".".".$concatCollab.".".$user.;
  $path = "useraudio/" . $concatCollab . $user . ".";
  echo "<script>console.log('ConcatCollab = $concatCollab');</script>";
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

echo <<<_UPLOAD
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
_UPLOAD;

echo <<<_END
    </div><br>
_END;
?>

<<<<<<< HEAD
<?
require_once 'footer.php';
?>
=======
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
>>>>>>> 219b574e1be3fa0f046ba33b8013f62fdb9437d4


<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>
