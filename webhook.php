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
			$response = "Attivo.";
		break;

		case "/debug":
			$response = "Debug.";
			$dump = json_encode($update, JSON_PRETTY_PRINT);
			echo json_encode([
        			'chat_id' => $chatId, 
        			'text' => "```\n$dump\n```", 
        			'method' => 'sendMessage', 
        			'parse_mode' => 'markdown'
    				]);
		break;

		case "/sito":
			//$label	= "<code style=\"color:blue\">Il sito e': </code>".PHP_EOL;
			$label	= "<code style=\"color:DodgerBlue;\">Il sito e': </code>".PHP_EOL;
			$sito	= "http://www.cattolica.net".PHP_EOL;
			$response = $label.PHP_EOL.$sito.PHP_EOL;
		break;
		case "/meteo";
  			$url = 'http://api.openweathermap.org/data/2.5/weather?q=cattolica,it&APPID='.getenv('ID_WEATHER').'&units=metric&lang=it_it&mode=xml';
  			$data = file_get_contents($url);
  			
  			$xml = new SimpleXMLElement($data);
 					
			$ril    = "Data Rilevazione:".date("d-m-Y H:s", strtotime($xml->lastupdate['value'][0])).PHP_EOL;
				
			$meteo   = "<b>Temp. Attuale</b>:   ".$xml->temperature['value'][0]." ".$xml->temperature['unit'][0].PHP_EOL.
				   "Temp. Max:       ".$xml->temperature['max'][0]." ".$xml->temperature['unit'][0].PHP_EOL.
				   "Temp. Min:       ".$xml->temperature['min'][0]." ".$xml->temperature['unit'][0].PHP_EOL.
				   "Temp. Percepita: ".$xml->feels_like['value'][0]." ".$xml->feels_like['unit'][0].PHP_EOL;
			
			$up      = "Umidita:         ".$xml->humidity['value'][0]." ".$xml->humidity['unit'][0].PHP_EOL.
				   "Pressione:       ".$xml->pressure['value'][0]." ".$xml->pressure['unit'][0].PHP_EOL;
				   
			$sole    = "Sole Sorge:      ".date("d-m-Y H:s", strtotime($xml->city->sun['rise'][0])).PHP_EOL.
				   "Sole Tramonta:   ".date("d-m-Y H:s", strtotime($xml->city->sun['set'][0])).PHP_EOL;
			
			$vento   = "Vento:           ".$xml->wind->speed['value'][0]." ".$xml->wind->speed['unit'][0].PHP_EOL;
			
			// $test	= '<span style="color:blue">some *This is Blue italic.* text</span>'.PHP_EOL;
			$test	= "<code style=\"color:blue\">some *This is Blue italic.* text</code>\ud83d\udd34".PHP_EOL;
			$test   ="<a href=\"http://www.example.com/\">inline URL</a>".PHP_EOL."<a href=\"tg://user?id=123456789\">inline mention of a user</a>".PHP_EOL;
			
			$response = $ril.PHP_EOL.$sole.PHP_EOL.$up.PHP_EOL.$meteo.PHP_EOL.$vento.PHP_EOL.$test.PHP_EOL;
		break;
	}


include 'par.php';


// $response = $response.'('.date_timestamp_get(date_create()).') <pre><code class="language-thon">pre-formatted fixed-width code block written in the Python programming language</code></pre>';
$response = $response.'('.date_timestamp_get(date_create()).')';

// $parameters = array('chat_id' => $chatId, "text" => $response);
// $parameters = array('chat_id' => $chatId, "text" => $response, 'parse_mode' =>"Markdown");
$parameters = array('chat_id' => $chatId, "text" => $response, 'parse_mode' =>"HTML");
$parameters["method"] = "sendMessage";

header("Content-Type: application/json");
echo json_encode($parameters);
