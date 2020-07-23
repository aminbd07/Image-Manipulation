<?php

$path    = 'galaries';
$images = array_diff(scandir($path), array('.', '..'));

echo json_encode($images);