<?php

$author = $_GET["author"];
$packname = $_GET["packname"];
$version = $_GET["version"];

echo "Generating ZenPack<br>";
chdir('CustomScriptBuilder');

if ( !is_null($_GET["nagios"]) )
{
    //makepack.sh should handle installations
    //echo "Fetching Nagios plugins. Please be patient<br>";
    //$nagios_out = shell_exec('yum install -y nrpe nagios-plugins-http nagios-plugins-dig');
    $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -p");
}else{
    $makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version");
}

$eggs = glob("*.egg");
foreach($eggs as $egg) {
    echo "<a href='CustomScriptBuilder/$egg'>$egg</a><br>";
}



?>

