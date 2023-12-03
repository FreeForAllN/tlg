<?php

// Replace 'YOUR_BOT_TOKEN' with your actual bot token
$botToken = '6373269061:AAEu8OZ4ihsRb3eVjrK90l-_fMRegWRrVto';

// Telegram channels to search


// Function to fetch messages from a channel using the Telegram Bot API
function fetchChannelMessages($botToken) {
    
    $aprl = "https://api.telegram.org/bot$botToken/getUpdates?offset=-1";
    $r = file_get_contents($aprl);
}



    // Fetch channel content using Telegram Bot API
$content = fetchChannelMessages($botToken);




?>




