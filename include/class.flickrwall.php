<?php

/*
    Flickrwall, James Shakespeare 2012
    www.jshakespeare.com
    
    This page picks up images that have been saved to the 'cache' folder and saves them into an array in the session. This array is then shuffled and the first n number of images are printed as a mosaic. It then substitutes random images for any remaining images left in the array. This substitution is called by javascript function changePhoto() which references changephoto.php.
*/

class Flickrwall{
    
    /**
    * The name of the directory to store and pull images from
    * @var string
    */
    public $img_dir = "imgcache";
    /**
    * An array to store all the images we'll be using
    * @var array
    */
    public $img_arr = array();
    /**
    * The maximum number of images to display on the page at any one time
    * @var int
    */
    public $images_on_page = 30;
    /**
    * The Flickr API key (get one from here http://www.flickr.com/services/apps/create/apply/). Or just use mine, whatever.
    * @var string
    */
    protected $api_key = "977f173122337c580393c83edc197092";
    /**
    * The ID of the Flickr Group we will be pulling images from
    * @var string
    */
    protected $pool_id = "30125420@N00";
    /**
    * The size in pixels of each side of the image (currently images must be square)
    * @var int
    */
    protected $thumb_size = 50;
    /**
    * Whether or not to shuffle the image order or order them by filename (asc)
    * @var bool
    */
    protected $shuffle = true;
    /**
    * The maximum number of images to pull from Flickr
    * @var int
    */
    protected $limit = 999;
    /**
    * Whether or not we should files of the same name in the image directory
    * @var bool
    */
    protected $delete_existing = true;    
    
    /* --------------- METHODS --------------- */
    
    /**
    * Pull down the latest images from the Flickr Pool
    * @access public
    * @return bool
    */
    public function fetch(){
        
        //load the PHPFlickr class and instantiate a new object
        require_once("phpFlickr/phpFlickr.php");
        
        $f = new phpFlickr($this->api_key);

        if(@$photos = $f->groups_pools_getPhotos($this->$pool_id)){
        
            // Loop through the photos
            foreach ((array)$photos['photos']['photo'] as $i => $photo) {
                
                if($i == $limit) break;
                
                $imgid = $photo['id'];
                
                //Continue to next iteration if the file already exists and we aren't overwriting files
                if(file_exists("{$this->imgdir}/$imgid.jpg") && !$this->delete_existing) continue;
                
                //Create the GD image we will load the thumb into 
                $palette = imagecreatetruecolor($this->thumb_size, $this->thumb_size);
                
                $imgurl = $f->buildPhotoURL($photo, "square");
                
                $thumb = imagecreatefromjpeg($imgurl);
                
                imagecopyresampled($palette, $thumb, 0, 0, 0, 0, $thumb_size, $thumb_size, 75, 75);
                
                if(@imagejpeg($palette, "{$this->imgdir}/$imgid.jpg"))
                    echo "$imgid.jpg written to cache\n";
                else
                    echo "file write error\n";	
                
            }
        }
        else echo "images not fetched";
    }
    
    /**
    * Populate the image array with images from the cache
    * @access public
    * @return array / bool false on failure
    */
    public function make_image_arr(){
        
        if ($handle = opendir($this->img_dir)) {
                        		
        	//load all images in cache into the images array
            while (false !== ($imgurl = readdir($handle))) {	
                
                if (substr($imgurl, 0, 1) != "."){
            	
            		$this->img_arr[] = "{$this->img_dir}/$imgurl";
        		}
        	} 
        	//shuffle the image array
        	if(!empty($this->img_arr) && $this->shuffle){
            	shuffle($this->img_arr);
            }
            return $this->img_arr;        
        }
        else return false;
        
    }
    
    //end of class
}

?>