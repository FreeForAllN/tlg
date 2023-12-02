<?php

// Replace 'YOUR_BOT_TOKEN' with your actual bot token
$botToken = '6830532730:AAEZCPMH5C6qD9hdhoZHK-h7UAanna3s2G0';

// Telegram channels to search
$channels = [
    "-1002105278221"
];

// Maximum number of messages to check
$maxMessages = 10;
$outputFile = 'output.txt';
// Array to store found links
$servers = [];

// Function to fetch messages from a channel using the Telegram Bot API
function fetchChannelMessages($botToken, $channel, $maxMessages) {
    $apiUrl = "https://api.telegram.org/bot$botToken/getUpdates?chat_id=$channel&limit=$maxMessages";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        return '';  // Handle error
    }

    $data = json_decode($response, true);

    if (!$data || !isset($data["result"])) {
        return '';  // Handle error or empty response
    }

    // Extract text from the response
    return getTextFromResult($data);
}

// Function to get text from the "result" array
function getTextFromResult($data) {
    $texts = [];
    foreach ($data["result"] as $result) {
        if (isset($result["channel_post"]["text"])) {
            $texts[] = htmlspecialchars($result["channel_post"]["text"]);
        }
    }

    // If no "text" property is found, you can return a default value or handle it as needed.
    return $texts;
}

// Loop through channels
foreach ($channels as $channel) {

    // Fetch channel content using Telegram Bot API
    $content = fetchChannelMessages($botToken, $channel, $maxMessages);

    if (empty($content)) {
        continue;  // Skip if content is empty or there's an error
    }

    // Loop through messages
    foreach ($content as $text) {
        // Split the text into lines
        $lines = explode("\n", $text);

        // Loop through lines
        foreach ($lines as $line) {
            // Check if the line starts with vmess, ss, ssr, trojan, or vless
            if (preg_match("/^(vmess|ss|ssr|trojan|vless):\/\/[^#]+/", $line, $matches)) {
                $servers[] = $matches[0] . "#join_FreeForAllN \n";
            }
        }
    }
}

// Fix "&" conversion issue
$servers = array_map('htmlspecialchars_decode', $servers);

foreach ($servers as $server) {
    echo "\n";
    echo $server;
    echo "\n";
}

file_put_contents($outputFile, implode(" \n", $servers));
header('Content-Disposition: attachment; filename="' . $outputFile . '"');
// Base64 encode links

?>
