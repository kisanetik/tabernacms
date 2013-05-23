<?php
/**
 * ported class from extra
 * @package RADCMS
 * @author Denys Yackushev
 */
class rad_gd_image
{
    var $extension = null;
    var $filepath;
    var $filesize;
    var $newfn;
    var $cw = 0;

    var $_error = null;

    function set($oldfn,$newfn, $fsize=0, $ext=null)
    {
        $this->filepath  = $oldfn;
        $this->newfn     = $newfn;
        if(!$fsize) {
            $this->filesize  = filesize($oldfn);
        } else {
            $this->filesize = $fsize;
        }
        if(!$ext) {
            $this->extension = strtolower($this->getExtension());
        } else {
            $this->extension = $ext;
        }
    }

    function resize($width, $height, $type = 'jpg')
    {
        $img = null;
        switch ($this->extension)
        {
            case 'jpeg':
            case 'jpe':
            case 'jpg': {
                $img = imagecreatefromjpeg($this->filepath);
            } break;

            case 'png': {
                $img = imagecreatefrompng($this->filepath);
            } break;

            case 'gif': {
                $img = imagecreatefromgif($this->filepath);
            } break;

            case 'gd': {
                $img = imagecreatefromgd($this->filepath);
            } break;

            default: {
                $this->setError('Unsupported media type of source file: ' . $this->extension);
                return false;
            } break;
        }
        
        $w_src = imagesx($img);
        $h_src = imagesy($img);

        $return = -2;

        if ($w_src > $width or $h_src > $height) {

            if (!$this->cw) {
                $ratioWidth  = $width  / $w_src;
                $ratioHeight = $height / $h_src;

                if ($ratioWidth < $ratioHeight) {
                    $height = intval($h_src * $ratioWidth);
                } elseif ($ratioWidth > $ratioHeight) {
                    $width = intval($w_src * $ratioHeight);
                }
            } else {
                //$height = $h_src;
                //$width = $w_src;
            }

            if (function_exists('imagecreatetruecolor')) {
                $resized_img = imagecreatetruecolor($width, $height);
                
                imageAlphaBlending($resized_img, false);
                imageSaveAlpha($resized_img, true);
                
               # $white = @imagecolorallocate($resized_img, 255, 255, 255);
               # @imagefill($resized_img, 0, 0, $white);
               # @imageColorTransparent($resized_img, $white);
            } else {
                $this->setError('Requires GD library version 2+');
                return false;
            }

            imagecopyresampled($resized_img, $img, 0, 0, 0, 0, $width, $height, $w_src, $h_src);

            switch (strtolower($type))
            {
                case 'jpeg':
                case 'jpe':
                case 'jpg': {
                    $return = @imagejpeg($resized_img, $this->newfn, 100);
                } break;

                case 'png': {
                    $return = @imagepng($resized_img, $this->newfn);
                } break;

                case 'gif': {
                    $return = @imagegif($resized_img, $this->newfn);
                } break;

                case 'gd': {
                    $return = @imagegd2($resized_img, $this->newfn, IMG_GD2_COMPRESSED);
                } break;

                default : {
                    $this->setError('Unsupported media type of target file: ' . $type);
                    return false;
                } break;
            }
        } else {
            $return = copy($this->filepath, $this->newfn);
        }

        imagedestroy($img);

        return $return;
    }

    function getExtension()
    {
        if ($this->extension === null) {
            $this->extension = substr(strrchr($this->filepath, "."), 1);
        }
        return $this->extension;
    }

    function setError($msg)
    {
        $this->_error = $msg;
    }

    function getError()
    {
        return $this->_error;
    }
}