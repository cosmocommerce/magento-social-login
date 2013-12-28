<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_WeiboController extends Mage_Core_Controller_Front_Action
{ 
	
	public function _construct(){
	
		return parent::_construct();
	} 
	
    public function loginAction()
    {
	
	
		$app_key=Mage::getStoreConfig('sns/sns_weibo/app_key');
		$debug=Mage::getStoreConfig('sns/sns_weibo/debug');
		$app_secret=Mage::getStoreConfig('sns/sns_weibo/app_secret');
		
		if($debug){
			error_reporting(E_ALL);
			ini_set('display_errors', true);
		}
		$callback=Mage::getUrl('sns/callback/weibo/');
		
		$snsweibo=Mage::getModel('sns/sns');
		
				
		$snsweibo->setKey( $app_key , $app_secret );
		$snsweibo->set_debug( $debug );

		// 生成state并存入SESSION，以供CALLBACK时验证使用
		$state = uniqid( 'weibo_', true);
		Mage::getModel('core/session')->setData('weibo_state',$state);
		

		$code_url = $snsweibo->getAuthorizeURL( $callback , 'code', $state );
		
		$this->getResponse()->setRedirect($code_url);
		return;
		
	}
}