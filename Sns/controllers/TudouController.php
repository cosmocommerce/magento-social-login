<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_TudouController extends Mage_Core_Controller_Front_Action
{
	protected  $consumer_key;
	protected  $consumer_secret;
	protected  $baseUrl;
	protected  $siteUrl;
	protected  $callback;
	protected  $config= Array();
	public function _construct(){
		$this->consumer_key='460fea519c74df2b';
		$this->consumer_secret='c1642d34f7f9fb682e2991fd1f4388f9';
		$this->baseUrl='http://api.tudou.com/v3/';
		$this->siteUrl='http://api.tudou.com/auth';
		$this->callback='http://arvato.cosmocommerce.com/sns/tudou/callback/';
		
		$this->config = array(
			'callbackUrl' =>$this->callback,
			'siteUrl' => $this->siteUrl,
			'consumerKey' => $this->consumer_key,
			'consumerSecret' => $this->consumer_secret
		);
		return parent::_construct();
	}
	public function test2Action(){
		try {
			$db = new PDO("mysql:host=localhost;dbname=video_db","root","af2010");
			
			$db -> exec("SET NAMES 'utf8'");
			
			
			$data=$db->query('SELECT * from video_item order by pubDate DESC');
			$selectrows = $data->fetchAll  ();
			foreach($selectrows as $row){
				echo ($row['title']).' Date:'.($row['pubDate'])."<br />";
			}
		} catch (PDOException $e) {
			print "ERROR: " . $e->getMessage() ;
			exit();
		}		
	}
	public function testAction(){
	
		$kw=$this->getRequest()->getParam('kw');
		$pageNo=1;
		$pageSize=100;
		$method="item.search";
		$appKey="460fea519c74df2b";
		$appSecret="c1642d34f7f9fb682e2991fd1f4388f9";
		
		$channelId=1;
		$inDays=7;//7,30 7：一周内发布的 ,30：一月内发布的
		//$ttlevel s、m、l s：短长度视频     m：中长度视频 l：长视频
		//media v、a	 v：只返回视频节目 a：只返回音频节目
		//sort s、t、v、d	指定排序方法，默认播放次数排序  s：匹配度排序       t：发布时间排序 v：播放次数排序   d：节目时长排序


		$url="http://api.tudou.com/v3/gw?inDays=".$inDays."&pageNo=".$pageNo."&pageSize=".$pageSize."&method=".$method."&kw=".$kw."&appKey=".$appKey."&appSecret=".$appSecret." ";


        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $returndata = curl_exec($crl);
        curl_close($crl);
		
		

		
		$video_items=(json_decode($returndata));
		if(isset($video_items->multiPageResult)){
			$mr=$video_items->multiPageResult;
			
			if(isset($video_items->multiPageResult)){
				$results=$video_items->multiPageResult->results;
				if(count($results)){
					foreach($results as $row) {
						$description  = $row->description;
						$tags   = $row->tags ;
						$itemId   = $row->itemId ;
						$itemCode   = $row->itemCode ;
						
						$title   = $row->title ;
						$picUrl   = $row->picUrl ;
						$totalTime   = $row->totalTime ;
						$channelId  = $row->channelId;
						
						$outerPlayerUrl   = $row->outerPlayerUrl ;
						$itemUrl   = $row->itemUrl ;
						
						
						$alias   = $row->alias ;
						$definition   = $row->definition ;
						$mediaType  = $row->mediaType;
						$playTimes  = $row->playTimes;
						$downEnable    = $row->downEnable  ;
						$pubDate    = $row->pubDate  ;
						$bigPicUrl    = $row->bigPicUrl  ;
						
						$ownerId   = $row->ownerId ;
						$ownerNickname    = $row->ownerNickname  ;
						$commentCount    = $row->commentCount  ;
						$ownerName   = $row->ownerName ;
						$picChoiceUrl    = json_encode($row->picChoiceUrl);
						
						$secret    = $row->secret  ;
						$addPlaylistTime   = $row->addPlaylistTime ;
						$source   = 'YOUKU';
						
						echo '<embed src="'.$outerPlayerUrl.'&withFirstFrame=false/v.swf 
 " type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="480" height="400"></embed> ';
 echo '<br />';
		echo '   <object height="205px" width="900px" data="'.$outerPlayerUrl.'" type="application/x-shockwave-flash">   
        <param value="'.$outerPlayerUrl.'" name="movie" />   
        <param value="high" name="quality" />   
        <param value="false" name="menu" />   
        <param value="transparent" name="wmode" />   
</object>';
						echo $outerPlayerUrl;
						
						echo "<br />";
		
						try {
							$db = new PDO("mysql:host=localhost;dbname=video_db","root","af2010");
							
							$db -> exec("SET NAMES 'utf8'");
							
							
							$data=$db->query('SELECT * from video_item where itemId='.$itemId);
							$selectrows = $data->fetch (PDO::FETCH_BOTH);
							if(($selectrows)){
									
									// query
									$sql = "UPDATE video_item SET description=?,tags=?,itemId=?,itemCode=?,title=?,picUrl=?,totalTime=?,channelId=?,outerPlayerUrl=?,itemUrl=?,alias=?,definition=?,mediaType=?,playTimes=?,downEnable=?,pubDate=?,bigPicUrl=?,ownerId=?,ownerNickname=?,commentCount=?,ownerName=?,picChoiceUrl=?,secret=?,addPlaylistTime=?,source=?  WHERE id=?";
								
								
								
									$sth = $db->prepare($sql);
									$sth->bindParam (1, $description);
									$sth->bindParam (2, $tags);
									$sth->bindParam (3, $itemId);
									$sth->bindParam (4, $itemCode);
									$sth->bindParam (5, $title);
									$sth->bindParam (6, $picUrl);
									$sth->bindParam (7, $totalTime);
									$sth->bindParam (8, $channelId);
									$sth->bindParam (9, $outerPlayerUrl);
									$sth->bindParam (10, $itemUrl);
									$sth->bindParam (11, $alias);
									$sth->bindParam (12, $definition);
									$sth->bindParam (13, $mediaType);
									$sth->bindParam (14, $playTimes);
									$sth->bindParam (15, $downEnable);
									$sth->bindParam (16, $pubDate);
									$sth->bindParam (17, $bigPicUrl);
									$sth->bindParam (18, $ownerId);
									$sth->bindParam (19, $ownerNickname);
									$sth->bindParam (20, $commentCount);
									$sth->bindParam (21, $ownerName);
									$sth->bindParam (22, $picChoiceUrl);
									$sth->bindParam (23, $secret);
									$sth->bindParam (24, $addPlaylistTime);
									$sth->bindParam (25, $source);
									$sth->bindParam (26,  $selectrows['id']);
									
									$sth->execute();
							}else{
							
 
 
 
								$sql = "INSERT INTO video_item (description,tags,itemId,itemCode,title,picUrl,totalTime,channelId,outerPlayerUrl,itemUrl,alias,definition,mediaType,playTimes,downEnable,pubDate,bigPicUrl,ownerId,ownerNickname,commentCount,ownerName,picChoiceUrl,secret,addPlaylistTime,source) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
								
								$sth = $db->prepare($sql);
								$sth->bindParam (1, $description);
								$sth->bindParam (2, $tags);
								$sth->bindParam (3, $itemId);
								$sth->bindParam (4, $itemCode);
								$sth->bindParam (5, $title);
								$sth->bindParam (6, $picUrl);
								$sth->bindParam (7, $totalTime);
								$sth->bindParam (8, $channelId);
								$sth->bindParam (9, $outerPlayerUrl);
								$sth->bindParam (10, $itemUrl);
								$sth->bindParam (11, $alias);
								$sth->bindParam (12, $definition);
								$sth->bindParam (13, $mediaType);
								$sth->bindParam (14, $playTimes);
								$sth->bindParam (15, $downEnable);
								$sth->bindParam (16, $pubDate);
								$sth->bindParam (17, $bigPicUrl);
								$sth->bindParam (18, $ownerId);
								$sth->bindParam (19, $ownerNickname);
								$sth->bindParam (20, $commentCount);
								$sth->bindParam (21, $ownerName);
								$sth->bindParam (22, $picChoiceUrl);
								$sth->bindParam (23, $secret);
								$sth->bindParam (24, $addPlaylistTime);
								$sth->bindParam (25, $source);
								
								$sth->execute();
 
 
							}
						} catch (PDOException $e) {
							print "ERROR: " . $e->getMessage() ;
							exit();
						}		
					}
				}
				
				$page=$video_items->multiPageResult->page;
				print_r($page);
			}
		}
		
		
		echo 'fs';
		exit();
	
	
	
	
	
	
	
	
	
		
	}
			
    public function callbackAction()
    {
		$oauth_token=$this->getRequest()->getParam('oauth_token');
			
		$config = $this->config;
		$consumer = new Zend_Oauth_Consumer($config);
		
		$TUDOU_REQUEST_TOKEN=unserialize(Mage::getSingleton('core/session')->getData('TUDOU_REQUEST_TOKEN'));
		
 
		if (!empty($_GET) && isset($TUDOU_REQUEST_TOKEN)) {
			$token = $consumer->getAccessToken($_GET,$TUDOU_REQUEST_TOKEN);
			Mage::getSingleton('core/session')->setData('TUDOU_ACCESS_TOKEN',serialize($token));
			
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
print_r($data);
		if($data->id){ 
		
		
			echo '登录';
			exit();
			
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
			$token = unserialize(Mage::getSingleton('core/session')->getData('TUDOU_ACCESS_TOKEN'));
		}
		
		$client = $token->getHttpClient($config);
		$client->setUri($this->baseUrl.'statuses/update.json');
		$client->setMethod(Zend_Http_Client::POST);
		$client->setParameterPost('status', $statusMessage);
		$response = $client->request();
		 
		$data = json_decode($response->getBody());
		print_r($data);
		
		
		
		
		exit();
	}
    public function indexAction()
    {
		$config = $this->config;
		$consumer = new Zend_Oauth_Consumer($config);	
		$token = $consumer->getRequestToken();
		Mage::getSingleton('core/session')->setData('TUDOU_REQUEST_TOKEN',serialize($token));
		
		$consumer->redirect();
			
    }
}