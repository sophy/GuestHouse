<?php 
/**
 * Uploader is a file transfer class. it can upload files and images.
 * It also can resize and crop images.
 * Works on PHP 5
 * @author Alaa Al-Hussein
 * @link http://www.freelancer-id.com/projects
 * @version 1.0
 * 
 */
class uploader{
	/**
	 * Array, The file object as $_FILES['element'].
	 * String, file location.
	 */
	public $source;
	/**
	 * Destination file location as folder.
	 */
	public $destDir;
	/**
	 * Directory for Resized images.
	 */
	public $resizeDir;
	/**
	 * Directory for Cropped images.
	 */
	public $cropDir;
	/**
	 * stores information for uploading file
	 */
	private $info = '';
	/**
	 * Enabling autoName will generate an auto file name for the uploaded file.
	 */
	public $autoName = false;
	/**
	 * Handles the error when it occurs.
	 */
	private $errorMsg = '';
	/**
	 * new width for resizing and cropping.
	 */
	public $newWidth;
	/**
	 * new height for resizing and cropping.
	 */
	public $newHeight;
	/**
	 * TOP postion to cropping image.
	 */
	public $top = 0;
	/**
	 * LEFT position for cropping image.
	 */
	public $left = 0;
	/**
	 * JPG quality (0 - 100). used for image resizing or cropping.
	 */
	public $quality = 60;
	
	/**
	 * 
	 * Thumbnail name and Simple name
	 * @var string
	 */
	
	private  $name;
	
	public function __construct(){
		//nothing
	}
	/**
	 * Uploads the file to the server.
	 * @param Array $_FILES[]
	 */
	public function upload($source){
		if($source != ""){
			$this->source = $source;
		}
		if(is_array($this->source)){
			if($this->fileExists()){
				return false;
			}
			return $this->copyFile();
		} else {
			return $this->source;
		}
	}
	/**
	 * return the error messages.
	 * @return String messages.
	 */
	public function getError(){
		return $this->errorMsg;
	}
	/**
	 * Get uploading information.
	 */
	public function getInfo(){
		return $this->info;
	}
	/**
	 * Copy the uploaded file to destination.
	 */
	private function copyFile(){
		if(!$this->isWritable()){
			$this->errorMsg .= '<div>Error, the directory: ('.$this->destDir.') is not writable. Please fix the permission to be able to upload.</div>';
			return false;
		}
		if(copy($this->source['tmp_name'],$this->destDir . $this->getName())){
			// Done.
			$this->info .= '<div>file was uploaded successfully.</div>';
		} else {
			$this->errorMsg .= '<div>Error, the file was not uploaded correctly because of an internal error. Please try again, if you see this message again, please contact web admin.</div>';
		}
	}
	/**
	 * Checks if the file was uploaded.
	 * @return boolean
	 */
	private function uploaded(){
		if($this->source['tmp_name']=="" || $this->source['error'] !=0){
			$this->errorMsg .= '<div>Error, file was not uploaded to the server. Please try again.</div>';
			return false;
		} else 
			return true;
	}
	/**
	 * Prepares the directory.
	 */
	private function preDir(){
		if($this->destDir!="" && substr($this->destDir, -1,1) != "/"){
			$this->destDir = $this->destDir . '/';
		}
		if($this->resizeDir!="" && substr($this->resizeDir, -1,1) != "/"){
			$this->destDir = $this->resizeDir . '/';
		}
		if($this->cropDir!="" && substr($this->cropDir, -1,1) != "/"){
			$this->destDir = $this->cropDir . '/';
		}
	}
	/**
	 * Check if the folder is writable or not.
	 * @return boolean
	 */
	private function isWritable(){
		$err = false;
		if(!is_writeable($this->destDir) && $this->destDir!=""){
			$this->errorMsg .= '<div>Error, the directory ('.$this->destDir.') is not writeable. File could not be uploaded.</div>';
			$err = true;
		}
		if(!is_writeable($this->resizeDir) && $this->resizeDir!=""){
			$this->errorMsg .= '<div>Error, the directory ('.$this->resizeDir.') is not writeable. File could not be resized.</div>';
			$err = true;
		}
		if(!is_writeable($this->cropDir) && $this->cropDir!=""){
			$this->errorMsg .= '<div>Error, the directory ('.$this->cropDir.') is not writeable. File could not be cropped.</div>';
			$err = true;
		}
		if($err == true){
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Checks if the file exists on the server
	 * @return boolean
	 */
	private function fileExists(){
		$this->preDir();
		if(file_exists($this->destDir.$this->source)){
			$this->errorMsg .= '<div>Upload error because file already exists.</div>';
			return true;
		} else {
			return false;
		}
	}
	/**
	 /586742130./8532 Crops image.
	 * @return String fileName or False on error
	 */
	public function crop($file='',$width='',$height='',$top='',$left=''){
		if($file!=""){ $this->source = $file;}
		if ($width != '') $this->newWidth = $width;
		if ($height != '') $this->newHeight = $height;
		if ($top != '') $this->top = $top;
		if ($left != '') $this->left = $left;
		return $this->_resize_crop(true);
	}
	/**
	 * Resizes an image.
	 * @return String fileName or False on error
	 */
	public function resize($file='',$width='',$height=''){
		if($file!=""){ $this->source = $file; }
		if($width != '') $this->newWidth = $width;
		if($height != '') $this->newHeight = $height;
		return $this->_resize_crop(false);
	}
	/**
	 * Get the Temp file location for the file.
	 * If the Source was a file location, it returns the same file location.
	 * @return String Temp File Location
	 */
	private function getTemp(){
		if(is_array($this->source)){
			return $this->source['tmp_name'];
		} else {
			return $this->source;
		}
	}
	/**
	 * Get the File location.
	 * If the source was a file location, it returns the same file location.
	 * @return String File Location
	 */
	private function getFile(){
		if(is_array($this->source)){
			return $this->source['name'];
		} else {
			return $this->source;
		}
	}
	
	public function getName(){
		if($this->name == ''){
			return $this->source['name'];
		}else{
			return $this->name;
		}
	}
	
	public function setName($name){
			$ext = explode(".",$this->getFile());
			$ext = strtolower(end($ext));
			
			if($ext == "jpg" || $ext == "jpeg") {
				$name .= '.jpg';
			} else if($ext == "gif") {
				$name .= '.gif';
			} else if($ext == "png") {
				$name .= '.png';
			}
		$this->name = $name;	
	}
	/**
	 * Resize or crop- the image.
	 * @param boolean $crop
	 * @return String fileName False on error
	 */
	private function _resize_crop ($crop) {
		$ext = explode(".",$this->getFile());
		$ext = strtolower(end($ext));
		list($width, $height) = getimagesize($this->getTemp());
		if(!$crop){
			$ratio = $width/$height;
			if ($this->newWidth/$this->newHeight > $ratio) {
				$this->newWidth = $this->newHeight*$ratio;
			} else {
				$this->newHeight = $this->newWidth/$ratio;
			}
		}
		$normal  = imagecreatetruecolor($this->newWidth, $this->newHeight);
		if($ext == "jpg") {
			$src = imagecreatefromjpeg($this->getTemp());
		} else if($ext == "gif") {
            $src = imagecreatefromgif ($this->getTemp());
		} else if($ext == "png") {
            $src = imagecreatefrompng ($this->getTemp());
		}
		if($crop){
			$pre = 'part_';
 			if(imagecopy($normal, $src, 0, 0, $this->top, $this->left, $this->newWidth, $this->newHeight)){
 				$this->info .= '<div>image was cropped and saved.</div>';
 			}
 			$dir = $this->cropDir;
		} else {
			$pre = 'thumb_';
			if(imagecopyresampled($normal, $src, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height)){
				$this->info .= '<div>image was resized and saved.</div>';
			}
			$dir = $this->resizeDir;
		}
		
		if($ext == "jpg" || $ext == "jpeg") {
			
			imagejpeg($normal, $dir . $this->name, $this->quality);
		} else if($ext == "gif") {
			
			imagegif ($normal, $dir . $this->name);
		} else if($ext == "png") {
			
			imagepng ($normal, $dir . $this->name,0);
		}
		imagedestroy($src);
		return $src;
	}
}
?>