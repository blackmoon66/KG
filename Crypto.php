<?php
class Crypto {
	public function __construct()
    {
        $this->urlPrefix = "https://vip.bitcoin.co.id/api/";
        $this->urlSuffix = "ticker";
        $this->cryptoList = array(
        	1=>"btc" ,
        	2=>"bch",
        	3=>"eth",
        	4=>"etc",
        	5=>"ltc",
        	6=>"waves",
        	7=>"xrp",
        	8=>"xzc"
        	);
    }
    

    function exec_get($fullurl)
    {
            
            $header = array(
                "Content-Type: application/json"
            );
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);        
            curl_setopt($ch, CURLOPT_FAILONERROR, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_URL, $fullurl);
            
            $returned =  curl_exec($ch);
        
            return($returned);
    }

    public function getCryptoInfo($cryptoIndex) 
    {
    	$cryptoId=this->cryptoList[$cryptoIndex];

        $fullUrl = $this->urlPrefix.$cryptoId.'_idr/'.$this->urlSuffix;
        $result = json_decode($this->exec_get($fullUrl), true);
        $result['cryptoId']=$cryptoId;
    	 return $result;
    }

    public function checkCryptoId($cryptoId) {
    	
    	/*if(in_array($cryptoId, $this->cryptoList)){
    		return true;
    	}

    	return false;
        */
        if(array_key_exists($cryptoId, $this->cryptoList))
        {
            return true;
        }
        return_false
    }

    public function generateIDRString($price) {
    	$separator = '.';
    	$result = '';
    	$count = 0;
    	$numLength = strlen((string)$price);
    	for($i = $numLength - 1; $i >= 0; $i--) {
    		if($count !=0 && $count % 3 == 0) {
    			$result = $price[$i].$separator.$result;
    		}
    		else {
    			$result = $price[$i].$result;
    		}
    		$count++;
    	}

    	return $result;
    }
}



?>