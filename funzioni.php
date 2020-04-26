<?php

// function inlinetastiera($chat_id, $text)
// {
// $tastiera ='&reply_markup={"inline_keyboard":[[{"text":"API%20Bot%20Telegram","url":"https://core.telegram.org/bots(api"},{"text":"Google","url":"https://www.google.it"}]]};
// $url = $GLOBALS[website].
// }


function send_message_html($chatid, $message)
{
  $parameters = array('chat_id' => $chatId, "text" => $message, 'parse_mode' =>"HTML");
  $parameters["method"] = "sendMessage";
  
  header("Content-Type: application/json");
  echo json_encode($parameters);
}



?>
