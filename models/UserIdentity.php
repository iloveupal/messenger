<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 0:33
 */

namespace app\models;


use yii\web\IdentityInterface;
use app\utils\Hash;

class UserIdentity extends Users implements IdentityInterface {
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = $token? $token : '';

        $user_id = TokensUser::extractUserId($token);

        $user = self::findOne($user_id);

        if (!$user) return null;

        foreach($user->tokens as $token_needle) {
            if (Hash::verify($token, $token_needle->token)) {
                return $user;
            }
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->tokens[0]->token;
    }

    public function validateAuthKey($token)
    {
        $token = $token? $token : '';

        $user_id = Users::extractUserId($token);

        $user = Users::findOne($user_id);

        if (!$user) return null;

        foreach($user->tokens as $token_needle) {
            if (Hash::verify($token, $token_needle->token)) {
                return true;
            }
        }

        return null;
    }

}