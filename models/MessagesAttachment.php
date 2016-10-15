<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 2:31
 */

namespace app\models;


class MessagesAttachment
{
    public static function AttachNewFiles(Messages $message)
    {
        $dialogue = Dialogues::findDialogueInstance($message->receiver, $message->sender);

        $attachments = Attachments::notUsed($message->sender);

        array_map(function(Attachments $attach) use ($dialogue, $message)
        {
            $attach->attachToMessage($dialogue, $message);
        }, $attachments);

        return $attachments;
    }
}