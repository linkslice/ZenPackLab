<?php

$author = $_GET["author"];
$packname = $_GET["packname"];
$version = $_GET["version"];

echo "Generating ZenPack<br>";
chdir('CustomScriptBuilder');

if ( !is_null($_GET["nagios"]) )
{
    if ( !is_null($_GET["symlink"]) )
    {
        $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -p");
    }else{
        $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -p -s");
    }

}else{
    if ( !is_null($_GET["symlink"]) )
    {
      $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version");
    }else{
      $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -s");
    }
}

$eggs = glob("*.egg");
foreach($eggs as $egg) {
    echo "<a href='CustomScriptBuilder/$egg'>$egg</a><br>";
}



?>

