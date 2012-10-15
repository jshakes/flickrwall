<?php
/*
*	Fetch the images in the Made in Brunel 2011 group pool
*	Save these images into the cache directory.

	Currently set up to run every day at 0600 hrs.
*/

require_once("include/phpFlickr/phpFlickr.php");
// Create new phpFlickr object
$f = new phpFlickr("977f173122337c580393c83edc197092");

$id = "30125420@N00";

$imgdir = "imgcache";

$thumb_size = 47;//the width and height of each thumbnail

$limit = 999;

$delete_existing = true;

//do something here to remove existing files

//Load the images in the pool
if(@$photos = $f->groups_pools_getPhotos($id)){

    // Loop through the photos
    foreach ((array)$photos['photos']['photo'] as $i => $photo) {
        
        if($i == $limit) break;
        
        $imgid = $photo['id'];
        
        if(!file_exists("$imgdir/$imgid.jpg")){
        
            //Create the GD image we will load the thumb into 
            $palette = imagecreatetruecolor(47, 47);
            
            $imgurl = $f->buildPhotoURL($photo, "square");
            
            $thumb = imagecreatefromjpeg($imgurl);
            
            imagecopyresampled($palette, $thumb, 0, 0, 0, 0, $thumb_size, $thumb_size, 75, 75);
            
            if(@imagejpeg($palette, "$imgdir/$imgid.jpg"))
                echo "$imgid.jpg written to cache\n";
            else
                echo "file write error\n";	
        }
    }
}


else echo "images not fetched";
?>