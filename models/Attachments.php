<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "attachments".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property integer $message_id
 * @property integer $dialogue_id
 * @property string $file_name
 *
 * @property Dialogues $dialogue
 * @property Messages $message
 * @property Users $owner
 */
class Attachments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'message_id', 'dialogue_id'], 'integer'],
            [['file_name'], 'string', 'max' => 255],
            [['dialogue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dialogues::className(), 'targetAttribute' => ['dialogue_id' => 'id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Messages::className(), 'targetAttribute' => ['message_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'message_id' => 'Message ID',
            'dialogue_id' => 'Dialogue ID',
            'file_name' => 'File Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialogue()
    {
        return $this->hasOne(Dialogues::className(), ['id' => 'dialogue_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Messages::className(), ['id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Users::className(), ['id' => 'owner_id']);
    }

    public static function upload(IdentityInterface $user, $files)
    {
        $result = [];

        foreach ($files as $file)
        {
            $result[$file->name] = self::uploadOne($user, $file->name);
        }

        return $result;
    }

    public static function uploadOne(IdentityInterface $user, $file_name)
    {
        $attachment = new Attachments();
        $attachment->owner_id = $user->getId();
        $attachment->file_name = $file_name;
        $attachment->save();

        return $attachment;
    }

    public function attachToMessage($dialogue, $message)
    {
        $this->dialogue_id = $dialogue->id;
        $this->message_id = $message->id;
        $this->save();
    }

    public static function notUsed(IdentityInterface $user)
    {
        return self::find()->where(['owner_id' => $user->getId()])->andWhere(['message_id' => null])->all();
    }
}
