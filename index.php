<?php
/*
Flickrwall, James Shakespeare 2012
www.jshakespeare.com

This page picks up images that have been saved to the 'cache' folder and saves them into an array in the session. This array is then shuffled and the first n number of images are printed as a mosaic. It then substitutes random images for any remaining images left in the array. This substitution is called by javascript function changePhoto() which references changephoto.php.
*/

//maximum number of images to display
$max = 30;
$shuffle = true;

//the location of the images
$dir = "imgcache";
if ($handle = opendir($dir)) {

	//the array to hold the images
	$images = array();
		
	//load all images in cache into the images array
    while (false !== ($imgurl = readdir($handle))) {	
        if (substr($imgurl, 0, 1) != "."){
    		$images[] = "$dir/$imgurl";
		}
	} 
	//shuffle the image array
	if(!empty($images) && $shuffle)    shuffle($images);
}
?>
<html>
<head>
<title>Flickr Wall Demo</title>
<link rel="stylesheet" href="css/style.css" />
</head>

<body>
<ul class="flickrwall">
<?php
//Images are printed out here
foreach($images as $pointer => $image){
	?>
	<li class="image" id="photo_<?php echo $pointer; ?>">
		<img src="<?php echo $image; ?>" />
	</li>
	<?php
	if($pointer + 1 == $max) break;
}
?>
</ul>
<script>

var images = new Array();
//this variable will ensure we start pulling in whichever images aren't already being displayed
var pointer = <?php echo $max; ?>;
<?php
//Our Javascript array goes here
foreach($images as $pointer => $image){ 
    ?>
    images[<?php echo $pointer; ?>] = '<?php echo $image; ?>';
    <?php
} ?>
</script>
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>

</body>
</html>