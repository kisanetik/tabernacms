<?php
/**
 * Class for managing products
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */

class controller_catalog_managecatalog extends rad_controller
{
	/**
	 * Root parent id
	 *
	 * @var integer
	 */
	private $_pid = 81;

	/**
	 * Types parent id
	 *
	 * @var integer
	 */
	private $_pid_types = 47;

	/**
	 * Items per page
	 * @var integer
	 */
	private $_itemsPerPage = 20;

	/**
	 * Show images in the list of products?
	 *
	 * @var integer
	 */
	private $_showImages = 0;

	/**
	 * Have special offer in news?
	 * @var boolean
	 */
	private $_have_spnews = false;

	/**
	 * Have special offers?
	 * @var boolean
	 */
	private $_have_sp = false;

	/**
	 * Have special offer?
	 * @var boolean
	 */
	private $_have_spoffer = false;

	/**
	 * Have special offer hit?
	 * @var boolean;
	 */
	private $_have_sphit = false;

	private $_have_downloads = true;

	private $_have_tags = true;

	private $_have_brands = true;
	
    private $_bigmaxsize_x = 800;
    
    private $_bigmaxsize_y = 600;

	public static function getBreadcrumbsVars()
	{
		$bco = new rad_breadcrumbsobject();
		$bco->add('action');
		$bco->add('product');
		$bco->add('curr_cat');
		$bco->add('parents');
		return $bco;
	}

	function __construct()
	{
		if ($this->getParamsObject()){
			$params = $this->getParamsObject();
			$this->_pid = $params->_get('treestart', $this->_pid, $this->getContentLangID());
			$this->_pid_types = $params->_get('treestart_types', $this->_pid_types, $this->getContentLangID());
			$this->_itemsPerPage = $params->itemsperpage;
			$this->_showImages = (boolean)$params->showimages;
			$this->_have_spnews = (boolean)$params->have_spnews;
			$this->_have_sp = (boolean)$params->have_sp;
			$this->_have_spoffer = (boolean)$params->have_spoffer;
			$this->_have_sphit = (boolean)$params->have_sphit;
			$this->_have_downloads = (boolean)$params->have_downloads;
			$this->_have_tags = (boolean)$params->have_tags;
			$this->_have_brands = (boolean)$params->have_brands;
			$this->_bigmaxsize_x = $params->_bigmaxsize_x;
			$this->_bigmaxsize_y = $params->_bigmaxsize_y;
			$this->setVar('params', $params);
		}
		$this->setVar('cat_id', (int)$this->request('cat_id'));
		$this->setVar('searchword', $this->request('searchword', ''));
		$this->setVar('hash', $this->hash());
		if ($this->request('action')){
			$this->setVar('action', $this->request('action'));
			switch($this->request('action')){
				case 'getTreeNodes':
					$this->getNodes();
					break;
				case 'getjs_product':
				case 'getjs':
					$this->getJS();
					break;
				case 'showEditNode':
					$this->showEditNode();
					break;
				case 'addNode':
					$this->addNode();
					break;
				case 'applyEditNode':
					$this->applyEditNode();
					break;
				case 'deleteNode':
					$this->deleteNode();
					break;
				//PRODUCTS LIST
				case 'showProductsList':
					$this->showProductsList();
					break;

				case 'productfileupload':
					include_once 'helpers'.DS.'fileuploader.php';
					$uploader = new fileuploader($this);
					$uploader->fileUpload();
					$this->setVar('typ', 'AJAX');
					break;

				case 'removefile':
					include_once 'helpers'.DS.'fileuploader.php';
					fileuploader::getInstance($this)->removeFile();
					$this->setVar('typ', 'AJAX');
					break;

				case 'addProductForm':
					$this->assignParams();
					if ($this->request('action_sub')){
						switch($this->request('action_sub')){
							case 'add':
								$this->add();
								break;
							case 'edit':
								$this->edit();
								break;
							default:
								$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
								break;
						}
						//switch
					} else {
						$this->addProductForm();
						$this->addBC('action', 'add');
					}
					break;
				case 'getRemoteImg':
					$this->getRemoteImg();
					break;
				case 'getjs_addeditproduct':
					$this->getJSAddEditProduct();
					break;
				case 'getProductTypes':
					$this->getProductTypes();
					break;
				case 'editform':
					$this->assignParams();
					if ($this->request('action_sub')){
						if ($this->request('action_sub') == 'edit'){
							$this->edit();
							if ($this->request('returntorefferer') == '1'){
								$this->editForm();
							}
						}
					} else {
						$this->editForm();
						$this->addBC('action', 'edit');
					}
					break;
				case 'deleteproduct':
					$this->deleteProduct();
					break;
				case 'deleteproducts':
					$this->deleteProductsInTree();
					break;
				case 'deleteproductnojs':
					$this->deleteProductNoJS();
					break;
				case 'searchproduct':
					$this->searchProduct();
					break;
				case 'setactive':
					$this->setActiveJS();
					break;
				case 'newcost':
					$this->newCost();
					break;
				case 'newcur':
					$this->newCurrency();
					break;
				case 'neworder':
					$this->newOrdering();
					break;
				case 'newlngpid':
					$this->newLngPID();
					break;
				case 'getcats':
					$this->getCats();
					break;
				case 'gettypesed':
					$this->getTypesEd();
					break;
				case '3dbin_genere':
					$this->genere3DBin();
					break;
				case '3dbin_check':
					$this->check3DBin();
					break;
				case '3dbin_refresh':
					if (!$this->request('cat_id')){
						$this->redirect('404');
					}
					$this->get3DBinItems((int)$this->request('cat_id'));
					break;
				default:
					$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
					break;
			}
			//switch
		} else {
			$this->assignTree();
			$this->setVar('pid', $this->_pid);
		}
		//else
	}

	//construct

	function assignTree()
	{
		$model = rad_instances::get('model_menus_tree');
		$model->setState('pid', $this->_pid);
		$model->setState('lang', $this->getContentLangID());
		$items = $model->getItems(true);
		$this->setVar('items', $items);
	}

	function getNodes()
	{
		$model = rad_instances::get('model_menus_tree');
		$model->setState('pid', $this->request('pid', $this->_pid));
		$model->setState('lang', $this->getContentLangID());
		$items = $model->getItems();
		$s = '<?xml version="1.0"?><nodes>';
		if (count($items)){
			$search = array('"', '&');
			$replace = array('&quot;', '&amp;');
			foreach($items as $id){
				$s .= '<node text="'.str_replace($search, $replace, $id->tre_name).'"';
				$s .= ($id->tre_active) ? '' : ' color="#808080"';
				$s .= ($id->tre_islast) ? '' : ' load="'.$this->makeURL('action='.$this->request('action').'&pid='.$id->tre_id).'"';
				$s .= ' id="'.$id->tre_id.'"';
				$s .= ' islast="'.$id->tre_islast.'"';
				$s .= ' />';
			}
			//foreach
		}
		//if
		$s .= '</nodes>';
		$this->header('Content-Length: '.strlen($s));
		$this->header('Content-Type: application/xml');
		echo $s;
	}

	function getJS()
	{
		$model = rad_instances::get('model_menus_tree');
		$root_node = $model->getItem($this->_pid);
		$this->setVar('root_node', $root_node);
		$this->setVar('PID', $this->_pid);
		$this->setVar('hash', $this->hash());
	}

	/**
	 * Show the edit node form
	 *
	 * @return html
	 *
	 */
	function showEditNode()
	{
		$id = (int)$this->request('node_id');
		if ($id){
			$model = rad_instances::get('model_menus_tree');
			$this->setVar('tree', $model->getItem($id));
			$trees[0] = $model->getItem($this->_pid);
			$model->setState('pid', $this->_pid);
			$model->setState('lang', $this->getContentLangID());
			$trees[0]->child = $model->getItems(true);
			$this->setVar('trees', $trees);
			$this->setVar('pid', $this->_pid);
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	/**
	 * Adds the default node
	 *
	 * @return JavaScript
	 *
	 */
	function addNode()
	{
		$node_id = (int)$this->request('node_id');
		if ($node_id){
			$model = rad_instances::get('model_menus_tree');
			$p_item = $model->getItem($node_id);
			$rows = 0;
			if ($p_item->tre_islast){
				$p_item->tre_islast = 0;
				$rows += $model->updateItem($p_item);
			}
			$item = new struct_tree();
			$item->tre_pid = $node_id;
			$item->tre_position = '1';
			$item->tre_name = $this->lang('defaultnodename.catalog.text').'_'.$p_item->tre_id;
			$item->tre_lang = $p_item->tre_lang;
			$rows += $model->insertItem($item);
			if ($rows){
				$item_id = $model->inserted_id();
				echo 'RADCatalogTree.dynamiclyInsert("'.addslashes($item->tre_name).'",'.$item_id.');';
				echo 'RADCatalogTree.editSelected();';
				echo 'RADCatalogTree.message("'.$this->lang('-inserted').': '.$rows.'");';
			} else {
				echo 'alert("'.addslashes($this->lang('-updated')).'");';
			}
		}
		//if node_id
	}

	/**
	 * Save the node
	 *
	 * @return JavaScript
	 *
	 */
	function applyEditNode()
	{
		if ($this->request('hash') == $this->hash()){
			$item = new struct_tree($this->getAllRequest());
			$item->tre_id = (int)$this->request('node_id');
			$item->tre_lang = $this->getContentLangID();
			$model = rad_instances::get('model_menus_tree');
			if ($item->tre_id == $this->_pid){
				$oldItem = $model->getItem($item->tre_id);
				$item->tre_pid = $oldItem->tre_pid;
			}
			$rows = $model->updateItem($item);
			//TODO  check the new parent and the old parent and try to change the islast
			if ($rows){
				echo 'RADCatalogTree.message("'.$this->lang('-updated').': '.$rows.'");';
				echo 'RADCatalogTree.cancelEdit();';
				echo 'RADCatalogTree.refresh();';
			} else {
				echo 'alert("'.addslashes($this->lang('norowsupdated.catalog.message')).'");';
			}
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	private function _deleteRecurseNodes($nodes)
	{
		$rows = 0;
		foreach($nodes as $id){
			if (is_array($id->child)){
				$rows += $this->_deleteRecurseNodes($id->child);
			}
			$model = rad_instances::get('model_menus_tree');
			$rows += $model->deleteItem($id);
		}
		return $rows;
	}

	/**
	 * Deletes the tree node
	 *
	 * @return JavaScript
	 */
	function deleteNode()
	{
		if ($this->request('hash') == $this->hash()){
			$node_id = (int)$this->request('node_id');
			if ($node_id){
				$model = rad_instances::get('model_menus_tree');
				$node = $model->getItem($node_id);
				$rows = 0;
				$rows += $model->deleteItemById($node_id);
				$parent_node = $model->getItem($node->tre_pid);
				if (!$node->tre_islast){
					$model->setState('pid', $node_id);
					$child_nodes = $model->getItems(true);
					$rows += $this->_deleteRecurseNodes($child_nodes);
				}
				$model->setState('pid', $parent_node->tre_id);
				$child_parents = $model->getItems();
				if (!count($child_parents)){
					$parent_node->tre_islast = 1;
					$model->updateItem($parent_node);
				}
				if ($rows){
					echo 'RADCatalogTree.message("'.$this->lang('-deleted').': '.$rows.'");';
					echo 'RADCatalogTree.cancelEdit();';
					echo 'RADCatalogTree.refresh();';
				} else {
					echo 'alert("'.addslashes($this->lang('norowsdeleted.catalog.message')).'");';
				}
			} else {
				$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
			}
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	/**
	 * Shows the products list in some node_id
	 *
	 * @return html
	 *
	 */
	function showProductsList()
	{
		$node_id = (int)$this->request('node_id');
		if ($node_id){
			$model = rad_instances::get('model_catalog_catalog');
			$model->setState('tre_id', $node_id)
				->setState('lang', $this->getContentLangID());
			$this->setVar('items', $model->getProductsList());
			$this->setVar('currencys', rad_instances::get('model_catalog_currency')->getItems());
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function addProductFormFiles()
	{
		$result = array();

		$result['time'] = date('r');
		$result['addr'] = substr_replace(gethostbyaddr($_SERVER['REMOTE_ADDR']), '******', 0, 6);
		$result['agent'] = $_SERVER['HTTP_USER_AGENT'];

		if (count($_GET)){
			$result['get'] = $_GET;
		}
		if (count($_POST)){
			$result['post'] = $_POST;
		}
		if (count($_FILES)){
			$result['files'] = $_FILES;
		}

		// we kill an old file to keep the size small
		if (file_exists('script.log') && filesize('script.log')>102400){
			unlink('script.log');
		}

		$log = @fopen('script.log', 'a');
		if ($log){
			fputs($log, print_r($result, true)."\n---\n");
			fclose($log);
		}


		// Validation

		$error = false;

		if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])){
			$error = 'Invalid Upload';
		}

		/**
		 * You would add more validation, checking image type or user rights.
		 *

		if (!$error && $_FILES['Filedata']['size'] > 2 * 1024 * 1024)
		{
		$error = 'Please upload only files smaller than 2Mb!';
		}

		if (!$error && !($size = @getimagesize($_FILES['Filedata']['tmp_name']) ) )
		{
		$error = 'Please upload only images, no other files are supported.';
		}

		if (!$error && !in_array($size[2], array(1, 2, 3, 7, 8) ) )
		{
		$error = 'Please upload only images of type JPEG, GIF or PNG.';
		}

		if (!$error && ($size[0] < 25) || ($size[1] < 25))
		{
		$error = 'Please upload an image bigger than 25px.';
		}
		 */


		// Processing

		/**
		 * Its a demo, you would move or process the file like:
		 *
		 * move_uploaded_file($_FILES['Filedata']['tmp_name'], '../uploads/' . $_FILES['Filedata']['name']);
		 * $return['src'] = '/uploads/' . $_FILES['Filedata']['name'];
		 *
		 * or
		 *
		 * $return['link'] = YourImageLibrary::createThumbnail($_FILES['Filedata']['tmp_name']);
		 *
		 */

		if ($error){

			$return = array(
				'status' => '0',
				'error' => $error
			);

		} else {

			$return = array(
				'status' => '1',
				'name' => $_FILES['Filedata']['name']
			);

			// Our processing, we get a hash value from the file
			$return['hash'] = md5_file($_FILES['Filedata']['tmp_name']);

			// ... and if available, we get image data
			$info = @getimagesize($_FILES['Filedata']['tmp_name']);

			if ($info){
				$return['width'] = $info[0];
				$return['height'] = $info[1];
				$return['mime'] = $info['mime'];
			}

		}


		// Output

		/**
		 * Again, a demo case. We can switch here, for different showcases
		 * between different formats. You can also return plain data, like an URL
		 * or whatever you want.
		 *
		 * The Content-type headers are uncommented, since Flash doesn't care for them
		 * anyway. This way also the IFrame-based uploader sees the content.
		 */

		if (isset($_REQUEST['response']) && $_REQUEST['response'] == 'xml'){
			// header('Content-type: text/xml');

			// Really dirty, use DOM and CDATA section!
			echo '<response>';
			foreach($return as $key => $value){
				echo "<$key><![CDATA[$value]]></$key>";
			}
			echo '</response>';
		} else {
			// header('Content-type: application/json');

			echo json_encode($return);
		}
	}

	function addProductForm()
	{
		$model = rad_instances::get('model_menus_tree');
		$model->setState('pid', $this->request('pid', $this->_pid));
		$this->setVar('trees', $model->getItems(true));
		$this->setVar('selected_tree', array($this->request('node_id')));
		$model->setState('pid', $this->_pid_types);
		$producttypes = $model->getItems(true);
		$firest_el = new struct_tree(array('tre_name' => $this->lang('-pleaseselect')));
		array_unshift($producttypes, $firest_el);
		$this->setVar('producttypes', $producttypes);
		$this->setVar('currencys', rad_instances::get('model_catalog_currency')->getItems());
		$this->setVar('product', new struct_catalog());
		$model->clearState(); // -- breadcrumbs
		$curr_cat = $model->getItem($this->request('node_id'));
		$this->addBC('curr_cat', $curr_cat);
		$cat_path = $model->getCategoryPath($curr_cat, $this->_pid, 0);
		unset($cat_path[0]);
		$this->addBC('parents', $cat_path); // -- end
		/** FOR MEASUREMENT IN RIGHT PANEL WHITCH NAMED "MAGAZINE"*/
		$model = new model_system_table(RAD.'measurement');
		$model->setState('order by', 'ms_position,ms_value');
		$measurements = $model->getItems();
		$this->setVar('measurements', $measurements);
		$model = rad_instances::get('model_catalog_brands');
		$this->setVar('brands', $model->getListBrands());
		$this->setVar('max_post', $this->configSys('max_post'));
		$this->setVar('max_post', $this->configSys('max_post'));

		include_once 'helpers'.DS.'fileuploader.php';
		$uploader = new fileuploader($this);
		$imageWidgets = array(
			$uploader->initWidget('images', array(), '', CATALOGORIGINALPATCH, 'catalog', true)
		);
		$this->setVar('widgets', $imageWidgets);
	}

	function getJSAddEditProduct()
	{
		$this->setVar('PID', $this->request('pid', $this->_pid));
	}

	private function _getProductTypesItems(&$items, $cat_id = NULL)
	{
		for($i = 0; $i<count($items); $i++){
			model_catalog_types::autoloadPlugins($items[$i]->vl_type_in);
			$items[$i]->getHTML = call_user_func(array($items[$i]->vl_type_in, 'getHTML'), $items[$i]); //::getHTML($item);
			if (isset($items->child) and is_array($items->child)){
				$this->_getProductTypesItems($items->child);
			}
		}
		//foreach
	}

	function getProductTypes()
	{
		$node_id = (int)$this->request('node_id');
		if ($node_id){
			$cat_id = (int)$this->request('cat_id');
			$model = rad_instances::get('model_catalog_types');
			$model->setState('vl_active', '1');
			$model->setState('vl_tre_id', $node_id);
			$model->setState('pid_types', $this->_pid_types);
			if ($cat_id){
				$model->setState('cat_id', $cat_id);
			}
			$items = $model->getItems(true);
			$this->_getProductTypesItems($items, $this->request('cat_id'));
			$this->setVar('items', $items);
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function getRemoteImg()
	{
		$url = $this->request('url');
		$url = urldecode($url);
		//$filename = md5($url . mktime(date("H"), 0, 0, date("n"), date("j"), date("Y")));
		$filename = md5($url . mktime(0, 0, 0, date("n"), date("j"), date("Y")));
		$fileadr = SMARTYCACHEPATH.$filename;
        $msg = '';
        
		if ($url and strpos($url, "http") === 0) 
		{
		    $opts = array('http' => array(
		                    'method' => "GET",
		                    'max_redirects' => 5,
		                    'timeout' => 5,
		                    'ignore_errors' => false
		                    )
                    );
		    $context = stream_context_create($opts);
		    $i = 3;
		    $fileData = NULL;
		    do {
		        $header = get_headers($url, 1);
		        if(isset($header['Content-Length'])) {
		            $contentLength = (int) $header['Content-Length'];
		            $maxPost = (int) $this->configSys('max_post');
    		        if($contentLength <= $maxPost) {
    		            if(!file_exists($fileadr)) {
            	            $fileData = @file_get_contents($url, false, $context);
            	            if($fileData) {
                	            $i = 0;
                	        } else {
                	            $i--;
                	        }
    		            } else {
    		                $fileExt = $this->_getImageExtension($fileadr);
    		                if($fileExt) {
    		                    die(json_encode(array('is_success'=>true, 'filename'=>$filename.'.'.$fileExt)));
    		                } else {
    		                    unlink($fileadr);
    		                    $i--;
    		                }
    		            }
    		        } else {
    		            $i = 0;
    		            $msg = $this->lang('imagesizetoobig.catalog.error');
    		        }
		        }
		    } while ($i > 0);
		    if($fileData) {
		        $hFile = fopen($fileadr, 'w');
		        if($hFile) {
		            fputs($hFile, $fileData);
		            flush();
		            fclose($hFile);
		            $fileExt = $this->_getImageExtension($fileadr);
		            if($fileExt) {
		                $fileInfo = getimagesize($fileadr);                
		                $gdImg = new rad_gd_image();
		                $gdImg->set($fileadr, $fileadr.'.'.$fileExt, 0 ,$fileExt);
		                $gdImg->resize($fileInfo[0], $fileInfo[1]);
		                die(json_encode(array('is_success'=>true, 'filename'=>$filename.'.'.$fileExt)));
		            } else {
		                unlink($fileadr);
		                $msg = $this->lang('wrongfiledata.catalog.error');		                
		            }
		        } else {
		            $msg = $this->lang('cannotcreatefile.catalog.error');
		        }
		    }
		} else {
			$msg = $this->lang('wrongimageurl.catalog.error');
		}
		die(json_encode(array('is_success'=>false, 'msg'=>$msg)));
	}

	private function _getImageExtension($fileadr='')
	{
	    $fileExt = null;
	    if(!empty($fileadr)) {
    	    $fileInfo = getimagesize($fileadr);
    	    switch($fileInfo['mime']) {
    	        case 'image/jpeg':
    	        case 'image/jpg':
    	        case 'image/jpe':
    	            $fileExt = 'jpg';
    	            break;
    	        case 'image/png':
    	            $fileExt = 'png';
    	            break;
    	        case 'image/bmp':
    	            $fileExt = 'bmp';
    	            break;
    	        case 'image/gif':
    	            $fileExt = 'gif';
    	            break;
    	    }
	    }
	    return $fileExt;
	}
	
	/**
	 * Copy and assign files
	 *
	 * @param string  $data_name
	 * @param integer $cat_id
	 *
	 * @access private
	 * @return array of struct_cat_files
	 */
	private function _assignFiles($data_name, $cat_id = NULL)
	{
		$return = array();
		if (!empty($_FILES[$data_name])){
			foreach($_FILES[$data_name]['name'] as $orig_name_id => $orig_name){
				if ((!$_FILES[$data_name]['error'][$orig_name_id]) and file_exists($_FILES[$data_name]['tmp_name'][$orig_name_id]) and ((int)$_FILES[$data_name]['size'][$orig_name_id])){
					if ($cat_id){
						$return[$orig_name_id] = new struct_cat_files(array('rcf_cat_id' => $cat_id, 'rcf_name' => $_FILES[$data_name]['name'][$orig_name_id]));
					} else {
						$return[$orig_name_id] = new struct_cat_files(array('rcf_name' => $_FILES[$data_name]['name'][$orig_name_id]));
					}
					$return[$orig_name_id]->rcf_filename = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$orig_name).'.'.strtolower(fileext($orig_name));
					move_uploaded_file($_FILES[$data_name]['tmp_name'][$orig_name_id], DOWNLOAD_FILES_DIR.$return[$orig_name_id]->rcf_filename);
				}
			}
			//foreach
		}
		return $return;
	}

	/**
	 * Copy and assign the images
	 *
	 * @param string  $data_name
	 * @param integer $cat_id
	 *
	 * @access private
	 * @return array of struct_cat_images - or array() (with count==0 elements, or empty)
	 */
	private function _assignImages($data_name, $rem_data_name, $cat_id = NULL)
	{
		$return = array();
		$i = 0;
		if (!empty($_FILES[$data_name])){
			foreach($_FILES[$data_name]['name'] as $orig_name_id => $orig_name){
				if ((!$_FILES[$data_name]['error'][$orig_name_id]) and file_exists($_FILES[$data_name]['tmp_name'][$orig_name_id]) and ((int)$_FILES[$data_name]['size'][$orig_name_id])){
					if ($cat_id){
						$return[$orig_name_id] = new struct_cat_images(array('img_cat_id' => $cat_id));
					} else {
						$return[$orig_name_id] = new struct_cat_images();
					}
					$return[$orig_name_id]->img_filename = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$orig_name).'.'.strtolower(fileext($orig_name));
					move_uploaded_file($_FILES[$data_name]['tmp_name'][$orig_name_id], CATALOGORIGINALPATCH.$return[$orig_name_id]->img_filename);
				}
				if($orig_name_id > $i) {
				    $i++;
				}
			}
		}
		if ($this->request($rem_data_name)) {
		    $files = $this->request($rem_data_name);
		    foreach($files as $orig_name_id => $orig_name) {
		        if (file_exists(SMARTYCACHEPATH.$orig_name)) {
		            if ($cat_id) {
		                $return[$i] = new struct_cat_images(array('img_cat_id' => $cat_id));
		            } else {
		                $return[$i] = new struct_cat_images();
		            }
		            $return[$i]->img_filename = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$orig_name).'.'.strtolower(fileext($orig_name));
		            copy(SMARTYCACHEPATH.$orig_name, CATALOGORIGINALPATCH.$return[$i]->img_filename);
		            $i++;
		        }
		    }
		}		
		return $return;
	}

	/**
	 * Assign from request data to product
	 * @return struct_catalog
	 */
	private function _assignProductFromRequest($cat_id = NULL)
	{
		$errors = array();
		$product = new struct_catalog();
		$product->cat_lngid = $this->getContentLangID();
		if ($cat_id){
			$product->cat_id = $cat_id;
		}
		$product->cat_name = stripslashes($this->request('productname'));
		$product->cat_article = stripslashes($this->request('productarticle'));
		$product->cat_code = stripslashes($this->request('productcode'));
		$product->cat_active = $this->request('productactive') ? 1 : 0;
		$product->cat_position = (int)$this->request('productposition');
		$product->cat_usercreated = $this->getCurrentUser()->u_id;
		$product->cat_ct_id = (int)$this->request('typeproduct');
		//Parse product type
		//TODO Make this product

		if ($product->cat_ct_id){
			$product->type_link = rad_instances::get('model_menus_tree')->getItem($product->cat_ct_id);
			$model_ct = rad_instances::get('model_catalog_types');
			$product->type_vl_link = array();
			if ($this->request('val_name')){
				foreach($this->request('val_name') as $vl_name_id => $vl_value){
					$product->type_vl_link[] = $model_ct->getItem((int)$vl_name_id);
					//TODO if the value is array - finish
					//TODO Also not finished the position
					$cnt = count($product->type_vl_link) - 1;
					if (is_array($vl_value)){
						$i = 0;
						foreach($vl_value as $vv_id => $vv_value){
							$product->type_vl_link[$cnt]->vv_values[$i] = new struct_cat_val_values();
							$product->type_vl_link[$cnt]->vv_values[0]->vv_id = (int)$vv_id;
							$product->type_vl_link[$cnt]->vv_values[0]->vv_name_id = (int)$vl_name_id;
							$product->type_vl_link[$cnt]->vv_values[0]->vv_value = stripslashes($vv_value);
							if ($cat_id){
								$product->type_vl_link[$cnt]->vv_values[0]->vv_cat_id = $cat_id;
							}
							++$i;
						}
						//foreach
					} else {
						$product->type_vl_link[$cnt]->vv_values[] = new struct_cat_val_values();
						$product->type_vl_link[$cnt]->vv_values[0]->vv_name_id = (int)$vl_name_id;
						$product->type_vl_link[$cnt]->vv_values[0]->vv_value = stripslashes($vl_value);
					}
				}
				//foreach
			}
		}
		//end parse product type
		$product->cat_shortdesc = stripslashes($this->request('FCKeditorShortDescription'));
		$product->cat_fulldesc = stripslashes($this->request('FCKeditorFullDescription'));
		//Magazine
		$product->cat_cost = (float)str_replace(',', '.', $this->request('cost'));
		$product->cat_buy_cost = (float)str_replace(',', '.', $this->request('cat_buy_cost'));
		$product->cat_availability = ($this->request('cat_availability')) ? '1' : '0';
		$product->cat_currency_id = (int)$this->request('currency_name');
		//Meta-tags
		$product->cat_keywords = stripslashes($this->request('meta_keywords'));
		$product->cat_metatitle = stripslashes($this->request('meta_title'));
		$product->cat_metatescription = stripslashes($this->request('meta_description'));

		//rad_cat_in_tree
		if ($this->request('product_tree')){
			$product->tree_link = array();
			foreach($this->request('product_tree') as $id => $tre_id){
				if ($cat_id){
					$product->tree_link[] = new struct_cat_in_tree(array('cit_tre_id' => $tre_id, 'cit_cat_id' => $cat_id));
				} else {
					$product->tree_link[] = new struct_cat_in_tree(array('cit_tre_id' => $tre_id));
				}
			}
		} else { //DEFAULT TREE PARENT PID
			$product->tree_link = array();
			if ($cat_id){
				$product->tree_link[] = new struct_cat_in_tree(array('cit_tre_id' => $this->_pid, 'cit_cat_id' => $cat_id));
			} else {
				$product->tree_link[] = new struct_cat_in_tree(array('cit_tre_id' => $this->_pid));
			}
		}

		//IMAGES
		if (isset($_FILES['product_image']) and count($_FILES['product_image'])){
			if ($cat_id){
				$product->images_link = $this->_assignImages('product_image', 'remote_image', $cat_id);
			} else {
				$product->images_link = $this->_assignImages('product_image', 'remote_image');
			}
		}
		
		//DELETE IMAGES
		if ($this->request('del_img')){
			foreach($this->request('del_img') as $img_id => $on){
				rad_instances::get('model_system_image')->deleteItemsByCat($img_id, true);
			}
			//foreach
		}
		//if del_img
		//Sets teh default image default_image
		$default_image_num = $this->request('default_image');
		if ((strlen($default_image_num)>=4) and ($default_image_num[0].$default_image_num[1] == 'id')){ //checked existing image
			$img_id = explode('_', $default_image_num);
			if (count($img_id)>=2){
				$img_id = (int)$img_id[1];
				if ($img_id and $product->cat_id){
					if (is_array($this->request('del_img')) and in_array($img_id, array_keys($this->request('del_img'))))
						$img_id = 0;
					rad_instances::get('model_system_image')->setDefaultImage($img_id, $product->cat_id);
				} else {
					$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
				}
			}
		} else { //checked new image
			$default_image_num = (int)$default_image_num;
			if (isset($product->images_link[$default_image_num])){
				$product->images_link[$default_image_num]->img_main = 1;
			}
		}
		//DOWNLOAD FILES
		//IS DOWNLOAD FILES?
		if ($this->_have_downloads){
			if (!empty($_FILES['product_file'])){
				$product->download_files = $this->_assignFiles('product_file', $cat_id);
			}
			//DELETE FILES
			if ($this->request('del_file')){
				foreach($this->request('del_file') as $file_id => $on){
					rad_instances::get('model_system_files')->deleteFilesByCat($file_id, true);
				}
				//foreach
			}
			//if del_img
		}

		//IS HAVE TAGS?
		if ($this->_have_tags){
			if (strlen(trim($this->request('producttags')))){
				$model_tags = rad_instances::get('model_resource_tags');
				$tags_array = $model_tags->addItems(trim($this->request('producttags')));
				if (count($tags_array)){
					foreach($tags_array as $id_tag => $tag_id){
						$product->tags[] = new struct_tags_in_item(array('tii_item_id' => $product->cat_id, 'tii_tag_id' => $tag_id));
					}
				}
			}
		}

		if ($this->_have_brands){
			if ($this->request('cat_brand_id'))
				$product->cat_brand_id = ($this->request('cat_brand_id') !== 0) ? $this->request('cat_brand_id') : NULL;
		}

		/*SPECIAL OFFERS*/
		//IS SPECIAL OFFER?
		if ($this->_have_sp){
			if ($this->request('productsp')){
				$product->cat_special_sp = true;
			}
		}
		if ($this->_have_sphit){
			if ($this->request('productsphit')){
				$product->cat_special_sphit = true;
			}
		}
		if ($this->_have_spnews){
			if ($this->request('productnew')){
				$product->cat_special_spnews = true;
			}
		}
		if ($this->_have_spoffer){
			if ($this->request('productspoffer')){
				$product->cat_special_spoffer = true;
			}
		}
		return $product;
	}

	/**
	 * Adds the product from add product form
	 * full post request
	 */
	function add()
	{
		$parent_id = (int)$this->request('parent_id');
		$product = $this->_assignProductFromRequest();
		$product->cat_datecreated = now();
		if ($product){
			$model = rad_instances::get('model_catalog_catalog');
			if ($this->_have_sp or $this->_have_sphit or $this->_have_spnews or $this->_have_spoffer){
				$model->setState('sp_offers', true);
			}
			$newItem = $model->insertItem($product);
			if ($this->request('returntorefferer') == '0'){
				$url = $this->makeURL('alias='.SITE_ALIAS);
			} else { //if apply clicked
				$url = $this->makeURL('alias='.SITE_ALIAS.'&action=editform&cat_id='.$newItem->cat_id);
			}
			if (strlen($parent_id)>0){
				$url .= '#nic/'.$parent_id;
			}
			$this->redirect($url);

		}
	}

	/**
	 * Edit the product from edit product form
	 * full post request
	 *
	 */
	function edit()
	{
		$cat_id = (int)$this->request('cat_id');
		$parent_id = (int)$this->request('parent_id');
		$product = $this->_assignProductFromRequest($cat_id);
		if ($product){
			$model = rad_instances::get('model_catalog_catalog');
			if ($this->_have_sp or $this->_have_sphit or $this->_have_spnews or $this->_have_spoffer){
				$model->setState('sp_offers', true);
			}
			$rows = $model->updateItem($product);
			if ($this->request('main_3d_image')){
				rad_instances::get('model_catalog_3dimages')->setMain((int)$this->request('main_3d_image'), (int)$this->request('cat_id'));
			}
			if ($this->request('del_3dimg')){
				$del3d = $this->request('del_3dimg');
				foreach($del3d as $idImg => $value){
					rad_instances::get('model_catalog_3dimages')->delete3Dimage($idImg);
				}
			}
			if ($this->request('returntorefferer') == '0'){
				$url = $this->makeURL('alias=SITE_ALIAS');
				if (strlen($parent_id)>0){
					$url .= '#nic/'.$parent_id;
				}
				$this->redirect($url);
			}
			//if returntorefferer
		}
	}

	/**
	 * Edit the product - shows the edit form
	 *
	 * @return html Full page edit form
	 */
	function editForm()
	{
		$cat_id = (int)$this->request('cat_id');
		if ($cat_id){
			$this->setVar('cat_id', $cat_id);
			$model = rad_instances::get('model_menus_tree');
			$model->setState('pid', $this->request('pid', $this->_pid))
				->setState('lang', $this->getContentLangID());
			$this->setVar('trees', $model->getItems(true));
			$model->setState('pid', $this->_pid_types);
			$producttypes = $model->getItems(true);
			$firest_el = new struct_tree();
			$firest_el->tre_name = $this->lang('-pleaseselect');
			array_unshift($producttypes, $firest_el);
			$this->setVar('producttypes', $producttypes);
			$this->setVar('currencys', rad_instances::get('model_catalog_currency')->getItems());
			/** FOR MEASUREMENT IN RIGHT PANEL WHITCH NAMED "MAGAZINE"
			$model = new model_system_table(RAD.'measurement');
			$model->setState('order by','ms_position,ms_value');
			$measurements = $model->getItems();
			$this->setVar( 'measurements', $measurements );
			 */
			$model_product = rad_instances::get('model_catalog_catalog');
			if ($this->_have_downloads){
				$model_product->setState('with_download_files', true);
			}
			if ($this->_have_tags){
				$model_product->setState('with_tags', true);
			}
			$product = $model_product->getItem($cat_id);
			$this->addBC('product', $product->cat_name);
			$model->clearState();
			if (count($product->tree_catin_link)){
				$curr_cat = $model->getItem($product->tree_catin_link[0]->cit_tre_id);
				$this->addBC('curr_cat', $curr_cat);
				$cat_path = $model->getCategoryPath($curr_cat, $this->_pid, 0);
				unset($cat_path[0]);
				$this->addBC('parents', $cat_path);
				$mas = array();
				foreach($product->tree_catin_link as $id){
					$mas[] = $id->cit_tre_id;
				}
				$this->setVar('selected_tree', $mas);
			}
			//if count catin_link
			$model = rad_instances::get('model_catalog_brands');
			$this->setVar('brands', $model->getListBrands());
			$this->setVar('product', $product);
			include_once 'helpers'.DS.'fileuploader.php';
			$uploader = new fileuploader($this);
			$imageWidgets = array(
				$uploader->initWidget('images', array(), '', CATALOGORIGINALPATCH, 'catalog', true)
			);
			$this->setVar('widgets', $imageWidgets);
			$this->get3DBinItems($cat_id);
		} else { //if $cat_id
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function assignParams()
	{
		$this->setVar('max_post', $this->configSys('max_post'));
		$this->setVar('have_sp', $this->_have_sp);
		$this->setVar('have_sphit', $this->_have_sphit);
		$this->setVar('have_spnews', $this->_have_spnews);
		$this->setVar('have_spoffer', $this->_have_spoffer);
		$this->setVar('have_brands', $this->_have_brands);
		$this->setVar('have_tags', $this->_have_tags);
		$this->setVar('have_downloads', $this->_have_downloads);
	}

	/**
	 * Deletes the one product
	 * @return javascript commands in for AJAX
	 */
	function deleteProduct()
	{
		if ($this->request('hash') == $this->hash()){
			$cat_id = (int)$this->request('cat_id');
			if ($cat_id){
				$rows = rad_instances::get('model_catalog_catalog')->deleteProductById($cat_id);
				if ($rows){
					echo 'RADCatalogList.message("'.addslashes($this->lang('-deleted')).': '.$rows.'");';
					echo 'RADCatalogList.refresh();';
				} else {
					echo 'RADCatalogList.message("'.addslashes($this->lang('deleted.catalog.error')).': '.$rows.'");';
					echo 'RADCatalogList.refresh();';
				}
			}
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	private function _getTreeIDsArray($items, &$result = array())
	{
		if (is_array($items)){
			foreach($items as $item){
				$result[] = $item->tre_id;
				if (!empty($item->child) and is_array($item->child)){
					$this->_getTreeIDsArray($item->child, $result);
				}
			}
			return $result;
		} else {
			return $items;
		}
	}

	function deleteProductsInTree()
	{
		$nodeId = (int)$this->request('node_id');
		if ($nodeId and $this->request('hash') == $this->hash()){
			$modelTree = rad_instances::get('model_menus_tree');
			$itemsTree = $modelTree->setState('tre_id', $nodeId)
				->setState('lang', $this->getContentLangID())
				->getItems(true);
			if (count($itemsTree)){
				$treeIds = $this->_getTreeIDsArray($itemsTree);
				if (count($treeIds)){
					$model = rad_instances::get('model_catalog_catalog');
					$items = $model->setState('tre_id', $treeIds)
						->setState('lang', $this->getContentLangID())
						->getItems();
					if (!empty($items)){
						foreach($items as $item){
							$model->deleteProductById($item->cat_id);
						}
					}
				}
				foreach($treeIds as $key => $treId){
					if ($treId == $nodeId){
						unset($treeIds[$key]);
					}
				}
				$modelTree->deleteItemById($treeIds);
				echo 'ok';
			}
		} else {
			$this->securityHoleAlert();
		}
	}

	/**
	 * Delete product specified by the cat_id parameeter
	 * @return void
	 */
	function deleteProductNoJS()
	{
		if ($this->request('hash') != $this->hash()){
			return $this->redirect('404');
		}
		$cat_id = (int)$this->request('cat_id');
		rad_instances::get('model_catalog_catalog')->deleteProductById($cat_id);
		$parent_id = (int)$this->request('parent_id');
		$this->redirect($this->makeURL('alias=SITE_ALIAS').'#nic/'.$parent_id);
	}


	/**
	 * Search product from AJAX form in product-list
	 *
	 */
	function searchProduct()
	{
		$searchword = $this->request('searchword');
		$cat = (int)$this->request('cat');
		if ($searchword and $cat){
			$this->setVar('searchword', $searchword);
			$model = rad_instances::get('model_catalog_catalog');
			$this->setVar('itemsPerPageDefault', $this->_itemsPerPage);
			$this->_itemsPerPage = (int)$this->request('i', $this->_itemsPerPage);
			$this->setVar('itemsPerPage', $this->_itemsPerPage);
			$model->setState('cat_in_tre', $cat);
			$model->setState('count', true);
			$model->setState('with_cat_keywords', false);
			$model->setState('with_cat_metatitle', false);
			$model->setState('with_cat_metatescription', false);
			$model->setState('with_tre_name', false);
			$model->setState('lang', $this->getContentLangID());
			$products_count = $model->searchItems($searchword);
			$model->setState('withvals', true);
			$model->unsetState('count');
			$p = (int)$this->request('p');
			$page = ($p) ? $p : 0;
			$limit = ($page * $this->_itemsPerPage).','.$this->_itemsPerPage;
			$model->setState('limit', $limit);
			$products = $model->searchItems($searchword);
			if ($products_count){
				$pages = div((int)$products_count, $this->_itemsPerPage);
				$pages += (mod($products_count, $this->_itemsPerPage)) ? 1 : 0;
				$this->setVar('pages_count', $pages + 1);
				$this->setVar('page', $page + 1);
			}
			$this->setVar('items', $products);
			$this->setVar('items_count', $products_count);
		} else { //if $searchword
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function setActiveJS()
	{
		if ($this->request('hash') == $this->hash()){
			$v = (int)$this->request('v');
			$cat_id = (int)$this->request('c');
			if ($cat_id){
				$r = rad_instances::get('model_catalog_catalog')->setActive($cat_id, $v);
				$r = ($v and $r) ? false : true;
				if ($r){
					echo '$("active_cat_link_'.$cat_id.'_1").style.display="none";';
					echo '$("active_cat_link_'.$cat_id.'_0").style.display="";';
				} else {
					echo '$("active_cat_link_'.$cat_id.'_1").style.display="";';
					echo '$("active_cat_link_'.$cat_id.'_0").style.display="none";';
				}
			} else {
				$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
			}
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function newCost()
	{
		if ($this->request('hash') == $this->hash()){
			$new_cost = (float)str_replace(',', '.', $this->request('nc'));
			$cat_id = (int)$this->request('c');
			if ($cat_id){
				$product = model_system_table::getInstance(RAD.'catalog')->getItem($cat_id);
				$product->cat_cost = $new_cost;
				$rows = model_system_table::getInstance(RAD.'catalog')->updateItem($product);
				if ($rows){
					echo '$("cat_cost_'.$cat_id.'").value="'.$new_cost.'";';
					echo 'RADCatalogList.message("'.$this->lang('-saved').'");';
				} else {
					echo 'RADCatalogList.message("'.$this->lang('-notsaved').'");';
				}
			} else {
				$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
			}
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function newCurrency()
	{
		if ($this->request('hash') == $this->hash()){
			$new_currency = (int)$this->request('nc');
			$cat_id = (int)$this->request('c');
			if ($cat_id){
				$product = model_system_table::getInstance(RAD.'catalog')->getItem($cat_id);
				$product->cat_currency_id = $new_currency;
				$rows = model_system_table::getInstance(RAD.'catalog')->updateItem($product);
				if ($rows){
					echo 'selectSel($("currency_cat_'.$cat_id.'"),'.$new_currency.');';
					echo 'RADCatalogList.message("'.$this->lang('-saved').'");';
				} else {
					echo 'RADCatalogList.message("'.$this->lang('-notsaved').'");';
				}
			} else {
				$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
			}
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function newOrdering()
	{
		if ($this->request('hash') == $this->hash()){
			$new_ordering = (int)$this->request('no');
			$cat_id = (int)$this->request('c');
			if ($cat_id){
				$product = model_system_table::getInstance(RAD.'catalog')->getItem($cat_id);
				$product->cat_position = $new_ordering;
				$rows = model_system_table::getInstance(RAD.'catalog')->updateItem($product);
				echo 'RADCatalogList.message("'.$this->lang('-saved').'");';
				echo 'RADCatalogList.refresh();';
			} else {
				$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
			}
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	/**
	 * Sets the new PID for the tree and return the JS commands
	 * @return JavaScript
	 *
	 */
	function newLngPID()
	{
		$lngid = (int)$this->request('i');
		if ($lngid){
			$params = $this->getParamsObject();
			echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
			echo 'RADCatalogTree.refresh();';
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	/**
	 * Gets the new categories for add\edit product form with needed lang_id
	 * @return JS array (JSON)
	 */
	function getCats()
	{
		$lngid = (int)$this->request('i');
		if ($lngid){
			$params = $this->getParamsObject();
			$model = rad_instances::get('model_menus_tree');
			$model->setState('pid', $this->request('pid', $params->_get('treestart', $this->_pid, $lngid)));
			$items = $model->getItems(true);
			echo json_encode($items);
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	function getTypesEd()
	{
		$lngid = (int)$this->request('i');
		if ($lngid){
			$params = $this->getParamsObject();
			$model = rad_instances::get('model_menus_tree');
			$model->setState('pid', $this->request('pid', $params->_get('treestart_types', $this->_pid_types, $lngid)));
			$items = $model->getItems(true);
			echo json_encode($items);
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	protected function genere3DBin()
	{
		$model = rad_instances::get('model_session_taberna');
		if (empty($this->getCurrentUser()->u_id) or $this->hash() !== $this->request('hash')){
			$this->redirect(SITE_URL);
		}
		if (!count($this->request('files'))){
			die('can\'t genere 3D-model without any files!');
		}
		$params['width'] = (string)(int)$this->request('tdParams_width');
		$params['height'] = (string)(int)$this->request('tdParams_height');
		$params['name'] = (string)$this->request('tdParams_name');
		$params['is360view'] = (string)(boolean)$this->request('tdParams_is360view');
		$params['logo'] = (string)$this->request('tdParams_logo');
		$params['autoalign'] = (string)(bool)$this->request('tdParams_autoalign');
		$params['сrop'] = (string)(int)$this->request('tdParams_crop');
		$params['files'] = $this->request('files');
		$params['cat_id'] = (string)(int)$this->request('cat_id');
		$res = $model->genere3DBin($params);
		try{
			$result = json_decode($res);
		} catch(Exception $e) {
			die('Some error: "'.$e->getMessage().'" Code: ['.$e->getCode().']');
		}
		switch($res){
			case 1: //CODE_USER_NOT_FOUND
				break;
			case 2: //CODE_WRONG_ACTION

				break;
			case 3: //CODE_NOT_ENOUPH_PARAMS
				break;
			case 4: //CODE_EMPTY_CAT_ID

				break;
			case 5: //CODE_EMPTY_SITE_URL
				break;
			case 6: //CODE_EMPTY_TRANSACTION_ID
				break;
			case 7: //CODE_TRANSACTION_NOT_FOUND
				break;
			case 8: //CODE_USER_FOUND
				break;
			case 9: //CODE_USER_BLOCKD
				break;
			case 10: //CODE_NO_MONEY
				break;
			case 11: //UNKNOWN_ERROR
				break;
			case 12: //demo count or time is finished
				break;
			case 'sended':
				break;
			default:
				//Parse the code or get the file
				break;
		}
		die($res);
	}

	public function check3DBin()
	{
		$model = rad_instances::get('model_session_taberna');
		if (empty($this->getCurrentUser()->u_id) or $this->hash() !== $this->request('hash')){
			$this->redirect(SITE_URL);
		}
		if ($this->request('transaction')){
			$transactionId = trim($this->request('transaction'));
			$catId = (int)$this->request('cat_id');
			$params = array('transaction_id' => $transactionId, 'cat_id' => $catId);
			$res = $model->progress3DBin($params);
			if (!empty($res)){
				$result = json_decode($res);
				if (isset($result->progress)){
					if ((int)$result->progress>=100){
						$fileName = $model->get3DBinFile($params);
						$item = new struct_cat_3dimages(array(
															 'img_cat_id' => $catId,
															 'img_filename' => basename($fileName)
														));
						rad_instances::get('model_catalog_3dimages')->insertItem($item);
					}
					die(json_encode(array('progress' => $result->progress)));
				} else {
					die('-11='.print_r($res, true));
				}
			}
		} else {
			die('-12');
		}
	}

	function get3DBinItems($catId)
	{
		$this->setVar('items_3dbin', rad_instances::get('model_catalog_3dimages')->setState('cat_id', $catId)->getItems());
	}

}