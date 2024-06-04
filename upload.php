
<?php
$target_dir = "libexec/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$scriptFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
  $check = getscriptsize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an script - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an script.";
    $uploadOk = 0;
  }
}
?>

