<html>
 <form action="/zenpacklab.php" method="get">
    Author:<input type=text name=author><br>
    Pack Name:<input type=text name=packname><br>
    Version: <input type=text name=version><br>
    install nagios plugins?:<input type=checkbox name=nagios><br>
    create symlinks during install?<input type=checkbox name=symlink> (don't do this unless you know why)<br>
    <input type=submit value="create pack">
 </form>

<hr>
<form action="upload.php" method="post" enctype="multipart/form-data">
  Select scripts to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="input script" name="submit">
</form>
<hr>

<?php
chdir('CustomScriptBuilder');
$eggs = glob("*.egg");
foreach($eggs as $egg) {
    echo "<a href='CustomScriptBuilder/$egg'>$egg</a><br>";
}
?>

</html>
