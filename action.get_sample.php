<?php
if (!isset($gCms)) exit;

    $tplstr = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'example'.DIRECTORY_SEPARATOR.'planets.txt');

    @ob_clean();
    @ob_clean();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Description: File Transfer');
    header('Content-Length: ' . strlen($tplstr));
    echo $tplstr;
    exit;
