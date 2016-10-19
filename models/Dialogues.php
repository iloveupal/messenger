<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "dialogues".
 *
 * @property integer $id
 * @property integer $user1
 * @property integer $user2
 * @property integer $last_message_id
 *
 * @property Messages $lastMessage
 * @property Users $user10
 * @property Users $user20
 */
class Dialogues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialogues';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user1', 'user2', 'last_message_id'], 'integer'],
            [['last_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Messages::className(), 'targetAttribute' => ['last_message_id' => 'id']],
            [['user1'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user1' => 'id']],
            [['user2'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user2' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user1' => 'User1',
            'user2' => 'User2',
            'last_message_id' => 'Last Message ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastMessage()
    {
        return $this->hasOne(MessagesUser::className(), ['id' => 'last_message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser10()
    {
        return $this->hasOne(Users::className(), ['id' => 'user1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser20()
    {
        return $this->hasOne(Users::className(), ['id' => 'user2']);
    }

    public static function findDialogueInstance(IdentityInterface $userA, IdentityInterface $userB)
    {
        $users = self::swapLowerFirst($userA, $userB);

        return self::findOne([
            'user1' => $users['user1']->getId(),
            'user2' => $users['user2']->getId()
        ]);
    }

    public static function refreshDialogueLastMessage(IdentityInterface $userA, IdentityInterface $userB, $messageId)
    {
        $messageId = (int) $messageId;
        $dialogue = self::findDialogueInstance($userA, $userB);
        if (!$dialogue) {
            $dialogue = self::createNewDialogue($userA, $userB);
        }
        $dialogue->last_message_id  = $messageId;
        return $dialogue->save();
    }

    public static function createNewDialogue(IdentityInterface $userA, IdentityInterface $userB)
    {
        $dialogue = new self();
        $users = self::swapLowerFirst($userA, $userB);
        $dialogue->user1 = $users['user1']->getId();
        $dialogue->user2 = $users['user2']->getId();
        return $dialogue;
    }

    public static function swapLowerFirst(IdentityInterface $user1, IdentityInterface $user2)
    {
        return [
            'user1' => $user1->getId() > $user2->getId()? $user2: $user1,
            'user2' => $user1->getId() > $user2->getId()? $user1: $user2
        ];
    }

    public static function getAllForUser(IdentityInterface $user, $limit = 5)
    {
        $query = self::find()
            ->where('user1 = :user_id', ['user_id' => $user->getId()])
            ->orWhere('user2 = :user_id', ['user_id' => $user->getId()]);

        $results = $query->limit($limit)->all();

        return $results;
    }
}
