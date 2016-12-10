<?php
// 设置时区
namespace Extend;
date_default_timezone_set('Asia/Shanghai');
header('content-type:text/html;charset=utf-8');

class Utils {
	static public function http($url, $postfields, $method = 'POST', array $headers = array() ){

		$ci = curl_init();
		/* Curl settings */
		curl_setopt( $ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt( $ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt( $ci, CURLOPT_TIMEOUT, 30);
		curl_setopt( $ci, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $ci, CURLOPT_ENCODING, 'gzip');
		curl_setopt( $ci, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt( $ci, CURLOPT_MAXREDIRS, 5);
		curl_setopt( $ci, CURLOPT_SSL_VERIFYPEER, false);
		
	//	curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
		
		curl_setopt( $ci, CURLOPT_HEADER, false);

		switch(strtoupper($method)){
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, true);
				if (!empty($postfields))
				curl_setopt($ci, CURLOPT_POSTFIELDS, http_build_query($postfields));
			//	curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
				
				    break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if (!empty($postfields))
				$url = "{$url}?" . http_build_query($postfields);
				break;
			case 'GET':
				if (!empty($postfields))
				$url = "{$url}?" . http_build_query($postfields);
				break;
			default:
				die('请传递正确的方法类型');
				break;
		}

		curl_setopt($ci, CURLOPT_URL, $url);
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ci, CURLINFO_HEADER_OUT, true);

		$response = curl_exec($ci);
		curl_close ($ci);
		return $response;
	}

	function dump($vars, $label = '', $return = false) {
	    if (ini_get('html_errors')) {
	        $content = "<pre>\n";
	        if ($label != '') {
	            $content .= "<strong>{$label} :</strong>\n";
	        }
	        $content .= htmlspecialchars(print_r($vars, true));
	        $content .= "\n</pre>\n";
	    } else {
	        $content = $label . " :\n" . print_r($vars, true);
	    }
	    if ($return) { return $content; }
	    echo $content;
	    return null;
	}
}

?>
