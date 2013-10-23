<?php
class CosmoCommerce_Sns_QqController extends Mage_Core_Controller_Front_Action
{ 
	
	public function _construct(){
	
		return parent::_construct();
	} 
	
    public function loginAction()
    {
	
	
		$app_key=Mage::getStoreConfig('sns/sns_tweibo/app_key');
		$debug=Mage::getStoreConfig('sns/sns_tweibo/debug');
		$app_secret=Mage::getStoreConfig('sns/sns_tweibo/app_secret');
		
		if($debug){
			error_reporting(E_ALL);
			ini_set('display_errors', true);
		}
		$callback=Mage::getUrl('sns/callback/qq');
		
		$snsweibo=Mage::getModel('sns/tweibo');
		
				
		$snsweibo->setKey( $app_key , $app_secret );
		$snsweibo->set_debug( $debug );

		
		$t_access_token=Mage::getModel('core/session')->getData('t_access_token');
		$t_openid=Mage::getModel('core/session')->getData('t_openid');
		$t_openkey=Mage::getModel('core/session')->getData('t_openkey');
		if ($t_access_token && ($t_openid && $t_openkey)) { // todo 改为 ||
		
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			
			echo $customer->getName();
            Mage::log( $r,null,'qq.log'); 
            
			exit();
		}else{

			if (isset($_REQUEST['code'])) {
				$code = $_REQUEST['code'];
				$openid = $_REQUEST['openid'];
				$openkey = $_REQUEST['openkey'];
			
				$url = $snsweibo->getAccessToken($code, $callback);
				
				$r = $snsweibo->request($url);
				parse_str($r, $out);
				//存储授权数据
				if ($out['access_token']) {
					Mage::getModel('core/session')->setData('t_access_token',$out['access_token']);
					Mage::getModel('core/session')->setData('t_refresh_token',$out['refresh_token']);
					Mage::getModel('core/session')->setData('t_expire_in',$out['expires_in']);
					Mage::getModel('core/session')->setData('t_code',$code);
					Mage::getModel('core/session')->setData('t_openid',$openid);
					Mage::getModel('core/session')->setData('t_openkey',$openkey);
					
					//print_r(Mage::getModel('core/session')->getData());
					//验证授权
					$r = $snsweibo->checkOAuthValid();
					
					if ($r) {
                           
						echo '授权成功请返回刚才页面继续分享';
                        exit();
					} else {
						echo '授权失败,请重试';
                        exit();
					}
				} else {
                    echo 'access_token失败,请重试';
                    exit();
				}
			
			}elseif(isset($_REQUEST['openid']) && isset($_REQUEST['openkey'])) {
				
				Mage::getModel('core/session')->setData('t_openid',$_REQUEST['openid']);
				Mage::getModel('core/session')->setData('t_openkey',$_REQUEST['openkey']);
				//验证授权
				$r = $snsweibo->checkOAuthValid();
				if ($r) {
					header('Location: ' . $callback);//刷新页面 
                    exit();
				} else {
                    echo '授权失败,请重试';
                    exit();
				}
                echo '授权失败,请重试';
                exit();
			}else{
                $state = uniqid( 'qq_', true);
                Mage::getModel('core/session')->setData('qq_state',$state);
				$url = $snsweibo->getAuthorizeURL($callback,'code',false,$state);
                
                header('Location: ' . $url);//刷新页面 
             
                exit();
			}
			
            echo '授权失败,请重试';
            exit();
		}

        echo '授权失败,请重试';
        exit();
		
	}
}