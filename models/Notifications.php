<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $new
 *
 * @property Users $user
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'new'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'new' => 'New',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public static function poll($user) {
        if (!$user) {
            throw new Exception('unauthorized');
        }

        $notification = self::getForUser($user);

        for($i = 0; $i < 10; $i++) {
            sleep(3);
            $new = $notification->isNew();
            if ($new) {
                return true;
            }
        }

        return false;
    }

    public static function getForUser($user) {
        $record = self::findOne(['user_id' => $user->getId()]);
        if (!$record) {
            $record = new self();
            $record->user_id = $user->getId();
        }

        $record->new = 0;
        $record->save();

        return $record;
    }

    public function isNew() {
        $model = self::findOne($this->id);
        return $model->new;
    }

    public static function post($user) {
        $model = self::getForUser($user);
        $model->new = 1;
        $model->save();
    }
}
