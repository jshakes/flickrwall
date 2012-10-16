<?php

require_once("include/class.flickrwall.php");
$flickrwall = new Flickrwall();
$img_arr = $flickrwall->make_image_arr();

?>
<html>
<head>
    <title>Flickrwall Demo</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <ul class="flickrwall">
    <?php
    //Images are printed out here
    foreach($img_arr as $pointer => $image){
    	?>
    	<li class="image" id="photo_<?php echo $pointer; ?>">
    		<img src="<?php echo $image; ?>" />
    	</li>
    	<?php
    	if($pointer + 1 == $flickrwall->images_on_page) break;
    }
    ?>
    </ul>
    
    <script>
    var images = new Array();
    //this variable will ensure we start pulling in whichever images aren't already being displayed
    var pointer = <?php echo $flickrwall->images_on_page; ?>;
    <?php
    //Our Javascript array goes here
    foreach($img_arr as $pointer => $image){ 
        ?>
        images[<?php echo $pointer; ?>] = '<?php echo $image; ?>';
        <?php
    } ?>
    </script>
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>