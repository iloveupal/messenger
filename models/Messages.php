<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property string $text
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $read
 * @property integer $parent_id
 *
 * @property Messages $parent
 * @property Messages[] $messages
 * @property Users $receiver
 * @property Users $sender
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['sender_id', 'receiver_id', 'read', 'parent_id'], 'integer'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Messages::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['receiver_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'read' => 'Read',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MessagesUser::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(MessagesUser::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(UserIdentity::className(), ['id' => 'receiver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(UserIdentity::className(), ['id' => 'sender_id']);
    }
}
