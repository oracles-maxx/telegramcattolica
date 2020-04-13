<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);

$response = '';

	switch($text) {
		case "/start":
			$response = "start";
		break;
		case "/tempo";
  			$url = 'http://api.openweathermap.org/data/2.5/weather?q=cattolica,it&APPID='.getenv('ID_WEATHER').'&units=metric&lang=it_it&mode=xml';
  			$data = file_get_contents($url);
  			
  			$xml = new SimpleXMLElement($data);
			// echo("<br><br><code><pre>");
  			
  			// print_r($xml);
			// echo("<br>----<br>");  			
  			// print_r($xml->temperature['value']);
			// echo("<br>----<br>");
  					
			$ril    = "Data Rilevazione:".date("d-m-Y H:s", strtotime($xml->lastupdate['value'][0])).PHP_EOL;
				
			$meteo   = "Temp. Attuale:   ".$xml->temperature['value'][0]." ".$xml->temperature['unit'][0].PHP_EOL.
				   "Temp. Max:       ".$xml->temperature['max'][0]." ".$xml->temperature['unit'][0].PHP_EOL.
				   "Temp. Min:       ".$xml->temperature['min'][0]." ".$xml->temperature['unit'][0].PHP_EOL.
				   "Temp. Percepita: ".$xml->feels_like['value'][0]." ".$xml->feels_like['unit'][0].PHP_EOL;
			
			$up      = "Umidita:         ".$xml->humidity['value'][0]." ".$xml->humidity['unit'][0].PHP_EOL.
				   "Pressione:       ".$xml->pressure['value'][0]." ".$xml->pressure['unit'][0].PHP_EOL;
				   
			$sole    = "Sole Sorge:      ".$xml->sun['rise'][0].PHP_EOL.
				   "Sole Tramonta:   ".$xml->su['set'][0].PHP_EOL;
			
			$response = $ril.PHP_EOL.$sole.PHP_EOL.$up.PHP_EOL.$meteo.PHP_EOL;
		break;
	}


include 'par.php';


$response = $response."(".$test.")-";

$parameters = array('chat_id' => $chatId, "text" => $response);
$parameters["method"] = "sendMessage";

header("Content-Type: application/json");
echo json_encode($parameters);
