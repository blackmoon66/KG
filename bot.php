<?php

require_once('./LineBotTiny.php');
require_once('./Crypto.php');


$channelAccessToken = 'LdDBgz7qtSFKUxd22i0nuOO9cWD7HKCfQlAAH4zZZD0affZcXf/NkJeI8MKHhqyWXSdjCuiu8lkNcXMtfK5uviz1sjLJhaqFGC0Pmf/yIn/dcBM2CgyYQZiUGjLW1ZEN40g8HcK5miFBb7XNqRPAyQdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'dbe5048d72a7edd4044a40048fafb058';
date_default_timezone_set('Asia/Jakarta');

$client 		= new LINEBotTiny($channelAccessToken, $channelSecret);
$reply 			= '';
$leave 			= false;

$event 			= $client->parseEvents()[0];
$type 			= $event['type']; 
$source     	= $event['source'];
$userId 		= $source['userId'];
$replyToken 	= $event['replyToken'];
$timestamp		= $event['timestamp'];
$message 		= $event['message'];
$messageid 		= $message['id'];


	



if($message['type']=='text')
{
	$incomingMsg = strtolower(trim($message['text']));

	if(is_numeric($incomingMsg))
	{
		$crypto 	= new Crypto();
		/*
		if($stringAfterCommand != "" ) 
		{
		 	if(strpos($stringAfterCommand, " ") === false) {
				$cryptoId = trim($stringAfterCommand);
			}
			else {
				$cryptoId = trim(substr($stringAfterCommand, 0 , strpos($stringAfterCommand, " ")));
			}

			if($crypto->checkCryptoId($cryptoId)){
				$cryptoData = $crypto->getCryptoInfo($cryptoId);
				$cryptoPrice = $cryptoData['ticker']['last'];
				$replyText = '1 '.strtoupper($cryptoId).' = '.$crypto->generateIDRString($cryptoPrice);
			}
			else {
				$replyText = 'maaf, petrik tidak mengenai crypto currency itu :(';
			}
		}
*/

			if($crypto->checkCryptoId($incomingMsg))
			{

				$cryptoData = $crypto->getCryptoInfo($incomingMsg);
				$cryptoPrice= $cryptodata['ticker']['last'];
				$cryptoid = strtolower($cryptoData['cryptoId']);
				$stringVol = 'vol_'.$cryptoId;
				$cryptoVolume=$cryptodata['ticker'][$stringVol];
				error_log("vol : ".$cryptoVolume);
				$replyText = '1 '.strtoupper($cryptoId).' = '.'Rp.'.$crypto->generateIDRString($cryptoPrice).' Volume:'.$crypto->generateIDRString($cryptoVolume);

			}


		else {
			$replyText = 'kurang cryptoId nya bosque';
		}	
	}
	else
	{
		$replytext = 'Input Harus Angka';
	}
	$reply = array(
								'replyToken' => $replyToken,														
								'messages' => array(
									array(
											'type' => 'text',					
											'text' => $replyText
										)
								)
							);
}
if($reply != "") {
				
		$client->replyMessage($reply);
	 
}


?>