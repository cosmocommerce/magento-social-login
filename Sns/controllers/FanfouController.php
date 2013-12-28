<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_FanfouController extends Mage_Core_Controller_Front_Action
{
	protected  $consumer_key;
	protected  $consumer_secret;
	protected  $baseUrl;
	protected  $siteUrl;
	protected  $callback;
	protected  $config= Array();
	public function _construct(){
		$this->consumer_key='ad7e3dbe7cf88772ad191a308ef66478';
		$this->consumer_secret='f22ff384d79afde7337c1355346ad8c2';
		$this->baseUrl='http://api.fanfou.com/';
		$this->siteUrl='http://fanfou.com/oauth';
		$this->callback='http://arvato.cosmocommerce.com/sns/fanfou/callback/';
		
		$this->config = array(
			'callbackUrl' =>$this->callback,
			'siteUrl' => $this->siteUrl,
			'consumerKey' => $this->consumer_key,
			'consumerSecret' => $this->consumer_secret
		);
		return parent::_construct();
	}
	public function testAction(){
	
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()){
			$id = Mage::getSingleton('customer/session')->getCustomer()->getId();
			$customer=Mage::getModel('customer/customer')->load($id);
			print_r( $customer->getData());
			exit();
		}else{
			echo 'please login';
			exit();
		}
        $this->loadLayout();
        $this->renderLayout();
		
		
	}
			
    public function callbackAction()
    {
		$oauth_token=$this->getRequest()->getParam('oauth_token');
			
		$config = $this->config;
		$consumer = new Zend_Oauth_Consumer($config);
		
		$FANFOU_REQUEST_TOKEN=unserialize(Mage::getSingleton('core/session')->getData('FANFOU_REQUEST_TOKEN'));
		
 
		if (!empty($_GET) && isset($FANFOU_REQUEST_TOKEN)) {
			$token = $consumer->getAccessToken($_GET,$FANFOU_REQUEST_TOKEN);
			Mage::getSingleton('core/session')->setData('FANFOU_ACCESS_TOKEN',serialize($token));
			
		} else {
			Mage::log('error access token');
			echo 'error';
			exit();
		}
		
		
		$client = $token->getHttpClient($config);
		$client->setUri($this->baseUrl.'account/verify_credentials.json');
		$client->setMethod(Zend_Http_Client::GET);
		$response = $client->request();
		 
		$data = json_decode($response->getBody());

		if($data->id){ 
		
			if(Mage::getSingleton('customer/session')->isLoggedIn()){
			
		
				$id = Mage::getSingleton('customer/session')->getCustomer()->getId();
				$customer=Mage::getModel('customer/customer')->load($id);
			
				$customer=Mage::helper('customer/data')->getCurrentCustomer();
				$customer->setFanfouId($data->id);
				$customer->setFanfouToken(serialize($token));
				$customer->save();
				echo '登录';
				exit();
			}else{
				echo '未登录';
				exit();
			}
			
		}
		
	

		exit();
	
	}
    public function postAction()
    {
		$token=null;
		if(Mage::getSingleton('customer/session')->isLoggedIn()){
		
	
			$id = Mage::getSingleton('customer/session')->getCustomer()->getId();
			$customer=Mage::getModel('customer/customer')->load($id);
		
			if($customer->getFanfouToken()){
				$token=unserialize($customer->getFanfouToken());
			}
		}
		
		$config = $this->config;
		$statusMessage = '用户验证通过~~☆';
		
		if(!$token){
			$token = unserialize(Mage::getSingleton('core/session')->getData('FANFOU_ACCESS_TOKEN'));
		}
		
		$client = $token->getHttpClient($config);
		$client->setUri($this->baseUrl.'statuses/update.json');
		$client->setMethod(Zend_Http_Client::POST);
		$client->setParameterPost('status', $statusMessage);
		$response = $client->request();
		 
		$data = json_decode($response->getBody());
		print_r($data);
		
		
		$client = $token->getHttpClient($config);
		$client->setUri($this->baseUrl.'account/rate_limit_status.json');
		$client->setMethod(Zend_Http_Client::GET);
		$response = $client->request();
		 
		$data = Zend_Json::decode($response->getBody());
		$result = $response->getBody();
		if (isset($data->text)) {
			$result = 'true';
		}
		echo $result;

		
		
		exit();
	}
    public function indexAction()
    {
		$config = $this->config;
		$consumer = new Zend_Oauth_Consumer($config);	
		$token = $consumer->getRequestToken();
		Mage::getSingleton('core/session')->setData('FANFOU_REQUEST_TOKEN',serialize($token));
		
		$consumer->redirect();
			
    }
}