<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
class CosmoCommerce_Sns_IndexController extends Mage_Core_Controller_Front_Action
{
    public function showAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
	
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/sns?id=15 
    	 *  or
    	 * http://site.com/sns/id/15 	
    	 */
    	/* 
		$sns_id = $this->getRequest()->getParam('id');

  		if($sns_id != null && $sns_id != '')	{
			$sns = Mage::getModel('sns/sns')->load($sns_id)->getData();
		} else {
			$sns = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($sns == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$snsTable = $resource->getTableName('sns');
			
			$select = $read->select()
			   ->from($snsTable,array('sns_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$sns = $read->fetchRow($select);
		}
		Mage::register('sns', $sns);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}