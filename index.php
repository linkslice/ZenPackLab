<html>
 <form action="/zenpacklab.php" method="get">
    Author:<input type=text name=author><br>
    Pack Name:<input type=text name=packname><br>
    Version: <input type=text name=version><br>
    install nagios plugins?:<input type=checkbox name=nagios>
    <input type=submit>
 </form>


<form action="upload.php" method="post" enctype="multipart/form-data">
  Select scripts to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="input script" name="submit">
</form>

</html>
