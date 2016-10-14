<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 13.10.16
 * Time: 2:42
 */

namespace app\utils;


class Hash
{
    public static function hash($pass) {
        return \yii::$app->getSecurity()->generatePasswordHash($pass, 5);
    }

    public static function verify($pass, $hash) {
        return \yii::$app->getSecurity()->validatePassword($pass, $hash);
    }
}