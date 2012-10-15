<?php
/*
Image mosaic, James Shakespeare 2011
www.jshakespeare.com

This page picks up images that have been saved to the 'cache' folder and saves them into an array in the session. This array is then shuffled and the first n number of images are printed as a mosaic. It then substitutes random images for any remaining images left in the array. This substitution is called by javascript function changePhoto() which references changephoto.php.

Images from the Flickr pool 'Made in Brunel 11' are loaded into the cache every 24 hours at 0600 by a cron job. The script that performs this task is 'fetch.php'.
*/

//maximum number of images to display
$max = 186;

//the location of the images
$dir = "imgcache";
if ($handle = opendir($dir)) {

	//the array to hold the images
	$images = array();
	
	//load all images in cache into the images array
    while (false !== ($imgurl = readdir($handle))) {	
        if ($imgurl != "." && $imgurl != "..") {
    		$images[] = "$dir/$imgurl";
		}
	} 
	if(!empty($images)){
		
		//shuffle the image array
		shuffle($images);
	
?>
<html>
<head>
<title>Flickr Wall Test</title>
<link rel="stylesheet" href="css/style.css" />
<script>

var images = new Array();
var pointer = <?php echo $max; ?>;
<?php
/* Our Javascript array goes here  */

		foreach($images as $pointer => $image){ ?>images[<?php echo $pointer; ?>] = '<?php echo $image; ?>';<?php } ?>

</script>
</head>

<body>
<ul class="flickrwall">
<?php

/* Images are printed out here */
		
		//starting x and y co-ordinates so we can keep track of where images are going on the grid
		$x = 0;
		$y = 1;
				
		foreach($images as $pointer => $image){
			?>
			<li class="image" id="photo_<?php echo $pointer; ?>">
				<img src="<?php echo $image; ?>" />
			</li>
			<?php
			//update x and y co-ordinates
			$x++;
			
			if($x == 20){
				$x = 0;
				$y++;
			}
			
			//a very hacky way of only writing 3 and 2 images to the 5th and 6th rows respectively 
			if(($y == 5 || $y == 6) && $x == 3){
				echo "<div class=\"clear\"></div>";
				$y++;
				$x = 0;
			}
			
			if($pointer == $max -1) break;
		}
	}
}
?>
</ul>

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>

</body>
</html>