<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 2:01
 */

namespace app\utils;


class Files
{
    public static function getUniqueFilename($ts,  $extension) {
        return $ts . self::generateRandomString() . '.' . $extension;
    }

    public static function generateRandomString() {
        return \yii::$app->getSecurity()->generateRandomString(15);
    }
}