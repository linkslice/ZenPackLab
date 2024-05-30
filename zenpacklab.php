<?php

$author = $_GET["author"];
$packname = $_GET["packname"];
$version = $_GET["version"];

if ( !is_null($_GET["nagios"]) )
{
    echo "Fetching Nagios plugins. Please be patient";
    $nagios_out = shell_exec('yum install -y nrpe nagios-plugins-http nagios-plugins-dig');
}

echo "Generating ZenPack";
chdir('CustomScriptBuilder')
$makepack_out = shell_exec("/bin/bash makepack.sh -a '".$author."' -n $packname -v $version");

echo "<a href='CustomScriptBuilder/$zenpack_out'>$zenpack_out</a>";




?>

