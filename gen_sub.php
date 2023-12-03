<?php

// Replace 'YOUR_BOT_TOKEN' with your actual bot token
$botToken = '6830532730:AAGQfabQlllYwjGRFfEf44WlUepVlvqDHYU';

// Telegram channels to search
$channels = [
    "-1002105278221"
];

// Maximum number of messages to check
$maxMessages = 11;
$outputFile = 'output2.txt';
// Array to store found links
$servers = [];
$vmessLinks = [];
$vlessLinks = [];
$trojanLinks = [];
$ssLinks = [];

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
    foreach ($content as $text) {
        // Split the text into lines
        $lines = explode("\n", $text);

        // Loop through lines
        foreach ($lines as $line) {
    // Check the line for different link types
            if (preg_match("/vmess:(\/\/[^#]+)/", $line, $matches)) {
                $vmessLinks[] = $matches[0]. "#join_@FreeForAllN \n";
            } elseif (preg_match("/vless:(\/\/[^#]+)/", $line, $matches)) {
                $vlessLinks[] = $matches[0]. "#join_@FreeForAllN \n";
            } elseif (preg_match("/trojan:(\/\/[^#]+)/", $line, $matches)) {
                $trojanLinks[] = $matches[0]. "#join_@FreeForAllN \n";
            } elseif (preg_match("/ss:(\/\/[^#]+)/", $line, $matches)) {
                $ssLinks[] = $matches[0]. "#join_@FreeForAllN \n";
            }
    }
 }
}
$vmessLinks = array_map('htmlspecialchars_decode', $vmessLinks);
$vlessLinks = array_map('htmlspecialchars_decode', $vlessLinks);
$trojanLinks = array_map('htmlspecialchars_decode', $trojanLinks);
$ssLinks = array_map('htmlspecialchars_decode', $ssLinks);
// Combine the links into a unified format
$output = "VMESS LINKS:\n" . implode("\n", $vmessLinks) . "\n\n" .
          "VLESS LINKS:\n" . implode("\n", $vlessLinks) . "\n\n" .
          "TROJAN LINKS:\n" . implode("\n", $trojanLinks) . "\n\n" .
          "SHADOWSOCKS LINKS:\n" . implode("\n", $ssLinks);




//file_put_contents($outputFile, implode(" \n", $servers));
// Base64 encode links

file_put_contents('sub/output', $output);
file_put_contents('sub/s65', base64_encode($output));

?>




