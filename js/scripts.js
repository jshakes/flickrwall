
var pausetime = 500,
    fadetime = 1500;

$(function(){
    
    /* - Home Page Flickr Banner Start - */
    
    //count the number of images initially loaded into the page
    var numitems = $("ul.flickrwall li").size();
       
	//set this function to run ever x milliseconds
	setInterval("changePhoto(" + numitems + ")", pausetime);
    	
    /* - Home Page Flickr Banner End - */
    
});

function changePhoto(numitems){
    
    if(pointer < (images.length -1 ))		pointer++;
    else	pointer = 0;
    
    
    //choose a random item to change
    var _randnum = Math.floor(Math.random() * numitems);
    var _imgdiv = $(".flickrwall li#photo_" + _randnum);
    console.log(_randnum);
    
    //add the new image to the photo div. It will remain behind the existing image for now
    if(typeof images[pointer] != "undefined"){
        _imgdiv.addClass("transition").prepend("<img src="+ images[pointer] +" />");
    }
    else{
        console.log("Couldn't find the image at " + pointer);
    }
    
    //when the image is loaded in
    _imgdiv.children("img:first-child").load(function(){
    
        //fade out the old image (last-child). This will reveal the new image behind it
        $(this).siblings("img:last-child").fadeOut(fadetime, function(){
        
            //once done, remove the old image...
            $(this).remove();
            _imgdiv.removeClass("transition");
        });
    });
}