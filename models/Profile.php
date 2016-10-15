<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $profile_image
 *
 * @property Users $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    public function publicAttributes()
    {
        return [
            'first_name',
            'last_name'
        ];
    }

    public function isPublicAttribute($attr)
    {
        return in_array($attr, $this->publicAttributes());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['first_name', 'last_name', 'profile_image'], 'string', 'max' => 255],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'profile_image' => 'Profile Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public static function getForUser(IdentityInterface $user)
    {
        $profile = self::findOne([
            'user_id' => $user->getId()
        ]);

        $profile = $profile? $profile: new Profile();
        $profile->user_id = $user->getId();

        return $profile;
    }

    public static function setForUser(IdentityInterface $user, Profile $profile)
    {
        $old_record = self::getForUser($user);

        array_map(function($key, $val) use ($old_record){
            $old_record->$key = $val;
        }, array_keys($profile->dirtyAttributes), $profile->dirtyAttributes);

        return $old_record->save();
    }

    public static function fromRequest($post)
    {
        $profile = new self();

        array_map(function($key, $val) use ($profile) {
            if ($profile->isPublicAttribute($key))
            {
                $profile->$key = $val;
            }
        }, array_keys($post), $post);

        return $profile;
    }
}
