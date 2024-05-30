<?php

$author = $_GET["author"];
$packname = $_GET["packname"];
$version = $_GET["version"];

if ( !is_null($_GET["nagios"]) )
{
    echo "Fetching Nagios plugins. Please be patient<br>";
    $nagios_out = shell_exec('yum install -y nrpe nagios-plugins-http nagios-plugins-dig');
}

echo "Generating ZenPack<br>";
chdir('CustomScriptBuilder');
$makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version");

echo "<a href='CustomScriptBuilder/$makepack_out'>$makepack_out</a>";




?>

