<?php
/**
 * Function uploud image
 *
 * @return string image name
 */
function upload_image($source, $path, $name = null){

	$is_image =array('jpg', 'gif', 'png', 'jpeg');

	if(is_array($source)){
		$ext = explode(".", $source['name']);
		$ext = strtolower(end($ext));

		//if upload is image
		if(in_array($ext, $is_image)){

			//upload image
			$upload = new uploader();
			$upload->source = $source;

                        if( !$name ){
                            $name = uniqid().'_'.time();
                        }else{
                            $name = strtolower( $name ) .'_'. time();
                        }

			$upload->setName($name);
			$upload->destDir = $path;
			//start upload
			$upload->upload("");

			if($upload->getError())
                            return false;

			else
                            return $upload->getName();
		}
	}

       return false;
}
/**
 * Redirect Function
 *
 */
function redirect($url,$permanent = false)
{
  if($permanent)
  {
    header('HTTP/1.1 301 Moved Permanently');
  }
  header('Location: '.$url);
  exit();
}
?>
