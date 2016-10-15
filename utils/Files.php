<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 2:01
 */

namespace app\utils;


use yii\base\Exception;

class Files
{
    public static function getUniqueFilename($ts,  $extension) {
        return $ts . self::generateRandomString() . '.' . $extension;
    }

    public static function generateRandomString() {
        return \yii::$app->getSecurity()->generateRandomString(15);
    }

    public static function downloadLink($filename)
    {
        if (empty($filename)) throw new Exception('no image found');
        return \yii::getAlias('@app') . '/uploads/' . $filename;
    }
}