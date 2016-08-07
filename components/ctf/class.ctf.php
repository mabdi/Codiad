<?php
/*
 * Copyright (c) Codiad & Andr3as, distributed
 * as-is and without warranty under the MIT License.
 * See http://opensource.org/licenses/MIT for more information. 
 * This information must remain intact.
 */
   include_once('config.php');
    class Ctf {
        
        public $resultArray;
        public $result;
        
        function __construct() {
           
        }
        
        public function doSubmit() {
            // zip src
            shell_exec("tar -zcf "+ getConfig()["zip-name"] +" " + $_SESSION['project']);
            // call platform file submit evaluation webservice + upload zip file
            $fullflepath = getConfig()["zip-name"];
			$upload_url = getConfig()["upload-webservice"];
			$pid = getConfig()["pid"];
			$token = getConfig()["token"];
			$params = array(
			 'file'=>"@$fullfilepath",
			 'pid'=> $pid,
			 'token' => $token
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: $cookie"));
			curl_setopt($ch, CURLOPT_URL, $upload_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			
			$response = curl_exec($ch);
			curl_close($ch);
            // make result
            $json = json_decode($response);
            if($json['status'] == 1){
            	return formatJSEND("success",array("message"=>$json['message']));
            }else{
            	//return result in json format
            	return formatJSEND("error",array("message"=>$json['message']));
			}
		}
        
        public function doReset($path, $repo) {
            // call platform reset webservice
            
			$upload_url = getConfig()["reset-webservice"];
			$pid = getConfig()["pid"];
			$token = getConfig()["token"];
			$params = array(
			 'pid'=> $pid,
			 'token' => $token
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: $cookie"));
			curl_setopt($ch, CURLOPT_URL, $upload_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			
			$response = curl_exec($ch);
			curl_close($ch);
            // make result
            $json = json_decode($response);
            if($json['status'] == 1){
            	return formatJSEND("success",array("message"=>$json['message']));
            }else{
            	//return result in json format
            	return formatJSEND("error",array("message"=>$json['message']));
            }
        }
        
    }
?>