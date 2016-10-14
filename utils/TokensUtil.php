<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 14:15
 */

namespace app\utils;


class TokensUtil
{
    public static function generateRawToken($user_id) {
        $token = self::generateTokenString();
        return self::appendUserId($token, $user_id);
    }

    public static function generateTokenString() {
        return \yii::$app->getSecurity()->generateRandomString(64);
    }

    public static function extractUserId($token) {
        $parts = explode('id$', $token);
        return $parts[0];
    }

    public static function appendUserId($token, $user_id) {
        return $user_id . 'id$' . $token;
    }

    public static function encryptToken($token) {
        return Hash::hash($token);
    }
}