<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_ShowController extends Mage_Core_Controller_Front_Action {
	
	public function successAction() {

		$this->loadLayout();
		$this->renderLayout();
	}
	public function failAction() {

		$this->loadLayout();
		$this->renderLayout();
	}
	public function _getCoreSession() {
		return Mage::getSingleton('core/session');
	}
	public function _getSession() {
        return Mage::getSingleton('customer/session');
	}
	public function indexAction() {

		
		if(!$this->_getSession()->getCustomerId()){
		
			$this->_getSession()->addError('请登陆后再上传照片');
			$this->_redirect('customer/account/login');
			return;
		}
	
		$this->loadLayout();
		$this->renderLayout();
	}
	public function showAction() {

		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function uploadAction()
    {

        if (!$this->_validateFormKey()) {
			$this->_getCoreSession()->addError('非法表单提交');
            return $this->_redirect('sns/show/index');
        }
		$errors = array();
		$fields = $this->getRequest()->getPost();

        if ($fields) {
            

            if ( isset($_FILES['photo']) && $_FILES['photo']['name'] != '' ) {
				
				$product= Mage::getModel('catalog/product')->load($fields['productid']);
			
				require_once ("lib/Varien/File/Uploader.php");
				$path = Mage::getBaseDir().DS.'media'.DS.'show'.DS.$product->getSku().DS.$this->_getSession()->getCustomerId(); //desitnation directory
				$fname = $_FILES['photo']['name']; //file name
				$uploader = new Varien_File_Uploader('photo'); //load class
				$uploader->setAllowedExtensions(array('jpg','png','gif')); //Allowed extension for file
				$uploader->setAllowCreateFolders(true); //for creating the directory if not exists
				$uploader->setAllowRenameFiles(false); //if true, uploaded file's name will be changed, if file with the same name already exists directory.
				$uploader->setFilesDispersion(false);
				$error=$uploader->save($path,$fname); //save the file on the specified path
			
            	if ( $error['error'] ) {
            		$errors[] =$error['error'];
            	}
				
				$path2 = Mage::getUrl().'media'.DS.'show'.DS.$product->getSku().DS.$this->_getSession()->getCustomerId().DS.$fname; 
				
				$userimage= Mage::getModel('blog/userimages');
				$userimage->setData('title',$fields['name']);
				$userimage->setData('product_id',$fields['productid']);
				$userimage->setData('filename',$path.$fname);
				$userimage->setData('description','');
				$userimage->setData('data1',$product->getSku());
				$userimage->setData('data2',$fields['email']);
				$userimage->setData('data3',$fields['telephone']);
				$userimage->setData('data4',$this->_getSession()->getCustomerId());
				$userimage->setData('data5',$path2);
				
				try {

					$userimage->save();
				
					if (count($errors)) {
						foreach ($errors as $message) {
							$this->_getCoreSession()->addError($message);
						}
					} else {
						$this->_getCoreSession()->addSuccess($this->__('图片上传成功'));
					}
					$this->_redirect('sns/show/success');
					return;
				} catch (Mage_Core_Exception $e) {
					$this->_getCoreSession()->addError($e->getMessage());
				} catch (Exception $e) {
					$this->_getCoreSession()->addException($e, $this->__('保存信息遇到错误'));
				} 
				
            }

            
        }

		$this->_redirect('sns/show/success');
		return;
    }
 
}
