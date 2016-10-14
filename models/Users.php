<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use app\utils\Hash;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $pass
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'pass'], 'string', 'max' => 255],
        ];
    }

    public function getTokens() {
        return $this->hasMany(Tokens::className(), ['user_id' => 'id']);
    }

    public static function validatePass($username, $pass) {
        $user = self::byUsername($username);
        $pass_correct = !$user? false: Hash::verify($pass, $user->pass);
        return $pass_correct? $user: null;
    }

    public static function createUser($username, $pass)
    {

        if (self::byUsername($username)) {
            throw new Exception('username_exists');
        }

        $user = new Users();

        $user->username = $username;
        $user->pass = Hash::hash($pass);

        return $user->save();
    }

    public static function byUsername($username) {
        return self::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'pass' => 'Pass',
        ];
    }





}
