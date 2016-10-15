<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 15:10
 */

namespace app\models;


use yii\base\Exception;

class AttachmentsUsers
{
    public static function isAllowedAttachment ($user, $attachment)
    {
        $message = $attachment->message;
        return $message->sender_id == $user->getId() || $message->receiver_id == $user->getId();
    }

    /**
     *
     * checks is allowed attachment for user and returns it or throws exception
     *
     * @param $user
     * @param $filename
     * @return null|static
     * @throws Exception
     */

    public static function getAttachment($user, $filename)
    {
        $attachment = Attachments::findOne(['file_name' => $filename]);

        if (!$attachment)
        {
            throw new Exception('Attachment not found');
        }

        if (!self::isAllowedAttachment($user, $attachment))
        {
            throw new Exception ('Attachment not allowed');
        }

        return $attachment;
    }
}