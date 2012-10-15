
$(function(){
    
    /* - Home Page Flickr Banner Start - */
    
    //count the number of images initially loaded into the page
    var numitems = $("ul.flickrwall li").size();
    
    $("ul.flickrwall li").hide();
    
    //when an image in the flickr panel has downloaded
    $("ul.flickrwall li img").load(function(){
    	$(this).parent().fadeIn(1000).show();	
    });
	//set this function to run again at a randomly set interval between .5 and 2.5 seconds
	//randtime = 1500*Math.random() + 150;
	setInterval("changePhoto(" + numitems + ")", 500);
    	
    /* - Home Page Flickr Banner End - */
    
});

function changePhoto(numitems){
		
	//choose a random item to change
	var randitem = Math.floor(Math.random()*numitems);
	
	//add the new image to the photo div. It will remain behind the existing image for now
		$(".flickrwall #photo_" + randitem).prepend("<img src="+ images[pointer] +" />");
		
		$(".flickrwall #photo_" + randitem + " img:first-child").load(function(){
		
		//fade the new image in (sloooowly)
		$(".flickrwall #photo_" + randitem + " img:first-child").hide().fadeIn(1500);
		
			//fade out the old image (last-child). This will reveal the new image behind it
			$(".flickrwall #photo_" + randitem + " img:last-child").fadeOut(1000, function(){
			
				//once done, remove the old image...
				$(this).remove();
			
			});
		
		});
		
		//increment the pointer by 1, or reset it if we've reached the end of the array
		if(pointer < images.length)		pointer++;
		else	pointer = 0;
		
	
}