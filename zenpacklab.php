<?php

$author = $_GET["author"];
$packname = $_GET["packname"];
$version = $_GET["version"];
$symlink = $_GET["symlink"];

echo "Generating ZenPack<br>";
chdir('CustomScriptBuilder');

if ( !is_null($_GET["nagios"]) )
{
    if ( $_GET["symlink"] )
    {
        $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -p -s");
    }else{
        $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -p");
    }

}else{
    if ( $_GET["symlink"] )
    {
      $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -s");
    }else{
      $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version");
    }
}

$eggs = glob("*.egg");
foreach($eggs as $egg) {
    echo "<a href='CustomScriptBuilder/$egg'>$egg</a><br>";
}


?>

<a href='/'>Start Again</a>
