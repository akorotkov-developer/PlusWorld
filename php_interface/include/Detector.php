<?php

/**
 *
 * @author Roman.Lapin
 *
 * Class for working with API Yandex.Detector for PHP.
 *
 * http://code.google.com/p/yandex-detector-wrapper/
 *
 */
class Yandex_Detector
{

	private $_isDetected = false;

	private $_rawXml = null;

	private $_params = array();

	/**
	 * @return boolean if device is detected - true; if it is unknown - false
	 */
	public function detect()
	{
        $url = 'http://phd.yandex.net/detect/';
    	$headers = $this->getHeaders();

    	$query = http_build_query($headers);
    	$body = file_get_contents($url . '?' . $query);

        $this->_rawXml = $body;

        $xml = simplexml_load_string($body);
        if ($xml):
            $rootTag = $xml->getName();
            if ('yandex-mobile-info' == $xml->getName()):
            	$this->_isDetected = true;
            endif;
        else:
            return false;
        endif;

        return $this->_isDetected;
	}

	public function getHeaders()
	{
		if (0 < count($this->_headers)) {
			return $this->_headers;
		}
		foreach ($_SERVER as $key => $value) {
   			if (strpos($key, 'HTTP_') === 0 && $key != 'HTTP_HOST') {
       			$key = strtolower(strtr(substr($key, 5), '_', '-'));
                if ($key == 'user-agent' || $key == 'x-operamini-phone-ua' || strpos($key, "profile"))
		          $this->_headers[$key] = $value;
		    }
		}
		return $this->_headers;
	}

	public function setHeaders(array $headers)
	{
		$this->_headers = $headers;
	}

	public function getRawXml()
	{
		return $this->_rawXml;
	}

	public function getParams()
	{
		if (!$this->_isDetected) {
			return false;
		}
		if (0 >= count($this->_params)) {
			$xml = simplexml_load_string($this->_rawXml);
			$this->_params = $this->_xmlObjectToArray($xml);
		}
		return $this->_params;
	}

	private function _xmlObjectToArray($xml)
	{
	    $arrData = array();

	    if (is_object($xml)) {
	        $xml = get_object_vars($xml);
	    }

	    if (is_array($xml)) {
	        foreach ($xml as $index => $value) {
	            if (is_object($value) || is_array($value)) {
	                $value = $this->_xmlObjectToArray($value);
	            }
	            $arrData[$index] = $value;
	        }
	    }
	    return $arrData;
	}

}