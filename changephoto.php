<?php
session_start();

/*
Get the array and the current pointer from the session var
*/

$pointer = $_SESSION['pointer'];
$images = $_SESSION['images'];

//the name of the image to load
$nextimg = $images[$pointer];

echo $nextimg;

//move the pointer up by 1, or reset it if we've reached the end of the array
if($pointer < count($images) -1)	$_SESSION['pointer'] ++;
else								$_SESSION['pointer'] = 0;
?>