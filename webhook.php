<?php
$content = \file_get_contents('php://input');
$update = \json_decode($content, true);

if(!$update) {
  exit;
}

$message = isset($update['message']) ? $update['message'] : null;
$messageId = isset($message['message_id']) ? $message['message_id'] : null;
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : null;
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : null;
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : null;
$username = isset($message['chat']['username']) ? $message['chat']['username'] : null;
$date = isset($message['date']) ? $message['date'] : null;
$text = isset($message['text']) ? $message['text'] : null;

if(strpos($text, "/start") === 0 || $text=="ciao")
{
	$response = "Ciao $firstname, benvenuto!";
}
elseif($text=="domanda 1")
{
	$response = "risposta 1";
}
elseif($text=="domanda 2")
{
	$response = "risposta 2";
}
else
{
	$response = "Comando non valido!";
}




\header('Content-Type: application/json');
$parameters = array('chat_id' => $chatId, 'text' => $text, 'method' => 'sendMessage');
echo \json_encode($parameters);
