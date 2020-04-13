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
  					
			$response = "tempo";
			
//			include 'par.php';
		break;
	}


/*
if(strpos($text, "/start") === 0 || $text=="ciao")
{
	$response = "Ciao $firstname, benvenuto!";
}
elseif($text=="/domanda1")
{
	$response = "risposta 1";
}
elseif($text=="/domanda2")
{
	$response = "risposta 2";
}
else
{
	$response = "Comando non valido!";
}
*/
include 'par.php';


$response = "(".$chatId.")".$response."(".$test.")";

$parameters = array('chat_id' => $chatId, "text" => $response);
$parameters["method"] = "sendMessage";

header("Content-Type: application/json");
echo json_encode($parameters);
