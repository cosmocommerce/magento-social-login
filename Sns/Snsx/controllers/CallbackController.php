<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
class CosmoCommerce_Sns_CallbackController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function errorAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function successAction()
    {
	
		
	
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function failAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function weiboAction()
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



		if (isset($_REQUEST['code'])) {
			$keys = array();

			// 验证state，防止伪造请求跨站攻击
			$state = $_REQUEST['state'];
			if ( empty($state) || $state !== Mage::getModel('core/session')->getData('weibo_state') ) {
				$this->_redirect('sns/callback/error');
				return;
			}
			Mage::getModel('core/session')->setData('weibo_state',null);

			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = $callback;
			try {
				$token = $snsweibo->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {
			}
		}

		if ($token) {
			Mage::getModel('core/session')->setData('token',$token);
			Mage::getModel('core/cookie')->set('weibojs_'.$snsweibo->client_id, http_build_query($token));
	
	
	
	
	
	
			$snsweibo_login=Mage::getModel('sns/weibo');
			$snsweibo_login->setKey( $app_key , $app_secret,$token['access_token'] );
			$snsweibo_login->set_debug( $debug );
			
			
			$uid_get = $snsweibo_login->get_uid();
			$uid = $uid_get['uid'];
			$data = $snsweibo_login->show_user_by_id($uid);
			$location = $data['location'];
			$province = $data['province'];
			$screen_name = $data['screen_name'];
			$name = $data['name'];
			$profile_image_url = $data['profile_image_url'];
			
			$customer=Mage::getModel('customer/customer');
			$customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
			$customer->loadByEmail($uid."@weibo.com"); 
			if(!$customer->getId()){ 
				$customer->setEmail($uid."@weibo.com");
				$customer->setFirstname("weibo");
				$customer->setAvatar($profile_image_url);
				$customer->setLastname($screen_name);
				$customer->setLocation($location);
				$customer->setProvince($province);
				$customer->setPassword($token['access_token']);
				
				
				$customer->setWeiboAccessToken($token['access_token']);
				$customer->setWeiboRemindIn($token['remind_in']);
				$customer->setWeiboExpiresIn($token['expires_in']);
				$customer->setWeiboUid($token['uid']);
				
				
				try {
					$customer->save();
					$customer->setConfirmation(null);
					$customer->save();
				}
				catch (Exception $ex) {
					Mage::log($ex->getMessage());
				}
				Mage::log("New Customer saved");
				Mage::getSingleton('customer/session')->loginById($customer->getId());
				$this->_redirect('sns/callback/success');
				return;
			}else{
				Mage::getSingleton('customer/session')->loginById($customer->getId());
				$this->_redirect('customer/account');
				return;
			}
			
		}else{
		
			$this->_redirect('sns/callback/fail');
			return;
		}
    }
}