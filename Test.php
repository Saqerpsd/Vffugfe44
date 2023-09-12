<?php
require 'vendor/autoload.php';

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

$telegram = new Api('6653913042:AAEQ86263edLX3KzXEgntGb64atyo7sYmBs');

function generateMessage()
{
    $message = '';
    $bombEmoji = '💣';
    $starEmoji = '⭐️';

    // إضافة 20 إيموجي قنبلة
    for ($i = 0; $i < 20; $i++) {
        $message .= $bombEmoji;
    }

    // إضافة 5 إيموجي نجمة في أماكن عشوائية
    for ($i = 0; $i < 5; $i++) {
        $randomIndex = rand(0, strlen($message));
        $message = substr_replace($message, $starEmoji, $randomIndex, 0);
    }

    return $message;
}

function processUpdate(Update $update)
{
    $message = $update->getMessage();
    $chat = $message->getChat();

    // التحقق مما إذا كانت الرسالة تحتوي على "start"
    if ($message->getText() === 'start') {
        $responseMessage = generateMessage();

        // إرسال الرسالة إلى محادثة تليجرام
        $response = $GLOBALS['telegram']->sendMessage([
            'chat_id' => $chat->getId(),
            'text' => $responseMessage
        ]);

        // التحقق من نجاح إرسال الرسالة
        if ($response->isOk()) {
            echo 'تم إرسال الرسالة بنجاح!';
        } else {
            echo 'حدث خطأ أثناء إرسال الرسالة.';
        }
    }
}

$update = $telegram->getWebhookUpdates();
processUpdate($update);
