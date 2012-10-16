<?php
header('Content-Type: image/jpeg');

$thumb_size = 47;//the width and height o

//Create the GD image we will load the thumbs into 
$palette = imagecreatetruecolor(940, 282);

// Loop through the photos

$i = 0;//the counter for the loop
$x = 0;
$y = 0;

if ($handle = opendir('imgcache/')) {

    while (false !== ($imgurl = readdir($handle))) {	
        if (substr($imgurl, 0, 1) != ".") {
    	
			$thumb = imagecreatefromjpeg("imgcache/$imgurl");
		
			imagecopy($palette, $thumb, $x, $y, 0, 0, 47, 47);
		
			$x += $thumb_size;
			if($x % 940 == 0){
				$y += $thumb_size;
				$x = 0;
			}
		}
	}
	imagejpeg($palette, NULL, 100);
}

else echo "images not loaded";
?>