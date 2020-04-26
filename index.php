<?php
echo "Start -"; 
$apiToken = getenv('BOT_TOKEN');
 
 $data = [
     'chat_id' => '@'.getenv('NAME_BOOT'),
     'text' => 'Hello world!'
 ];


 $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
print_r( $data);

echo "End -"; 
// $chatId = $update["message"]["chat"]["id"];
// $message = $update["message"]["text"];
// echo($chatId);
//echo($message."aaa");
// getenv('id')

?>
