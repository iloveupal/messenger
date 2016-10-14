<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 13.10.16
 * Time: 1:56
 */

namespace app\models;

use app\utils\Hash;

class TokensUser extends Tokens
{
    public static function addToken($user_id, $scope = '') {
        $token = new Tokens();
        $token->user_id = $user_id;
        $token_raw = self::appendUserId(self::generateTokenString(), $user_id);
        $token->token = Hash::hash($token_raw);
        $token->scope = $scope;
        $token->save();
        return $token_raw;
    }

    public static function extractUserId($token) {
        $parts = explode('id$', $token);
        return $parts[0];
    }

    public static function appendUserId($token, $user_id) {
        return $user_id . 'id$' . $token;
    }

    public static function login($username, $pass) {
        $user = Users::validatePass($username, $pass);
        if (!$user) {
            return false;
        }

        return self::addToken($user->id);
    }

    public static function generateTokenString() {
        return \yii::$app->getSecurity()->generateRandomString(64);
    }
}