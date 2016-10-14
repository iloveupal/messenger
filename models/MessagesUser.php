<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 1:11
 */

namespace app\models;


use yii\web\IdentityInterface;

class MessagesUser extends Messages
{
    public static function createMessage(IdentityInterface $sender, IdentityInterface $receiver, $text)
    {
        $message = new Messages();
        $message->sender_id = $sender->getId();
        $message->receiver_id = $receiver->getId();

        $latest_message = self::getLatestMessage($receiver, $sender);

        $message->parent_id = $latest_message? $latest_message->id: null;

        $message->text = $text;

        $message->save();
    }

    public static function getLastConversation(IdentityInterface $one, IdentityInterface $two, $limit = 5)
    {
        $latest_message = self::getLatestMessage($one, $two);


        return $latest_message->getArrayOfNext($limit);
    }

    public function getArrayOfNext(int $max) {
        $result = [$this];



        $message_cycle = $this;
        $count = 0;


        while(($message_cycle = $message_cycle->parent) && (++$count < $max)) {
            $result[]= $message_cycle;
        }

        return $result;

    }

    public static function getLatestMessage(IdentityInterface $one, IdentityInterface $two) {
        $messagesQuery = new MessagesUser();
        $scoped = $messagesQuery->scopeConversation($one, $two);
        $latest_message = $messagesQuery->latest($scoped);

        return self::findOne($latest_message);
    }

    public function scopeConversation(IdentityInterface $one, IdentityInterface $two)
    {
        return $this->find()->where(
            ['and', 'receiver_id = :id2', 'sender_id = :id1'],
            [
                'id1' => $one->getId(),
                'id2' => $two->getId()
            ]
        )->orWhere(
            ['and', 'receiver_id = :id1', 'sender_id = :id2'],
            [
                'id1' => $one->getId(),
                'id2' => $two->getId()
            ]
        );
    }

    public function latest ($query) {
        return $query->select("max(id)")->scalar();
    }
};