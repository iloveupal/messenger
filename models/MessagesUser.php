<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 1:11
 */

namespace app\models;


use yii\base\Exception;
use yii\web\IdentityInterface;

class MessagesUser extends Messages
{

    public $attachments;
    public $is_from_admin;



    public static function createMessage(IdentityInterface $sender, IdentityInterface $receiver, $text)
    {
        $message = new Messages();
        $message->sender_id = $sender->getId();
        $message->receiver_id = $receiver->getId();

        $latest_message = self::getLatestMessage($receiver, $sender);

        $message->parent_id = $latest_message? $latest_message->id: null;
        $message->text = $text;

        $message_sent_success = $message->save();
        if (!$message_sent_success || !$message->id) {
            throw new Exception('could not send message');
        }

        Dialogues::refreshDialogueLastMessage($sender, $receiver, $message->id);
        MessagesAttachment::AttachNewFiles($message);
    }

    public static function getLastConversation(IdentityInterface $one, IdentityInterface $two, $limit = 5)
    {
        $latest_message = self::getLatestMessage($one, $two);
        if (!$latest_message) return null;

        return $latest_message->getArrayOfNext($limit);
    }

    public function getArrayOfNext(int $max) {
        $result = [$this];
        $message_cycle = $this;
        $count = 0;

        while(($message_cycle = $message_cycle->parent) && (++$count < $max)) {
            $result[]= $message_cycle;
        }

        array_map('\app\models\MessagesAggregation::aggregateFromMessage', $result);

        return $result;
    }

    public static function getLatestMessage(IdentityInterface $one, IdentityInterface $two) {
        $dialogue = Dialogues::findDialogueInstance($one, $two);
        if (!$dialogue) return null;

        $latest_message = $dialogue->lastMessage;

        return $latest_message;
    }
};