<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 13:54
 */

namespace app\models;


class MessagesAggregation extends MessagesUser
{
    public static function applyAttachments($message)
    {
        $message->attachments = Attachments::forMessageId($message->id);
    }

    public static function checkIsAdmin($message)
    {
        $message->is_from_admin = $message->sender->is_admin;
    }

    public static function aggregateFromMessage($message)
    {
        self::applyAttachments($message);
        self::checkIsAdmin($message);
    }
}