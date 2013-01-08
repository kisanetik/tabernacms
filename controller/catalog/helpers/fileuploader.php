<?php
/**
 * Controller functions for uploading files
 * @autor Vycheslav Panevskiy
 */
class fileuploader
{
    protected $_controller = null;

    public function __construct(rad_controller $maintainedControeller) {
        $this->_controller = $maintainedControeller;
    }

    public static function getInstance(rad_controller $maintainedControeller) {
        return new self($maintainedControeller);
    }

    /**
     * get current maintained controller
     * @return controller_session_personalcabinet
     */
    public function getController()
    {
        return $this->_controller;
    }

    public function fileUpload()
    {
        $controller = $this->getController();
        $controller->setVar('uiName', $controller->request('uiName'));
        $filePathForSave = $controller->request('filePathForSave', null);

        $fileName = $this->_assignImage('uploadFile', $filePathForSave);
        $result= new stdClass();
        $result->success = $fileName ? true : false;
        $result->fileName = $fileName;
        $controller->setVar('result', $result);
        $this->_afterUpload($fileName);
    }

    /**
     * Copy and assign the images
     * @return array of struct_cat_images - or array() (with count==0 elements, or empty)
     */
    protected  function _assignImage($data_name, $filePathForSave)
    {
        if(!empty($_FILES[$data_name])) {
            $orig_name = $_FILES[$data_name]['name'];
            if((!$_FILES[$data_name]['error']) and ((int)$_FILES[$data_name]['size'])) {
                $currentUser = $this->getController()->getCurrentUser();
                $image = new struct_cat_images();
                $image->img_filename = 't_' . $currentUser->u_id.md5(time() . $currentUser->u_id.$orig_name) . '.' . strtolower( fileext($orig_name) );
                move_uploaded_file($_FILES[$data_name]['tmp_name'], $filePathForSave . $image->img_filename);
                return $image->img_filename;
            }
        }
    }

    public function removeFile()
    {
        $controller = $this->getController();
        $fileName = $controller->request('file', null);
        $filePath = $controller->request('path', null);
        $fullPath = $filePath . $fileName;
        $success = is_file($fullPath) && unlink($fullPath);
        if ($success) {
            $this->_afterRemoveFile($success);
        }
        header('Content-type: application/json');
        echo json_encode(array(
            'success' => $success,
            'message' => 'Deleted'
        ));
        exit;
    }

    /**
     * Инициализация виджета загрузки картинок
     * @param $widgetName имя виджета (Должно совпадать с именем объекта js)
     * @param $images массив ранее загруженных изображений
     */
    public function initWidget($widgetName, $images, $title, $filePathForSave, $urlDir, $multiImages = false)
    {
        $widget = array();
        // префикс используется для согласования имён формы и имён полей виджета
        $widget["namePrefix"] = "";
        $widget["title"] = $title;
        $widget['images'] =  $images ? $images : array();
        $widget['filePathForSave'] =  $filePathForSave;
        $widget['urlDir'] =  $urlDir;
        $imageExtensions = array('gif', 'jpg', 'jpeg', 'png');
        $allowTypes = implode(', ', $imageExtensions);
        $widget['allowTypes'] = $allowTypes;
        // название виджета соответствует названия объекта js класса FileUploadWidget
        $widget["widgetName"] = $widgetName;
        $widget["multiImages"] = $multiImages;
        $widget["fileAddAction"] = '';
        return array_merge(
            $widget,
            $this->_setCustomParams()
        );
    }

    protected function _afterUpload($fileName) {}
    protected function _setCustomParams() {return array('uploadAction' => 'productfileupload');}
    protected function _afterRemoveFile() {}
}
