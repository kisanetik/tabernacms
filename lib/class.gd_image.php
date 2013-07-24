<?php
/**
 * Image class - GD2 wrapper for resizing
 * @package Taberna
 * @author Denys Yackushev
 * @author Tereshchenko Viacheslav
 */
class rad_gd_image
{
    const RESIZE_METHOD_SCALE = 'scale';    
    const RESIZE_METHOD_CROP = 'crop';
    const RESIZE_METHOD_STRETCH = 'stretch';

    const WATERMARK_OPACITY = 0.3;
    const WATERMARK_TEXT_HEIGHT = 24;

    private $_fileExtension = '';
    
    private $_oldfileAddr = '';
    private $_newFileAddr = '';
    
    private $_preset = array();
    
    private $_error = '';
    
    private $dst_image = null;
    private $src_image = null;

    /**
     * Return image file extension by MIME
     *
     * @param string $filename
     * @return string
     */
    public static function getFileExtension($fileAdr='')
    {
        $fileExt = null;
        if(!empty($fileAdr)) {
            $fileInfo = getimagesize($fileAdr);
            switch($fileInfo['mime']) {
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/jpe':
                    $fileExt = 'jpg';
                    break;
                case 'image/png':
                    $fileExt = 'png';
                    break;
                case 'image/gd':
                    $fileExt = 'gd';
                    break;
                case 'image/gif':
                    $fileExt = 'gif';
                    break;
            }
        }
        return $fileExt;
    }    
    
    /**
     * Set resizing params 
     *
     * @param string  $oldFn - filename
     * @param string  $newFn - new filename
     * @param array $preset - perset from image config
     */
    function set($oldFn, $newFn, $preset)
    {
        $this->logInfo('Set', array($oldFn, $newFn, $preset));
        if(!empty($oldFn)) {
            $this->_oldfileAddr = $oldFn;
        } else {
            $this->setError('Empty old file name!');
        }

        if(!empty($newFn)) {
            $this->_newFileAddr = $newFn;
        } else {
            $this->setError('Empty new file name!');
        }
        
        if(!empty($preset)) {
            $this->_preset = $preset;
        } else {
            $this->setError('Empty preset!');
        }

        $this->_fileExtension = $this->getFileExtension($oldFn);
        if(!$this->_fileExtension) {
            $this->setError('Wrong file extension!');
        }
        
        if(empty($this->_error)) {
            $this->logInfo('Set OK');
            return true;
        } else {
            return false;
        }
    }

    private function _createImage($path, $ext=false) {
        if (!$ext) {
            $ext = self::getFileExtension($path);
        }

        switch($ext)
        {
            case 'jpeg':
            case 'jpe':
            case 'jpg':
                return imagecreatefromjpeg($path);
            case 'png':
                return  imagecreatefrompng($path);
            case 'gif':
                return  imagecreatefromgif($path);
            case 'gd':
                return imagecreatefromgd($path);
            default:
                $this->setError('Unsupported media type of source file: ' . $ext);
                return false;
        }
    }

    /**
     * Resize and save the image
     * need to call $this->set() before
     * 
     * @return boolean
     */
    function resize() 
    {
        $this->logInfo('Resize');
        $this->src_image = $this->_createImage($this->_oldfileAddr, $this->_fileExtension);
        if (!$this->src_image) {
            $this->logInfo('Resize error: src empty');
            $this->setError('Resize error: src empty');
            return false;
        }

        if(!empty($this->_preset['mode']) && $this->_preset['mode'] == 'no') {
            $this->logInfo('Resize: copying original file');
            $this->dst_image = $this->src_image;
        } else {
            //Source and destination images metrics
            $h_src = imagesy($this->src_image);
            $w_src = imagesx($this->src_image);
            $h_dst = (int) $this->_preset['h'];
            $w_dst = (int) $this->_preset['w'];
            $enlarge = (!empty($this->_preset['enlarge'])) ? (bool)$this->_preset['enlarge'] : false;

            //Resize parameters
            $src_x = 0;
            $src_y = 0;
            $h_ratio = ($h_dst == $h_src) ? 1 : $h_dst / $h_src; //NB: checking to prevent rounding problem, e.g. 14759/14759 = 0.9999
            $w_ratio = ($w_dst == $w_src) ? 1 : $w_dst / $w_src;

            switch($this->_preset['mode'])
            {
                case self::RESIZE_METHOD_SCALE:
                    $ratio = min($h_ratio, $w_ratio);
                    if (!$enlarge && $ratio > 1) $ratio = 1;

                    $new_h = round($h_src * $ratio);
                    $new_w = round($w_src * $ratio);

                    $this->logInfo("Resize: scale ({$ratio})", array($w_src, $h_src,$new_w, $new_h));
                    if($this->_prepareDstImage($new_w, $new_h)) {
                        imagecopyresampled($this->dst_image, $this->src_image, 0, 0, 0, 0, $new_w, $new_h, $w_src, $h_src);
                        $this->logInfo('Resize OK');
                    } else {
                        $this->logInfo('Resize error');
                        $this->setError('Resize error');
                        return false;
                    }
                    break;

                case self::RESIZE_METHOD_CROP:
                    $this->logInfo('Resize crop');
                    $centerSrcW = round($w_src/2, 1);
                    $centerSrcH = round($h_src/2, 1);
                    $centerDstW = round($w_dst/2, 1);
                    $centerDstH = round($h_dst/2, 1);
                    
                    /** CROP FROM CENTER */
                    if($h_src > $h_dst and $w_src > $w_dst) {
                        $src_y = floor($centerSrcH - $centerDstH);
                        $new_h = $h_dst;
                        $src_x = floor($centerSrcW - $centerDstW);
                        $new_w = $w_dst;
                        
                        if($this->_prepareDstImage($new_w, $new_h)) {                    
                            imagecopy($this->dst_image, $this->src_image, 0, 0, $src_x, $src_y, $new_w, $new_h);
                            $this->logInfo('Resize crop OK');
                        } else {
                            $this->logInfo('Resize crop error');
                            $this->setError('Resize&crop error');
                            return false;
                        }
                    } elseif($h_src == $h_dst and $w_src == $w_dst) {
                        $this->logInfo('Resize crop/copy');
                        $result = copy($this->_oldfileAddr, $this->_newFileAddr);
                        if (!$result) $this->setError('Copy error');
                        return $result;
                    } else {
                        if(!$enlarge) {
                            if($h_src > $h_dst) {
                                $src_y = floor($centerSrcH - $centerDstH);
                                $new_h = $h_dst;
                            } else {
                                $new_h = $h_src;
                            }
                            if($w_src > $w_dst) {
                                $src_x = floor($centerSrcW - $centerDstW);
                                $new_w = $w_dst;
                            } else {
                                $new_w = $w_src;
                            }
                            
                            if($this->_prepareDstImage($new_w, $new_h)) {
                                imagecopy($this->dst_image, $this->src_image, 0, 0, $src_x, $src_y, $new_w, $new_h);
                                $this->logInfo('Resize crop OK');
                            } else {
                                $this->logInfo('Resize crop error');
                                $this->setError('Resize&crop2 error');
                                return false;
                            }
                        } else {
                            // image increased so as to completely fill the target area, and then cut
                            $ratio = 1;
                            if($h_dst > $w_dst) {
                                $ratio = round($h_dst / $h_src, 4);
                            }
                            if($h_dst < $w_dst) {
                                $ratio = round($w_dst / $w_src, 4);
                            }
                            $new_h = round($h_src * $ratio);
                            $new_w = round($w_src * $ratio);

                            $this->logInfo("Resize crop/enlarge ({$ratio})", array($w_src, $h_src, $new_w, $new_h));
                            if($this->_prepareDstImage($new_w, $new_h)) {
                                imagecopyresampled($this->dst_image, $this->src_image, 0, 0, 0, 0, $new_w, $new_h, $w_src, $h_src);
                                $this->logInfo('Resize crop/enlarge OK');
                            } else {
                                $this->logInfo('Resize crop/enlarge error');
                                $this->setError('Resize&crop&enlarge error');
                                return false;
                            }
    
                            // calculations and cut image
                            if($w_src > $w_dst or $h_src > $h_dst) {
                                $centerSrcW = round($new_w/2, 1);
                                $centerSrcH = round($new_h/2, 1);
                                if($new_h > $h_dst) {
                                    $src_y = floor($centerSrcH - $centerDstH);
                                    $new_h = $h_dst;
                                }
                                if($new_w > $w_dst) {
                                    $src_x = floor($centerSrcW - $centerDstW);
                                    $new_w = $w_dst;
                                }
                                
                                imagedestroy($this->src_image);
                                $this->src_image = $this->dst_image;
                                $this->logInfo('Resize crop/enlarge/crop');
                                if($this->_prepareDstImage($new_w, $new_h)) {
                                    imagecopy($this->dst_image, $this->src_image, 0, 0, $src_x, $src_y, $new_w, $new_h);
                                    $this->logInfo('Resize crop/enlarge/crop OK');
                                } else {
                                    $this->logInfo('Resize crop/enlarge/crop error');
                                    return false;
                                }
                            }
                        }
                    }
                    break;
                
                case self::RESIZE_METHOD_STRETCH:
                    $this->logInfo('Resize stretch');
                    if(!$enlarge and $w_src <= $w_dst and $h_src <= $h_dst) {
                        $result = copy($this->_oldfileAddr, $this->_newFileAddr);
                        return $result;
                    } else {
                        $new_h = $h_dst;
                        $new_w = $w_dst;
                    }
                    if($this->_prepareDstImage($new_w, $new_h)) {
                        imagecopyresampled($this->dst_image, $this->src_image, 0, 0, 0, 0, $new_w, $new_h, $w_src, $h_src);
                        $this->logInfo('Resize stretch OK');
                    } else {
                        $this->logInfo('Resize stretch error');
                        $this->setError('Resize&stretch error');
                        return false;
                    }
                    break;
            }
        }

        if (!empty($this->_preset['water-image']) || !empty($this->_preset['water-text'])) {
            $this->logInfo('Watermarking');
            $this->_addWatermark();
        }

        $this->logInfo('Saving as '.$this->_fileExtension);
        imagesavealpha($this->dst_image, true);
        switch($this->_fileExtension)
        {
            case 'jpeg':
            case 'jpe':
            case 'jpg':
                $return = @imagejpeg($this->dst_image, $this->_newFileAddr, 100);
                break;

            case 'png':
                $return = @imagepng($this->dst_image, $this->_newFileAddr);
                break;

            case 'gif':
                $return = @imagegif($this->dst_image, $this->_newFileAddr);
                break;

            case 'gd':
                $return = @imagegd2($this->dst_image, $this->_newFileAddr, IMG_GD2_COMPRESSED);
                break;

            default:
                $this->setError('Unsupported media type of target file: ' . $this->_fileExtension);
                return false;
        }

        imagedestroy($this->src_image);
        $this->logInfo('Resize finished');
        if (!$return) $this->setError('Result save error');
        return $return;
    }

    /**
     * Calculate watermark position
     *
     * @param int $watermark_width
     * @param int $watermark_height
     * @return array(x, y)
     */
    private function _getWatermarkPosition($watermark_width, $watermark_height)
    {
        $margin_x = isset($this->_preset['water-margin-h']) ? intval($this->_preset['water-margin-h']) : 0;
        $margin_y = isset($this->_preset['water-margin-v']) ? intval($this->_preset['water-margin-v']) : 0;

        if (!isset($this->_preset['water-place']) || ($this->_preset['water-place'] == 'bottom-right')) {
            $x = imagesx($this->dst_image) - $watermark_width - $margin_x;
            $y = imagesy($this->dst_image) - $watermark_height - $margin_y;
        } elseif ($this->_preset['water-place'] == 'top-left') {
            $x = $margin_x;
            $y = $margin_y;
        } elseif ($this->_preset['water-place'] == 'top-right') {
            $x = imagesx($this->dst_image) - $watermark_width - $margin_x;
            $y = $margin_y;
        } elseif ($this->_preset['water-place'] == 'bottom-left') {
            $x = $margin_x;
            $y = imagesy($this->dst_image) - $watermark_height - $margin_y;
        } elseif ($this->_preset['water-place'] == 'center') {
            $x = round( (imagesx($this->dst_image) - $watermark_width) / 2);
            $y = round( (imagesy($this->dst_image) - $watermark_height) / 2);
        } else {
            $this->setError('Unsupported watermark place');
            return false;
        }
        return array('x'=>$x, 'y'=>$y);
    }

    /**
     * Convert the image to true color
     */
    private function _setTrueColor()
    {
        $w = imagesx($this->dst_image);
        $h = imagesy($this->dst_image);
        $img = imagecreatetruecolor($w, $h);
        imagecopy($img, $this->dst_image, 0, 0, 0, 0, $w, $h);
        imagedestroy($this->dst_image);
        $this->dst_image = $img;
    }

    /**
     * Apply opacity filter to the image
     * @param $img - image resource id,
     * @param $opacity
     */
    private function _filterOpacity($img, $opacity)
    {
        $w = imagesx($img);
        $h = imagesy($img);
        imagealphablending($img, false);

        //find the most opaque pixel in the image (the one with the smallest alpha value)
        $minalpha = 127;
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $alpha = ( imagecolorat( $img, $x, $y ) >> 24 ) & 0xFF;
                if ($alpha < $minalpha) {
                    $minalpha = $alpha;
                }
            }
        }
        //loop through image pixels and modify alpha for each
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                //get current alpha value (represents the TANSPARENCY!)
                $colorxy = imagecolorat($img, $x, $y);
                $alpha = ( $colorxy >> 24 ) & 0xFF;
                //calculate new alpha
                if ($minalpha !== 127) {
                    $alpha = 127 + 127 * $opacity * ( $alpha - 127 ) / ( 127 - $minalpha );
                } else {
                    $alpha += 127 * $opacity;
                }
                //get the color index with new alpha
                $alphacolorxy = imagecolorallocatealpha($img, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
                //set pixel with the new color + opacity
                if (!imagesetpixel($img, $x, $y, $alphacolorxy)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Add a watermark to the image
     * @author Roman Chertov
     *
     * @example:
     * image_config.php:
     *
     * Watermark is a image:
     * $image_config['catalog']['thumb'] = array(
     *   'x'=>140,
     *   'y'=>140,
     *   'water-image' => $GLOBALS['config']['rootPath'].'watermark.png',
     *   'water-place' => 'top-left', // or top-right, bottom-left, bottom-right, center, default value is 'bottom-right'
     *   'water-margin-h' => 10, // Horizontal margin
     *   'water-margin-v' => 10, // Vertical margin
     *   'water-opacity' => 0.5, // Opacity, a number between 0 and 1. Default value is 0.3
     *   'water-scale' => 75 // Scale, from 0 to 100
     * );
     *
     * Watermark is a text:
     * $image_config['catalog']['thumb'] = array(
     *   'x'=>300,
     *   'y'=>300,
     *   'water-text' => 'www.tabernacms.com',
     *   'water-text-font' => 'C:/windows/fonts/arial.ttf', // Path to TTF file
     *   'water-opacity' => 0.7,
     *   'water-scale' => 150 // Scale of the text, from 0 to 500
     * );
     */
    private function _addWatermark()
    {
        if (!imageistruecolor($this->dst_image)) {
            $this->_setTrueColor();
        }
        imagealphablending($this->dst_image, true);

        if (!empty($this->_preset['water-image'])) {
            $wm_image = $this->_createImage($this->_preset['water-image']);
            if (!$wm_image) {
                return false;
            }
            $scale_width = $wm_width = imagesx($wm_image);
            $scale_height = $wm_height = imagesy($wm_image);

            if (isset($this->_preset['water-scale'])) {
                $img_width = imagesx($this->dst_image);
                $img_height = imagesy($this->dst_image);
                $scale = intval($this->_preset['water-scale']);

                if ($img_width > $img_height) {
                    if ($wm_width < $wm_height) {
                        $scale_height = round(($img_height * $scale) / 100);
                        $scale_width = $wm_width * $scale_height / $wm_height;
                    } else {
                        $scale_width = round(($img_height * $scale) / 100);
                        $scale_height = $wm_height * $scale_width / $wm_width;
                    }
                } else {
                    if ($wm_width < $wm_height) {
                        $scale_height = round(($img_width * $scale) / 100);
                        $scale_width = $wm_width * $scale_height / $wm_height;
                    } else {
                        $scale_width = round(($img_width * $scale) / 100);
                        $scale_height = $wm_height * $scale_width / $wm_width;
                    }
                }
            }
        } elseif (!empty($this->_preset['water-text'])) {
            if (!file_exists($this->_preset['water-text-font'])) {
                return false;
            }
            $text_height = self::WATERMARK_TEXT_HEIGHT;
            if (isset($this->_preset['water-scale'])) {
                $scale = intval($this->_preset['water-scale']);
                if ($scale == 0) {
                    return true;
                } elseif (($scale > 0) && ($scale < 500)) {
                    $text_height = round($text_height * $scale / 100);
                }
            }

            $text_box = imagettfbbox($text_height, 0, $this->_preset['water-text-font'], $this->_preset['water-text']);
            $wm_width = $scale_width = $text_box[4] - $text_box[0];
            $wm_height = $scale_height = $text_box[1] - $text_box[5];
            $wm_image = imagecreatetruecolor($wm_width, $wm_height);
            imagealphablending($wm_image, false);
            imagesavealpha($wm_image, true);
            $transparent = imagecolorallocatealpha($wm_image, 0, 0, 0, 127);
            imagefill($wm_image, 0, 0, $transparent);

            $black = imagecolorallocate($wm_image, 0, 0, 0);
            imagettftext($wm_image, $text_height, 0, 0, $wm_height-$text_box[1], $black, $this->_preset['water-text-font'], $this->_preset['water-text']);
        } else {
            return false;
        }

        if (!($position = $this->_getWatermarkPosition($scale_width, $scale_height))) {
            return false;
        }

        $opacity = isset($this->_preset['water-opacity']) ? round($this->_preset['water-opacity'], 2) : self::WATERMARK_OPACITY;
        if ($opacity == 0) {
            return true;
        } elseif ($opacity > 0 && $opacity < 1) {
            $this->_filterOpacity($wm_image, $opacity);
        }

        imagecopyresampled($this->dst_image, $wm_image, $position['x'], $position['y'], 0, 0, $scale_width, $scale_height, $wm_width, $wm_height);
        return true;
    }

    /**
     * Check GD2 library and prepare image to resize
     * 
     * @param int $w - image width
     * @param int $h - image height
     * @return boolean
     */
    private function _prepareDstImage($w, $h)
    {
        if (function_exists('imagecreatetruecolor')) {
            $this->dst_image = imagecreatetruecolor($w, $h);
            imageAlphaBlending($this->dst_image, false);
            imageSaveAlpha($this->dst_image, true);

            $transparent_index = imagecolortransparent($this->src_image); /* gives the index of current transparent color or -1 */
            if ($transparent_index != -1) {
                $transparent_color = imagecolorsforindex($this->src_image, $transparent_index);
                $transparent_new = imagecolorallocate($this->dst_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                $transparent_new_index = imagecolortransparent($this->dst_image, $transparent_new);
                imagefill($this->dst_image, 0, 0, $transparent_new_index); /* don't forget to fill the new image with the transparent color */
            }
            # $white = @imagecolorallocate($resized_img, 255, 255, 255);
            # @imagefill($resized_img, 0, 0, $white);
            return true;
        } else {
            $this->setError('Requires GD library version 2+');
            return false;
        }        
    }
    
    function setError($msg)
    {
        $this->_error = $msg;
    }
    
    function getError()
    {
        return $this->_error;
    }

    public static function renewCache($fileOriginal, $fileCached, $presetName){
        //TODO: move all verifications from image.php here
        $presetsList = include('image_config.php');
        if (empty($presetsList[$presetName])) {
            throw new RuntimeException('Image preset does not exist!');
        }
        $preset = $presetsList[$presetName];

        if (file_exists($fileCached)) {
            if (time() - filemtime($fileCached) < rad_config::getParam('cache.power.time')) {
                return true;
            }
        } else {
            $cachePath = dirname($fileCached);
            if (!is_dir($cachePath) && !recursive_mkdir($cachePath)) {
                throw new RuntimeException('Could not create cache folder for image');
            }
        }

        $img = new self();
        if (!$img->set($fileOriginal, $fileCached, $preset) || !$img->resize()){
            throw new RuntimeException('Image conversion error: '.$img->getError());
        }
    }

    public static function prepareImages(array $files){
        $theme = rad_loader::getCurrentTheme();
        if (empty($theme)) $theme = 'default';

        foreach($files as $file){
            $fileOriginal = getThemedComponentFile($file['module'], 'img', $file['file']);
            $fileCached = CACHEPATH . 'img' . DS . $theme . DS . $file['module'] . DS . 'original' . DS . str_replace('/', DS, $file['file']);

            if (file_exists($fileCached)) {
                if (time() - filemtime($fileCached) < rad_config::getParam('cache.power.time')) {
                    continue; //File is already cached
                }
            } else {
                $cachePath = dirname($fileCached);
                if (!is_dir($cachePath) && !recursive_mkdir($cachePath)) {
                    throw new RuntimeException('Could not create cache folder for image');
                }
            }
            copy($fileOriginal, $fileCached);
        }
    }

    public static function getLinkToImage($module, $file, $preset){
        if (empty($preset)) {
            //TODO: maybe it'd be better to set "original" preset by default?
            throw new RuntimeException('"Preset" parameter is required in {url type="image"} TAG');
        }
        $fnameOriginal = getThemedComponentFile($module, 'img', $file);
        if (!$fnameOriginal) {
            throw new RuntimeException("File {$file} not found in module {$module} for {url type='image'}");
        }
        $theme = rad_loader::getCurrentTheme();
        if (empty($theme)) $theme = 'default';
        $tail = "img/{$theme}/{$module}/{$preset}/{$file}";
        $fnameCached = CACHEPATH . str_replace('/', DS, $tail);
        self::renewCache($fnameOriginal, $fnameCached, $preset);
        return SITE_URL.'cache/'.$tail;
    }

    private function logInfo($message, $data = null){
        //DEBUG:
        //$log = date('Y-m-d H:i:s').' '.$message;
        //if ($data !== null) $log .= "\n".print_r($data, true);
        //$log .= "\n\n";
        //safe_put_contents(CACHEPATH.'gd_img.log', $log, FILE_APPEND);
    }
}