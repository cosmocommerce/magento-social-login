<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
class CosmoCommerce_Sns_IndexController extends Mage_Core_Controller_Front_Action
{


	public function WriteJsConnect($User, $Request, $ClientID, $Secret, $Secure = TRUE) {
		$JS_TIMEOUT= 24 * 60;
	   $User = array_change_key_case($User);
	   
	   // Error checking.
	   if ($Secure) {
		  // Check the client.
		  if (!isset($Request['client_id']))
			 $Error = array('error' => 'invalid_request', 'message' => 'The client_id parameter is missing.');
		  elseif ($Request['client_id'] != $ClientID)
			 $Error = array('error' => 'invalid_client', 'message' => "Unknown client {$Request['client_id']}.");
		  elseif (!isset($Request['timestamp']) && !isset($Request['signature'])) {
			 if (is_array($User) && count($User) > 0) {
				// This isn't really an error, but we are just going to return public information when no signature is sent.
				$Error = array('name' => $User['name'], 'photourl' => @$User['photourl']);
			 } else {
				$Error = array('name' => '', 'photourl' => '');
			 }
		  } elseif (!isset($Request['timestamp']) || !is_numeric($Request['timestamp']))
			 $Error = array('error' => 'invalid_request', 'message' => 'The timestamp parameter is missing or invalid.');
		  elseif (!isset($Request['signature']))
			 $Error = array('error' => 'invalid_request', 'message' => 'Missing  signature parameter.');
		  elseif (($Diff = abs($Request['timestamp'] - $this->JsTimestamp())) > $JS_TIMEOUT)
			 $Error = array('error' => 'invalid_request', 'message' => 'The timestamp is invalid.');
		  else {
			 // Make sure the timestamp hasn't timed out.
			 $Signature = $this->JsHash($Request['timestamp'].$Secret, $Secure);
			 if ($Signature != $Request['signature'])
				$Error = array('error' => 'access_denied', 'message' => 'Signature invalid.');
		  }
	   }
	   
	   
	   if (isset($Error))
		  $Result = $Error;
	   elseif (is_array($User) && count($User) > 0) {
		  if ($Secure === NULL) {
			 $Result = $User;
		  } else {
			 $Result = $this->SignJsConnect($User, $ClientID, $Secret, $Secure, TRUE);
		  }
	   } else
		  $Result = array('name' => '', 'photourl' => '');
	   
	   $Json = json_encode($Result);
	   
	   if (isset($Request['callback']))
		  echo "{$Request['callback']}($Json)";
	   else
		  echo $Json;
	}

	public function SignJsConnect($Data, $ClientID, $Secret, $HashType, $ReturnData = FALSE) {
	   $Data = array_change_key_case($Data);
	   ksort($Data);

	   foreach ($Data as $Key => $Value) {
		  if ($Value === NULL)
			 $Data[$Key] = '';
	   }
	   
	   $String = http_build_query($Data, NULL, '&');
	//   echo "$String\n";
	   $Signature = $this->JsHash($String.$Secret, $HashType);
	   if ($ReturnData) {
		  $Data['client_id'] = $ClientID;
		  $Data['signature'] = $Signature;
	//      $Data['string'] = $String;
		  return $Data;
	   } else {
		  return $Signature;
	   }
	}
	public function JsHash($String, $Secure = TRUE) {
	   if ($Secure === TRUE)
		  $Secure = 'md5';
	   
	   switch ($Secure) {
		  case 'sha1':
			 return sha1($String);
			 break;
		  case 'md5':
		  case FALSE:
			 return md5($String);
		  default:
			 return hash($Secure, $String);
	   }
	}
	public function JsTimestamp() {
	   return time();
	}
	public function JsSSOString($User, $ClientID, $Secret) {
	   if (!isset($User['client_id']))
		  $User['client_id'] = $ClientID;
	   
	   $String = base64_encode(json_encode($User));
	   $Timestamp = time();
	   $Hash = hash_hmac('sha1', "$String $Timestamp", $Secret);
	   
	   $Result = "$String $Hash $Timestamp hmacsha1";
	   return $Result;
	}




	public function testAction(){
	
	
		// 1. Get your client ID and secret here. These must match those in your jsConnect settings.
		$clientID = "620872645";
		$secret = "af0ea049cd3e2f04259a3f5e946c8af4";

		// 2. Grab the current user from your session management system or database here.
		$signedIn = true; // this is just a placeholder

		// YOUR CODE HERE.

		// 3. Fill in the user information in a way that Vanilla can understand.
		$user = array();

		if ($signedIn) {
		   // CHANGE THESE FOUR LINES.
		   $user['uniqueid'] = '3';
		   $user['name'] = 'Airforce';
		   $user['email'] = '63208705@qq.com';
		   $user['photourl'] = '';
		}


		$test=array();
		$test['client_id']=$clientID;
		$test['timestamp']=time();
		$test['signature']=$this->JsHash($test['timestamp'].$secret,true);
		// 4. Generate the jsConnect string.

		// This should be true unless you are testing. 
		// You can also use a hash name like md5, sha1 etc which must be the name as the connection settings in Vanilla.
		$secure = true; 
		echo $this->WriteJsConnect($user, $test, $clientID, $secret, $secure);
		exit();
	}












    public function indexAction()
    { 
			
		$this->loadLayout();     
		$this->renderLayout();
    }
}